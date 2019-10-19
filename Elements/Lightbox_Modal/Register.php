<?php

return [
    'name' => 'Lightbox_Modal',
    'class' => '\SA_EL_ADDONS\Elements\Lightbox_Modal\Lightbox_Modal',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/magnific-popup/css/index.min.css',
            SA_EL_ADDONS_PATH . 'Elements/Lightbox_Modal/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/magnific-popup/js/jquery.magnific-popup.min.js',
            SA_EL_ADDONS_PATH . 'assets/vendor/cookie/js/jquery.cookie.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Lightbox_Modal/assets/index.min.js',
        ],
    ],
    'category' => 'Creative Elements',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
