<?php

return [
    'name' => 'Interactive_Card',
    'class' => '\SA_EL_ADDONS\Elements\Interactive_Card\Interactive_Card',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/interactive-cards/css/interactive-cards.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/nicescroll/js/jquery.nicescroll.min.js',
            SA_EL_ADDONS_PATH . 'assets/vendor/interactive-cards/js/interactive-cards.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Interactive_Card/assets/index.min.js',
        ],
    ],
    'category' => 'Creative Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
