<?php
	$default_width = 100;
	$default_height = 100;
	if (empty($alt)) {
		$alt = '';
	}
	if (empty($width)) {
		$width = $default_width;
	}
	if (empty($height)) {
		$height = $default_height;
	}
	if (empty($src)) {
		$src = "../images/avatar.png";
	}
	if (empty($class)) {
		$class = '';
	}
?>
<div class='image-upload mb-1' style="max-width: {{$width}}px; max-height: {{$height}}px">
	<img src="{{$src}}" img-name="" style="height: {{$height}}px; width:{{$width}}px" alt="{{$alt}}" class="img-thumbnail img-show {{$class}}" onclick="openFileUpload(this)">
	<input type='file' name="inp-upload-image" is-change='false' onchange="readURL(this);" class="file-upload" style='display:none'>
	<span class="label-change" onclick="openFileUpload(this)">Thay đổi</span>
</div>
