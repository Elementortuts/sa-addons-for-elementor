<?php

return [
    'name' => 'filterable_gallery',
    'class' => '\SA_EL_ADDONS\Elements\Filterable_Gallery\Filterable_Gallery',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/magnific-popup/css/index.min.css',
            SA_EL_ADDONS_PATH . 'Elements/Filterable_Gallery/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/imagesLoaded/js/imagesloaded.pkgd.min.js',
            SA_EL_ADDONS_PATH . 'assets/vendor/isotope/js/isotope.pkgd.min.js',
            SA_EL_ADDONS_PATH . 'assets/vendor/magnific-popup/js/jquery.magnific-popup.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Filterable_Gallery/assets/index.min.js',
        ],
    ],
    'category' => 'Creative Elements',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
