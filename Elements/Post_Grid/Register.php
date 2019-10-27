<?php

return [
    'name' => 'Post_Grid',
    'class' => '\SA_EL_ADDONS\Elements\Post_Grid\Post_Grid',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Post_Grid/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'Elements/Post_Grid/assets/index.min.js',
        ],
    ],
    'category' => 'Post Elements',
    'Premium' => true,
    'condition' => '',
    'API' => ''
];
