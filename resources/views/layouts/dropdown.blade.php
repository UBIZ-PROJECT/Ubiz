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

<div class="textfield {{$html_type}} root_textfield rootIsUnderlined {{$control_id}}_container">
    <div class="wrapper">
        <label for="{{$control_id}}" class="ms-Label lbl-primary root-56">{{$label}}:</label>
        <div class="fieldGroup">
            <select {{$html_control_type}} id="{{$control_id}}" class="dropdown_field">
                <option value=""></option>
                @foreach($data as $value => $item)
                    <option value="{{ $value  }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>