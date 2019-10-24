<?php

namespace SA_EL_ADDONS\Elements\Content_Ticker;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Content_Ticker
 *
 * @author biplo
 * 
 */
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base as Widget_Base;

class Content_Ticker extends Widget_Base {

    use \SA_EL_ADDONS\Helper\Post_Query;
    use \SA_EL_ADDONS\Elements\Content_Ticker\Files\Content_Ticker;

    public function get_name() {
        return 'sa_el_content_ticker';
    }

    public function get_title() {
        return esc_html__('Content Ticker', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'eicon-call-to-action oxi-el-admin-icon';
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    protected function _register_controls() {

        /**
         * Content Ticker Content Settings
         */
        $this->start_controls_section(
                'sa_el_section_content_ticker_settings',
                [
                    'label' => esc_html__('Ticker Settings', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );
        $this->add_control(
                'sa_el_ticker_type',
                [
                    'label' => esc_html__('Ticker Type', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'dynamic',
                    'label_block' => false,
                    'options' => [
                        'dynamic' => esc_html__('Dynamic', SA_EL_ADDONS_TEXTDOMAIN),
                        'custom' => esc_html__('Custom', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                ]
        );



        $this->add_control(
                'sa_el_ticker_tag_text',
                [
                    'label' => esc_html__('Tag Text', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => false,
                    'default' => esc_html__('Trending Today', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                '_section_step',
                [
                    'label' => __('Content Ticker', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_CONTENT,
                    'condition' => [
                        'sa_el_ticker_type' => 'dynamic',
                    ],
                ]
        );

        $this->sa_el_query_controls();

        $this->end_controls_section();

        $this->start_controls_section(
                'sa_el_section_ticker_custom_content_settings',
                [
                    'label' => __('Custom Content Settings', SA_EL_ADDONS_TEXTDOMAIN),
                    'condition' => [
                        'sa_el_ticker_type' => 'custom'
                    ]
                ]
        );

        $this->add_control(
                'sa_el_ticker_custom_contents',
                [
                    'type' => Controls_Manager::REPEATER,
                    'seperator' => 'before',
                    'default' => [
                        ['sa_el_ticker_custom_content' => 'Ticker Custom Content'],
                    ],
                    'fields' => [
                        [
                            'name' => 'sa_el_ticker_custom_content',
                            'label' => esc_html__('Content', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::TEXT,
                            'label_block' => true,
                            'default' => esc_html__('Ticker custom content', SA_EL_ADDONS_TEXTDOMAIN)
                        ],
                        [
                            'name' => 'sa_el_ticker_custom_content_link',
                            'label' => esc_html__('Button Link', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::URL,
                            'label_block' => true,
                            'default' => [
                                'url' => '#',
                                'is_external' => '',
                            ],
                            'show_external' => true,
                        ],
                    ],
                    'title_field' => '{{sa_el_ticker_custom_content}}',
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'section_additional_options',
                [
                    'label' => __('Animation Settings', SA_EL_ADDONS_TEXTDOMAIN),
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
                    ],
                ]
        );

        $this->add_responsive_control(
                'items',
                [
                    'label' => __('Visible Items', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'default' => ['size' => 1],
                    'tablet_default' => ['size' => 1],
                    'mobile_default' => ['size' => 1],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 10,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => '',
                    'condition' => [
                        'carousel_effect' => 'slide',
                    ],
                    'separator' => 'before',
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
                    'condition' => [
                        'carousel_effect' => 'slide',
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
                    'separator' => 'before',
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
                    'separator' => 'before',
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
                    'separator' => 'before',
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
                'direction',
                [
                    'label' => __('Direction', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'left',
                    'options' => [
                        'left' => __('Left', SA_EL_ADDONS_TEXTDOMAIN),
                        'right' => __('Right', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                    'separator' => 'before',
                    'condition' => [
                        'carousel_effect' => 'slide',
                    ],
                ]
        );

        $this->end_controls_section();


        /**
         * -------------------------------------------
         * Tab Style (Ticker Content Style)
         * -------------------------------------------
         */
        $this->start_controls_section(
                'sa_el_section_ticker_typography_settings',
                [
                    'label' => esc_html__('Ticker Content', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'sa_el_ticker_content_bg',
                [
                    'label' => esc_html__('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-ticker-wrap .sa-el-ticker' => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'sa_el_ticker_content_color',
                [
                    'label' => esc_html__('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#333333',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-ticker-wrap .sa-el-ticker .ticker-content a' => 'color: {{VALUE}};',
                    ],
                ]
        );
        $this->add_control(
                'sa_el_ticker_hover_content_color',
                [
                    'label' => esc_html__('Text Hover Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#f44336',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-ticker-wrap .sa-el-ticker .ticker-content a:hover' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sa_el_ticker_content_typography',
                    'selector' => '{{WRAPPER}} .sa-el-ticker-wrap .sa-el-ticker .ticker-content a',
                ]
        );

        $this->add_responsive_control(
                'sa_el_ticker_content_padding',
                [
                    'label' => esc_html__('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-ticker-wrap .sa-el-ticker .ticker-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'sa_el_section_ticker_tag_style_settings',
                [
                    'label' => esc_html__('Tag Style', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );
        $this->add_control(
                'sa_el_ticker_tag_bg_color',
                [
                    'label' => esc_html__('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#f7048e',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-ticker-wrap .ticker-badge' => 'background-color: {{VALUE}};',
                    ],
                ]
        );
        $this->add_control(
                'sa_el_ticker_tag_color',
                [
                    'label' => esc_html__('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-ticker-wrap .ticker-badge span' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sa_el_ticker_tag_typography',
                    'selector' => '{{WRAPPER}} .sa-el-ticker-wrap .ticker-badge span',
                ]
        );
        $this->add_responsive_control(
                'sa_el_ticker_tag_padding',
                [
                    'label' => esc_html__('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-ticker-wrap .ticker-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_ticker_tag_margin',
                [
                    'label' => esc_html__('Margin', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-ticker-wrap .ticker-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );
        $this->add_responsive_control(
                'sa_el_ticker_tag_radius',
                [
                    'label' => esc_html__('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-ticker-wrap .ticker-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );
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
                'prev_arrow',
                [
                    'label' => __('Choose Prev Arrow', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::ICONS,
                    'label_block' => true,
                    'default' => [
                        'value' => 'fas fa-angle-left',
                        'library' => 'fa-solid',
                    ]
                ]
        );

        $this->add_control(
                'arrow_new',
                [
                    'label' => __('Choose Next Arrow', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'arrow',
                    'label_block' => true,
                    'default' => [
                        'value' => 'fas fa-angle-right',
                        'library' => 'fa-solid',
                    ]
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
                            'min' => 5,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .swiper-container-wrap .swiper-button-next img, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'right: {{SIZE}}{{UNIT}};',
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
                            'max' => 100,
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
    }

    protected function render() {
        $settings = $this->get_settings_for_display();


        $args = $this->query_args($settings);

        $this->add_render_attribute('content-ticker-wrap', 'class', 'swiper-container-wrap sa-el-ticker');

        $this->add_render_attribute('content-ticker', 'class', 'swiper-container sa-el-content-ticker');
        $this->add_render_attribute('content-ticker', 'class', 'swiper-container-' . esc_attr($this->get_id()));
        $this->add_render_attribute('content-ticker', 'data-pagination', '.swiper-pagination-' . esc_attr($this->get_id()));
        $this->add_render_attribute('content-ticker', 'data-arrow-next', '.swiper-button-next-' . esc_attr($this->get_id()));
        $this->add_render_attribute('content-ticker', 'data-arrow-prev', '.swiper-button-prev-' . esc_attr($this->get_id()));

        if ($settings['direction'] == 'right') {
            $this->add_render_attribute('content-ticker', 'dir', 'rtl');
        }

        if (!empty($settings['items']['size'])) {
            $this->add_render_attribute('content-ticker', 'data-items', $settings['items']['size']);
        }
        if (!empty($settings['items_tablet']['size'])) {
            $this->add_render_attribute('content-ticker', 'data-items-tablet', $settings['items_tablet']['size']);
        }
        if (!empty($settings['items_mobile']['size'])) {
            $this->add_render_attribute('content-ticker', 'data-items-mobile', $settings['items_mobile']['size']);
        }
        if (!empty($settings['margin']['size'])) {
            $this->add_render_attribute('content-ticker', 'data-margin', $settings['margin']['size']);
        }
        if (!empty($settings['margin_tablet']['size'])) {
            $this->add_render_attribute('content-ticker', 'data-margin-tablet', $settings['margin_tablet']['size']);
        }
        if (!empty($settings['margin_mobile']['size'])) {
            $this->add_render_attribute('content-ticker', 'data-margin-mobile', $settings['margin_mobile']['size']);
        }
        if ($settings['carousel_effect']) {
            $this->add_render_attribute('content-ticker', 'data-effect', $settings['carousel_effect']);
        }
        if (!empty($settings['slider_speed']['size'])) {
            $this->add_render_attribute('content-ticker', 'data-speed', $settings['slider_speed']['size']);
        }
        if ($settings['autoplay'] == 'yes' && !empty($settings['autoplay_speed']['size'])) {
            $this->add_render_attribute('content-ticker', 'data-autoplay', $settings['autoplay_speed']['size']);
        } else {
            $this->add_render_attribute('content-ticker', 'data-autoplay', '999999');
        }
        if ($settings['pause_on_hover'] == 'yes') {
            $this->add_render_attribute('content-ticker', 'data-pause-on-hover', 'true');
        }
        if ($settings['infinite_loop'] == 'yes') {
            $this->add_render_attribute('content-ticker', 'data-loop', true);
        }
        if ($settings['grab_cursor'] == 'yes') {
            $this->add_render_attribute('content-ticker', 'data-grab-cursor', true);
        }
        if ($settings['arrows'] == 'yes') {
            $this->add_render_attribute('content-ticker', 'data-arrows', '1');
        }

        echo '<div class="sa-el-ticker-wrap" id="sa-el-ticker-wrap-' . $this->get_id() . '">';
        if (!empty($settings['sa_el_ticker_tag_text'])) {
            echo '<div class="ticker-badge">
                    <span>' . $settings['sa_el_ticker_tag_text'] . '</span>
                </div>';
        }

        echo '<div ' . $this->get_render_attribute_string('content-ticker-wrap') . '>
                <div ' . $this->get_render_attribute_string('content-ticker') . '>
                    <div class="swiper-wrapper">';
        if ('dynamic' === $settings['sa_el_ticker_type']) {
            echo self::__render_template($args, null);
        } else {

            foreach ($settings['sa_el_ticker_custom_contents'] as $content) :
                $target = $content['sa_el_ticker_custom_content_link']['is_external'] ? 'target="_blank"' : '';
                $nofollow = $content['sa_el_ticker_custom_content_link']['nofollow'] ? 'rel="nofollow"' : '';
                ?>
                <div class="swiper-slide">
                    <div class="ticker-content">
                        <?php if (!empty($content['sa_el_ticker_custom_content_link']['url'])) : ?>
                            <a <?php echo $target; ?> <?php echo $nofollow; ?> href="<?php echo esc_url($content['sa_el_ticker_custom_content_link']['url']); ?>" class="ticker-content-link"><?php echo _e($content['sa_el_ticker_custom_content'], 'essential-addons-elementor') ?></a>
                        <?php else : ?>
                            <p><?php echo _e($content['sa_el_ticker_custom_content'], 'essential-addons-elementor') ?></p>
                        <?php endif; ?>   
                    </div>
                </div>
                <?php
            endforeach;
        }

        do_action('render_content_ticker_custom_content', $settings);
        echo '</div>
				</div>
				' . $this->render_arrows() . '
			</div>
		</div>';
    }

    /**
     * Render Content Ticker arrows output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render_arrows() {
        $settings = $this->get_settings_for_display();

        if ($settings['arrows'] == 'yes') {
            if (isset($settings['__fa4_migrated']['arrow_new']) || empty($settings['arrow'])) {
                $arrow = $settings['arrow_new']['value'];
            } else {
                $arrow = $settings['arrow'];
            }

            $html = '<div class="content-ticker-pagination">';

            $html .= '<div class="swiper-button-next swiper-button-next-' . $this->get_id() . '">';
            if (isset($arrow['url'])) {
                $html .= '<img src="' . esc_url($arrow['url']) . '" alt="' . esc_attr(get_post_meta($arrow['id'], '_wp_attachment_image_alt', true)) . '" />';
            } else {
                $html .= '<i class="' . $arrow . '"></i>';
            }
            $html .= '</div>';

            $html .= '<div class="swiper-button-prev swiper-button-prev-' . $this->get_id() . '">';
            if (isset($settings['prev_arrow']['value']['url'])) {
                $html .= '<img src="' . esc_url($settings['prev_arrow']['value']['url']) . '" alt="' . esc_attr(get_post_meta($settings['prev_arrow']['value']['id'], '_wp_attachment_image_alt', true)) . '" />';
            } else {
                $html .= '<i class="' . esc_attr($settings['prev_arrow']['value']) . '"></i>';
            }
            $html .= '</div>';

            $html .= '</div>';


            return $html;
        }
    }

}
