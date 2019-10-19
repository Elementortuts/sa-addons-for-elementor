<?php

return [
    'name' => 'Advance_Tooltip',
    'class' => '\SA_EL_ADDONS\Extensions\SA_Advance_Tooltip\SA_Advance_Tooltip',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/tippy/css/tippy.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/popper/js/popper.min.js',
            SA_EL_ADDONS_PATH . 'assets/vendor/tippy/js/tippy.min.js',
            SA_EL_ADDONS_PATH . 'Extensions/SA_Advance_Tooltip/assets/index.min.js',
        ],
    ],
    'category' => 'Extension',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
