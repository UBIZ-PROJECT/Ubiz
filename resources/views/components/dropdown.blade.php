<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/12/2018
 * Time: 10:29 PM
 */
$lbl_style = "";
if(isset($lbl_width)){
    $lbl_style = "width : " . $lbl_width. "px";
}
$html_type = '';
$html_control_type = '';
if (!isset($type)) {
    $type = '';
}
$html_width = "300px";
if(isset($width)){
    $html_width = $width . "px";
}
$html_value = "";
if(isset($value)){
    $html_value = $value;
}

if(!isset($label)) {
    $label = '';
} else {
    $label = $label . ":";
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
        <label for="{{$control_id}}" class="lbl-primary ms-Label root-56" style="{{$lbl_style}}">{{$label}}</label>
        <div class="fieldGroup">
            <select name="{{$control_id}}" id="{{$control_id}}" {{$html_control_type}} class="dropdown_field">
                <option value=""></option>
                @foreach( $data as $value => $options)
                    <option value="{{ $value }}" {{ $html_value == $value ? "selected" : "" }}>{{ $options }}</option>
                @endforeach
            </select>
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