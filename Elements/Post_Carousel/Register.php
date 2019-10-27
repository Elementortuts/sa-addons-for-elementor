<?php

return [
    'name' => 'Post_Carousel',
    'class' => '\SA_EL_ADDONS\Elements\Post_Carousel\Post_Carousel',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Post_Carousel/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'Elements/Post_Carousel/assets/index.min.js',
        ],
    ],
    'category' => 'Post Elements',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
