<?php

return [
    'name' => 'Post_Block',
    'class' => '\SA_EL_ADDONS\Elements\Post_Block\Post_Block',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Post_Block/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'Elements/Post_Block/assets/index.min.js',
        ],
    ],
    'category' => 'Post Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
