<?php

return [
    'name' => 'pricing_table',
    'class' => '\SA_EL_ADDONS\Elements\Pricing_Table\Pricing_Table',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/tooltipster/css/tooltipster.bundle.min.css',
            SA_EL_ADDONS_PATH . 'Elements/Pricing_Table/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/tooltipster/js/tooltipster.bundle.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Pricing_Table/assets/index.min.js',
        ],
    ],
    'category' => 'Marketing Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
