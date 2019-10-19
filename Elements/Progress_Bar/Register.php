<?php

return [
    'name' => 'progress_bar',
    'class' => '\SA_EL_ADDONS\Elements\Progress_Bar\Progress_Bar',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Progress_Bar/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/inview/js/inview.min.js',
            SA_EL_ADDONS_PATH . 'assets/vendor/progress-bar/js/progress-bar.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Progress_Bar/assets/index.min.js',
        ],
    ],
    'category' => 'Creative Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
