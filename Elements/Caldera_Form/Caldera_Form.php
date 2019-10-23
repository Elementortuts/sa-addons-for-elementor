<?php

namespace SA_EL_ADDONS\Elements\Caldera_Form;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Controls_Manager as Controls_Manager;
use \Elementor\Group_Control_Border as Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography as Group_Control_Typography;
use \Elementor\Scheme_Typography as Scheme_Typography;
use \Elementor\Widget_Base as Widget_Base;

class Caldera_Form extends Widget_Base {

    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function get_name() {
        return 'sa_el_caldera_form';
    }

    public function get_title() {
        return esc_html__('Caldera From', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'fa fa-envelope-o  oxi-el-admin-icon';
    }

    public function get_keywords() {
        return ['caldera', 'wpf', 'wpform', 'form', 'contact', 'cf7', 'contact form', 'gravity', 'ninja'];
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    /**
     * Check if WPForms is activated
     *
     * @return bool
     */
    public function sa_el_is_cal_f_activated() {
        return class_exists('Caldera_Forms');
    }

    /**
     * Get a list of all WPForms
     *
     * @return array
     */
    public function sa_el_get_caldera_form() {
        $options = array();

        if (class_exists('Caldera_Forms')) {
            $contact_forms = \Caldera_Forms_Forms::get_forms(true, true);

            if (!empty($contact_forms) && !is_wp_error($contact_forms)) {
                $options[0] = esc_html__('Select Caldera Form', SA_EL_ADDONS_TEXTDOMAIN);
                foreach ($contact_forms as $form) {
                    $options[$form['ID']] = $form['name'];
                }
            }
        } else {
            $options[0] = esc_html__('Create a Form First', SA_EL_ADDONS_TEXTDOMAIN);
        }

        return $options;
    }

    function _register_controls() {
        /**
         * Content Tab: Caldera Forms
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_info_box',
                [
                    'label' => __('Caldera Forms', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );
        if (!$this->sa_el_is_cal_f_activated()) {
            $this->add_control(
                    'calderaf_missing_notice',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => sprintf(
                                __('Hi, it seems %1$s is missing in your site. Please install and activate %1$s first.', SA_EL_ADDONS_TEXTDOMAIN),
                                '<a href="https://wordpress.org/plugins/caldera-forms/" target="_blank" rel="noopener">Caldera Form</a>'
                        ),
                        'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                    ]
            );
            $this->end_controls_section();
            return;
        }
        $this->add_control(
                'contact_form_list',
                [
                    'label' => esc_html__('Caldera Form', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => $this->sa_el_get_caldera_form(),
                    'default' => '0',
                ]
        );

        $this->add_control(
                'custom_title_description',
                [
                    'label' => __('Custom Title & Description', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                    'return_value' => 'yes',
                ]
        );

        $this->add_control(
                'form_title_custom',
                [
                    'label' => esc_html__('Title', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'default' => '',
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'form_description_custom',
                [
                    'label' => esc_html__('Description', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => '',
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'labels_switch',
                [
                    'label' => __('Labels', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'label_on' => __('Show', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_off' => __('Hide', SA_EL_ADDONS_TEXTDOMAIN),
                    'return_value' => 'yes',
                    'prefix_class' => 'sa-el-caldera-form-labels-',
                ]
        );

        $this->add_control(
                'placeholder_switch',
                [
                    'label' => __('Placeholder', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'label_on' => __('Show', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_off' => __('Hide', SA_EL_ADDONS_TEXTDOMAIN),
                    'return_value' => 'yes',
                ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Errors
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_errors',
                [
                    'label' => __('Errors', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'error_messages',
                [
                    'label' => __('Error Messages', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'show',
                    'options' => [
                        'show' => __('Show', SA_EL_ADDONS_TEXTDOMAIN),
                        'hide' => __('Hide', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                    'selectors_dictionary' => [
                        'show' => 'block',
                        'hide' => 'none',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .has-error .parsley-required' => 'display: {{VALUE}} !important;',
                    ],
                ]
        );

        $this->end_controls_section();


        /* ----------------------------------------------------------------------------------- */
        /*    Style Tab
          /*----------------------------------------------------------------------------------- */

        /**
         * Style Tab: Form Title & Description
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_form_title_style',
                [
                    'label' => __('Title & Description', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->add_responsive_control(
                'heading_alignment',
                [
                    'label' => __('Alignment', SA_EL_ADDONS_TEXTDOMAIN),
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
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form-heading' => 'text-align: {{VALUE}};',
                    ],
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'title_heading',
                [
                    'label' => __('Title', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'form_title_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form-title' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'form_title_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form-title',
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->add_responsive_control(
                'form_title_margin',
                [
                    'label' => __('Margin', SA_EL_ADDONS_TEXTDOMAIN),
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
                        '{{WRAPPER}} .sa-el-caldera-form-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'description_heading',
                [
                    'label' => __('Description', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'form_description_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form-description' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'form_description_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form-description',
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->add_responsive_control(
                'form_description_margin',
                [
                    'label' => __('Margin', SA_EL_ADDONS_TEXTDOMAIN),
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
                        '{{WRAPPER}} .sa-el-caldera-form-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'custom_title_description' => 'yes',
                    ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Form Container
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_container_style',
                [
                    'label' => __('Form Container', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'sa_el_contact_form_background',
                [
                    'label' => esc_html__('Form Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form' => 'background: {{VALUE}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_contact_form_alignment',
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
                            'icon' => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'eicon-h-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__('Right', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default' => 'default',
                ]
        );

        $this->add_responsive_control(
                'sa_el_contact_form_max_width',
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
                        '{{WRAPPER}} .sa-el-caldera-form' => 'max-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_contact_form_padding',
                [
                    'label' => esc_html__('Form Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_control(
                'sa_el_contact_form_border_radius',
                [
                    'label' => esc_html__('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'separator' => 'before',
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'sa_el_contact_form_border',
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'sa_el_contact_form_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form',
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Labels
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_label_style',
                [
                    'label' => __('Labels', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'text_color_label',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group label' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'typography_label',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form .form-group label',
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Input & Textarea
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_fields_style',
                [
                    'label' => __('Input & Textarea', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'input_alignment',
                [
                    'label' => __('Alignment', SA_EL_ADDONS_TEXTDOMAIN),
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
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .form-group textarea, {{WRAPPER}} .sa-el-caldera-form .form-group select' => 'text-align: {{VALUE}};',
                    ],
                ]
        );

        $this->start_controls_tabs('tabs_fields_style');

        $this->start_controls_tab(
                'tab_fields_normal',
                [
                    'label' => __('Normal', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'field_bg_color',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .form-group textarea, {{WRAPPER}} .sa-el-caldera-form .form-group select' => 'background-color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'field_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .form-group textarea, {{WRAPPER}} .sa-el-caldera-form .form-group select' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'field_border',
                    'label' => __('Border', SA_EL_ADDONS_TEXTDOMAIN),
                    'placeholder' => '1px',
                    'default' => '1px',
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .form-group textarea, {{WRAPPER}} .sa-el-caldera-form .form-group select',
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'field_radius',
                [
                    'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .form-group textarea, {{WRAPPER}} .sa-el-caldera-form .form-group select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'field_text_indent',
                [
                    'label' => __('Text Indent', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 60,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 30,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .form-group textarea, {{WRAPPER}} .sa-el-caldera-form .form-group select' => 'text-indent: {{SIZE}}{{UNIT}}',
                    ],
                    'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'input_width',
                [
                    'label' => __('Input Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1200,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .form-group select' => 'width: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_responsive_control(
                'input_height',
                [
                    'label' => __('Input Height', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 80,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .form-group select' => 'height: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_responsive_control(
                'textarea_width',
                [
                    'label' => __('Textarea Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1200,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group textarea' => 'width: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_responsive_control(
                'textarea_height',
                [
                    'label' => __('Textarea Height', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group textarea' => 'height: {{SIZE}}{{UNIT}}',
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
                        '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .form-group textarea, {{WRAPPER}} .sa-el-caldera-form .form-group select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'field_spacing',
                [
                    'label' => __('Spacing', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'field_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .form-group textarea, {{WRAPPER}} .sa-el-caldera-form .form-group select',
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'field_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .form-group textarea, {{WRAPPER}} .sa-el-caldera-form .form-group select',
                    'separator' => 'before',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_fields_focus',
                [
                    'label' => __('Focus', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'field_bg_color_focus',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus, {{WRAPPER}} .sa-el-caldera-form .form-group textarea:focus' => 'background-color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'focus_input_border',
                    'label' => __('Border', SA_EL_ADDONS_TEXTDOMAIN),
                    'placeholder' => '1px',
                    'default' => '1px',
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus, {{WRAPPER}} .sa-el-caldera-form .form-group textarea:focus',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'focus_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus, {{WRAPPER}} .sa-el-caldera-form .form-group textarea:focus',
                    'separator' => 'before',
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Field Description
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_field_description_style',
                [
                    'label' => __('Field Description', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'field_description_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .help-block' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'field_description_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form .help-block',
                ]
        );

        $this->add_responsive_control(
                'field_description_spacing',
                [
                    'label' => __('Spacing', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .help-block' => 'padding-top: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Placeholder
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_placeholder_style',
                [
                    'label' => __('Placeholder', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'placeholder_switch' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'text_color_placeholder',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group input::-webkit-input-placeholder, {{WRAPPER}} .sa-el-caldera-form .form-group textarea::-webkit-input-placeholder' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'placeholder_switch' => 'yes',
                    ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Radio & Checkbox
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_radio_checkbox_style',
                [
                    'label' => __('Radio & Checkbox', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'custom_radio_checkbox',
                [
                    'label' => __('Custom Styles', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                    'return_value' => 'yes',
                ]
        );

        $this->add_responsive_control(
                'radio_checkbox_size',
                [
                    'label' => __('Size', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '15',
                        'unit' => 'px',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 80,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-custom-radio-checkbox input[type="checkbox"], {{WRAPPER}} .sa-el-custom-radio-checkbox input[type="radio"]' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                    ],
                    'condition' => [
                        'custom_radio_checkbox' => 'yes',
                    ],
                ]
        );

        $this->start_controls_tabs('tabs_radio_checkbox_style');

        $this->start_controls_tab(
                'radio_checkbox_normal',
                [
                    'label' => __('Normal', SA_EL_ADDONS_TEXTDOMAIN),
                    'condition' => [
                        'custom_radio_checkbox' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'radio_checkbox_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-custom-radio-checkbox input[type="checkbox"], {{WRAPPER}} .sa-el-custom-radio-checkbox input[type="radio"]' => 'background: {{VALUE}}',
                    ],
                    'condition' => [
                        'custom_radio_checkbox' => 'yes',
                    ],
                ]
        );

        $this->add_responsive_control(
                'checkbox_border_width',
                [
                    'label' => __('Border Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 15,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-custom-radio-checkbox input[type="checkbox"], {{WRAPPER}} .sa-el-custom-radio-checkbox input[type="radio"]' => 'border-width: {{SIZE}}{{UNIT}}',
                    ],
                    'condition' => [
                        'custom_radio_checkbox' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'checkbox_border_color',
                [
                    'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-custom-radio-checkbox input[type="checkbox"], {{WRAPPER}} .sa-el-custom-radio-checkbox input[type="radio"]' => 'border-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'custom_radio_checkbox' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'checkbox_heading',
                [
                    'label' => __('Checkbox', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'condition' => [
                        'custom_radio_checkbox' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'checkbox_border_radius',
                [
                    'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-custom-radio-checkbox input[type="checkbox"], {{WRAPPER}} .sa-el-custom-radio-checkbox input[type="checkbox"]:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'custom_radio_checkbox' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'radio_heading',
                [
                    'label' => __('Radio Buttons', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'condition' => [
                        'custom_radio_checkbox' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'radio_border_radius',
                [
                    'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-custom-radio-checkbox input[type="radio"], {{WRAPPER}} .sa-el-custom-radio-checkbox input[type="radio"]:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'custom_radio_checkbox' => 'yes',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'radio_checkbox_checked',
                [
                    'label' => __('Checked', SA_EL_ADDONS_TEXTDOMAIN),
                    'condition' => [
                        'custom_radio_checkbox' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'radio_checkbox_color_checked',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-custom-radio-checkbox input[type="checkbox"]:checked:before,
                         {{WRAPPER}} .sa-el-custom-radio-checkbox input[type="radio"]:checked:before' => 'background: {{VALUE}}',
                    ],
                    'condition' => [
                        'custom_radio_checkbox' => 'yes',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Submit Button
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_submit_button_style',
                [
                    'label' => __('Submit Button', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'button_align',
                [
                    'label' => __('Alignment', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __('Left', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => __('Center', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'eicon-h-align-center',
                        ],
                        'right' => [
                            'title' => __('Right', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default' => '',
                    'prefix_class' => 'sa-el-caldera-form-button-',
                    'condition' => [
                        'button_width_type' => 'custom',
                    ],
                ]
        );

        $this->add_control(
                'button_width_type',
                [
                    'label' => __('Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'custom',
                    'options' => [
                        'full-width' => __('Full Width', SA_EL_ADDONS_TEXTDOMAIN),
                        'custom' => __('Custom', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                    'prefix_class' => 'sa-el-caldera-form-button-',
                ]
        );

        $this->add_responsive_control(
                'button_width',
                [
                    'label' => __('Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1200,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"], {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]' => 'width: {{SIZE}}{{UNIT}}',
                    ],
                    'condition' => [
                        'button_width_type' => 'custom',
                    ],
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
                'button_bg_color_normal',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"], {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]' => 'background-color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'button_text_color_normal',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"], {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'button_border_normal',
                    'label' => __('Border', SA_EL_ADDONS_TEXTDOMAIN),
                    'placeholder' => '1px',
                    'default' => '1px',
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"], {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]',
                ]
        );

        $this->add_control(
                'button_border_radius',
                [
                    'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"], {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'button_padding',
                [
                    'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"], {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'button_margin',
                [
                    'label' => __('Margin Top', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"], {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]' => 'margin-top: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'button_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"], {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]',
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'button_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"], {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]',
                    'separator' => 'before',
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
                'button_bg_color_hover',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"]:hover, {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]:hover' => 'background-color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'button_text_color_hover',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"]:hover, {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]:hover' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'button_border_color_hover',
                [
                    'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .form-group input[type="submit"]:hover, {{WRAPPER}} .sa-el-caldera-form .form-group input[type="button"]:hover' => 'border-color: {{VALUE}}',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Success Message
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_success_message_style',
                [
                    'label' => __('Success Message', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'success_message_bg_color',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .caldera-grid .alert-success' => 'background-color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'success_message_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .caldera-grid .alert-success' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'success_message_border',
                    'label' => __('Border', SA_EL_ADDONS_TEXTDOMAIN),
                    'placeholder' => '1px',
                    'default' => '1px',
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form .caldera-grid .alert-success',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'success_message_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form .caldera-grid .alert-success',
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Errors
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_error_style',
                [
                    'label' => __('Errors', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'error_messages_heading',
                [
                    'label' => __('Error Messages', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'condition' => [
                        'error_messages' => 'show',
                    ],
                ]
        );

        $this->add_control(
                'error_message_text_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .has-error .help-block' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'error_messages' => 'show',
                    ],
                ]
        );

        $this->add_control(
                'error_fields_heading',
                [
                    'label' => __('Error Fields', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'error_fields_label_color',
                [
                    'label' => __('Label Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-caldera-form .has-error .control-label' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'error_field_border',
                    'label' => __('Input Border', SA_EL_ADDONS_TEXTDOMAIN),
                    'placeholder' => '1px',
                    'default' => '1px',
                    'selector' => '{{WRAPPER}} .sa-el-caldera-form .has-error input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-caldera-form .has-error textarea',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        if (!class_exists('\Caldera_Forms')) {
            return;
        }

        $settings = $this->get_settings();

        $this->add_render_attribute('caldera-form', 'class', [
            'sa-el-caldera-form',
        ]);

        if ($settings['placeholder_switch'] != 'yes') {
            $this->add_render_attribute('caldera-form', 'class', 'placeholder-hide');
        }

        if ($settings['custom_title_description'] == 'yes') {
            $this->add_render_attribute('caldera-form', 'class', 'title-description-hide');
        }

        if ($settings['custom_radio_checkbox'] == 'yes') {
            $this->add_render_attribute('caldera-form', 'class', 'sa-el-custom-radio-checkbox');
        }
        if ($settings['sa_el_contact_form_alignment'] == 'left') {
            $this->add_render_attribute('caldera-form', 'class', 'sa-el-caldera-form-top-align-left');
        } elseif ($settings['sa_el_contact_form_alignment'] == 'center') {
            $this->add_render_attribute('caldera-form', 'class', 'sa-el-caldera-form-top-align-center');
        } elseif ($settings['sa_el_contact_form_alignment'] == 'right') {
            $this->add_render_attribute('caldera-form', 'class', 'sa-el-caldera-form-top-align-right');
        } else {
            $this->add_render_attribute('caldera-form', 'class', 'sa-el-caldera-form-top-align-default');
        }

        if (!empty($settings['contact_form_list'])) {
            ?>
            <div <?php echo $this->get_render_attribute_string('caldera-form'); ?>>
                <?php if ($settings['custom_title_description'] == 'yes') { ?>
                    <div class="sa-el-caldera-form-heading">
                        <?php if ($settings['form_title_custom'] != '') { ?>
                            <h3 class="sa-el-caldera-form-title sa-el-caldera-form-title">
                                <?php echo esc_attr($settings['form_title_custom']); ?>
                            </h3>
                        <?php } ?>
                        <?php if ($settings['form_description_custom'] != '') { ?>
                            <div class="sa-el-caldera-form-description sa-el-caldera-form-description">
                                <?php echo $this->parse_text_editor($settings['form_description_custom']); ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php echo do_shortcode('[caldera_form id="' . $settings['contact_form_list'] . '" ]'); ?>
            </div>
            <?php
        }
    }

}
