<?php

namespace App;
use App\SimpleImage;


class Helper
{
	public static function resizeImage($img, $img_type = '', $target_img, $new_img_width, $new_img_height)
	{
			$image = new SimpleImage();
			$target_dir = base_path() . '/resources/images/' . $img_type;
			if($img_type != ''){
				$target_file = $target_dir . '/' . $target_img);
			}else{
				$target_file = $target_dir . $target_img);
			}
			$image->load($img);
			$image->resize($new_img_width, $new_img_height);
			$image->save($target_file);
	}
	
	public static function resizeImageToHeight($img, $img_type = '', $target_img, $new_img_height)
	{
			$image = new SimpleImage();
			$target_dir = base_path() . '/resources/images/' . $img_type;
			if($img_type != ''){
				$target_file = $target_dir . '/' . $target_img);
			}else{
				$target_file = $target_dir . $target_img);
			}
			$image->load($img);
			$image->resizeToHeight($new_img_height);
			$image->save($target_file);
	}
	
	public static function resizeImageToWidth($img, $img_type = '', $target_img, $new_img_width)
	{
			$image = new SimpleImage();
			$target_dir = base_path() . '/resources/images/' . $img_type;
			if($img_type != ''){
				$target_file = $target_dir . '/' . $target_img);
			}else{
				$target_file = $target_dir . $target_img);
			}
			$image->load($img);
			$image->resizeToWidth($new_img_width);
			$image->save($target_file);
	}
	
	public static function scaleImage($img, $img_type = '', $scale)
	{
			$image = new SimpleImage();
			$target_dir = base_path() . '/resources/images/' . $img_type;
			if($img_type != ''){
				$target_file = $target_dir . '/' . $target_img);
			}else{
				$target_file = $target_dir . $target_img);
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
		$type   = pathinfo($path, PATHINFO_EXTENSION);
		$data   = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}
}