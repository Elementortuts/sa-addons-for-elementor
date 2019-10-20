<?php

return [
    'name' => 'Table',
    'class' => '\SA_EL_ADDONS\Elements\Table\Table',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Table/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'assets/vendor/table-sorter/js/jquery.tablesorter.min.js',
            SA_EL_ADDONS_PATH . 'Elements/Table/assets/index.min.js',
        ],
    ],
    'category' => 'Dynamic Contents',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
