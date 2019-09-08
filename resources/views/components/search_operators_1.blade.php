<?php
$operators = [
    [
        'key' => env('EQUAL_TO', 1),
        'name' => __('Equal To')
    ],
    [
        'key' => env('NOT_EQUAL_TO', 2),
        'name' => __('Not Equal To')
    ],
    [
        'key' => env('CONTAIN', 7),
        'name' => __('Contain')
    ],
    [
        'key' => env('NOT_CONTAIN', 8),
        'name' => __('Not Contain')
    ],
];
?>
@include('components.search_operators',['operators'=>$operators])
