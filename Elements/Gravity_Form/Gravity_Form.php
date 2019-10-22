<?php

namespace SA_EL_ADDONS\Elements\Gravity_Form;

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

class Gravity_Form extends Widget_Base {

    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function get_name() {
        return 'sa_el_gravity_form';
    }

    public function get_title() {
        return esc_html__('Gravity Forms', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'fa fa-envelope-o  oxi-el-admin-icon';
    }

    public function get_keywords() {
        return ['wpf', 'wpform', 'form', 'contact', 'cf7', 'contact form', 'gravity', 'ninja'];
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    /**
     * Get Gravity Form [ if exists ]
     *
     * @return array
     */
    public function sa_el_select_gravity_form() {
        $options = array();

        if (class_exists('GFCommon')) {
            $gravity_forms = \RGFormsModel::get_forms(null, 'title');

            if (!empty($gravity_forms) && !is_wp_error($gravity_forms)) {

                $options[0] = esc_html__('Select Gravity Form', SA_EL_ADDONS_TEXTDOMAIN);
                foreach ($gravity_forms as $form) {
                    $options[$form->id] = $form->title;
                }
            } else {
                $options[0] = esc_html__('Create a Form First', SA_EL_ADDONS_TEXTDOMAIN);
            }
        }

        return $options;
    }

    protected function _register_controls() {

        /* ----------------------------------------------------------------------------------- */
        /* 	CONTENT TAB
          /*----------------------------------------------------------------------------------- */
        if (!class_exists('\GFForms')) {
            $this->start_controls_section(
                    'sa_el_global_warning',
                    [
                        'label' => __('Warning!', SA_EL_ADDONS_TEXTDOMAIN),
                    ]
            );

            $this->add_control(
                    'sa_el_global_warning_text',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => __('<strong>Gravity Forms</strong> is not installed/activated on your site. Please install and activate <strong>Gravity Forms</strong> first.', SA_EL_ADDONS_TEXTDOMAIN),
                        'content_classes' => 'sa-el-warning',
                    ]
            );

            $this->end_controls_section();
        } else {
            /**
             * Content Tab: Contact Form
             * -------------------------------------------------
             */
            $this->start_controls_section(
                    'section_info_box',
                    [
                        'label' => __('Gravity Forms', SA_EL_ADDONS_TEXTDOMAIN),
                    ]
            );

            $this->add_control(
                    'contact_form_list',
                    [
                        'label' => esc_html__('Select Form', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::SELECT,
                        'label_block' => true,
                        'options' => $this->sa_el_select_gravity_form(),
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
                    'form_title',
                    [
                        'label' => __('Title', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::SWITCHER,
                        'default' => 'yes',
                        'label_on' => __('Show', SA_EL_ADDONS_TEXTDOMAIN),
                        'label_off' => __('Hide', SA_EL_ADDONS_TEXTDOMAIN),
                        'return_value' => 'yes',
                        'condition' => [
                            'custom_title_description!' => 'yes',
                        ],
                    ]
            );

            $this->add_control(
                    'form_description',
                    [
                        'label' => __('Description', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::SWITCHER,
                        'default' => 'yes',
                        'label_on' => __('Show', SA_EL_ADDONS_TEXTDOMAIN),
                        'label_off' => __('Hide', SA_EL_ADDONS_TEXTDOMAIN),
                        'return_value' => 'yes',
                        'condition' => [
                            'custom_title_description!' => 'yes',
                        ],
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

            $this->add_control(
                    'form_ajax',
                    [
                        'label' => __('Use Ajax', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::SWITCHER,
                        'description' => __('Use ajax to submit the form', SA_EL_ADDONS_TEXTDOMAIN),
                        'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                        'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
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
                            '{{WRAPPER}} .sa-el-gravity-form .validation_message' => 'display: {{VALUE}} !important;',
                        ],
                    ]
            );

            $this->add_control(
                    'validation_errors',
                    [
                        'label' => __('Validation Errors', SA_EL_ADDONS_TEXTDOMAIN),
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
                            '{{WRAPPER}} .sa-el-gravity-form .validation_error' => 'display: {{VALUE}} !important;',
                        ],
                    ]
            );

            $this->end_controls_section();
        }

        /* ----------------------------------------------------------------------------------- */
        /* 	STYLE TAB
          /*----------------------------------------------------------------------------------- */

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
                'sa_el_gravity_form_background',
                [
                    'label' => esc_html__('Form Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form' => 'background: {{VALUE}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_gravity_form_alignment',
                [
                    'label' => esc_html__('Form Alignment', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::CHOOSE,
                    'label_block' => true,
                    'options' => [
                        
                        'sa-el-gravity-form-top-align-left' => [
                            'title' => esc_html__('Left', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'sa-el-gravity-form-top-align-center' => [
                            'title' => esc_html__('Center', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'eicon-h-align-center',
                        ],
                        'sa-el-gravity-form-top-align-right' => [
                            'title' => esc_html__('Right', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default' => 'sa-el-gravity-form-top-align-left',
                ]
        );

        $this->add_responsive_control(
                'sa_el_gravity_form_width',
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
                        '{{WRAPPER}} .sa-el-gravity-form' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_gravity_form_max_width',
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
                        '{{WRAPPER}} .sa-el-gravity-form' => 'max-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );


        $this->add_responsive_control(
                'sa_el_gravity_form_margin',
                [
                    'label' => esc_html__('Form Margin', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'sa_el_gravity_form_padding',
                [
                    'label' => esc_html__('Form Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );


        $this->add_control(
                'sa_el_gravity_form_border_radius',
                [
                    'label' => esc_html__('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'separator' => 'before',
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );


        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'sa_el_gravity_form_border',
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form',
                ]
        );


        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'sa_el_gravity_form_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form',
                ]
        );

        $this->end_controls_section();
        /**
         * Style Tab: Title and Description
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_general_style',
                [
                    'label' => __('Title & Description', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
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
                        '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper .gform_heading' => 'text-align: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'title_heading',
                [
                    'label' => __('Title', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'title_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper .gform_title, {{WRAPPER}} .sa-el-gravity-form .sa-el-gravity-form-title' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper .gform_title, {{WRAPPER}} .sa-el-gravity-form .sa-el-gravity-form-title',
                ]
        );

        $this->add_control(
                'description_heading',
                [
                    'label' => __('Description', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'description_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper .gform_description, {{WRAPPER}} .sa-el-gravity-form .sa-el-gravity-form-description' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'description_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper .gform_description, {{WRAPPER}} .sa-el-gravity-form .sa-el-gravity-form-description',
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
                    'condition' => [
                        'labels_switch' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'text_color_label',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gfield label' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'labels_switch' => 'yes',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'typography_label',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gfield label',
                    'condition' => [
                        'labels_switch' => 'yes',
                    ],
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield input[type="text"], {{WRAPPER}} .sa-el-gravity-form .gfield textarea' => 'text-align: {{VALUE}};',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield input[type="text"], {{WRAPPER}} .sa-el-gravity-form .gfield textarea, {{WRAPPER}} .sa-el-gravity-form .gfield select' => 'background-color: {{VALUE}}',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield input[type="text"], {{WRAPPER}} .sa-el-gravity-form .gfield textarea, {{WRAPPER}} .sa-el-gravity-form .gfield select' => 'color: {{VALUE}}',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_responsive_control(
                'field_spacing_right',
                [
                    'label' => __('Spacing Right', SA_EL_ADDONS_TEXTDOMAIN),
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield.gf_left_half' => 'padding-right: {{SIZE}}{{UNIT}}',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-gravity-form .gfield textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'text_indent',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield input[type="text"], {{WRAPPER}} .sa-el-gravity-form .gfield textarea, {{WRAPPER}} .sa-el-gravity-form .gfield select' => 'text-indent: {{SIZE}}{{UNIT}}',
                    ],
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield input[type="text"], {{WRAPPER}} .sa-el-gravity-form .gfield select' => 'width: {{SIZE}}{{UNIT}}',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield input[type="text"], {{WRAPPER}} .sa-el-gravity-form .gfield input[type="email"], {{WRAPPER}} .sa-el-gravity-form .gfield input[type="url"], {{WRAPPER}} .sa-el-gravity-form .gfield select' => 'height: {{SIZE}}{{UNIT}}',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield textarea' => 'width: {{SIZE}}{{UNIT}}',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield textarea' => 'height: {{SIZE}}{{UNIT}}',
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
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gfield input[type="text"], {{WRAPPER}} .sa-el-gravity-form .gfield textarea, {{WRAPPER}} .sa-el-gravity-form .gfield select',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield input[type="text"], {{WRAPPER}} .sa-el-gravity-form .gfield textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'field_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gfield input[type="text"], {{WRAPPER}} .sa-el-gravity-form .gfield textarea, {{WRAPPER}} .sa-el-gravity-form .gfield select',
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'field_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gfield input[type="text"], {{WRAPPER}} .sa-el-gravity-form .gfield textarea, {{WRAPPER}} .sa-el-gravity-form .gfield select',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield input:focus, {{WRAPPER}} .sa-el-gravity-form .gfield textarea:focus' => 'background-color: {{VALUE}}',
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
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gfield input:focus, {{WRAPPER}} .sa-el-gravity-form .gfield textarea:focus',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'focus_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gfield input:focus, {{WRAPPER}} .sa-el-gravity-form .gfield textarea:focus',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield .gfield_description' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'field_description_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gfield .gfield_description',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield .gfield_description' => 'padding-top: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Section Field
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_field_style',
                [
                    'label' => __('Section Field', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'section_field_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gfield.gsection .gsection_title' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'section_field_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gfield.gsection .gsection_title',
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'section_field_border_type',
                [
                    'label' => __('Border Type', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'solid',
                    'options' => [
                        'none' => __('None', SA_EL_ADDONS_TEXTDOMAIN),
                        'solid' => __('Solid', SA_EL_ADDONS_TEXTDOMAIN),
                        'double' => __('Double', SA_EL_ADDONS_TEXTDOMAIN),
                        'dotted' => __('Dotted', SA_EL_ADDONS_TEXTDOMAIN),
                        'dashed' => __('Dashed', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gfield.gsection' => 'border-bottom-style: {{VALUE}}',
                    ],
                    'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'section_field_border_height',
                [
                    'label' => __('Border Height', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 1,
                    ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 20,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gfield.gsection' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
                    ],
                    'condition' => [
                        'section_field_border_type!' => 'none',
                    ],
                ]
        );

        $this->add_control(
                'section_field_border_color',
                [
                    'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gfield.gsection' => 'border-bottom-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'section_field_border_type!' => 'none',
                    ],
                ]
        );

        $this->add_responsive_control(
                'section_field_margin',
                [
                    'label' => __('Margin', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gfield.gsection' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Section Field
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_price_style',
                [
                    'label' => __('Price', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'price_label_color',
                [
                    'label' => __('Price Label Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper .ginput_product_price_label' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'price_text_color',
                [
                    'label' => __('Price Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper .ginput_product_price' => 'color: {{VALUE}}',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gfield input::-webkit-input-placeholder, {{WRAPPER}} .sa-el-gravity-form .gfield textarea::-webkit-input-placeholder' => 'color: {{VALUE}}',
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
                        'unit' => 'px'
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
                        '{{WRAPPER}} .sa-el-custom-radio-checkbox input[type="checkbox"], {{WRAPPER}} .sa-el-custom-radio-checkbox input[type="radio"]' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}}',
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
                'radio_checkbox_border_width',
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
                'radio_checkbox_border_color',
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
                        '{{WRAPPER}} .sa-el-custom-radio-checkbox input[type="checkbox"]:checked:before, {{WRAPPER}} .sa-el-custom-radio-checkbox input[type="radio"]:checked:before' => 'background: {{VALUE}}',
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
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_footer' => 'text-align: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]' => 'display:inline-block;'
                    ],
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
                    'prefix_class' => 'sa-el-gravity-form-button-',
                ]
        );

        $this->add_responsive_control(
                'button_width',
                [
                    'label' => __('Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '100',
                        'unit' => 'px'
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1200,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]' => 'width: {{SIZE}}{{UNIT}}',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]' => 'background-color: {{VALUE}}',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]' => 'color: {{VALUE}}',
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
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]',
                ]
        );

        $this->add_control(
                'button_border_radius',
                [
                    'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]' => 'margin-top: {{SIZE}}{{UNIT}}',
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
                'button_bg_color_hover',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]:hover' => 'background-color: {{VALUE}}',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]:hover' => 'color: {{VALUE}}',
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
                        '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]:hover' => 'border-color: {{VALUE}}',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'button_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]',
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'button_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-gravity-form .gform_footer input[type="submit"]',
                    'separator' => 'before',
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
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gfield .validation_message' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'error_messages' => 'show',
                    ],
                ]
        );

        $this->add_control(
                'validation_errors_heading',
                [
                    'label' => __('Validation Errors', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'validation_errors' => 'show',
                    ],
                ]
        );

        $this->add_control(
                'validation_error_description_color',
                [
                    'label' => __('Error Description Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper .validation_error' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'validation_errors' => 'show',
                    ],
                ]
        );

        $this->add_control(
                'validation_error_border_color',
                [
                    'label' => __('Error Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper .validation_error' => 'border-top-color: {{VALUE}}; border-bottom-color: {{VALUE}}',
                        '{{WRAPPER}} .sa-el-gravity-form .gfield_error' => 'border-top-color: {{VALUE}}; border-bottom-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'validation_errors' => 'show',
                    ],
                ]
        );

        $this->add_control(
                'validation_errors_bg_color',
                [
                    'label' => __('Error Field Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gfield_error' => 'background: {{VALUE}}',
                    ],
                    'condition' => [
                        'validation_errors' => 'show',
                    ],
                ]
        );

        $this->add_control(
                'validation_error_field_label_color',
                [
                    'label' => __('Error Field Label Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gfield_error .gfield_label' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'validation_errors' => 'show',
                    ],
                ]
        );

        $this->add_control(
                'validation_error_field_input_border_color',
                [
                    'label' => __('Error Field Input Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper li.gfield_error input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .gform_wrapper li.gfield_error textarea' => 'border-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'validation_errors' => 'show',
                    ],
                ]
        );

        $this->add_control(
                'validation_error_field_input_border_width',
                [
                    'label' => __('Error Field Input Border Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 1,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_wrapper li.gfield_error input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .gform_wrapper li.gfield_error textarea' => 'border-width: {{VALUE}}px',
                    ],
                    'condition' => [
                        'validation_errors' => 'show',
                    ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Thank You Message
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_ty_style',
                [
                    'label' => __('Thank You Message', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'ty_message_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-gravity-form .gform_confirmation_wrapper .gform_confirmation_message' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!class_exists('\GFForms')) {
            return;
        }

        $settings = $this->get_settings();

        $this->add_render_attribute('gravity-form', 'class', [
            'sa-el-gravity-form',
                ]
        );

        if ($settings['labels_switch'] != 'yes') {
            $this->add_render_attribute('gravity-form', 'class', 'labels-hide');
        }

        if ($settings['placeholder_switch'] != 'yes') {
            $this->add_render_attribute('gravity-form', 'class', 'placeholder-hide');
        }

        if ($settings['custom_title_description'] == 'yes') {
            $this->add_render_attribute('gravity-form', 'class', 'title-description-hide');
        }

        if ($settings['custom_radio_checkbox'] == 'yes') {
            $this->add_render_attribute('gravity-form', 'class', 'sa-el-custom-radio-checkbox');
        }
        
        $this->add_render_attribute('gravity-form', 'class', $settings['sa_el_gravity_form_alignment']);
         
         


        if (!empty($settings['contact_form_list'])) {
            ?>
            <div <?php echo $this->get_render_attribute_string('gravity-form'); ?>>
                <?php if ($settings['custom_title_description'] == 'yes') { ?>
                    <div class="sa-el-gravity-form-heading">
                        <?php if ($settings['form_title_custom'] != '') { ?>
                            <h3 class="sa-el-gravity-form-title sa-el-gravity-form-title">
                                <?php echo esc_attr($settings['form_title_custom']); ?>
                            </h3>
                        <?php } ?>
                        <?php if ($settings['form_description_custom'] != '') { ?>
                            <div class="sa-el-gravity-form-description sa-el-gravity-form-description">
                                <?php echo $this->parse_text_editor($settings['form_description_custom']); ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php
                $sa_el_form_id = $settings['contact_form_list'];
                $sa_el_form_title = $settings['form_title'];
                $sa_el_form_description = $settings['form_description'];
                $sa_el_form_ajax = $settings['form_ajax'];

                gravity_form($sa_el_form_id, $sa_el_form_title, $sa_el_form_description, $display_inactive = false, $field_values = null, $sa_el_form_ajax, '', $echo = true);
                ?>
            </div>
            <?php
        }
    }

}
