<?php

use App as App;
use App\User as User;
use Illuminate\Support\Facades\DB as DB;
use Intervention\Image\ImageManagerStatic as Image;

function resizeImage($img, $target_img, $new_img_width, $new_img_height, $img_type = '')
{
    try {
        $target_dir = base_path() . '/resources/images/' . $img_type;
        if ($img_type != '') {
            $target_file = $target_dir . '/' . $target_img;
        } else {
            $target_file = $target_dir . $target_img;
        }

        $image = Image::make($img);
        $image->resize($new_img_width, $new_img_height);
        $image->save($target_file);
    } catch (\Throwable $e) {
        throw $e;
    }
}

function resizeImageToHeight($img, $target_img, $new_img_height, $img_type = '')
{
    try {

        $target_dir = base_path() . '/resources/images/' . $img_type;
        if ($img_type != '') {
            $target_file = $target_dir . '/' . $target_img;
        } else {
            $target_file = $target_dir . $target_img;
        }

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

        $target_dir = base_path() . '/resources/images/' . $img_type;
        if ($img_type != '') {
            $target_file = $target_dir . '/' . $target_img;
        } else {
            $target_file = $target_dir . $target_img;
        }

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

function scaleImage($img, $scale, $img_type = '')
{
    try {
        $image = new SimpleImage();
        $target_dir = base_path() . '/resources/images/' . $img_type;
        if ($img_type != '') {
            $target_file = $target_dir . '/' . $target_img;
        } else {
            $target_file = $target_dir . $target_img;
        }

        $image = Image::make($img);

        $new_img_width = $image->width() * $scale / 100;
        $new_img_height = $image->height() * $scale / 100;

        $image->resize($new_img_width, $new_img_height);
        $image->save($target_file);

    } catch (\Throwable $e) {
        throw $e;
    }
}

function saveOriginalImage($img, $target_img, $img_type = '')
{
    try {
        $target_dir = base_path() . '/resources/images/' . $img_type;
        if ($img_type != '') {
            $target_file = $target_dir . '/' . $target_img;
        } else {
            $target_file = $target_dir . $target_img;
        }
        if ($target_dir !== "/" && $target_dir !== "" && !is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image = Image::make($img);
        $image->save($target_file);
    } catch (\Throwable $e) {
        throw $e;
    }
}

function readImage($img, $img_type = '')
{
    try {
        if ($img_type != '') {
            $path = base_path() . '/resources/images/' . $img_type . '/' . $img;
        } else {
            $path = base_path() . '/resources/images/' . $img;
        }
        if (empty($img) || !file_exists($path)) {
            return "";
        }
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
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
        }abort(403);
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
