<?php

namespace SA_EL_ADDONS\Elements\Content_Timeline;

if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Controls_Manager as Controls_Manager;
use \Elementor\Group_Control_Background as Group_Control_Background;
use \Elementor\Scheme_Typography as Scheme_Typography;
use \Elementor\Group_Control_Border as Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography as Group_Control_Typography;
use \Elementor\Utils as Utils;
use \Elementor\Widget_Base as Widget_Base;
use \Elementor\ElementsCommonFunctions;

use \SA_EL_ADDONS\Elements\Content_Timeline\Files\Post_Query as Post_Query;

class Content_Timeline extends Widget_Base
{

    use \SA_EL_ADDONS\Helper\Elementor_Helper;
    use \SA_EL_ADDONS\Helper\Post_Query;


    public function get_name()
    {
        return 'sa_el_content_timeline';
    }

    public function get_title()
    {
        return esc_html__('Content Timeline', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon()
    {
        return 'eicon-time-line oxi-el-admin-icon';
    }

    public function get_categories()
    {
        return ['sa-el-addons'];
    }

    protected function _register_controls()
    {
        /**
         * Custom Timeline Settings
         */
        $this->start_controls_section(
            'sa_el_section_custom_timeline_settings',
            [
                'label' => __('Timeline Content', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'sa_el_content_timeline_choose',
            [
                'label'           => esc_html__('Content Source', SA_EL_ADDONS_TEXTDOMAIN),
                'type'             => Controls_Manager::SELECT,
                'default'         => 'dynamic',
                'label_block'     => false,
                'options'         => [
                    'custom'      => esc_html__('Custom', SA_EL_ADDONS_TEXTDOMAIN),
                    'dynamic'      => esc_html__('Dynamic', SA_EL_ADDONS_TEXTDOMAIN),
                ],
            ]
        );

        $this->end_controls_section();
        /**
         * Custom Content
         */
        $this->start_controls_section(
            'sa_el_section_custom_content_settings',
            [
                'label' => __('Custom Content Settings', SA_EL_ADDONS_TEXTDOMAIN),
                'condition' => [
                    'sa_el_content_timeline_choose' => 'custom'
                ],
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'sa_el_coustom_content_posts',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => [
                    [
                        'sa_el_custom_title' => __('The Ultimate Addons For Elementor', SA_EL_ADDONS_TEXTDOMAIN),
                        'sa_el_custom_excerpt' => __('A new concept of showing content in your web page with more interactive way.', SA_EL_ADDONS_TEXTDOMAIN),
                        'sa_el_custom_post_date' => 'Nov 09, 2017',
                        'sa_el_read_more_text_link' => '#',
                        'sa_el_show_custom_read_more' => '1',
                        'sa_el_show_custom_read_more_text' => 'Read More',
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'sa_el_custom_title',
                        'label' => esc_html__('Title', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => esc_html__('The Ultimate Addons For Elementor', SA_EL_ADDONS_TEXTDOMAIN),
                        'dynamic' => ['active' => true]
                    ],
                    [
                        'name' => 'sa_el_custom_excerpt',
                        'label' => esc_html__('Content', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::WYSIWYG,
                        'label_block' => true,
                        'default' => esc_html__('A new concept of showing content in your web page with more interactive way.', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                    [
                        'name' => 'sa_el_custom_post_date',
                        'label' => __('Post Date', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Nov 09, 2017', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                    [
                        'name' => 'sa_el_show_custom_image_or_icon',
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
                            ]
                        ],
                        'default' => 'icon',
                        'separator' => 'before'
                    ],
                    [
                        'name' => 'sa_el_custom_icon_image',
                        'label' => esc_html__('Icon Image', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'condition' => [
                            'sa_el_show_custom_image_or_icon' => 'img',
                        ]
                    ],
                    [
                        'name' => 'sa_el_custom_icon_image_size',
                        'label' => esc_html__('Icon Image Size', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::NUMBER,
                        'default' => 24,
                        'condition' => [
                            'sa_el_show_custom_image_or_icon' => 'img',
                        ],
                    ],
                    [
                        'name' => 'sa_el_custom_content_timeline_circle_icon',
                        'label' => esc_html__('Icon', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::ICON,
                        'default' => 'fa fa-pencil',
                        'condition' => [
                            'sa_el_show_custom_image_or_icon' => 'icon',
                        ]
                    ],
                    [
                        'name' => 'sa_el_show_custom_read_more',
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
                            ]
                        ],
                        'default' => '1',
                        'separator' => 'before'
                    ],
                    [
                        'name' => 'sa_el_show_custom_read_more_text',
                        'label' => esc_html__('Label Text', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => esc_html__('Read More', SA_EL_ADDONS_TEXTDOMAIN),
                        'condition' => [
                            'sa_el_show_custom_read_more' => '1',
                        ]
                    ],
                    [
                        'name' => 'sa_el_read_more_text_link',
                        'label' => esc_html__('Button Link', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::URL,
                        'label_block' => true,
                        'default' => [
                            'url' => '#',
                            'is_external' => '',
                        ],
                        'show_external' => true,
                        'condition' => [
                            'sa_el_show_custom_read_more' => '1',
                        ]
                    ],
                ],
                'title_field' => '{{sa_el_custom_title}}',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'sa_el_section_timeline__filters',
            [
                'label' => __('Dynamic Content Settings', SA_EL_ADDONS_TEXTDOMAIN),
                'condition' => [
                    'sa_el_content_timeline_choose' => 'dynamic'
                ],
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->sa_el_query_controls();

        $this->end_controls_section();

        $this->start_controls_section(
            'sa_el_section_post_timeline_layout',
            [
                'label' => __('Layout Settings', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->sa_el_layout_controls();

        $this->end_controls_section();


        $this->start_controls_section(
            'sa_el_section_post_timeline_style',
            [
                'label' => __('Timeline Style', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'sa_el_timeline_line_size',
            [
                'label' => esc_html__('Line Size', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 4,
                ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-line' => 'width: {{SIZE}}px;',
                    '{{WRAPPER}} .sa-el-content-timeline-line .sa-el-content-timeline-inner' => 'width: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'sa_el_timeline_line_from_left',
            [
                'label' => esc_html__('Position From Left', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 2,
                ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-line' => 'margin-left: -{{SIZE}}px;',
                ],
                'description' => __('Use half of the Line size for perfect centering', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'sa_el_timeline_line_color',
            [
                'label' => __('Inactive Line Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#d7e4ed',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-line' => 'background: {{VALUE}}',
                ]

            ]
        );

        $this->add_control(
            'sa_el_timeline_line_active_color',
            [
                'label' => __('Active Line Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#2EC9F3',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-line .sa-el-content-timeline-inner' => 'background: {{VALUE}}',
                ]

            ]
        );

        $this->end_controls_section();

        /**
         * Card Style
         */
        $this->start_controls_section(
            'sa_el_section_post_timeline_card_style',
            [
                'label' => __('Card Style', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'sa_el_card_bg_color',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#f1f2f3',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .sa-el-content-timeline-content::before' => 'border-left-color: {{VALUE}}; border-right-color: {{VALUE}};',
                ]

            ]
        );

        $this->add_responsive_control(
            'sa_el_card_padding',
            [
                'label' => esc_html__('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sa_el_card_margin',
            [
                'label' => esc_html__('Margin', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sa_el_card_border',
                'label' => esc_html__('Border', SA_EL_ADDONS_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .sa-el-content-timeline-content',
            ]
        );

        $this->add_responsive_control(
            'sa_el_card_radius',
            [
                'label' => esc_html__('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sa_el_card_shadow',
                'selector' => '{{WRAPPER}} .sa-el-content-timeline-content',
            ]
        );

        $this->end_controls_section();

        /**
         * Icon Circle Style
         */
        $this->start_controls_section(
            'sa_el_section_post_timeline_icon_circle_style',
            [
                'label' => __('Bullet Style', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'sa_el_icon_circle_size',
            [
                'label' => esc_html__('Bullet Size', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 40,
                ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-img' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'sa_el_icon_font_size',
            [
                'label' => esc_html__('Icon Font Size', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 14,
                ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-img i' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'sa_el_icon_circle_from_top',
            [
                'label' => esc_html__('Position From Top', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 8,
                ],
                'range' => [
                    'px' => [
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-img' => 'margin-top: {{SIZE}}px;',
                    '{{WRAPPER}} .sa-el-content-timeline-line' => 'margin-top: {{SIZE}}px;',
                    '{{WRAPPER}} ..sa-el-content-timeline-line .sa-el-content-timeline-inner' => 'margin-top: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'sa_el_icon_circle_from_left',
            [
                'label' => esc_html__('Position From Left', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'description' => __('Use half of the Icon Cicle Size for perfect centering', SA_EL_ADDONS_TEXTDOMAIN),
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-img' => 'margin-left: -{{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'sa_el_icon_circle_border_width',
            [
                'label' => esc_html__('Bullet Border Width', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 6,
                ],
                'range' => [
                    'px' => [
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-img.sa-el-picture' => 'border-width: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'sa_el_icon_circle_color',
            [
                'label' => __('Bullet Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#f1f2f3',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-img.sa-el-picture' => 'background: {{VALUE}}',
                ]

            ]
        );


        $this->add_control(
            'sa_el_icon_circle_border_color',
            [
                'label' => __('Bullet Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#f9f9f9',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-img.sa-el-picture' => 'border-color: {{VALUE}}',
                ]

            ]
        );


        $this->add_control(
            'sa_el_icon_circle_font_color',
            [
                'label' => __('Bullet Font Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-img i' => 'color: {{VALUE}}',
                ]

            ]
        );


        $this->add_control(
            'sa_el_timeline_icon_active_state',
            [
                'label' => __('Active State (Highlighted)', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sa_el_icon_circle_active_color',
            [
                'label' => __('Bullet Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#2EC9F3',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-block.highlight .sa-el-content-timeline-img.sa-el-picture' => 'background: {{VALUE}}',
                ]

            ]
        );


        $this->add_control(
            'sa_el_icon_circle_active_border_color',
            [
                'label' => __('Bullet Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-block.highlight .sa-el-content-timeline-img.sa-el-picture' => 'border-color: {{VALUE}}',
                ]

            ]
        );

        $this->add_control(
            'sa_el_icon_circle_active_font_color',
            [
                'label' => __('Bullet Font Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-block.highlight .sa-el-content-timeline-img i' => 'color: {{VALUE}}',
                ]

            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'sa_el_section_typography',
            [
                'label' => __('Color & Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'sa_el_timeline_title_style',
            [
                'label' => __('Title Style', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sa_el_timeline_title_color',
            [
                'label' => __('Title Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#303e49',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content h2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .sa-el-content-timeline-content h2 a' => 'color: {{VALUE}};',
                ]

            ]
        );

        $this->add_responsive_control(
            'sa_el_timeline_title_alignment',
            [
                'label' => __('Title Alignment', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-right',
                    ]
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content h2' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .sa-el-content-timeline-content h2 a' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_timeline_title_typography',
                'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .sa-el-content-timeline-content h2 a',
            ]
        );

        $this->add_control(
            'sa_el_timeline_excerpt_style',
            [
                'label' => __('Excerpt Style', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sa_el_timeline_excerpt_color',
            [
                'label' => __('Excerpt Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content p' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'sa_el_timeline_excerpt_alignment',
            [
                'label' => __('Excerpt Alignment', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_timeline_excerpt_typography',
                'label' => __('Excerpt Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .sa-el-content-timeline-content p',
            ]
        );

        $this->add_control(
            'sa_el_timeline_date_style',
            [
                'label' => __('Date Style', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'sa_el_timeline_date_margin',
            [
                'label' => esc_html__('Margin', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sa_el_timeline_date_color',
            [
                'label' => __('Date Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#4d4d4d',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-date' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_timeline_date_typography',
                'label' => __('excerpt Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-date',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sa_el_section_load_more_btn',
            [
                'label' => __('Load More Button Style', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_load_more' => '1'
                ]
            ]
        );

        $this->add_responsive_control(
            'sa_el_post_block_load_more_btn_padding',
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
            'sa_el_post_block_load_more_btn_margin',
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
                'name' => 'sa_el_post_block_load_more_btn_typography',
                'selector' => '{{WRAPPER}} .sa-el-load-more-button',
            ]
        );

        $this->start_controls_tabs('sa_el_post_block_load_more_btn_tabs');

        // Normal State Tab
        $this->start_controls_tab('sa_el_post_block_load_more_btn_normal', ['label' => esc_html__('Normal', SA_EL_ADDONS_TEXTDOMAIN)]);

        $this->add_control(
            'sa_el_post_block_load_more_btn_normal_text_color',
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
            'sa_el_load_more_bg_color',
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
                'name' => 'sa_el_post_block_load_more_btn_normal_border',
                'label' => esc_html__('Border', SA_EL_ADDONS_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .sa-el-load-more-button',
            ]
        );

        $this->add_control(
            'sa_el_post_block_load_more_btn_border_radius',
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

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab('sa_el_post_block_load_more_btn_hover', ['label' => esc_html__('Hover', SA_EL_ADDONS_TEXTDOMAIN)]);

        $this->add_control(
            'sa_el_post_block_load_more_btn_hover_text_color',
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
            'sa_el_post_block_load_more_btn_hover_bg_color',
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
            'sa_el_post_block_load_more_btn_hover_border_color',
            [
                'label' => esc_html__('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]

        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sa_el_post_block_load_more_btn_shadow',
                'selector' => '{{WRAPPER}} .sa-el-load-more-button',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'sa_el_post_timeline_load_more_loader_pos_title',
            [
                'label' => esc_html__('Loader Position', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'sa_el_post_timeline_loader_pos_left',
            [
                'label' => esc_html__('From Left', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button.button--loading .button__loader' => 'left: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'sa_el_post_timeline_loader_pos_top',
            [
                'label' => esc_html__('From Top', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-load-more-button.button--loading .button__loader' => 'top: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style (Button Style)
         * -------------------------------------------
         */
        $this->start_controls_section(
            'sa_el_read_more_button_style',
            [
                'label' => esc_html__('Read More Button Style', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'sa_el_read_more_padding',
            [
                'label' => esc_html__('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sa_el_read_more_margin',
            [
                'label' => esc_html__('Margin', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_read_more_typography',
                'selector' => '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-read-more',
            ]
        );

        $this->start_controls_tabs('sa_el_read_more_tabs');

        // Normal State Tab
        $this->start_controls_tab('sa_el_read_more_normal', ['label' => esc_html__('Normal', SA_EL_ADDONS_TEXTDOMAIN)]);

        $this->add_control(
            'sa_el_read_more_normal_text_color',
            [
                'label' => esc_html__('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-read-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sa_el_read_more_normal_bg_color',
            [
                'label' => esc_html__('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#2EC9F3',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-read-more' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sa_el_read_more_normal_border',
                'label' => esc_html__('Border', SA_EL_ADDONS_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-read-more',
            ]
        );

        $this->add_control(
            'sa_el_read_more_border_radius',
            [
                'label' => esc_html__('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-read-more' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab('sa_el_read_more_hover', ['label' => esc_html__('Hover', SA_EL_ADDONS_TEXTDOMAIN)]);

        $this->add_control(
            'sa_el_read_more_hover_text_color',
            [
                'label' => esc_html__('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#f9f9f9',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-read-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sa_el_read_more_hover_bg_color',
            [
                'label' => esc_html__('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#bac4cb',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-read-more:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sa_el_read_more_hover_border_color',
            [
                'label' => esc_html__('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-read-more:hover' => 'border-color: {{VALUE}};',
                ],
            ]

        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sa_el_read_more_shadow',
                'selector' => '{{WRAPPER}} .sa-el-content-timeline-content .sa-el-read-more',
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $args = $this->query_args($settings);
        // echo "<pre>";
        // print_r($settings['sa_el_content_timeline_choose']);
        // echo "</pre>";
        $settings = [

            'sa_el_content_timeline_choose'   => $settings['sa_el_content_timeline_choose'],
            'sa_el_coustom_content_posts'   => $settings['sa_el_coustom_content_posts'],
            'sa_el_show_image_or_icon'   => $settings['sa_el_show_image_or_icon'],
            'sa_el_icon_image'   => $settings['sa_el_icon_image'],
            'sa_el_content_timeline_circle_icon' => (isset($settings['__fa4_migrated']['sa_el_content_timeline_circle_icon_new']) || empty($settings['sa_el_content_timeline_circle_icon'])) ? $settings['sa_el_content_timeline_circle_icon_new']['value'] : $settings['sa_el_content_timeline_circle_icon'],
            'sa_el_show_title'   => $settings['sa_el_show_title'],
            'sa_el_show_excerpt'   => $settings['sa_el_show_excerpt'],
            'sa_el_excerpt_length'   => $settings['sa_el_excerpt_length'],
            'expanison_indicator'   => $settings['excerpt_expanison_indicator'],
            'sa_el_show_read_more'   => $settings['sa_el_show_read_more'],
            'sa_el_read_more_text'   => $settings['sa_el_read_more_text'],
        ];
        ?>
        <div id="sa-el-content-timeline-<?php echo esc_attr($this->get_id()); ?>">
            <div class="sa-el-content-timeline-container">
                <div class="sa-el-content-timeline-container">
                    <?php
                            if ('dynamic' === $settings['sa_el_content_timeline_choose']) :
                                echo  Post_Query::__post_template($args, $settings);
                            elseif ('custom' === $settings['sa_el_content_timeline_choose']) : ?>
                        <?php foreach ($settings['sa_el_coustom_content_posts'] as $custom_content) : ?>
                            <?php
                                            $target   = $custom_content['sa_el_read_more_text_link']['is_external'] ? 'target="_blank"' : '';
                                            $nofollow = $custom_content['sa_el_read_more_text_link']['nofollow'] ? 'rel="nofollow"' : '';
                                            ?>
                            <div class="sa-el-content-timeline-block">
                                <div class="sa-el-content-timeline-line">
                                    <div class="sa-el-content-timeline-inner"></div>
                                </div>
                                <div class="sa-el-content-timeline-img sa-el-picture <?php if ('bullet' === $settings['sa_el_show_image_or_icon']) : echo 'sa-el-content-timeline-bullet';
                                                                                                        endif; ?>">
                                    <?php if ('img' === $custom_content['sa_el_show_custom_image_or_icon']) : ?>
                                        <img src="<?php echo esc_url($custom_content['sa_el_custom_icon_image']['url']); ?>" style="width: <?php echo $custom_content['sa_el_custom_icon_image_size']; ?>px;" alt="<?php echo esc_attr(get_post_meta($custom_content['sa_el_custom_icon_image']['id'], '_wp_attachment_image_alt', true)); ?>">
                                    <?php endif; ?>
                                    <?php if ('icon' === $custom_content['sa_el_show_custom_image_or_icon']) : ?>
                                        <i class="<?php echo esc_attr($custom_content['sa_el_custom_content_timeline_circle_icon']); ?>"></i>
                                    <?php endif; ?>
                                </div>

                                <div class="sa-el-content-timeline-content">
                                    <?php if ('1' == $settings['sa_el_show_title']) : ?>
                                        <h2><a href="<?php echo esc_url($custom_content['sa_el_read_more_text_link']['url']); ?> <?php echo $target; ?> <?php echo $nofollow; ?>"><?php echo $custom_content['sa_el_custom_title']; ?></a></h2>
                                    <?php endif; ?>
                                    <?php if ('1' == $settings['sa_el_show_excerpt']) : ?>
                                        <p><?php echo $custom_content['sa_el_custom_excerpt']; ?></p>
                                    <?php endif; ?>
                                    <?php if ('1' == $custom_content['sa_el_show_custom_read_more'] && !empty($custom_content['sa_el_show_custom_read_more_text'])) : ?>
                                        <a href="<?php echo esc_url($custom_content['sa_el_read_more_text_link']['url']); ?>" class="sa-el-read-more" <?php echo $target; ?> <?php echo $nofollow; ?>><?php echo esc_html__($custom_content['sa_el_show_custom_read_more_text'], SA_EL_ADDONS_TEXTDOMAIN); ?></a>
                                    <?php endif; ?>
                                    <?php if (!empty($custom_content['sa_el_custom_post_date'])) : ?>
                                        <span class="sa-el-date"><?php echo $custom_content['sa_el_custom_post_date']; ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
<?php


    }
}
