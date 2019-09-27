<?php
$operators = [
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
@include('components.search_operators',['operators'=>$operators, 'name'=>$name])
