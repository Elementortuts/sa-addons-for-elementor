<?php

return [
    'name' => 'data_table',
    'class' => '\SA_EL_ADDONS\Elements\Data_Table\Data_Table',
    'dependency' => [
        'css' => [
            SA_EL_ADDONS_PATH . 'Elements/Data_Table/assets/index.min.css',
        ],
        'js' => [
            SA_EL_ADDONS_PATH . 'Elements/Data_Table/assets/index.min.js',
            SA_EL_ADDONS_PATH . 'assets/vendor/table-sorter/js/jquery.tablesorter.min.js',
        ],
    ],
    'category' => 'Dynamic Contents',
    'Premium' => TRUE,
    'condition' => '',
    'API' => ''
];
