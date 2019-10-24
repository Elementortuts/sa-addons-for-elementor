<?php

return [
    'name' => 'Simple_Menu',
    'class' => '\SA_EL_ADDONS\Elements\Simple_Menu\Simple_Menu',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Simple_Menu/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'Elements/Simple_Menu/assets/index.min.js',
        ],
    ],
    'category' => 'Header Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
