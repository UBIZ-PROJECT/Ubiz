<?php

namespace App;
use App\Libs\SimpleImage;


class Helper
{
	public static function resizeImage($img, $target_img, $new_img_width, $new_img_height, $img_type = '')
	{
			$image = new SimpleImage();
			$target_dir = base_path() . '/resources/images/' . $img_type;
			if($img_type != ''){
				$target_file = $target_dir . '/' . $target_img;
			}else{
				$target_file = $target_dir . $target_img;
			}
			$image->load($img);
			$image->resize($new_img_width, $new_img_height);
			$image->save($target_file);
	}
	
	public static function resizeImageToHeight($img, $target_img, $new_img_height, $img_type = '')
	{
			$image = new SimpleImage();
			$target_dir = base_path() . '/resources/images/' . $img_type;
			if($img_type != ''){
				$target_file = $target_dir . '/' . $target_img;
			}else{
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
			if($img_type != ''){
				$target_file = $target_dir . '/' . $target_img;
			}else{
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
			if($img_type != ''){
				$target_file = $target_dir . '/' . $target_img;
			}else{
				$target_file = $target_dir . $target_img;
			}
			$image->load($img);
			$image->scale($scale);
			$image->save($target_file);
	}
	
	public static function readImage($img, $img_type = '')
	{
		if($img_type != ''){
			$path   = base_path() . '/resources/images/' . $img_type . '/' . $img;
		}else{
			$path   = base_path() . '/resources/images/' . $img;
		}
		if (empty($img) || !file_exists($path)) {
		    return "";
        }
		$type   = pathinfo($path, PATHINFO_EXTENSION);
		$data   = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}
}