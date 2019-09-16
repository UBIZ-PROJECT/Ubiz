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
        'key' => env('GREATER_THAN', 3),
        'name' => __('Greater Than')
    ],
    [
        'key' => env('LESS_THAN', 4),
        'name' => __('Less Than')
    ],
    [
        'key' => env('GREATER_THAN_OR_EQUAL_TO', 5),
        'name' => __('Greater Than Or Equal To')
    ],
    [
        'key' => env('LESS_THAN_OR_EQUAL_TO', 6),
        'name' => __('Less Than Or Equal To')
    ]
];
?>
@include('components.search_operators',['operators'=>$operators, 'name'=>$name])
