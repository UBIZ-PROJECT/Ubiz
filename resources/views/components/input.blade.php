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
$is_select = false;
if(isset($select)){
    $is_select = $select;
}
$lbl_style = "";
if(isset($lbl_width)){
    $lbl_style = "width : " . $lbl_width. "px";
}
$html_max_length = "";
if(isset($length)){
    $html_max_length = "maxlength=$length";
}
$html_class = "";
if(isset($class)){
    $html_class = $class;
}
$html_value = "";
if(isset($value)){
    $html_value = $value;
}
$html_i_focus = "i_focus(this)";
if(isset($i_focus)){
    $html_i_focus = $i_focus;
}
$html_i_blur = "i_blur(this)";
if(isset($i_blur)){
    $html_i_blur = $i_blur;
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
            <input is-change="false" onchange="{{ $html_onchange }}" onfocus="{{ $html_i_focus }}" placeholder="{{$html_placeholder}}" onblur="{{ $html_i_blur }}" spellcheck="false" type="text" {{ $html_max_length }} {{$html_control_type}} id="{{$control_id}}" name="{{$control_id}}" value="{{ $html_value }}" class="input_field {{ $html_class }}">
            <input type="hidden" name="{{$control_id}}_old" value="{{ $html_value }}">
            @if($is_select == true)
                <div class="dropdown" id="{{$control_id}}_drd">
                    <svg focusable="false" role="button" id="{{$control_id}}_select" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" height="24px" viewBox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 10l5 5 5-5z"></path>
                        <path d="M0 0h24v24H0z" fill="none"></path>
                    </svg>
                    <div id="{{$control_id}}_drd_menu" class="dropdown-menu dropdown-menu-right" style="width: {{ $html_width }}" aria-labelledby="{{$control_id}}_select"></div>
                </div>
            @endif
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
