<?php

return [
    'name' => 'Showcase',
    'class' => '\SA_EL_ADDONS\Elements\Showcase\Showcase',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/fancybox/css/jquery.fancybox.min.css',
            SA_EL_ADDONS_PATH . 'Elements/Showcase/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/fancybox/js/jquery.fancybox.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Showcase/assets/index.min.js',
        ],
    ],
    'category' => 'Creative Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
