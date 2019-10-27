<?php

return [
    'name' => 'Post_Timeline',
    'class' => '\SA_EL_ADDONS\Elements\Post_Timeline\Post_Timeline',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Post_Timeline/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'Elements/Post_Timeline/assets/index.min.js',
        ],
    ],
    'category' => 'Post Elements',
    'Premium' => true,
    'condition' => '',
    'API' => ''
];
