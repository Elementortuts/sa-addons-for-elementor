<?php

return [
    'name' => 'Image_Comparison',
    'class' => '\SA_EL_ADDONS\Elements\Image_Comparison\Image_Comparison',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/twentytwenty/css/twentytwenty.min.css',
            SA_EL_ADDONS_PATH . 'Elements/Image_Comparison/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/event_move/js/jquery.event.move.min.js',
            SA_EL_ADDONS_PATH . 'assets/vendor/twentytwenty/js/jquery.twentytwenty.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Image_Comparison/assets/index.min.js',
        ],
    ],
    'category' => 'Creative Elements',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
