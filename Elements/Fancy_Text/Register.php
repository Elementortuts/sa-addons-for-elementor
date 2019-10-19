<?php

return [
    'name' => 'Fancy_Text',
    'class' => '\SA_EL_ADDONS\Elements\Fancy_Text\Fancy_Text',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Fancy_Text/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/fancy-text/js/fancy-text.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Fancy_Text/assets/index.min.js',
        ],
    ],
    'category' => 'Creative Elements',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
