<?php

namespace SA_EL_ADDONS\Helper;

if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;


trait Post_Query
{
    // All Controls For Query
    public function sa_el_query_controls()
    {
        $this->add_control(
            'post_type',
            [
                'label' => __('Source', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => self::post_type(),
                'default' => key(self::post_type()),
            ]
        );
        $this->add_control(
            'authors',
            [
                'label' => __('Author', SA_EL_ADDONS_TEXTDOMAIN),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => [],
                'options' => self::post_author(),
                'condition' => [
                    'post_type!' => 'by_id',
                ],
            ]
        );
        foreach (self::post_type() as $key => $value) {
            if ($key != 'page') :
                $this->add_control(
                    $key . '_category',
                    [
                        'label' => __('Category', SA_EL_ADDONS_TEXTDOMAIN),
                        'label_block' => true,
                        'type' => Controls_Manager::SELECT2,
                        'multiple' => true,
                        'default' => [],
                        'options' => self::post_category($key),
                        'condition' => [
                            'post_type' => $key,
                        ],
                    ]
                );
                $this->add_control(
                    $key . '_tag',
                    [
                        'label' => __('Tags', SA_EL_ADDONS_TEXTDOMAIN),
                        'label_block' => true,
                        'type' => Controls_Manager::SELECT2,
                        'multiple' => true,
                        'default' => [],
                        'options' => self::post_tags($key),
                        'condition' => [
                            'post_type' => $key,
                        ],
                    ]
                );
            endif;
            $this->add_control(
                $key . '_include',
                [
                    'label' => __('Include', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_block' => true,
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'default' => [],
                    'options' => self::post_include($key),
                    'condition' => [
                        'post_type' => $key,
                    ],
                ]
            );
            $this->add_control(
                $key . '_exclude',
                [
                    'label' => __('Exclude', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_block' => true,
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'default' => [],
                    'options' => self::post_exclude($key),
                    'condition' => [
                        'post_type' => $key,
                    ],
                ]
            );
        }
        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => __('Offset', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => self::get_post_orderby_options(),
                'default' => 'date',

            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
                'default' => 'desc',

            ]
        );
    }
    // All Query Layout Controls
    public function sa_el_layout_controls()
    {
        if ($this->get_name() === 'sa_el_post_grid') {
            $this->add_responsive_control(
                'sa_el_post_grid_columns',
                [
                    'label' => esc_html__('Number of Columns', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'sa-el-col-4',
                    'options' => [
                        'sa-el-col-1' => esc_html__('Single Column', SA_EL_ADDONS_TEXTDOMAIN),
                        'sa-el-col-2' => esc_html__('Two Columns', SA_EL_ADDONS_TEXTDOMAIN),
                        'sa-el-col-3' => esc_html__('Three Columns', SA_EL_ADDONS_TEXTDOMAIN),
                        'sa-el-col-4' => esc_html__('Four Columns', SA_EL_ADDONS_TEXTDOMAIN),
                        'sa-el-col-5' => esc_html__('Five Columns', SA_EL_ADDONS_TEXTDOMAIN),
                        'sa-el-col-6' => esc_html__('Six Columns', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                ]
            );
        }
        if ($this->get_name() === 'sa_el_post_block') {
            $this->add_control(
                'grid_style',
                [
                    'label' => esc_html__('Post Block Style Preset', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'post-block-style-default',
                    'options' => [
                        'post-block-style-default' => esc_html__('Default', SA_EL_ADDONS_TEXTDOMAIN),
                        'post-block-style-overlay' => esc_html__('Overlay', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                ]
            );
        }
        if ($this->get_name() !== 'sa_el_post_carousel') {
            if ($this->get_name() === 'sa_el_content_timeline') {
                $this->add_control(
                    'content_timeline_layout',
                    [
                        'label' => esc_html__('Layout', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'center',
                        'options' => [
                            'left'   => esc_html__('Right', SA_EL_ADDONS_TEXTDOMAIN),
                            'center' => esc_html__('Center', SA_EL_ADDONS_TEXTDOMAIN),
                            'right'  => esc_html__('Left', SA_EL_ADDONS_TEXTDOMAIN),
                        ],
                        'default'   => 'center'
                    ]
                );

                $this->add_control(
                    'date_position',
                    [
                        'label' => esc_html__('Date Position', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'inside',
                        'options' => [
                            'inside'   => esc_html__('Inside', SA_EL_ADDONS_TEXTDOMAIN),
                            'outside' => esc_html__('Outside', SA_EL_ADDONS_TEXTDOMAIN)
                        ],
                        'default'   => 'inside',
                        'condition' => [
                            'content_timeline_layout!'  => 'center'
                        ]
                    ]
                );

                $this->add_control(
                    'sa_el_show_read_more',
                    [
                        'label' => __('Show Read More', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::CHOOSE,
                        'options' => [
                            '1' => [
                                'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                                'icon' => 'fa fa-check',
                            ],
                            '0' => [
                                'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                                'icon' => 'fa fa-ban',
                            ],
                        ],
                        'default' => '1',
                        'condition' => [
                            'sa_el_content_timeline_choose' => 'dynamic',
                        ],
                    ]
                );

                $this->add_control(
                    'sa_el_read_more_text',
                    [
                        'label' => esc_html__('Label Text', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => false,
                        'default' => esc_html__('Read More', SA_EL_ADDONS_TEXTDOMAIN),
                        'condition' => [
                            'sa_el_content_timeline_choose' => 'dynamic',
                            'sa_el_show_read_more' => '1',
                        ],
                    ]
                );
            } else {
                $this->add_control(
                    'show_load_more',
                    [
                        'label' => __('Show Load More', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::CHOOSE,
                        'options' => [
                            '1' => [
                                'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                                'icon' => 'fa fa-check',
                            ],
                            '0' => [
                                'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                                'icon' => 'fa fa-ban',
                            ],
                        ],
                        'default' => '0',
                    ]
                );

                $this->add_control(
                    'show_load_more_text',
                    [
                        'label' => esc_html__('Label Text', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => false,
                        'default' => esc_html__('Load More', SA_EL_ADDONS_TEXTDOMAIN),
                        'condition' => [
                            'show_load_more' => '1',
                        ],
                    ]
                );
            }
        }
        if ($this->get_name() !== 'sa_el_content_timeline') {
            $this->add_control(
                'sa_el_show_image',
                [
                    'label' => __('Show Image', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        '1' => [
                            'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-check',
                        ],
                        '0' => [
                            'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-ban',
                        ],
                    ],
                    'default' => '1',
                ]
            );
            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'image',
                    'exclude' => ['custom'],
                    'default' => 'medium',
                    'condition' => [
                        'sa_el_show_image' => '1',
                    ],
                ]
            );
        }
        if ($this->get_name() === 'sa_el_content_timeline') {
            $this->add_control(
                'sa_el_show_image_or_icon',
                [
                    'label' => __('Show Circle Image / Icon', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'img' => [
                            'title' => __('Image', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-picture-o',
                        ],
                        'icon' => [
                            'title' => __('Icon', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-info',
                        ],
                        'bullet' => [
                            'title' => __('Bullet', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-circle',
                        ],
                    ],
                    'default' => 'icon',
                    'condition' => [
                        'sa_el_content_timeline_choose' => 'dynamic',
                    ],
                ]
            );

            $this->add_control(
                'sa_el_icon_image',
                [
                    'label' => esc_html__('Icon Image', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'sa_el_show_image_or_icon' => 'img',
                    ],
                ]
            );
            $this->add_control(
                'sa_el_icon_image_size',
                [
                    'label' => esc_html__('Icon Image Size', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 24,
                    ],
                    'range' => [
                        'px' => [
                            'max' => 60,
                        ],
                    ],
                    'condition' => [
                        'sa_el_show_image_or_icon' => 'img',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .eael-content-timeline-img img' => 'width: {{SIZE}}px;',
                    ],
                ]
            );

            $this->add_control(
                'sa_el_content_timeline_circle_icon_new',
                [
                    'label' => esc_html__('Icon', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa4compatibility' 		=> 'sa_el_content_timeline_circle_icon',
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-pencil-alt',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'sa_el_content_timeline_choose' => 'dynamic',
                        'sa_el_show_image_or_icon' => 'icon',
                    ],
                ]
            );
        }
        $this->add_control(
            'sa_el_show_title',
            [
                'label' => __('Show Title', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-ban',
                    ],
                ],
                'default' => '1',
            ]
        );

        $this->add_control(
            'sa_el_show_excerpt',
            [
                'label' => __('Show excerpt', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-ban',
                    ],
                ],
                'default' => '1',
            ]
        );

        $this->add_control(
            'sa_el_excerpt_length',
            [
                'label' => __('Excerpt Words', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::NUMBER,
                'default' => '10',
                'condition' => [
                    'sa_el_show_excerpt' => '1',
                ],
            ]
        );

        $this->add_control(
            'excerpt_expanison_indicator',
            [
                'label' => esc_html__('Expanison Indicator', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => esc_html__('...', SA_EL_ADDONS_TEXTDOMAIN),
                'condition' => [
                    'sa_el_show_excerpt' => '1',
                ],
            ]
        );

        if (($this->get_name() === 'sa_el_post_grid') || ($this->get_name() === 'sa_el_post_block') || ($this->get_name() === 'sa_el_post_carousel')) {
            $this->add_control(
                'sa_el_show_read_more_button',
                [
                    'label' => __('Show Read More Button', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        '1' => [
                            'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-check',
                        ],
                        '0' => [
                            'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-ban',
                        ],
                    ],
                    'default' => '1',
                ]
            );

            $this->add_control(
                'read_more_button_text',
                [
                    'label' => __('Button Text', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Read More', SA_EL_ADDONS_TEXTDOMAIN),
                    'condition' => [
                        'sa_el_show_read_more_button' => '1',
                    ],
                ]
            );
        }
        if (($this->get_name() === 'sa_el_post_grid') || ($this->get_name() === 'sa_el_post_block') || ($this->get_name() === 'sa_el_post_carousel')) {

            $this->add_control(
                'sa_el_show_meta',
                [
                    'label' => __('Show Meta', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        '1' => [
                            'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-check',
                        ],
                        '0' => [
                            'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-ban',
                        ],
                    ],
                    'default' => '1',
                ]
            );

            $this->add_control(
                'meta_position',
                [
                    'label' => esc_html__('Meta Position', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'meta-entry-footer',
                    'options' => [
                        'meta-entry-header' => esc_html__('Entry Header', SA_EL_ADDONS_TEXTDOMAIN),
                        'meta-entry-footer' => esc_html__('Entry Footer', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                    'condition' => [
                        'sa_el_show_meta' => '1',
                    ],
                ]
            );
        }
    }

    public function sa_el_load_more_style()
    {
        $this->start_controls_section(
            'sa_el_section_load_more_btn',
            [
                'label' => __('Load More Button Style', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_load_more' => '1',
                ],
            ]
        );

        $this->add_responsive_control(
            'sa_el_post_grid_load_more_btn_padding',
            [
                'label' => esc_html__('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sa_el_post_grid_load_more_btn_margin',
            [
                'label' => esc_html__('Margin', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_post_grid_load_more_btn_typography',
                'selector' => '{{WRAPPER}} .sa-el-load-more-button',
            ]
        );

        $this->start_controls_tabs('sa_el_post_grid_load_more_btn_tabs');

        // Normal State Tab
        $this->start_controls_tab('sa_el_post_grid_load_more_btn_normal', ['label' => esc_html__('Normal', SA_EL_ADDONS_TEXTDOMAIN)]);

        $this->add_control(
            'sa_el_post_grid_load_more_btn_normal_text_color',
            [
                'label' => esc_html__('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sa_el_cta_btn_normal_bg_color',
            [
                'label' => esc_html__('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#29d8d8',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sa_el_post_grid_load_more_btn_normal_border',
                'label' => esc_html__('Border', SA_EL_ADDONS_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .sa-el-load-more-button',
            ]
        );

        $this->add_control(
            'sa_el_post_grid_load_more_btn_border_radius',
            [
                'label' => esc_html__('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sa_el_post_grid_load_more_btn_shadow',
                'selector' => '{{WRAPPER}} .sa-el-load-more-button',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab('sa_el_post_grid_load_more_btn_hover', ['label' => esc_html__('Hover', SA_EL_ADDONS_TEXTDOMAIN)]);

        $this->add_control(
            'sa_el_post_grid_load_more_btn_hover_text_color',
            [
                'label' => esc_html__('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sa_el_post_grid_load_more_btn_hover_bg_color',
            [
                'label' => esc_html__('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#27bdbd',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sa_el_post_grid_load_more_btn_hover_border_color',
            [
                'label' => esc_html__('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]

        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sa_el_post_grid_load_more_btn_hover_shadow',
                'selector' => '{{WRAPPER}} .sa-el-load-more-button:hover',
                'separator' => 'before',
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'sa_el_post_grid_loadmore_button_alignment',
            [
                'label' => __('Button Alignment', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button-wrap' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    // Query Rander
    public function query_args($settings)
    {
        // fix old settings
        // foreach($settings as $key => $value) {
        //     if(strpos($key, 'saeposts_') !== false) {
        //         $settings[str_replace('saeposts_', '', $key)] = $value;
        //         unset($settings[$key]);
        //     }
        // };
        $settings = wp_parse_args($settings, [
            'post_type' => 'post',
            'orderby' => 'date',
            'order' => 'desc',
            'posts_per_page' => 3,
            'offset' => 0,
            'post__not_in' => [],
        ]);

        $args = [
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post_status' => 'publish',
            'posts_per_page' => $settings['posts_per_page'],
            'offset' => $settings['offset']
        ];
        $args['post_type'] = $settings['post_type'];
        $args['tax_query'] = [];
        if (!empty($settings['authors'])) {
            $args['author__in'] = $settings['authors'];
        }
        $type = $settings['post_type'];
        if (!empty($settings[$type . '_exclude'])) {
            $args['post__not_in'] = $settings[$type . '_exclude'];
        }
        if (!empty($settings[$type . '_include'])) {
            $args['post__in'] = $settings[$type . '_include'];
        }
        if ($type != 'page') :
            if (!empty($settings[$type . '_category'])) :
                $args['tax_query'][] = [
                    'taxonomy' => $type . '_category',
                    'field' => 'term_id',
                    'terms' => $settings[$type . '_category'],
                ];
            endif;
            if (!empty($settings[$type . '_tag'])) :
                $args['tax_query'][] = [
                    'taxonomy' => $type . '_tag',
                    'field' => 'term_id',
                    'terms' => $settings[$type . '_tag'],
                ];
            endif;
            if (!empty($args['tax_query'])) :
                $args['tax_query']['relation'] = 'OR';
            endif;
        endif;
        return $args;
    }

    // All Query start
    public static function post_type()
    {
        return get_post_types(array('public' => true, 'show_in_nav_menus' => true), 'names');
    }

    public static function post_author()
    {
        $us = [];
        $users = get_users();
        if ($users) {
            foreach ($users as $user) {
                $us[$user->ID] = ucfirst($user->display_name);
            }
        }
        return $us;
    }

    public static function post_category($type)
    {
        $cat = [];
        $categories = get_terms(array(
            'taxonomy' => $type == 'post' ? 'category' : $type . '_category',
            'hide_empty' => true,
        ));
        if (empty($categories) || is_wp_error($categories)) :
            return [];
        endif;

        foreach ($categories as $categorie) {
            $cat[$categorie->term_id] = ucfirst($categorie->name);
        }
        return $cat;
    }

    public static function post_tags($type)
    {
        $tg = [];
        $tags = get_terms(array(
            'taxonomy' => $type . '_tag',
            'hide_empty' => true,
        ));
        if (empty($tags) || is_wp_error($tags)) :
            return [];
        endif;

        foreach ($tags as $tag) {
            $tg[$tag->term_id] = ucfirst($tag->name);
        }

        return $tg;
    }

    public static function post_include($type)
    {
        $post_list = get_posts(array(
            'post_type' => $type,
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => -1,
        ));
        if (empty($post_list) && is_wp_error($post_list)) :
            return [];
        endif;
        $posts = array();
        foreach ($post_list as $post) {
            $posts[$post->ID] = ucfirst($post->post_title);
        }
        return $posts;
    }

    public static function post_exclude($type)
    {
        $post_list = get_posts(array(
            'post_type' => $type,
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => -1,
        ));
        if (empty($post_list) && is_wp_error($post_list)) :
            return [];
        endif;
        $posts = array();
        foreach ($post_list as $post) {
            $posts[$post->ID] = ucfirst($post->post_title);
        }
        return $posts;
    }

    public static function thumbnail_sizes()
    {
        $default_image_sizes = get_intermediate_image_sizes();
        $thumbnail_sizes = array();
        foreach ($default_image_sizes as $size) {
            $image_sizes[$size] = $size . ' - ' . intval(get_option("{$size}_size_w")) . ' x ' . intval(get_option("{$size}_size_h"));
            $thumbnail_sizes[$size] = str_replace('_', ' ', ucfirst($image_sizes[$size]));
        }
        return $thumbnail_sizes;
    }

    /**
     * POst Orderby Options
     *
     */
    public static function get_post_orderby_options()
    {
        $orderby = array(
            'ID' => 'Post ID',
            'author' => 'Post Author',
            'title' => 'Title',
            'date' => 'Date',
            'modified' => 'Last Modified Date',
            'parent' => 'Parent Id',
            'rand' => 'Random',
            'comment_count' => 'Comment Count',
            'menu_order' => 'Menu Order',
        );

        return $orderby;
    }
    // All Query End
}
