<?php

return [
    'name' => 'Justified_Gallery',
    'class' => '\SA_EL_ADDONS\Elements\Justified_Gallery\Justified_Gallery',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/justifiedGallery/css/justifiedGallery.min.css',
            SA_EL_ADDONS_PATH . 'Elements/Justified_Gallery/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/justifiedGallery/js/jquery.justifiedGallery.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Justified_Gallery/assets/index.min.js',
        ],
    ],
    'category' => 'Creative Elements',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
