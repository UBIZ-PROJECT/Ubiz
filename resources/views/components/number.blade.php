<?php

$html_type = '';
$html_control_type = '';
$html_placeholder = '';
if (isset($placeholder)) {
    $html_placeholder = $placeholder;
}
if (!isset($type)) {
    $type = '';
}
$html_width = "300px";
if(isset($width)){
    $html_width = $width . "px";
}
$lbl_style = "";
if(isset($lbl_width)){
    $lbl_style = "width : " . $lbl_width. "px";
}
$html_max_length = "10";
if(isset($length)){
    $html_max_length = $length;
}
$html_class = "";
if(isset($class)){
    $html_class = $class;
}
$html_value = "";
if(isset($value)){
    $html_value = $value;
}
$html_min = "0";
if(isset($min)){
    $html_min = $min;
}
$html_max = "2147483648";
if(isset($max)){
    $html_max = $max;
}
$html_onchange = "";
if(isset($onchange)){
    $html_onchange = $onchange;
}

switch ($type) {
    case 'disabled':
        $html_type = 'rootIsDisabled';
        $html_control_type = 'disabled';
        break;
    case 'required':
        $html_type = 'rootIsRequiredLabel';
        $html_control_type = 'required';
        break;
    default:
        break;
}
?>

<div class="textfield {{$html_type}} root_textfield rootIsUnderlined {{$control_id}}_container" style="width: {{ $html_width }}">
    <div class="wrapper">
        <label for="{{$control_id}}" class="ms-Label root-56 lbl-primary" style="{{$lbl_style}}">{{$label}}:</label>
        <div class="fieldGroup">
            <input is-change="false" onchange="{{ $html_onchange }}" onfocus="num_focus(this)" onblur="num_blur(this)" onkeydown="num_keydown(event)" min="{{ $html_min }}" max="{{ $html_max }}" placeholder="{{$html_placeholder}}" spellcheck="false" type="text" maxlength="{{ $html_max_length }}" {{$html_control_type}} id="{{$control_id}}" name="{{$control_id}}" value="{{ $html_value }}" class="input_field {{ $html_class }}">
            <input type="hidden" name="{{$control_id}}_old" value="{{ $html_value }}">
        </div>
    </div>
    <span class="error_message hidden-content">
       <div class="message-container">
          <p class="label_errorMessage css-57 errorMessage">
              <span class="error-message-text"></span>
          </p>
       </div>
    </span>
</div>
