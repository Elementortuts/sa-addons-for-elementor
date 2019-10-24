<?php

return [
    'name' => 'Content_Ticker',
    'class' => '\SA_EL_ADDONS\Elements\Content_Ticker\Content_Ticker',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Content_Ticker/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'Elements/Content_Ticker/assets/index.min.js',
        ],
    ],
    'category' => 'Post Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
