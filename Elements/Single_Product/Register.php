<?php

return [
    'name' => 'single_product',
    'class' => '\SA_EL_ADDONS\Elements\Single_Product\Single_Product',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Single_Product/assets/index.min.css',
            SA_EL_ADDONS_PATH . 'Elements/Single_Product/assets/overlay.min.css',
        ],
    ],
    'category' => 'Content Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
