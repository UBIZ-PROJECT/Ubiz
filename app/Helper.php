<?php

namespace App;
use App\SimpleImage;


class Helper
{
	public static function resizeImage($img, $img_type, $target_img, $new_img_width, $new_img_height)
	{
			$image = new SimpleImage();
			$target_dir = base_path() . '/public/images/' . $img_type . '/';
			$target_file = $target_dir . $target_img);
			$image->load($img);
			$image->resize($new_img_width, $new_img_height);
			$image->save($target_file);
	}
	
	public static function readImage($img, $img_type)
	{
		$path   = base_path() . '/public/images/' . $img_type . '/' . $img;
		$type   = pathinfo($path, PATHINFO_EXTENSION);
		$data   = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}
}