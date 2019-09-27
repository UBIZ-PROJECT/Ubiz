<?php

use App as App;
use App\User as User;
use Illuminate\Validation\Rule as Rule;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Http\Testing\MimeType as MimeType;
use Illuminate\Support\Facades\Storage as Storage;
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

function resizeImageBase64($img_base64, $img_uuid, $img_width, $img_height, $img_type)
{
    try {
        $drive_path = getDrivePath();
        $img_dir = $drive_path . '/images/' . $img_type;
        makeDir($img_dir);

        $image = Image::make($img_base64);
        $image_ext = MimeType::search($image->mime());

        $img_name = "$img_uuid.$image_ext";
        $img_file = "$img_dir/$img_name";
        $image->resize($img_width, $img_height);
        $image->save($img_file);
        return $img_name;
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

function mailValidator($mail)
{
    $credential_name = "name";
    $credential_data = $mail;
    $rules = [
        $credential_name => 'email'
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
        return is_dir($path) || mkdir($path, 0777, true);
    } catch (\Throwable $e) {
        throw $e;
    }
}

function rebuild_date($format, $time = 0)
{
    try {
        if (!$time) $time = time();

        $lang = array();
        $lang['sun'] = 'CN';
        $lang['mon'] = 'T2';
        $lang['tue'] = 'T3';
        $lang['wed'] = 'T4';
        $lang['thu'] = 'T5';
        $lang['fri'] = 'T6';
        $lang['sat'] = 'T7';
        $lang['sunday'] = 'Chủ nhật';
        $lang['monday'] = 'Thứ hai';
        $lang['tuesday'] = 'Thứ ba';
        $lang['wednesday'] = 'Thứ tư';
        $lang['thursday'] = 'Thứ năm';
        $lang['friday'] = 'Thứ sáu';
        $lang['saturday'] = 'Thứ bảy';
        $lang['january'] = 'Tháng Một';
        $lang['february'] = 'Tháng Hai';
        $lang['march'] = 'Tháng Ba';
        $lang['april'] = 'Tháng Tư';
        $lang['may'] = 'Tháng Năm';
        $lang['june'] = 'Tháng Sáu';
        $lang['july'] = 'Tháng Bảy';
        $lang['august'] = 'Tháng Tám';
        $lang['september'] = 'Tháng Chín';
        $lang['october'] = 'Tháng Mười';
        $lang['november'] = 'Tháng M. một';
        $lang['december'] = 'Tháng M. hai';
        $lang['jan'] = 'T01';
        $lang['feb'] = 'T02';
        $lang['mar'] = 'T03';
        $lang['apr'] = 'T04';
        $lang['may2'] = 'T05';
        $lang['jun'] = 'T06';
        $lang['jul'] = 'T07';
        $lang['aug'] = 'T08';
        $lang['sep'] = 'T09';
        $lang['oct'] = 'T10';
        $lang['nov'] = 'T11';
        $lang['dec'] = 'T12';

        $format = str_replace("r", "D, d M Y H:i:s O", $format);
        $format = str_replace(array("D", "M"), array("[D]", "[M]"), $format);
        $return = date($format, $time);

        $replaces = array(
            '/\[Sun\](\W|$)/' => $lang['sun'] . "$1",
            '/\[Mon\](\W|$)/' => $lang['mon'] . "$1",
            '/\[Tue\](\W|$)/' => $lang['tue'] . "$1",
            '/\[Wed\](\W|$)/' => $lang['wed'] . "$1",
            '/\[Thu\](\W|$)/' => $lang['thu'] . "$1",
            '/\[Fri\](\W|$)/' => $lang['fri'] . "$1",
            '/\[Sat\](\W|$)/' => $lang['sat'] . "$1",
            '/\[Jan\](\W|$)/' => $lang['jan'] . "$1",
            '/\[Feb\](\W|$)/' => $lang['feb'] . "$1",
            '/\[Mar\](\W|$)/' => $lang['mar'] . "$1",
            '/\[Apr\](\W|$)/' => $lang['apr'] . "$1",
            '/\[May\](\W|$)/' => $lang['may2'] . "$1",
            '/\[Jun\](\W|$)/' => $lang['jun'] . "$1",
            '/\[Jul\](\W|$)/' => $lang['jul'] . "$1",
            '/\[Aug\](\W|$)/' => $lang['aug'] . "$1",
            '/\[Sep\](\W|$)/' => $lang['sep'] . "$1",
            '/\[Oct\](\W|$)/' => $lang['oct'] . "$1",
            '/\[Nov\](\W|$)/' => $lang['nov'] . "$1",
            '/\[Dec\](\W|$)/' => $lang['dec'] . "$1",
            '/Sunday(\W|$)/' => $lang['sunday'] . "$1",
            '/Monday(\W|$)/' => $lang['monday'] . "$1",
            '/Tuesday(\W|$)/' => $lang['tuesday'] . "$1",
            '/Wednesday(\W|$)/' => $lang['wednesday'] . "$1",
            '/Thursday(\W|$)/' => $lang['thursday'] . "$1",
            '/Friday(\W|$)/' => $lang['friday'] . "$1",
            '/Saturday(\W|$)/' => $lang['saturday'] . "$1",
            '/January(\W|$)/' => $lang['january'] . "$1",
            '/February(\W|$)/' => $lang['february'] . "$1",
            '/March(\W|$)/' => $lang['march'] . "$1",
            '/April(\W|$)/' => $lang['april'] . "$1",
            '/May(\W|$)/' => $lang['may'] . "$1",
            '/June(\W|$)/' => $lang['june'] . "$1",
            '/July(\W|$)/' => $lang['july'] . "$1",
            '/August(\W|$)/' => $lang['august'] . "$1",
            '/September(\W|$)/' => $lang['september'] . "$1",
            '/October(\W|$)/' => $lang['october'] . "$1",
            '/November(\W|$)/' => $lang['november'] . "$1",
            '/December(\W|$)/' => $lang['december'] . "$1");

        return preg_replace(array_keys($replaces), array_values($replaces), $return);
    } catch (\Throwable $e) {
        throw $e;
    }
}

function makeMailConf($smtp_username, $smtp_password, $from_email, $from_name)
{
    try {
        $mail_conf = [];
        $mail_conf['smtp_host'] = 'smtp.gmail.com';
        $mail_conf['smtp_port'] = '465';
        $mail_conf['smtp_encryption'] = 'ssl';
        $mail_conf['smtp_username'] = $smtp_username;
        $mail_conf['smtp_password'] = $smtp_password;
        $mail_conf['from_email'] = $from_email;
        $mail_conf['from_name'] = $from_name;
        return $mail_conf;
    } catch (\Throwable $e) {
        throw $e;
    }
}

/**
 * @param $search_name | String
 * @param $search_value | String | Array
 * @param $search_operator | [1,..,10]
 * @return array
 * @throws Throwable
 */
function buildSearchCond($search_name, $search_value, $search_operator)
{

    $params = [];
    $where_raw = [];
    $search_cond = [];

    $search_value = $search_value == null ? '' : $search_value;

    switch ($search_operator) {
        case env('EQUAL_TO'):
            if (is_array($search_value)) {
                foreach ($search_value as $value) {
                    $params[] = $value;
                    $where_raw[] = buildEqualToSearchCond($search_name);
                }
            }

            if (is_string($search_value)) {
                $params[] = $search_value;
                $where_raw[] = buildEqualToSearchCond($search_name);
            }

            $search_cond['params'] = $params;
            $search_cond['where_raw'] = " ( " . implode('OR', $where_raw) . " ) ";
            break;
        case env('NOT_EQUAL_TO'):
            if (is_array($search_value)) {
                foreach ($search_value as $value) {
                    $params[] = $value;
                    $where_raw[] = buildNotEqualToSearchCond($search_name);
                }
            }

            if (is_string($search_value)) {
                $params[] = $search_value;
                $where_raw[] = buildNotEqualToSearchCond($search_name);
            }

            $search_cond['params'] = $params;
            $search_cond['where_raw'] = " ( " . implode('AND', $where_raw) . " ) ";
            break;
        case env('GREATER_THAN'):
            $params[] = $search_value;
            $where_raw[] = buildGreaterThanSearchCond($search_name);
            $search_cond['params'] = $params;
            $search_cond['where_raw'] = " ( " . implode('AND', $where_raw) . " ) ";
            break;
        case env('LESS_THAN'):
            $params[] = $search_value;
            $where_raw[] = buildLessThanSearchCond($search_name);
            $search_cond['params'] = $params;
            $search_cond['where_raw'] = " ( " . implode('AND', $where_raw) . " ) ";
            break;
        case env('GREATER_THAN_OR_EQUAL_TO'):
            $params[] = $search_value;
            $where_raw[] = buildGreaterThanOrEqualToSearchCond($search_name);
            $search_cond['params'] = $params;
            $search_cond['where_raw'] = " ( " . implode('AND', $where_raw) . " ) ";
            break;
        case env('LESS_THAN_OR_EQUAL_TO'):
            $params[] = $search_value;
            $where_raw[] = buildLessThanOrEqualToSearchCond($search_name);
            $search_cond['params'] = $params;
            $search_cond['where_raw'] = " ( " . implode('AND', $where_raw) . " ) ";
            break;
        case env('CONTAIN'):
            if (is_array($search_value)) {
                foreach ($search_value as $value) {
                    $params[] = $value;
                    $where_raw[] = buildContainSearchCond($search_name, $search_value);
                }
            }

            if (is_string($search_value)) {
                $params[] = $search_value;
                $where_raw[] = buildContainSearchCond($search_name, $search_value);
            }

            $search_cond['params'] = $params;
            $search_cond['where_raw'] = " ( " . implode('OR', $where_raw) . " ) ";
            break;
        case env('NOT_CONTAIN'):
            if (is_array($search_value)) {
                foreach ($search_value as $value) {
                    $params[] = $value;
                    $where_raw[] = buildNotContainSearchCond($search_name, $search_value);
                }
            }

            if (is_string($search_value)) {
                $params[] = $search_value;
                $where_raw[] = buildNotContainSearchCond($search_name, $search_value);
            }

            $search_cond['params'] = $params;
            $search_cond['where_raw'] = " ( " . implode('AND', $where_raw) . " ) ";
            break;
        case env('BETWEEN'):

            if ($search_value['from'] == '' && $search_value['to'] != '') {
                $params[] = $search_value['to'];
                $where_raw[] = buildLessThanOrEqualToSearchCond($search_name);
            } elseif ($search_value['from'] != '' && $search_value['to'] == '') {
                $params[] = $search_value['from'];
                $where_raw[] = buildGreaterThanOrEqualToSearchCond($search_name);
            } elseif ($search_value['from'] != '' && $search_value['to'] != '') {
                $params[] = $search_value['from'];
                $params[] = $search_value['to'];
                $where_raw[] = buildBetweenSearchCond($search_name);
            }

            $search_cond['params'] = $params;
            $search_cond['where_raw'] = " ( " . implode('', $where_raw) . " ) ";
            break;
        case env('NOT_BETWEEN'):
            if ($search_value['from'] == '' && $search_value['to'] != '') {
                $params[] = $search_value['to'];
                $where_raw[] = buildGreaterThanOrEqualToSearchCond($search_name);
            } elseif ($search_value['from'] != '' && $search_value['to'] == '') {
                $params[] = $search_value['from'];
                $where_raw[] = buildLessThanOrEqualToSearchCond($search_name);
            } elseif ($search_value['from'] != '' && $search_value['to'] != '') {
                $params[] = $search_value['from'];
                $params[] = $search_value['to'];
                $where_raw[] = buildNotBetweenSearchCond($search_name);
            }

            $search_cond['params'] = $params;
            $search_cond['where_raw'] = " ( " . implode('', $where_raw) . " ) ";
            break;
    }
    return $search_cond;
}

function buildEqualToSearchCond($search_name)
{
    try {
        $search_cond = " $search_name = ? ";
        return $search_cond;
    } catch (\Throwable $e) {
        throw $e;
    }
}

function buildNotEqualToSearchCond($search_name)
{
    try {
        $search_cond = " $search_name != ? ";
        return $search_cond;
    } catch (\Throwable $e) {
        throw $e;
    }
}

function buildGreaterThanSearchCond($search_name)
{
    try {
        $search_cond = " $search_name > ? ";
        return $search_cond;
    } catch (\Throwable $e) {
        throw $e;
    }
}

function buildGreaterThanOrEqualToSearchCond($search_name)
{
    try {
        $search_cond = " $search_name >= ?  ";
        return $search_cond;
    } catch (\Throwable $e) {
        throw $e;
    }
}

function buildLessThanSearchCond($search_name)
{
    try {
        $search_cond = " $search_name < ? ";
        return $search_cond;
    } catch (\Throwable $e) {
        throw $e;
    }
}

function buildLessThanOrEqualToSearchCond($search_name)
{
    try {
        $search_cond = " $search_name <= ? ";
        return $search_cond;
    } catch (\Throwable $e) {
        throw $e;
    }
}

function buildContainSearchCond($search_name, $search_value)
{
    try {
        if ($search_value == '') {
            $search_cond = " COALESCE($search_name,'') = ? ";
        } else {
            $search_cond = " COALESCE($search_name,'') REGEXP ? ";
        }
        return $search_cond;
    } catch (\Throwable $e) {
        throw $e;
    }
}

function buildNotContainSearchCond($search_name, $search_value)
{
    try {
        try {
            if ($search_value == '') {
                $search_cond = " COALESCE($search_name,'') != ? ";
            } else {
                $search_cond = " COALESCE($search_name,'') NOT REGEXP ? ";
            }
            return $search_cond;
        } catch (\Throwable $e) {
            throw $e;
        }
    } catch (\Throwable $e) {
        throw $e;
    }
}

function buildBetweenSearchCond($search_name)
{
    try {
        $search_cond = " $search_name BETWEEN ? AND ? ";
        return $search_cond;
    } catch (\Throwable $e) {
        throw $e;
    }
}

function buildNotBetweenSearchCond($search_name)
{
    try {
        $search_cond = " $search_name NOT BETWEEN ? AND ? ";
        return $search_cond;
    } catch (\Throwable $e) {
        throw $e;
    }
}