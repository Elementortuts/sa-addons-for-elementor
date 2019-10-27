<?php

return [
    'name' => 'Recipe',
    'class' => '\SA_EL_ADDONS\Elements\Recipe\Recipe',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Recipe/assets/index.min.css',
        ],
        'js' => [

            SA_EL_ADDONS_PATH . 'Elements/Recipe/assets/index.min.js',
        ],
    ],
    'category' => 'Creative Elements',
    'Premium' => FALSE,
    'condition' => '',
    'API' => ''
];
