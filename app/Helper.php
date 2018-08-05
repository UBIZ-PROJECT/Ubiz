<?php

namespace App;

use App;
use App\User;
use App\Libs\SimpleImage;
use Illuminate\Support\Facades\DB;

class Helper
{
    public static function resizeImage($img, $target_img, $new_img_width, $new_img_height, $img_type = '')
    {
        $image = new SimpleImage();
        $target_dir = base_path() . '/resources/images/' . $img_type;
        if ($img_type != '') {
            $target_file = $target_dir . '/' . $target_img;
        } else {
            $target_file = $target_dir . $target_img;
        }
        $image->load($img);
        $image->resize($new_img_width, $new_img_height);
        $image->save($target_file);
    }

    public static function saveOriginalImage($img, $target_img, $img_type = '')
    {
        $image = new SimpleImage();
        $target_dir = base_path() . '/resources/images/' . $img_type;
        if ($img_type != '') {
            $target_file = $target_dir . '/' . $target_img;
        } else {
            $target_file = $target_dir . $target_img;
        }
        $image->load($img);
        $image->save($target_file);
    }

    public static function resizeImageToHeight($img, $target_img, $new_img_height, $img_type = '')
    {
        $image = new SimpleImage();
        $target_dir = base_path() . '/resources/images/' . $img_type;
        if ($img_type != '') {
            $target_file = $target_dir . '/' . $target_img;
        } else {
            $target_file = $target_dir . $target_img;
        }
        $image->load($img);
        $image->resizeToHeight($new_img_height);
        $image->save($target_file);
    }

    public static function resizeImageToWidth($img, $target_img, $new_img_width, $img_type = '')
    {
        $image = new SimpleImage();
        $target_dir = base_path() . '/resources/images/' . $img_type;
        if ($img_type != '') {
            $target_file = $target_dir . '/' . $target_img;
        } else {
            $target_file = $target_dir . $target_img;
        }
        $image->load($img);
        $image->resizeToWidth($new_img_width);
        $image->save($target_file);
    }

    public static function scaleImage($img, $scale, $img_type = '')
    {
        $image = new SimpleImage();
        $target_dir = base_path() . '/resources/images/' . $img_type;
        if ($img_type != '') {
            $target_file = $target_dir . '/' . $target_img;
        } else {
            $target_file = $target_dir . $target_img;
        }
        $image->load($img);
        $image->scale($scale);
        $image->save($target_file);
    }

    public static function readImage($img, $img_type = '')
    {
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
    }

    public static function readJsonBasedLanguage()
    {
        $json_based_language = "{}";
        $locale = App::getLocale();
        $path = base_path() . "/resources/lang/$locale.json";
        if (file_exists($path)) {
            $json_based_language = file_get_contents($path);
        }
        return $json_based_language;
    }

    public static function checkScreenUserRight($screen_id)
    {
        try {

            $user = new User();
            $data = $user->getAuthUser();

            if($data == null)
                return false;

            $user_right = DB::table('permission')
                ->select('screen_id', 'screen_name', 'screen_status')
                ->where([
                    ['dep_id', '=', $data->dep_id],
                    ['screen_id', '=', $screen_id],
                    ['delete_flg', '=', '0']
                ])
                ->first();

            if($user_right == null)
                return false;

            if($user_right->screen_status == '0')
                return false;

        } catch (\Throwable $e) {
            throw $e;
        }
        return true;

    }

    public static function convertDataToDropdownOptions($data, $value, $option)
    {
        $options = [];
        foreach ($data as $item) {
            if (property_exists($item, $value) && property_exists($item, $option)) {
                $options[$item->$value] = $item->$option;
            }
        }
        return $options;
    }
}