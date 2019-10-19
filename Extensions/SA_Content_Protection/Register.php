<?php

return [
    'name' => 'Content_Protection',
    'class' => '\SA_EL_ADDONS\Extensions\SA_Content_Protection\SA_Content_Protection',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Extensions/SA_Content_Protection/assets/index.min.css',
        ]
    ],
    'category' => 'Extension',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
