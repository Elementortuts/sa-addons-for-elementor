<?php
namespace SA_EL_ADDONS\Skins;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

use \Elementor\Skin_Base;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;

class Skin_Seven extends Skin_Base
{
    public function get_id()
    {
        return 'skin-seven';
    }

    public function get_title()
    {
        return __('Skin Seven', SA_EL_ADDONS_TEXTDOMAIN);
    }

    protected function _register_controls_actions()
    {
        add_action('elementor/element/sa-el-advanced-menu/sa_el_advanced_menu_section_general/before_section_end', [$this, 'section_general']);
        add_action('elementor/element/sa-el-advanced-menu/sa_el_advanced_menu_section_style_menu/before_section_end', [$this, 'section_style_menu']);
        add_action('elementor/element/sa-el-advanced-menu/sa_el_advanced_menu_section_style_dropdown/before_section_end', [$this, 'section_style_dropdown']);
        add_action('elementor/element/sa-el-advanced-menu/sa_el_advanced_menu_section_style_top_level_item/before_section_end', [$this, 'section_style_top_level_item']);
        add_action('elementor/element/sa-el-advanced-menu/sa_el_advanced_menu_section_style_dropdown_item/before_section_end', [$this, 'section_style_dropdown_item']);
    }

    public function section_general(Widget_Base $widget)
    {
        $this->parent = $widget;

        $this->add_control(
            'sa_el_advanced_menu_layout',
            [
                'label' => esc_html__('Layout', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [
                    'horizontal' => __('Horizontal', SA_EL_ADDONS_TEXTDOMAIN),
                    'vertical' => __('Vertical', SA_EL_ADDONS_TEXTDOMAIN),
                ],
                'default' => 'vertical',
                'separator' => 'before',
            ]
        );
    }

    public function section_style_menu(Widget_Base $widget)
    {
        $this->parent = $widget;

        $this->add_control(
            'sa_el_advanced_menu_background',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#4caf50',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu-container' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu-container .sa-el-advanced-menu.sa-el-advanced-menu-horizontal' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sa_el_advanced_menu_border',
                'label' => __('Border', SA_EL_ADDONS_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .sa-el-advanced-menu-container, {{WRAPPER}} .sa-el-advanced-menu.sa-el-advanced-menu-horizontal.sa-el-advanced-menu-responsive',
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sa_el_advanced_menu_box_shadow',
                'label' => __('Shadow', SA_EL_ADDONS_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .sa-el-advanced-menu-container',
            ]
        );
    }

    public function section_style_dropdown(Widget_Base $widget)
    {
        $this->parent = $widget;

        $this->add_control(
            'sa_el_advanced_menu_dropdown_animation',
            [
                'label' => __('Animation', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'sa-el-advanced-menu-dropdown-animate-fade' => __('Fade', SA_EL_ADDONS_TEXTDOMAIN),
                    'sa-el-advanced-menu-dropdown-animate-to-top' => __('To Top', SA_EL_ADDONS_TEXTDOMAIN),
                    'sa-el-advanced-menu-dropdown-animate-zoom-in' => __('ZoomIn', SA_EL_ADDONS_TEXTDOMAIN),
                    'sa-el-advanced-menu-dropdown-animate-zoom-out' => __('ZoomOut', SA_EL_ADDONS_TEXTDOMAIN),
                ],
                'default' => 'sa-el-advanced-menu-dropdown-animate-to-top',
                'condition' => [
                    'skin_seven_sa_el_advanced_menu_layout' => ['horizontal'],
                ],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_background',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#419544',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sa_el_advanced_menu_dropdown_border',
                'label' => __('Border', SA_EL_ADDONS_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .sa-el-advanced-menu li ul',
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_responsive_control(
            'sa_el_advanced_menu_dropdown_border_radius',
            [
                'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_responsive_control(
            'sa_el_advanced_menu_dropdown_padding',
            [
                'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sa_el_advanced_menu_dropdown_box_shadow',
                'label' => __('Shadow', SA_EL_ADDONS_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .sa-el-advanced-menu li ul',
            ]
        );

    }

    public function section_style_top_level_item()
    {
        $this->start_controls_tabs('sa_el_advanced_menu_top_level_item');

        $this->start_controls_tab(
            'sa_el_advanced_menu_top_level_item_default',
            [
                'label' => __('Default', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_alignment',
            [
                'label' => __('Alignment', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'sa-el-advanced-menu-align-left' => [
                        'title' => __('Left', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-left',
                    ],
                    'sa-el-advanced-menu-align-center' => [
                        'title' => __('Center', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-center',
                    ],
                    'sa-el-advanced-menu-align-right' => [
                        'title' => __('Right', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'sa-el-advanced-menu-align-left',
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_advanced_menu_item_typography',
                'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .sa-el-advanced-menu li > a, .sa-el-advanced-menu-container .sa-el-advanced-menu-toggle-text',
                'fields_options' => [
                    'font_family' => [
                        'default' => 'Ubuntu',
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '400',
                    ],
                    'line_height' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '60',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_color',
            [
                'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu-toggle-text' => 'color: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_background',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li > a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_divider_color',
            [
                'label' => __('Divider Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu.sa-el-advanced-menu-horizontal:not(.sa-el-advanced-menu-responsive) > li > a' => 'border-right: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu-align-center .sa-el-advanced-menu.sa-el-advanced-menu-horizontal:not(.sa-el-advanced-menu-responsive) > li:first-child > a' => 'border-left: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu-align-right .sa-el-advanced-menu.sa-el-advanced-menu-horizontal:not(.sa-el-advanced-menu-responsive) > li:first-child > a' => 'border-left: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu.sa-el-advanced-menu-horizontal.sa-el-advanced-menu-responsive > li:not(:last-child) > a' => 'border-bottom: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu.sa-el-advanced-menu-vertical > li:not(:last-child) > a' => 'border-bottom: 1px solid {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_padding',
            [
                'label' => __('Item Padding', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .sa-el-advanced-menu.sa-el-advanced-menu-horizontal li ul li a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'label' => __('Dropdown Indicator', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_indicator',
            [
                'label' => __('Icon', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::ICON,
                'include' => [
                    'fa fa-angle-double-down',
                    'fa fa-angle-down',
                    'fa fa-arrow-circle-o-down',
                    'fa fa-arrow-down',
                    'fa fa-caret-down',
                    'fa fa-chevron-circle-down',
                    'fa fa-chevron-down',
                    'fa fa-hand-o-down',
                ],
                'default' => 'fa fa-angle-down',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'label' => __('Important Note', SA_EL_ADDONS_TEXTDOMAIN),
                'show_label' => false,
                'type' => Controls_Manager::RAW_HTML,
                'raw' => __('<div style="font-size: 11px;font-style:italic;line-height:1.4;color:#a4afb7;">Following options are only available in the <span style="color:#d30c5c"><strong>Small</strong></span> screens for <span style="color:#d30c5c"><strong>Horizontal</strong></span> Layout, and all screens for <span style="color:#d30c5c"><strong>Vertical</strong></span> Layout</div>', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_indicator_color',
            [
                'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li .sa-el-advanced-menu-indicator:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_indicator_background',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#4caf50',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li .sa-el-advanced-menu-indicator' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_indicator_border',
            [
                'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li .sa-el-advanced-menu-indicator' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sa_el_advanced_menu_top_level_item_hover',
            [
                'label' => __('Hover', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_color_hover',
            [
                'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li:hover > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li.current-menu-item > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li.current-menu-ancestor > a' => 'color: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_background_hover',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#419544',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li:hover > a' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li.current-menu-item > a' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li.current-menu-ancestor > a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'label' => __('Dropdown Indicator', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'label' => __('Important Note', SA_EL_ADDONS_TEXTDOMAIN),
                'show_label' => false,
                'type' => Controls_Manager::RAW_HTML,
                'raw' => __('<div style="font-size: 11px;font-style:italic;line-height:1.4;color:#a4afb7;">Following options are only available in the <span style="color:#d30c5c"><strong>Small</strong></span> screens for <span style="color:#d30c5c"><strong>Horizontal</strong></span> Layout, and all screens for <span style="color:#d30c5c"><strong>Vertical</strong></span> Layout</div>', SA_EL_ADDONS_TEXTDOMAIN),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_indicator_color_hover',
            [
                'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#4caf50',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li .sa-el-advanced-menu-indicator:hover:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li .sa-el-advanced-menu-indicator.sa-el-advanced-menu-indicator-open:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_indicator_background_hover',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li .sa-el-advanced-menu-indicator:hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li .sa-el-advanced-menu-indicator.sa-el-advanced-menu-indicator-open' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_item_indicator_border_hover',
            [
                'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li .sa-el-advanced-menu-indicator:hover' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li .sa-el-advanced-menu-indicator.sa-el-advanced-menu-indicator-open' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }

    public function section_style_dropdown_item(Widget_Base $widget)
    {
        $this->parent = $widget;

        $this->start_controls_tabs('sa_el_advanced_menu_dropdown_item');

        $this->start_controls_tab(
            'sa_el_advanced_menu_dropdown_item_default',
            [
                'label' => __('Default', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_alignment',
            [
                'label' => __('Alignment', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'sa-el-advanced-menu-dropdown-align-left' => [
                        'title' => __('Left', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-left',
                    ],
                    'sa-el-advanced-menu-dropdown-align-center' => [
                        'title' => __('Center', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-center',
                    ],
                    'sa-el-advanced-menu-dropdown-align-right' => [
                        'title' => __('Right', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'sa-el-advanced-menu-dropdown-align-left',
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sa_el_advanced_menu_dropdown_item_typography',
                'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .sa-el-advanced-menu li ul li > a',
                'fields_options' => [
                    'font_family' => [
                        'default' => 'Ubuntu',
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '400',
                    ],
                    'line_height' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '50',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_color',
            [
                'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li > a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_background',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li > a' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_divider_color',
            [
                'label' => __('Divider Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu.sa-el-advanced-menu-horizontal li ul li > a' => 'border-bottom: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu.sa-el-advanced-menu-vertical li ul li > a' => 'border-bottom: 1px solid {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'label' => __('Dropdown Indicator', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_indicator',
            [
                'label' => __('Icon', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::ICON,
                'include' => [
                    'fa fa-angle-double-down',
                    'fa fa-angle-down',
                    'fa fa-arrow-circle-o-down',
                    'fa fa-arrow-down',
                    'fa fa-caret-down',
                    'fa fa-chevron-circle-down',
                    'fa fa-chevron-down',
                    'fa fa-hand-o-down',
                ],
                'default' => 'fa fa-angle-down',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'label' => __('Important Note', SA_EL_ADDONS_TEXTDOMAIN),
                'show_label' => false,
                'type' => Controls_Manager::RAW_HTML,
                'raw' => __('<div style="font-size: 11px;font-style:italic;line-height:1.4;color:#a4afb7;">Following options are only available in the <span style="color:#d30c5c"><strong>Small</strong></span> screens for <span style="color:#d30c5c"><strong>Horizontal</strong></span> Layout, and all screens for <span style="color:#d30c5c"><strong>Vertical</strong></span> Layout</div>', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_indicator_color',
            [
                'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#4caf50',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li .sa-el-advanced-menu-indicator:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_indicator_background',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li .sa-el-advanced-menu-indicator' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_indicator_border',
            [
                'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#4caf50',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li .sa-el-advanced-menu-indicator' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sa_el_advanced_menu_dropdown_item_hover',
            [
                'label' => __('Hover', SA_EL_ADDONS_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_color_hover',
            [
                'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li:hover > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li.current-menu-item > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li.current-menu-ancestor > a' => 'color: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_background_hover',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#39833c',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li:hover > a' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li.current-menu-item > a' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li.current-menu-ancestor > a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'label' => __('Dropdown Indicator', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            base64_encode(mt_rand()),
            [
                'label' => __('Important Note', SA_EL_ADDONS_TEXTDOMAIN),
                'show_label' => false,
                'type' => Controls_Manager::RAW_HTML,
                'raw' => __('<div style="font-size: 11px;font-style:italic;line-height:1.4;color:#a4afb7;">Following options are only available in the <span style="color:#d30c5c"><strong>Small</strong></span> screens for <span style="color:#d30c5c"><strong>Horizontal</strong></span> Layout, and all screens for <span style="color:#d30c5c"><strong>Vertical</strong></span> Layout</div>', SA_EL_ADDONS_TEXTDOMAIN),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_indicator_color_hover',
            [
                'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li .sa-el-advanced-menu-indicator:hover:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li .sa-el-advanced-menu-indicator.sa-el-advanced-menu-indicator-open:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_indicator_background_hover',
            [
                'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#4caf50',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li .sa-el-advanced-menu-indicator:hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li .sa-el-advanced-menu-indicator.sa-el-advanced-menu-indicator-open' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sa_el_advanced_menu_dropdown_item_indicator_border_hover',
            [
                'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '#4caf50',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li .sa-el-advanced-menu-indicator:hover' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .sa-el-advanced-menu li ul li .sa-el-advanced-menu-indicator.sa-el-advanced-menu-indicator-open' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }

    public function render()
    {
        $settings = $this->parent->get_settings();
        $menu_classes = ['sa-el-advanced-menu', $settings['skin_seven_sa_el_advanced_menu_dropdown_animation'], 'sa-el-advanced-menu-indicator'];
        $container_classes = ['sa-el-advanced-menu-container', $settings['skin_seven_sa_el_advanced_menu_item_alignment'], $settings['skin_seven_sa_el_advanced_menu_dropdown_item_alignment']];

        if ($settings['skin_seven_sa_el_advanced_menu_layout'] == 'horizontal') {
            $menu_classes[] = 'sa-el-advanced-menu-horizontal';
        } else {
            $menu_classes[] = 'sa-el-advanced-menu-vertical';
        }

        if ( isset($settings['skin_seven_sa_el_advanced_menu_item_dropdown_indicator']) && $settings['skin_seven_sa_el_advanced_menu_item_dropdown_indicator'] == 'yes') {
            $menu_classes[] = 'sa-el-advanced-menu-indicator';
        }

        $this->parent->add_render_attribute('sa-el-advanced-menu', [
            'class' => implode(' ', array_filter($container_classes)),
            'data-indicator-class' => $settings['skin_seven_sa_el_advanced_menu_item_indicator'],
            'data-dropdown-indicator-class' => $settings['skin_seven_sa_el_advanced_menu_dropdown_item_indicator'],
        ]);

        if ($settings['sa_el_advanced_menu_menu']) {
            $args = [
                'menu' => $settings['sa_el_advanced_menu_menu'],
                'menu_class' => implode(' ', array_filter($menu_classes)),
                'container' => false,
                'echo' => false,
            ];

            echo '<div ' . $this->parent->get_render_attribute_string('sa-el-advanced-menu') . '>' . wp_nav_menu($args) . '</div>';
        }
    }
}
