<?php

return [
    'name' => 'Content_Timeline',
    'class' => '\SA_EL_ADDONS\Elements\Content_Timeline\Content_Timeline',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Content_Timeline/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'Elements/Content_Timeline/assets/index.min.js',
        ],
    ],
    'category' => 'Post Elements',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
