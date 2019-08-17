<?php

$html_value = "";
if (isset($value)) {
    $html_value = $value;
}
?>

<input type="hidden" name="{{$control_id}}" value="{{ $html_value }}">
