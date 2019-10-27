<?php

namespace SA_EL_ADDONS\Elements\Post_Carousel;

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
use \SA_EL_ADDONS\Elements\Post_Carousel\Files\Post_Query as Post_Query;

class Post_Carousel extends Widget_Base
{

    use \SA_EL_ADDONS\Helper\Elementor_Helper;
    use \SA_EL_ADDONS\Helper\Post_Query;


    public function get_name()
    {
        return 'sa_el_post_carousel';
    }

    public function get_title()
    {
        return esc_html__('Post Carousel', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon()
    {
        return 'eicon-posts-grid oxi-el-admin-icon';
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
                'label' => __('Post Carousel', SA_EL_ADDONS_TEXTDOMAIN),
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
            'section_additional_options',
            [
                'label' => __('Carousel Settings', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'carousel_effect',
            [
                'label' => __('Effect', SA_EL_ADDONS_TEXTDOMAIN),
                'description' => __('Sets transition effect', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => __('Slide', SA_EL_ADDONS_TEXTDOMAIN),
                    'fade' => __('Fade', SA_EL_ADDONS_TEXTDOMAIN),
                    'cube' => __('Cube', SA_EL_ADDONS_TEXTDOMAIN),
                    'coverflow' => __('Coverflow', SA_EL_ADDONS_TEXTDOMAIN),
                    'flip' => __('Flip', SA_EL_ADDONS_TEXTDOMAIN),
                ],
            ]
        );

        $this->add_responsive_control(
            'items',
            [
                'label' => __('Visible Items', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 3],
                'tablet_default' => ['size' => 2],
                'mobile_default' => ['size' => 1],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => __('Items Gap', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 10],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
            ]
        );

        $this->add_responsive_control(
            'post_image_height',
            [
                'label' => __('Image Height', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 350],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 600,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-entry-thumbnail' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slider_speed',
            [
                'label' => __('Slider Speed', SA_EL_ADDONS_TEXTDOMAIN),
                'description' => __('Duration of transition between slides (in ms)', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 400],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 3000,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Autoplay Speed', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 2000],
                'range' => [
                    'px' => [
                        'min' => 500,
                        'max' => 5000,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => __('Pause On Hover', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                'return_value' => 'yes',
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label' => __('Infinite Loop', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'grab_cursor',
            [
                'label' => __('Grab Cursor', SA_EL_ADDONS_TEXTDOMAIN),
                'description' => __('Shows grab cursor when you hover over the slider', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Show', SA_EL_ADDONS_TEXTDOMAIN),
                'label_off' => __('Hide', SA_EL_ADDONS_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'navigation_heading',
            [
                'label' => __('Navigation', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'arrows',
            [
                'label' => __('Arrows', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'dots',
            [
                'label' => __('Dots', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'sa_el_section_post_grid_style',
            [
                'label' => __('Post Style', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sa_el_post_grid_bg_hover_icon',
            [
                'label' => __('Post Hover Icon', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::ICON,
            ]
        );

        $this->add_control(
            'sa_el_post_grid_bg_color',
            [
                'label' => __('Post Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-grid-post-holder' => 'background-color: {{VALUE}}',
                ],

            ]
        );

        $this->add_control(
            'sa_el_post_block_hover_animation',
            [
                'label' => __('Hover Style', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'fade-in',
                'options' => [
                    'none' => esc_html__('None', SA_EL_ADDONS_TEXTDOMAIN),
                    'fade-in' => esc_html__('FadeIn', SA_EL_ADDONS_TEXTDOMAIN),
                    'zoom-in' => esc_html__('ZoomIn', SA_EL_ADDONS_TEXTDOMAIN),
                    'slide-up' => esc_html__('SlideUp', SA_EL_ADDONS_TEXTDOMAIN),
                ],
            ]
        );

        $this->add_control(
            'sa_el_thumbnail_overlay_color',
            [
                'label' => __('Thumbnail Overlay Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0, .75)',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-entry-overlay' => 'background-color: {{VALUE}}',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sa_el_post_grid_border',
                'label' => esc_html__('Border', SA_EL_ADDONS_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .sa-el-grid-post-holder',
            ]
        );

        $this->add_control(
            'sa_el_post_grid_border_radius',
            [
                'label' => esc_html__('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .sa-el-grid-post-holder' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sa_el_post_grid_box_shadow',
                'selector' => '{{WRAPPER}} .sa-el-grid-post-holder',
            ]
        );

        $this->end_controls_section();

        
        $this->start_controls_section(
            'sa_el_section_typography',
            [
                'label' => __('Color & Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sa_el_post_grid_title_style',
            [
                'label' => __('Title Style', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sa_el_post_grid_title_color',
            [
                'label' => __('Title Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#303133',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-entry-title, {{WRAPPER}} .sa-el-entry-title a' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'sa_el_post_grid_title_hover_color',
            [
                'label' => __('Title Hover Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#23527c',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-entry-title:hover, {{WRAPPER}} .sa-el-entry-title a:hover' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'sa_el_post_grid_title_alignment',
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
                    '{{WRAPPER}} .sa-el-entry-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_post_grid_title_typography',
                'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .sa-el-entry-title',
            ]
        );

        $this->add_control(
            'sa_el_post_grid_excerpt_style',
            [
                'label' => __('Excerpt Style', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sa_el_post_grid_excerpt_color',
            [
                'label' => __('Excerpt Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-grid-post-excerpt p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sa_el_post_grid_excerpt_alignment',
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
                    '{{WRAPPER}} .sa-el-grid-post-excerpt p' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .sa-el-grid-post-excerpt .sa-el-post-elements-readmore-btn' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_post_grid_excerpt_typography',
                'label' => __('Excerpt Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .sa-el-grid-post-excerpt p',
            ]
        );
/**
         * Read More Button Style Controls
         */
        $this->add_control(
            'sa_el_post_grid_read_more_style',
            [
                'label' => __('Read More Style', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_post_grid_read_more_typography',
                'label' => __('Meta Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .sa-el-post-elements-readmore-btn',

            ]
        );
        $this->start_controls_tabs('sa_el_post_grid_read_more_tabs');

        // Normal State Tab
        $this->start_controls_tab('sa_el_post_grid_read_more_normal', ['label' => esc_html__('Normal', SA_EL_ADDONS_TEXTDOMAIN)]);

        $this->add_control(
            'sa_el_post_grid_read_more_color',
            [
                'label' => __('Read More Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-post-elements-readmore-btn' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        // hover State Tab
        $this->start_controls_tab('sa_el_post_grid_read_more_hover', ['label' => esc_html__('Hover', SA_EL_ADDONS_TEXTDOMAIN)]);

        $this->add_control(
            'sa_el_post_grid_read_more_color_h',
            [
                'label' => __('Read More Hover Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-post-elements-readmore-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'sa_el_post_grid_read_more_spacing',
            [
                'label' => esc_html__('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-post-elements-readmore-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'sa_el_post_grid_meta_style',
            [
                'label' => __('Meta Style', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sa_el_post_grid_meta_color',
            [
                'label' => __('Meta Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-entry-meta, .sa-el-entry-meta a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sa_el_post_grid_meta_alignment',
            [
                'label' => __('Meta Alignment', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
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
                'prefix_class' => 'post_carousel_meta_alignment-%s',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_post_grid_meta_typography',
                'label' => __('Meta Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .sa-el-entry-meta > div',
            ]
        );

        $this->end_controls_section();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Arrows
         */
        $this->start_controls_section(
            'section_arrows_style',
            [
                'label' => __('Arrows', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'arrows' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrow',
            [
                'label' => __('Choose Arrow', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'fa fa-angle-right',
                'options' => [
                    'fa fa-angle-right' => __('Angle', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa fa-angle-double-right' => __('Double Angle', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa fa-chevron-right' => __('Chevron', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa fa-chevron-circle-right' => __('Chevron Circle', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa fa-arrow-right' => __('Arrow', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa fa-long-arrow-right' => __('Long Arrow', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa fa-caret-right' => __('Caret', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa fa-caret-square-o-right' => __('Caret Square', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa fa-arrow-circle-right' => __('Arrow Circle', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa fa-arrow-circle-o-right' => __('Arrow Circle O', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa fa-toggle-right' => __('Toggle', SA_EL_ADDONS_TEXTDOMAIN),
                    'fa fa-hand-o-right' => __('Hand', SA_EL_ADDONS_TEXTDOMAIN),
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_size',
            [
                'label' => __('Arrows Size', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => '22'],
                'range' => [
                    'px' => [
                        'min' => 15,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'left_arrow_position',
            [
                'label' => __('Align Left Arrow', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 40,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'right_arrow_position',
            [
                'label' => __('Align Right Arrow', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 40,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_arrows_style');

        $this->start_controls_tab(
            'tab_arrows_normal',
            [
                'label' => __('Normal', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'arrows_bg_color_normal',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_normal',
            [
                'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'arrows_border_normal',
                'label' => __('Border', SA_EL_ADDONS_TEXTDOMAIN),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev',
            ]
        );

        $this->add_control(
            'arrows_border_radius_normal',
            [
                'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_arrows_hover',
            [
                'label' => __('Hover', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'arrows_bg_color_hover',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_border_color_hover',
            [
                'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'arrows_padding',
            [
                'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Dots
         */
        $this->start_controls_section(
            'section_dots_style',
            [
                'label' => __('Dots', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'dots' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label' => __('Position', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'default' => 'outside',
                'options' => [
                    'inside' => __('Inside', SA_EL_ADDONS_TEXTDOMAIN),
                    'outside' => __('Outside', SA_EL_ADDONS_TEXTDOMAIN),
                ],
                
            ]
        );

        $this->add_responsive_control(
            'dots_size',
            [
                'label' => __('Size', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 40,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-{{ID}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}} !important; width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_spacing',
            [
                'label' => __('Spacing', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-{{ID}} .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}} !important; margin-right: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_dots_style');

        $this->start_controls_tab(
            'tab_dots_normal',
            [
                'label' => __('Normal', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'dots_color_normal',
            [
                'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-{{ID}} .swiper-pagination-bullet' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'active_dot_color_normal',
            [
                'label' => __('Active Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-{{ID}} .swiper-pagination-bullet-active' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_border_normal',
                'label' => __('Border', SA_EL_ADDONS_TEXTDOMAIN),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .swiper-pagination-{{ID}} .swiper-pagination-bullet',
            ]
        );

        $this->add_control(
            'dots_border_radius_normal',
            [
                'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-{{ID}} .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_padding',
            [
                'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'allowed_dimensions' => 'vertical',
                'placeholder' => [
                    'top' => '',
                    'right' => 'auto',
                    'bottom' => '',
                    'left' => 'auto',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-{{ID}} .swiper-pagination-bullets' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_hover',
            [
                'label' => __('Hover', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'dots_color_hover',
            [
                'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-{{ID}} .swiper-pagination-bullet:hover' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'dots_border_color_hover',
            [
                'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-{{ID}} .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $args = $this->query_args($settings);

        $this->add_render_attribute(
            'sa-el-post-carousel-container',
            [
                'class' => [
                    'swiper-container-wrap',
                    'sa-el-logo-carousel-wrap',
                    'sa-el-post-grid-container',
                ],
                'id' => 'sa-el-post-grid-' . esc_attr($this->get_id()),
            ]
        );

        if ($settings['dots_position']) {
            $this->add_render_attribute('sa-el-post-carousel-container', 'class', 'swiper-container-wrap-dots-' . $settings['dots_position']);
        }

        $this->add_render_attribute(
            'sa-el-post-carousel-wrap',
            [
                'class' => [
                    'swiper-container',
                    'sa-el-post-carousel',
                    'sa-el-post-grid',
                    'swiper-container-' . esc_attr($this->get_id()),
                    'sa-el-post-appender-' . esc_attr($this->get_id()),
                ],
                'data-pagination' => '.swiper-pagination-' . esc_attr($this->get_id()),
                'data-arrow-next' => '.swiper-button-next-' . esc_attr($this->get_id()),
                'data-arrow-prev' => '.swiper-button-prev-' . esc_attr($this->get_id()),
            ]
        );

        if ($settings['sa_el_show_read_more_button']) {
            $this->add_render_attribute(
                'sa-el-post-carousel-wrap',
                'class',
                'show-read-more-button'
            );
        }

        if (!empty($settings['items']['size'])) {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-items', $settings['items']['size']);
        }
        if (!empty($settings['items_tablet']['size'])) {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-items-tablet', $settings['items_tablet']['size']);
        }
        if (!empty($settings['items_mobile']['size'])) {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-items-mobile', $settings['items_mobile']['size']);
        }
        if (!empty($settings['margin']['size'])) {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-margin', $settings['margin']['size']);
        }
        if (!empty($settings['margin_tablet']['size'])) {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-margin-tablet', $settings['margin_tablet']['size']);
        }
        if (!empty($settings['margin_mobile']['size'])) {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-margin-mobile', $settings['margin_mobile']['size']);
        }
        if ($settings['carousel_effect']) {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-effect', $settings['carousel_effect']);
        }
        if (!empty($settings['slider_speed']['size'])) {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-speed', $settings['slider_speed']['size']);
        }

        if ($settings['autoplay'] == 'yes' && !empty($settings['autoplay_speed']['size'])) {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-autoplay', $settings['autoplay_speed']['size']);
        } else {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-autoplay', '0');
        }

        if ($settings['pause_on_hover'] == 'yes') {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-pause-on-hover', 'true');
        }

        if ($settings['infinite_loop'] == 'yes') {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-loop', '1');
        }
        if ($settings['grab_cursor'] == 'yes') {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-grab-cursor', '1');
        }
        if ($settings['arrows'] == 'yes') {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-arrows', '1');
        }
        if ($settings['dots'] == 'yes') {
            $this->add_render_attribute('sa-el-post-carousel-wrap', 'data-dots', '1');
        }

        $settings = [
            'sa_el_show_image' => $settings['sa_el_show_image'],
            'image_size' => $settings['image_size'],
            'sa_el_show_title' => $settings['sa_el_show_title'],
            'sa_el_show_excerpt' => $settings['sa_el_show_excerpt'],
            'sa_el_show_meta' => $settings['sa_el_show_meta'],
            'meta_position' => $settings['meta_position'],
            'sa_el_excerpt_length' => intval($settings['sa_el_excerpt_length'], 10),
            'sa_el_show_read_more_button' => $settings['sa_el_show_read_more_button'],
            'read_more_button_text' => $settings['read_more_button_text'],
            'read_more_button_text' => $settings['read_more_button_text'],
            'expanison_indicator' => $settings['excerpt_expanison_indicator'],
            'sa_el_post_block_hover_animation' => $settings['sa_el_post_block_hover_animation'],
            'sa_el_post_grid_bg_hover_icon' => $settings['sa_el_post_grid_bg_hover_icon'],
            'arrow' => $settings['arrow'],
        ];
        echo '<div ' . $this->get_render_attribute_string('sa-el-post-carousel-container') . '>
                <div ' . $this->get_render_attribute_string('sa-el-post-carousel-wrap') . '">
                    <div class="swiper-wrapper">
                        ' . Post_Query::__post_template($args, $settings) . '
                    </div>
                </div>';

                $this->render_dots();

                $this->render_arrows();
                
                
        echo'</div>';
        // if (1 == $settings['show_load_more']) {
        //     if ($args['posts_per_page'] != '-1') {
        //         echo '  <div class="sa-el-load-more-button-wrap">
        //                         <button class="sa-el-load-more-button" id="sa-el-load-more-btn-' . $this->get_id() . '" data-widget="' . $this->get_id() . '" data-class="SA_EL_ADDONS\Elements\Post_Carousel\Files\Post_Query" data-function="__ajax_template" data-args=\'' . json_encode($args) . '\' data-settings=\'' . json_encode($settings) . '\' data-page="1">
        //                                 <div class="sa-el-btn-loader button__loader"></div>
        //                                 <span>' . esc_html__($settings['show_load_more_text'], SA_EL_ADDONS_TEXTDOMAIN) . '</span>
        //                         </button>
        //                     </div>';
        //     }
        // }
    }


    //changes
    protected function render_dots()
    {
        $settings = $this->get_settings_for_display();

        if ($settings['dots'] == 'yes') { ?>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-<?php echo esc_attr($this->get_id()); ?>"></div>
        <?php }
            }

            /**
             * Render logo carousel arrows output on the frontend.
             */
            protected function render_arrows()
            {
                $settings = $this->get_settings_for_display();

                if ($settings['arrows'] == 'yes') { ?>
            <?php
                        if ($settings['arrow']) {
                            $pa_next_arrow = $settings['arrow'];
                            $pa_prev_arrow = str_replace("right", "left", $settings['arrow']);
                        } else {
                            $pa_next_arrow = 'fa fa-angle-right';
                            $pa_prev_arrow = 'fa fa-angle-left';
                        }
                        ?>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-next-<?php echo esc_attr($this->get_id()); ?>">
                <i class="<?php echo esc_attr($pa_next_arrow); ?>"></i>
            </div>
            <div class="swiper-button-prev swiper-button-prev-<?php echo esc_attr($this->get_id()); ?>">
                <i class="<?php echo esc_attr($pa_prev_arrow); ?>"></i>
            </div>
<?php }
    }
}
