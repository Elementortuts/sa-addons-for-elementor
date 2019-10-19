<?php

return [
    'name' =>'Offcanvas' ,
        'class' => '\SA_EL_ADDONS\Elements\Offcanvas\Offcanvas',
        'dependency' => [
            'css' => [
                SA_EL_ADDONS_PATH . 'Elements/Offcanvas/assets/index.min.css',
            ],
            'js' => [
                SA_EL_ADDONS_PATH . 'assets/vendor/offcanvas/js/offcanvas.min.js',
                SA_EL_ADDONS_PATH . 'Elements/Offcanvas/assets/index.min.js',
            ],
        ],
        'category' => 'Content Elements',
        'Premium' => TRUE,
        'condition' => '',
        'API' => ''
    
];
