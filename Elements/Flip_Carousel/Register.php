<?php

return [
    'name' => 'flip_carousel',
    'class' => '\SA_EL_ADDONS\Elements\Flip_Carousel\Flip_Carousel',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/flipster/css/jquery.flipster.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/flipster/js/jquery.flipster.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Flip_Carousel/assets/index.min.js',
        ]
    ],
    'category' => 'Carousel & Slider',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
