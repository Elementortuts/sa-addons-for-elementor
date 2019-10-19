<?php

return [
    'name' => 'tabs',
    'class' => '\SA_EL_ADDONS\Elements\Tabs\Tabs',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Tabs/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'Elements/Tabs/assets/index.min.js',
        ],
    ],
    'category' => 'Content Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
