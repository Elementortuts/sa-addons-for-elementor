<?php

return [
    'name' => 'count_down',
    'class' => '\SA_EL_ADDONS\Elements\Count_Down\Count_Down',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Count_Down/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/countdown/js/countdown.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Count_Down/assets/index.min.js',
        ],
    ],
    'category' => 'Creative Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
