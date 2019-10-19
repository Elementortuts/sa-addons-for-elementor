<?php

return [
     'name' => 'Image_Hotspots' ,
        'class' => '\SA_EL_ADDONS\Elements\Image_Hotspots\Image_Hotspots',
        'dependency' => [
            'css' => [
                SA_EL_ADDONS_PATH . 'Elements/Image_Hotspots/assets/index.min.css',
            ],
            'js' => [
                SA_EL_ADDONS_PATH . 'assets/vendor/tipso/js/tipso.min.js',
                SA_EL_ADDONS_PATH . 'Elements/Image_Hotspots/assets/index.min.js',
            ]
        ],
        'category' => 'Creative Elements',
        'Premium' => FALSE,
        'condition' => '',
        'API' => ''

];
