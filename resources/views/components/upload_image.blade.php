<?php
$default_width = 150;
$default_height = 150;
if (empty($multiUpload) || $multiUpload == false) {
    $multiUpload = '';
} else {
    $multiUpload = "[]";
}
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

if (empty($callback)) {
    $callback = 'jQuery.UbizOIWidget.w_callback_remove_image';
}
if (empty($label_class)) {
    $label_class = "label-change";
}

?>
<div class='image-upload mb-1' style="width: {{$width}}px; height: {{$height}}px">
	<img src="{{$src}}" img-name="" style="height: {{$height}}px; width:{{$width}}px" alt="{{$alt}}" class="img-thumbnail img-show {{$class}}" onclick="openFileUpload(this)">
	<input type='file' accept="image/*" name="inp-upload-image{{$multiUpload}}" is-change='false' onchange="readURL(this,{{$callback}});" class="file-upload" style='display:none'>
    <button type="button" style="top: -{{$height}}px;" class="close" aria-label="Close" onclick="removeImage(this, {{$callback}})">
        <span aria-hidden="true">&times;</span>
    </button>
    <span class="{{$label_class}}" style="width: {{$width}}px;" onclick="openFileUpload(this)">{{ __("Change") }}</span>
</div>
