<?php

namespace SA_EL_ADDONS\Elements\Contact_Form_7;

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

class Contact_Form_7 extends Widget_Base {

    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    /**
     * Sanitize html class string
     *
     * @param $class
     * @return string
     */
    public function get_name() {
        return 'sa_el_cf7';
    }

    public function get_title() {
        return esc_html__('Contact Form 7', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'fa fa-envelope-o  oxi-el-admin-icon';
    }

    public function get_keywords() {
        return ['form', 'contact', 'cf7', 'contact form', 'gravity', 'ninja'];
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    /**
     * Check if contact form 7 is activated
     *
     * @return bool
     */
    public function sa_el_cf7_activated() {
        return class_exists('WPCF7');
    }

    /**
     * Get a list of all CF7 forms
     *
     * @return array
     */
    public function sa_el_get_cf7_forms() {
        $forms = get_posts([
            'post_type' => 'wpcf7_contact_form',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        ]);

        if (!empty($forms)) {
            return wp_list_pluck($forms, 'post_title', 'ID');
        }
        return [];
    }

    /**
     * Sanitize html class string
     *
     * @param $class
     * @return string
     */
    public function sa_el_sanitize_html_class_param($class) {
        $classes = !empty($class) ? explode(' ', $class) : [];
        $sanitized = [];
        if (!empty($classes)) {
            $sanitized = array_map(function( $cls ) {
                return sanitize_html_class($cls);
            }, $classes);
        }
        return implode(' ', $sanitized);
    }

    protected function _register_controls() {

        $this->start_controls_section(
                '_section_cf7',
                [
                    'label' => $this->sa_el_cf7_activated() ? __('Contact Form 7', SA_EL_ADDONS_TEXTDOMAIN) : __('Notice', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        if (!$this->sa_el_cf7_activated()) {
            $this->add_control(
                    'cf7_missing_notice',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => sprintf(
                                __('Hi, it seems %1$s is missing in your site. Please install and activate %1$s first.', SA_EL_ADDONS_TEXTDOMAIN),
                                '<a href="https://wordpress.org/plugins/contact-form-7/" target="_blank" rel="noopener">Contact Form 7</a>'
                        ),
                        'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                    ]
            );
            $this->end_controls_section();
            return;
        }

        $this->add_control(
                'form_id',
                [
                    'label' => __('Select Your Form', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => ['' => __('', SA_EL_ADDONS_TEXTDOMAIN)] + $this->sa_el_get_cf7_forms(),
                ]
        );

        $this->add_control(
                'html_class',
                [
                    'label' => __('HTML Class', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'description' => __('Add CSS custom class to the form.', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                '_section_fields_style',
                [
                    'label' => __('Form Fields', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'field_width',
                [
                    'label' => __('Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'unit' => '%',
                    ],
                    'tablet_default' => [
                        'unit' => '%',
                    ],
                    'mobile_default' => [
                        'unit' => '%',
                    ],
                    'size_units' => ['%', 'px'],
                    'range' => [
                        '%' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                        'px' => [
                            'min' => 1,
                            'max' => 500,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'width: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .sa-el-cf7-form label' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'field_margin',
                [
                    'label' => __('Spacing Bottom', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'field_padding',
                [
                    'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'field_border_radius',
                [
                    'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_control(
                'hr',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'style' => 'thick',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'field_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_3
                ]
        );

        $this->add_control(
                'field_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'field_placeholder_color',
                [
                    'label' => __('Placeholder Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} ::-moz-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} ::-ms-input-placeholder' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->start_controls_tabs('tabs_field_state');

        $this->start_controls_tab(
                'tab_field_normal',
                [
                    'label' => __('Normal', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'field_border',
                    'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'field_box_shadow',
                    'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
                ]
        );

        $this->add_control(
                'field_bg_color',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'background-color: {{VALUE}}',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_field_focus',
                [
                    'label' => __('Focus', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'field_focus_border',
                    'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'field_focus_box_shadow',
                    'exclude' => [
                        'box_shadow_position',
                    ],
                    'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus',
                ]
        );

        $this->add_control(
                'field_focus_bg_color',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus' => 'background-color: {{VALUE}}',
                    ],
                ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
                'cf7-form-label',
                [
                    'label' => __('Form Fields Label', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'label_margin',
                [
                    'label' => __('Spacing Bottom', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'margin-top: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_control(
                'hr3',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'style' => 'thick',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'label_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} label',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_3
                ]
        );

        $this->add_control(
                'label_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} label' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'submit',
                [
                    'label' => __('Submit Button', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'submit_margin',
                [
                    'label' => __('Margin', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'submit_padding',
                [
                    'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'submit_typography',
                    'selector' => '{{WRAPPER}} .wpcf7-submit',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'submit_border',
                    'selector' => '{{WRAPPER}} .wpcf7-submit',
                ]
        );

        $this->add_control(
                'submit_border_radius',
                [
                    'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'submit_box_shadow',
                    'selector' => '{{WRAPPER}} .wpcf7-submit',
                ]
        );

        $this->add_control(
                'hr4',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'style' => 'thick',
                ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
                'tab_button_normal',
                [
                    'label' => __('Normal', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'submit_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-submit' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'submit_bg_color',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-submit' => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_button_hover',
                [
                    'label' => __('Hover', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'submit_hover_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-submit:hover, {{WRAPPER}} .wpcf7-submit:focus' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'submit_hover_bg_color',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-submit:hover, {{WRAPPER}} .wpcf7-submit:focus' => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'submit_hover_border_color',
                [
                    'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wpcf7-submit:hover, {{WRAPPER}} .wpcf7-submit:focus' => 'border-color: {{VALUE}};',
                    ],
                ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        if (!$this->sa_el_cf7_activated()) {
            return;
        }

        $settings = $this->get_settings_for_display();

        if (!empty($settings['form_id'])) {
            echo $this->sa_el_do_shortcode('contact-form-7', [
                'id' => $settings['form_id'],
                'html_class' => 'sa-el-cf7-form ' . $this->sa_el_sanitize_html_class_param($settings['html_class']),
            ]);
        }
    }

}
