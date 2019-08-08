<?php

use App as App;
use App\User as User;
use Illuminate\Validation\Rule as Rule;
use Illuminate\Support\Facades\DB as DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator as Validator;

function resizeImage($img, $target_img, $new_img_width, $new_img_height, $img_type)
{
    try {
        $drive_path = getDrivePath();
        $target_dir = $drive_path . '/images/' . $img_type;
        makeDir($target_dir);
        $target_file = $target_dir . '/' . $target_img;
        $image = Image::make($img);
        $image->resize($new_img_width, $new_img_height);
        $image->save($target_file);
    } catch (\Throwable $e) {
        throw $e;
    }
}

function resizeImageToHeight($img, $target_img, $new_img_height, $img_type)
{
    try {

        $drive_path = getDrivePath();
        $target_dir = $drive_path . '/images/' . $img_type;
        makeDir($target_dir);
        $target_file = $target_dir . '/' . $target_img;

        $image = Image::make($img);
        $image->resize(null, $new_img_height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($target_file);
    } catch (\Throwable $e) {
        throw $e;
    }
}

function resizeImageToWidth($img, $target_img, $new_img_height, $img_type = '')
{
    try {

        $drive_path = getDrivePath();
        $target_dir = $drive_path . '/images/' . $img_type;
        makeDir($target_dir);
        $target_file = $target_dir . '/' . $target_img;

        $image = Image::make($img);
        // resize the image to a width and constrain aspect ratio (auto height)
        $image->resize($new_img_width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($target_file);
    } catch (\Throwable $e) {
        throw $e;
    }
}

function scaleImage($img, $scale, $img_type)
{
    try {

        $drive_path = getDrivePath();
        $target_dir = $drive_path . '/images/' . $img_type;
        makeDir($target_dir);
        $target_file = $target_dir . '/' . $target_img;

        $image = Image::make($img);

        $new_img_width = $image->width() * $scale / 100;
        $new_img_height = $image->height() * $scale / 100;

        $image->resize($new_img_width, $new_img_height);
        $image->save($target_file);

    } catch (\Throwable $e) {
        throw $e;
    }
}

function saveOriginalImage($img, $target_img, $img_type)
{
    try {

        $drive_path = getDrivePath();
        $target_dir = $drive_path . '/images/' . $img_type;
        makeDir($target_dir);
        $target_file = $target_dir . '/' . $target_img;

        $image = Image::make($img);
        $image->save($target_file);
    } catch (\Throwable $e) {
        throw $e;
    }
}

function readImage($img_name, $img_type)
{
    try {

        $drive_path = getDrivePath();
        $file_path = $drive_path . '/images/' . $img_type . '/' . $img_name;

        if (empty($file_path) || !file_exists($file_path)) {
            return "";
        }

        $file_type = pathinfo($file_path, PATHINFO_EXTENSION);
        $file_data = file_get_contents($file_path);
        $file_base64 = 'data:image/' . $file_type . ';base64,' . base64_encode($file_data);
        return $file_base64;
    } catch (\Throwable $e) {
        throw $e;
    }
}

function readJsonBasedLanguage()
{
    try {
        $json_based_language = "{}";
        $locale = App::getLocale();
        $path = base_path() . "/resources/lang/$locale.json";
        if (file_exists($path)) {
            $json_based_language = file_get_contents($path);
        }
        return $json_based_language;
    } catch (\Throwable $e) {
        throw $e;
    }
}

function checkUserRight($scr_id, $fnc_id)
{
    try {

        $user = new User();
        $data = $user->getAuthUser();

        if ($data == null)
            return false;

        $user_permission = DB::table('m_permission_user')
            ->select('usr_allow')
            ->where([
                ['dep_id', '=', $data->dep_id],
                ['scr_id', '=', $scr_id],
                ['fnc_id', '=', $fnc_id],
                ['usr_id', '=', $data->id],
                ['delete_flg', '=', '0']
            ])
            ->first();

        $usr_allow = $user_permission == null ? null : $user_permission->usr_allow;

        $dep_permission = DB::table('m_permission_department')
            ->select('dep_allow')
            ->where([
                ['dep_id', '=', $data->dep_id],
                ['scr_id', '=', $scr_id],
                ['fnc_id', '=', $fnc_id],
                ['delete_flg', '=', '0']
            ])
            ->first();

        $dep_allow = $dep_permission == null ? null : $dep_permission->dep_allow;

        if ($usr_allow == null && ($dep_allow == null || $dep_allow == '0')) {
            abort(403);
        }

        if ($usr_allow == '0') {
            abort(403);
        }
    } catch (\Throwable $e) {
        throw $e;
    }
}

function convertDataToDropdownOptions($data, $value, $option)
{
    try {
        $options = [];
        foreach ($data as $item) {
            if (property_exists($item, $value) && property_exists($item, $option)) {
                $options[$item->$value] = $item->$option;
            }
        }
        return $options;
    } catch (\Throwable $e) {
        throw $e;
    }
}

function getAllUsers()
{
    try {
        $user = new User();
        return $user->getAllUsers();
    } catch (\Throwable $e) {
        throw $e;
    }
}

function dateValidator($date, $format = null)
{
    $credential_name = "name";
    $credential_data = $date;

    $credential_rule = 'date';
    if ($format != null) {
        $credential_rule >= "|date_format:$format";
    }

    $rules = [
        $credential_name => $credential_rule
    ];
    $credentials = [
        $credential_name => $credential_data
    ];

    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
        return false;
    }
    return true;
}

function formatDateValidator($date, $format)
{
    $credential_name = "name";
    $credential_data = $date;
    $credential_rule = "date_format:$format";

    $rules = [
        $credential_name => $credential_rule
    ];
    $credentials = [
        $credential_name => $credential_data
    ];
    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
        return false;
    }
    return true;
}

