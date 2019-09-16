<?php
$operators = [
    [
        'key' => env('EQUAL_TO', 1),
        'name' => __('Equal To')
    ],
    [
        'key' => env('NOT_EQUAL_TO', 2),
        'name' => __('Not Equal To')
    ]
];
?>
@include('components.search_operators',['operators'=>$operators, 'name'=>$name])
