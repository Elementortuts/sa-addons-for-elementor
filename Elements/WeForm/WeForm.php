<?php

namespace SA_EL_ADDONS\Elements\WeForm;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use \Elementor\Widget_Base as Widget_Base;

class WeForm extends Widget_Base {

    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function get_name() {
        return 'sa_el_weform';
    }

    public function get_title() {
        return esc_html__('WeFrom', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'fa fa-envelope-o  oxi-el-admin-icon';
    }

    public function get_keywords() {
        return ['weForms', 'we forms', 'caldera', 'wpf', 'wpform', 'form', 'contact', 'cf7', 'contact form', 'gravity', 'ninja'];
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    /**
     * Check if WPForms is activated
     *
     * @return bool
     */
    public function sa_el_is_weform_activated() {
        return class_exists('WeForms');
    }

    /**
     * Get a list of all WPForms
     *
     * @return array
     */
    public function sa_el_get_weforms() {
        $wpuf_form_list = get_posts(array(
            'post_type' => 'wpuf_contact_form',
            'showposts' => 999,
        ));

        $options = array();

        if (!empty($wpuf_form_list) && !is_wp_error($wpuf_form_list)) {
            $options[0] = esc_html__('Select weForm', SA_EL_ADDONS_TEXTDOMAIN);
            foreach ($wpuf_form_list as $post) {
                $options[$post->ID] = $post->post_title;
            }
        } else {
            $options[0] = esc_html__('Create a Form First', SA_EL_ADDONS_TEXTDOMAIN);
        }

        return $options;
    }

    protected function _register_controls() {
        $this->start_controls_section(
                'section_info_box',
                [
                    'label' => __('WeForm', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );
        if (!$this->sa_el_is_weform_activated()) {
            $this->add_control(
                    'wpf_missing_notice',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => sprintf(
                                __('Hi, it seems %1$s is missing in your site. Please install and activate %1$s first.', SA_EL_ADDONS_TEXTDOMAIN),
                                '<a href="https://wordpress.org/plugins/weforms/" target="_blank" rel="noopener">weForms</a>'
                        ),
                        'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                    ]
            );
            $this->end_controls_section();
            return;
        }

        $this->add_control(
                'wpuf_contact_form',
                [
                    'label' => esc_html__('Select Form', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => $this->sa_el_get_weforms(),
                    'default' => '0',
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'sa_el_section_weform_styles',
                [
                    'label' => esc_html__('Form Container Styles', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'sa_el_weform_background',
                [
                    'label' => esc_html__('Form Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container' => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_alignment',
                [
                    'label' => esc_html__('Form Alignment', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::CHOOSE,
                    'label_block' => true,
                    'options' => [
                        'default' => [
                            'title' => __('Default', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-ban',
                        ],
                        'left' => [
                            'title' => esc_html__('Left', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__('Right', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'default' => 'default',
                    'prefix_class' => 'sa-el-contact-form-align-',
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_width',
                [
                    'label' => esc_html__('Form Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px', 'em', '%'],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 1500,
                        ],
                        'em' => [
                            'min' => 1,
                            'max' => 80,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_max_width',
                [
                    'label' => esc_html__('Form Max Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px', 'em', '%'],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 1500,
                        ],
                        'em' => [
                            'min' => 1,
                            'max' => 80,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container' => 'max-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_margin',
                [
                    'label' => esc_html__('Form Margin', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_padding',
                [
                    'label' => esc_html__('Form Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_control(
                'sa_el_weform_border_radius',
                [
                    'label' => esc_html__('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'separator' => 'before',
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'sa_el_weform_border',
                    'selector' => '{{WRAPPER}} .sa-el-weform-container',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'sa_el_weform_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-weform-container',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'sa_el_section_weform_field_styles',
                [
                    'label' => esc_html__('Form Fields Styles', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'sa_el_weform_input_background',
                [
                    'label' => esc_html__('Input Field Background', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="text"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="password"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="email"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="number"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields textarea' => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_input_width',
                [
                    'label' => esc_html__('Input Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px', 'em', '%'],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 1500,
                        ],
                        'em' => [
                            'min' => 1,
                            'max' => 80,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="text"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="password"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="email"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="number"]' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_textarea_width',
                [
                    'label' => esc_html__('Textarea Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px', 'em', '%'],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 1500,
                        ],
                        'em' => [
                            'min' => 1,
                            'max' => 80,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields textarea' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_input_padding',
                [
                    'label' => esc_html__('Fields Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="text"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="password"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="email"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="number"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_control(
                'sa_el_weform_input_border_radius',
                [
                    'label' => esc_html__('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'separator' => 'before',
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="text"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="password"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="email"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="number"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'sa_el_weform_input_border',
                    'selector' => '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="text"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="password"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="email"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="number"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields textarea',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'sa_el_weform_input_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="text"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="password"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="email"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="number"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields textarea',
                ]
        );

        $this->add_control(
                'sa_el_weform_focus_heading',
                [
                    'type' => Controls_Manager::HEADING,
                    'label' => esc_html__('Focus State Style', SA_EL_ADDONS_TEXTDOMAIN),
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'sa_el_weform_input_focus_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="text"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="password"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="email"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="number"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields textarea:focus',
                ]
        );

        $this->add_control(
                'sa_el_weform_input_focus_border',
                [
                    'label' => esc_html__('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="text"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="password"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="email"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="number"]:focus,
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields textarea:focus' => 'border-color: {{VALUE}};',
                    ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'sa_el_section_weform_typography',
                [
                    'label' => esc_html__('Color & Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'sa_el_weform_label_color',
                [
                    'label' => esc_html__('Label Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container, {{WRAPPER}} .sa-el-weform-container .wpuf-label label' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'sa_el_weform_field_color',
                [
                    'label' => esc_html__('Field Font Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="text"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="password"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="email"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="number"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields textarea' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'sa_el_weform_placeholder_color',
                [
                    'label' => esc_html__('Placeholder Font Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-weform-container ::-moz-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-weform-container ::-ms-input-placeholder' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'sa_el_weform_label_heading',
                [
                    'type' => Controls_Manager::HEADING,
                    'label' => esc_html__('Label Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sa_el_weform_label_typography',
                    'selector' => '{{WRAPPER}} .sa-el-weform-container, {{WRAPPER}} .sa-el-weform-container .wpuf-label label',
                ]
        );

        $this->add_control(
                'sa_el_weform_heading_input_field',
                [
                    'type' => Controls_Manager::HEADING,
                    'label' => esc_html__('Input Fields Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sa_el_weform_input_field_typography',
                    'selector' => '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="text"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="password"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="email"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="url"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields input[type="number"],
					 {{WRAPPER}} .sa-el-weform-container ul.wpuf-form li .wpuf-fields textarea',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'sa_el_section_weform_submit_button_styles',
                [
                    'label' => esc_html__('Submit Button Styles', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_submit_btn_width',
                [
                    'label' => esc_html__('Button Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px', 'em', '%'],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 1500,
                        ],
                        'em' => [
                            'min' => 1,
                            'max' => 80,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_submit_btn_alignment',
                [
                    'label' => esc_html__('Button Alignment', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::CHOOSE,
                    'label_block' => true,
                    'options' => [
                        'left' => [
                            'title' => esc_html__('Left', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__('Right', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'default' => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit ' => 'text-align : {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sa_el_weform_submit_btn_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]',
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_submit_btn_margin',
                [
                    'label' => esc_html__('Margin', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_weform_submit_btn_padding',
                [
                    'label' => esc_html__('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->start_controls_tabs('sa_el_weform_submit_button_tabs');

        $this->start_controls_tab('normal', ['label' => esc_html__('Normal', SA_EL_ADDONS_TEXTDOMAIN)]);

        $this->add_control(
                'sa_el_weform_submit_btn_text_color',
                [
                    'label' => esc_html__('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'sa_el_weform_submit_btn_background_color',
                [
                    'label' => esc_html__('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]' => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'sa_el_weform_submit_btn_border',
                    'selector' => '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]',
                ]
        );

        $this->add_control(
                'sa_el_weform_submit_btn_border_radius',
                [
                    'label' => esc_html__('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]' => 'border-radius: {{SIZE}}px;',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('sa_el_weform_submit_btn_hover', ['label' => esc_html__('Hover', SA_EL_ADDONS_TEXTDOMAIN)]);

        $this->add_control(
                'sa_el_weform_submit_btn_hover_text_color',
                [
                    'label' => esc_html__('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]:hover' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'sa_el_weform_submit_btn_hover_background_color',
                [
                    'label' => esc_html__('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]:hover' => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'sa_el_weform_submit_btn_hover_border_color',
                [
                    'label' => esc_html__('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]:hover' => 'border-color: {{VALUE}};',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'sa_el_weform_submit_btn_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-weform-container ul.wpuf-form .wpuf-submit input[type="submit"]',
                ]
        );



        $this->end_controls_section();
    }

    protected function render() {
        if (!$this->sa_el_is_weform_activated()) {
            return;
        }

        $settings = $this->get_settings();


        if (!empty($settings['wpuf_contact_form'])) {
            echo '<div class="sa-el-weform-container">
			' . do_shortcode('[weforms id="' . $settings['wpuf_contact_form'] . '" ]') . '
		</div>';
        }
    }

}
