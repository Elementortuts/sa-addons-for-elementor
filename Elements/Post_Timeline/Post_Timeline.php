<?php

namespace SA_EL_ADDONS\Elements\Post_Timeline;

if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Widget_Base as Widget_Base;
use \SA_EL_ADDONS\Elements\Post_Timeline\Files\Post_Query as Post_Query;

class Post_Timeline extends Widget_Base
{

    use \SA_EL_ADDONS\Helper\Elementor_Helper;
    use \SA_EL_ADDONS\Helper\Post_Query;


    public function get_name()
    {
        return 'sa_el_post_grid';
    }

    public function get_title()
    {
        return esc_html__('Post Grid', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon()
    {
        return 'eicon-flow oxi-el-admin-icon';
    }

    public function get_categories()
    {
        return ['sa-el-addons'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            '_section_step',
            [
                'label' => __('Post Grid', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->sa_el_query_controls();
        $this->end_controls_section();

        $this->start_controls_section(
            'sa_el_section_post_timeline_layout',
            [
                'label' => __('Layout Settings', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->sa_el_layout_controls();

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_icon_style',
            [
                'label' => __('Post Grid Style', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sa_el_timeline_overlay_color',
            [
                'label' => __('Overlay Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'description' => __('Leave blank or Clear to use default gradient overlay', SA_EL_ADDONS_TEXTDOMAIN),
                'default' => 'linear-gradient(45deg, #3f3f46 0%, #05abe0 100%) repeat scroll 0 0 rgba(0, 0, 0, 0)',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-post-inner' => 'background: {{VALUE}}',
                ],

            ]
        );

        $this->add_control(
            'sa_el_timeline_bullet_color',
            [
                'label' => __('Timeline Bullet Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#9fa9af',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-bullet' => 'background-color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'sa_el_timeline_bullet_border_color',
            [
                'label' => __('Timeline Bullet Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-bullet' => 'border-color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'sa_el_timeline_vertical_line_color',
            [
                'label' => __('Timeline Vertical Line Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(83, 85, 86, .2)',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-post:after' => 'background-color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'sa_el_timeline_border_color',
            [
                'label' => __('Border & Arrow Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#e5eaed',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-post-inner' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .sa-el-timeline-post-inner::after' => 'border-left-color: {{VALUE}};',
                    '{{WRAPPER}} .sa-el-timeline-post:nth-child(2n) .sa-el-timeline-post-inner::after' => 'border-right-color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'sa_el_timeline_date_background_color',
            [
                'label' => __('Date Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.7)',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-post time' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .sa-el-timeline-post time::before' => 'border-bottom-color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'sa_el_timeline_date_color',
            [
                'label' => __('Date Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-post time' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sa_el_section_typography',
            [
                'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
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
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-post-title h2' => 'color: {{VALUE}};',
                ],

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
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-post-title h2' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_timeline_title_typography',
                'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .sa-el-timeline-post-title h2',
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
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-post-excerpt p' => 'color: {{VALUE}};',
                ],
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
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-post-excerpt p' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_timeline_excerpt_typography',
                'label' => __('excerpt Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .sa-el-timeline-post-excerpt p',
            ]
        );

        $this->end_controls_section();
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

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $args = $this->query_args($settings);

        $this->add_render_attribute(
            'post_grid_wrapper',
            [
                'id' => 'sa-el-post-grid-' . esc_attr($this->get_id()),
                'class' => [
                    'sa-el-post-grid-container',
                    esc_attr($settings['sa_el_post_grid_columns']),
                ],
            ]
        );
        $settings = [
            'sa_el_show_image' => $settings['sa_el_show_image'],
            'image_size' => $settings['image_size'],
            'sa_el_show_title' => $settings['sa_el_show_title'],
            'sa_el_show_excerpt' => $settings['sa_el_show_excerpt'],
            'sa_el_show_meta' => $settings['sa_el_show_meta'],
            'meta_position' => $settings['meta_position'],
            'sa_el_excerpt_length' => intval($settings['sa_el_excerpt_length'], 10),
            'sa_el_post_grid_hover_animation' => $settings['sa_el_post_grid_hover_animation'],
            'sa_el_post_grid_bg_hover_icon' => (isset($settings['__fa4_migrated']['sa_el_post_grid_bg_hover_icon_new']) || empty($settings['sa_el_post_grid_bg_hover_icon'])) ? $settings['sa_el_post_grid_bg_hover_icon_new']['value'] : $settings['sa_el_post_grid_bg_hover_icon'],
            'sa_el_show_read_more_button' => $settings['sa_el_show_read_more_button'],
            'read_more_button_text' => $settings['read_more_button_text'],
            'read_more_button_text' => $settings['read_more_button_text'],
            'sa_el_post_grid_columns' => $settings['sa_el_post_grid_columns'],
            'show_load_more' => $settings['show_load_more'],
            'show_load_more_text' => $settings['show_load_more_text'],
            'expanison_indicator' => $settings['excerpt_expanison_indicator']
        ];
        echo '<div ' . $this->get_render_attribute_string('post_grid_wrapper') . '>
                <div class="sa-el-post-grid sa-el-post-appender sa-el-post-appender-' . $this->get_id() . '">
                    ' . Post_Query::__post_template($args, $settings) . '
                </div>
                <div class="clearfix"></div>
            </div>
        ';
        if (1 == $settings['show_load_more']) {
            if ($args['posts_per_page'] != '-1') {
                echo '  <div class="sa-el-load-more-button-wrap">
                            <button class="sa-el-load-more-button" id="sa-el-load-more-btn-' . $this->get_id() . '" data-widget="' . $this->get_id() . '" data-class="SA_EL_ADDONS\Elements\Post_Grid\Files\Post_Query" data-function="__ajax_template" data-args=\'' . json_encode($args) . '\' data-settings=\'' . json_encode($settings) . '\' data-layout="masonry" data-page="1">
                                    <div class="sa-el-btn-loader button__loader"></div>
                                    <span>' . esc_html__($settings['show_load_more_text'], SA_EL_ADDONS_TEXTDOMAIN) . '</span>
                            </button>
                        </div>';
            }
        }

        
    }
}
