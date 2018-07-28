<?php
$default_width = 150;
$default_height = 150;
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

$default_label_height = $default_height / 3.8;
?>
<div class='image-upload mb-1' style="max-width: {{$width}}px; max-height: {{$height}}px">
	<img src="{{$src}}" img-name="" style="height: {{$height}}px; width:{{$width}}px" alt="{{$alt}}" class="img-thumbnail img-show {{$class}}" onclick="openFileUpload(this)">
	<input type='file' accept="image/*" name="inp-upload-image" is-change='false' onchange="readURL(this);" class="file-upload" style='display:none'>
	<span class="label-change" style="width: {{$default_width}}px; top: -{{$default_label_height}}px; line-height:{{$default_label_height}}px; height: {{$default_label_height}}px" onclick="openFileUpload(this)">{{ __("Change") }}</span>
</div>
