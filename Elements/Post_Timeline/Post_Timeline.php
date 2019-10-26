<?php

namespace SA_EL_ADDONS\Elements\Post_Timeline;

if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
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
        return 'sa_el_post_timeline';
    }

    public function get_title()
    {
        return esc_html__('Post Timeline', SA_EL_ADDONS_TEXTDOMAIN);
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
        $this->start_controls_section(
            '_section_step',
            [
                'label' => __('Post Timeline', SA_EL_ADDONS_TEXTDOMAIN),
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
                    '{{WRAPPER}} .sa-el-timeline-post-title h3' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'sa_el_timeline_title_alignment',
            [
                'label' => __('Title Alignment', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'default' => '',
                'options' => [
                    '' => [
                        'title' => __('Left', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'eicon-long-arrow-left',
                    ],
                    '2' => [
                        'title' => __('Right', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'eicon-long-arrow-right',
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-timeline-post-title .sa-el-timeline-post-link' => 'order: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_timeline_title_typography',
                'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .sa-el-timeline-post-title h3',
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
        $this->sa_el_load_more_style();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $args = $this->query_args($settings);

        $settings = [
            'sa_el_show_image' => $settings['sa_el_show_image'],
            'image_size' => $settings['image_size'],
            'sa_el_show_title' => $settings['sa_el_show_title'],
            'sa_el_show_excerpt' => $settings['sa_el_show_excerpt'],
            'sa_el_excerpt_length' => $settings['sa_el_excerpt_length'],
            'show_load_more' => $settings['show_load_more'],
            'show_load_more_text' => $settings['show_load_more_text'],
            'expanison_indicator'   => $settings['excerpt_expanison_indicator'],
        ];

        $this->add_render_attribute(
            'sa_el_post_timeline_wrapper',
            [
                'id' => "sa-el-post-timeline-{$this->get_id()}",
                'class' => 'sa-el-post-timeline',
            ]
        );

        $this->add_render_attribute(
            'sa_el_post_timeline',
            [
                'class' => ['sa-el-post-timeline', 'sa-el-post-appender', "sa-el-post-appender-{$this->get_id()}"],
            ]
        );

        echo '<div ' . $this->get_render_attribute_string('sa_el_post_timeline_wrapper') . '>
		    <div ' . $this->get_render_attribute_string('sa_el_post_timeline') . '>
				' . Post_Query::__post_template($args, $settings) . '
		    </div>
		</div>';

        if (1 == $settings['show_load_more']) {
            if ($args['posts_per_page'] != '-1') {
                echo '  <div class="sa-el-load-more-button-wrap">
                            <button class="sa-el-load-more-button" id="sa-el-load-more-btn-' . $this->get_id() . '" data-widget="' . $this->get_id() . '" data-class="SA_EL_ADDONS\Elements\Post_Timeline\Files\Post_Query" data-function="__ajax_template" data-args=\'' . json_encode($args) . '\' data-settings=\'' . json_encode($settings) . '\' data-page="1">
                                    <div class="sa-el-btn-loader button__loader"></div>
                                    <span>' . esc_html__($settings['show_load_more_text'], SA_EL_ADDONS_TEXTDOMAIN) . '</span>
                            </button>
                        </div>';
            }
        }

        
    }
}
