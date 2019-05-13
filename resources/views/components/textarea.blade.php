<?php

$html_type = '';
$html_control_type = '';
if (!isset($type)) {
    $type = '';
}
$html_width = "300px";
if(isset($width)){
    $html_width = $width . "px";
}
$html_height = "150px";
if(isset($height)) {
    $html_height = $height . "px";
}
$html_max_length = "";
if(isset($length)){
    $html_max_length = "maxlength=$length";
}
$html_class = "";
if(isset($class)){
    $html_class = $class;
}

$html_resize = "both";
if(isset($resize)){
    $html_resize = $resize;
}

$html_value = "";
if(isset($value)){
    $html_value = $value;
}

$html_lable_class = "";
if(isset($lable_class)){
    $html_lable_class = $lable_class;
}

$placeholder = $label;
if(!isset($lable_class) || $lable_class != 'hidden-content'){
    $placeholder = "";
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

<div class="textarea {{$html_type}} root_textarea rootIsUnderlined {{$control_id}}_container" style="width: {{ $html_width }}">
    <label for="{{$control_id}}" class="ms-Label root-56 lbl-primary {{ $html_lable_class }}">{{$label}}:</label>
    <div class="wrapper">
        <div class="fieldGroup_area">
            <textarea style="height: {{$html_height}};width: {{ $html_width }}; resize: {{ $html_resize }}" is-change="false" placeholder="{{$placeholder}}" {{ $html_max_length }} {{$html_control_type}} id="{{$control_id}}" name="{{$control_id}}" class="input-textarea {{ $html_class }}">{{ $html_value }}</textarea>
            <textarea style="display: none" name="{{$control_id}}_old">{{ $html_value }}</textarea>
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