function requiredValidator($data)
{
    $credential_name = "name";
    $credential_data = $data;
    $rules = [
        $credential_name => 'required'
    ];
    $credentials = [
        $credential_name => $credential_data
    ];
    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
        return false;
    }
    return true;
}

function maxlengthValidator($data, $max_length)
{
    $credential_name = "name";
    $credential_data = $data;
    $rules = [
        $credential_name => "max:$max_length"
    ];
    $credentials = [
        $credential_name => $credential_data
    ];
    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
        return false;
    }
    return true;
}

function numericValidator($data)
{
    $credential_name = "name";
    $credential_data = $data;
    $rules = [
        $credential_name => "numeric"
    ];
    $credentials = [
        $credential_name => $credential_data
    ];
    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
        return false;
    }
    return true;
}

function existsInDBValidator($data, $table, $column)
{

    $credential_name = "name";
    $credential_data = $data;
    $credential_rule = Rule::exists($table, $column)->where(function ($query) {
        $query->where([
            ['delete_flg', '=', '0'],
        ]);
    });

    $rules = [
        $credential_name => [
            $credential_rule
        ]
    ];
    $credentials = [
        $credential_name => $credential_data
    ];

    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
        return false;
    }
    return true;
}

function inArrayValidator($data, $in_array = [])
{

    if (sizeof($in_array) == 0 || isArrayValidator($in_array) == false) {
        return false;
    }

    $credential_name = "name";
    $credential_data = $data;
    $credential_rule = Rule::in($in_array);
    $rules = [
        $credential_name => $credential_rule
    ];
    $credentials = [
        $credential_name => $credential_data
    ];
    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
        return false;
    }
    return true;
}

function isArrayValidator($data)
{
    $credential_name = "name";
    $credential_data = $data;
    $credential_rule = 'array';
    $rules = [
        $credential_name => $credential_rule
    ];
    $credentials = [
        $credential_name => $credential_data
    ];
    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
        return false;
    }
    return true;
}

function presentValidator($data)
{
    $credential_name = "name";
    $credential_data = $data;
    $credential_rule = 'present';
    $rules = [
        $credential_name => $credential_rule
    ];
    $credentials = [
        $credential_name => $credential_data
    ];
    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
        return false;
    }
    return true;
}

function beforeOrEqualValidator($start_date, $end_date)
{
    $credential_start = "start_date";
    $credential_end = "end_date";

    $credential_rule = "before_or_equal:$credential_end";
    $rules = [
        $credential_start => $credential_rule
    ];
    $credentials = [
        $credential_start => $start_date,
        $credential_end => $end_date
    ];
    $validator = Validator::make($credentials, $rules);
    if ($validator->fails()) {
        return false;
    }
    return true;
}

function getDrivePath()
{
    try {
        return env('DRIVE_PATH', '/home/drive');
    } catch (\Throwable $e) {
        throw $e;
    }
}

function makeDir($path)
{
    try {
        return is_dir($path) || mkdir($path);
    } catch (\Throwable $e) {
        throw $e;
    }
}