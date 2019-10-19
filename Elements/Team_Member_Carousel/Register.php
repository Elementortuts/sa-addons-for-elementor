<?php

return [
    'name' => 'team_member_carousel',
    'class' => '\SA_EL_ADDONS\Elements\Team_Member_Carousel\Team_Member_Carousel',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Team_Member_Carousel/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'Elements/Team_Member_Carousel/assets/index.min.js',
        ],
    ],
    'category' => 'Carousel & Slider',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
