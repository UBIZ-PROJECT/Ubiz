<?php
$operators = [
    [
        'key' => env('BETWEEN', 9),
        'name' => __('Between')
    ],
    [
        'key' => env('NOT_BETWEEN', 10),
        'name' => __('Not Between')
    ]
];
?>
@include('components.search_operators',['operators'=>$operators, 'name'=>$name])
