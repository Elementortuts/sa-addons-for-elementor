<?php

return [
    'name' => 'Counter',
    'class' => '\SA_EL_ADDONS\Elements\Counter\Counter',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/odometer/css/odometer-theme-default.min.css',
            SA_EL_ADDONS_PATH . 'Elements/Counter/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/waypoints/js/waypoints.min.js',
            SA_EL_ADDONS_PATH . 'assets/vendor/odometer/js/odometer.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Counter/assets/index.min.js',
        ],
    ],
    'category' => 'Creative Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
