<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/12/2018
 * Time: 10:29 PM
 */

$html_type = '';
$html_control_type = '';
if (!isset($type)) {
    $type = '';
}

$html_value = "0";
if (isset($value)) {
    $html_value = $value;
}
$html_checked = "";
if (isset($checked) && $checked == true) {
    $html_checked = "checked";
}
$html_width = "300px";
if(isset($width)){
    $html_width = $width . "px";
    if (strpos($width, "%") > -1) {
        $html_width = $width;
    }
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
<?php if($type == 1) {?>
    <div class="{{$html_type}} {{$control_id}}_container" style="width: {{ $html_width }}; display: inline-block;">
    <div class="wrapper">
        <div>
            <div class="{{ $html_checked == "checked"?"sck":"suc" }}" onclick="checkbox_click(this)"></div>
            <input is-change="false"
                   type="checkbox"
                   {{ $html_checked }}
                   {{ $html_control_type }}
                   id="{{ $control_id }}"
                   value="{{ $html_value }}"
                   style="display: none"
                   class="checkbox_field"
            />
            <input type="hidden" name="{{$control_id}}_old" value="{{ $html_value }}">
        </div>
    </div>
</div>
<?php } else {?>
    <div class="textfield {{$html_type}} root_textfield rootIsUnderlined {{$control_id}}_container" style="width: {{ $html_width }}">
        <div class="wrapper">
            <label for="{{$control_id}}" class="lbl-primary ms-Label root-56">{{$label}}:</label>
            <div class="fieldGroup">
                <div class="{{ $html_checked == "checked"?"sck":"suc" }}" onclick="checkbox_click(this)"></div>
                <input is-change="false"
                       type="checkbox"
                       {{ $html_checked }}
                       {{ $html_control_type }}
                       id="{{ $control_id }}"
                       value="{{ $html_value }}"
                       style="display: none"
                       class="checkbox_field"
                />
                <input type="hidden" name="{{$control_id}}_old" value="{{ $html_value }}">
            </div>
        </div>
    </div>
<?php } ?>
