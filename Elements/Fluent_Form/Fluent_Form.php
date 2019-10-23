<?php

namespace SA_EL_ADDONS\Elements\Fluent_Form;

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

class Fluent_Form extends Widget_Base {

    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function get_name() {
        return 'sa_el_fluent_form';
    }

    public function get_title() {
        return esc_html__('Fluent Form', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'fa fa-envelope-o  oxi-el-admin-icon';
    }

    public function get_keywords() {
        return ['fluent ', 'fluent form', 'we forms', 'caldera', 'wpf', 'wpform', 'form', 'contact', 'cf7', 'contact form', 'gravity', 'ninja'];
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    /**
     * Get a list of all WPForms
     *
     * @return array
     */
    public function sa_el_get_fluent_form() {
        $options = array();

        if (defined('FLUENTFORM')) {
            global $wpdb;

            $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}fluentform_forms");
            if ($result) {
                $options[0] = esc_html__('Select a Fluent Form', SA_EL_ADDONS_TEXTDOMAIN);
                foreach ($result as $form) {
                    $options[$form->id] = $form->title;
                }
            } else {
                $options[0] = esc_html__('Create a Form First', SA_EL_ADDONS_TEXTDOMAIN);
            }
        }

        return $options;
    }

    protected function _register_controls() {
        /* -----------------------------------------------------------------------------------
          Content Tab
          ----------------------------------------------------------------------------------- */
        if (!defined('FLUENTFORM')) {
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
                        'raw' => __('<strong>Fluent Form</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=fluentform&tab=search&type=term" target="_blank">Fluent Form</a> first.', SA_EL_ADDONS_TEXTDOMAIN),
                        'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                    ]
            );

            $this->end_controls_section();
        } else {

            $this->start_controls_section(
                    'section_form_info_box',
                    [
                        'label' => __('Fluent Form', SA_EL_ADDONS_TEXTDOMAIN),
                    ]
            );



            $this->add_control(
                    'form_list',
                    [
                        'label' => esc_html__('Fluent Form', SA_EL_ADDONS_TEXTDOMAIN),
                        'type' => Controls_Manager::SELECT,
                        'label_block' => true,
                        'options' => $this->sa_el_get_fluent_form(),
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
                        'return_value' => 'yes'
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
                        ]
                    ]
            );

            $this->end_controls_section();
        }

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
                        '{{WRAPPER}} .sa-el-fluentform-title' => 'text-align: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-fluentform-description' => 'text-align: {{VALUE}};',
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
                        '{{WRAPPER}} .sa-el-fluentform-title' => 'color: {{VALUE}}',
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
                    'selector' => '{{WRAPPER}} .sa-el-fluentform-title',
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
                        '{{WRAPPER}} .sa-el-fluentform-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .sa-el-fluentform-description' => 'color: {{VALUE}}',
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
                    'selector' => '{{WRAPPER}} .sa-el-fluentform-description',
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
                        '{{WRAPPER}} .sa-el-fluentform-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .sa-el-fluent-form' => 'background: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'fluentform_link_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group a' => 'color: {{VALUE}};',
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
                        '{{WRAPPER}} .sa-el-fluent-form' => 'width: {{SIZE}}{{UNIT}};'
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
                        '{{WRAPPER}} .sa-el-fluent-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .sa-el-fluent-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'sa_el_contact_form_border',
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'sa_el_contact_form_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group label' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'typography_label',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group label',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group select' => 'text-align: {{VALUE}};',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group select' => 'background-color: {{VALUE}}',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group select' => 'color: {{VALUE}}',
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
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group select',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group select' => 'text-indent: {{SIZE}}{{UNIT}}',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group select' => 'width: {{SIZE}}{{UNIT}}',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group select' => 'height: {{SIZE}}{{UNIT}}',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea' => 'width: {{SIZE}}{{UNIT}}',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea' => 'height: {{SIZE}}{{UNIT}}',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'field_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group select',
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'field_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group select',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea:focus' => 'background-color: {{VALUE}}',
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
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea:focus',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'focus_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea:focus',
                    'separator' => 'before',
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group input::-webkit-input-placeholder, {{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group textarea::-webkit-input-placeholder' => 'color: {{VALUE}}',
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
         * Style Tab: Section Break Style
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_break_style',
                [
                    'label' => __('Section Break Style', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'section_break_label',
                [
                    'label' => __('Label', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING
                ]
        );

        $this->add_control(
                'section_break_label_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-section-break .ff-el-section-title' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'section_break_label_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '.sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-section-break .ff-el-section-title',
                    'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'section_break_label_padding',
                [
                    'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-section-break .ff-el-section-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'section_break_label_margin',
                [
                    'label' => __('Margin', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-section-break .ff-el-section-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_control(
                'section_break_description',
                [
                    'label' => __('Description', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before'
                ]
        );

        $this->add_control(
                'section_break_description_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-section-break div' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'section_break_description_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-section-break div',
                    'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'section_break_description_padding',
                [
                    'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-section-break div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'section_break_description_margin',
                [
                    'label' => __('Margin', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-section-break div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'section_break_alignment',
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
                    'prefix_class' => 'sa-el-fluentform-section-break-content-'
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Section Checkbox grid Style
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_table_grid',
                [
                    'label' => __('Checkbox Grid Style', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'section_table_grid_head',
                [
                    'label' => __('Grid Table Head', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before'
                ]
        );

        $this->add_control(
                'section_table_grid_head_color',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-table thead th' => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'section_table_grid_head_text_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-table thead th' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'section_table_grid_head_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-table thead th',
                    'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'section_table_grid_head_height',
                [
                    'label' => __('Height', SA_EL_ADDONS_TEXTDOMAIN),
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-table thead th' => 'height: {{SIZE}}{{UNIT}}',
                    ]
                ]
        );

        $this->add_responsive_control(
                'section_table_grid_head_padding',
                [
                    'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_control(
                'section_table_grid_item',
                [
                    'label' => __('Grid Table Item', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before'
                ]
        );

        $this->add_control(
                'table_grid_item_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-table tbody tr td' => 'color: {{VALUE}} !important;',
                    ],
                ]
        );

        $this->add_control(
                'table_grid_item_bg_color',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-table tbody tr td' => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'table_grid_item_odd_bg_color',
                [
                    'label' => __('Odd Item Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .ff-checkable-grids tbody>tr:nth-child(2n)>td' => 'background-color: {{VALUE}} !important;',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'table_grid_item_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-table tbody tr td',
                ]
        );

        $this->add_responsive_control(
                'section_table_grid_item_height',
                [
                    'label' => __('Height', SA_EL_ADDONS_TEXTDOMAIN),
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-table tbody tr td' => 'height: {{SIZE}}{{UNIT}}',
                    ]
                ]
        );

        $this->add_responsive_control(
                'section_table_grid_item_padding',
                [
                    'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Address Line
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_address_line_style',
                [
                    'label' => __('Address Line Style', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'address_line_label_color',
                [
                    'label' => __('Label Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .fluent-address label' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'address_line_label_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .fluent-address label',
                ]
        );

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
                    'prefix_class' => 'sa-el-fluentform-form-button-',
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
                    'prefix_class' => 'sa-el-fluentform-form-button-',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit' => 'width: {{SIZE}}{{UNIT}}',
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
                    'default' => '#409EFF',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit' => 'background-color: {{VALUE}} !important;',
                    ],
                ]
        );

        $this->add_control(
                'button_text_color_normal',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit' => 'color: {{VALUE}} !important;',
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
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit',
                ]
        );

        $this->add_control(
                'button_border_radius',
                [
                    'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit' => 'margin-top: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'button_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit',
                    'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'button_box_shadow',
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit:hover' => 'background-color: {{VALUE}} !important;',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit:hover' => 'color: {{VALUE}} !important;',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-el-group .ff-btn-submit:hover' => 'border-color: {{VALUE}}',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-message-success' => 'background-color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'success_message_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-message-success' => 'color: {{VALUE}}',
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
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-message-success',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'success_message_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .ff-message-success',
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
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .error.text-danger' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'error_messages' => 'show',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'error_message_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .error.text-danger',
                ]
        );

        $this->add_responsive_control(
                'error_message_padding',
                [
                    'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .error.text-danger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_responsive_control(
                'error_message_margin',
                [
                    'label' => __('Margin', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-fluent-form.sa-el-fluent-form-wrapper .error.text-danger' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->end_controls_section();
    }
     protected function render()
    {

        if( ! defined('FLUENTFORM') ) return;


        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            'sa_el_fluentform_wrapper',
            [
                'class' => [
                    'sa-el-fluent-form',
                    'sa-el-fluent-form-wrapper'
                ]
            ]
        );

        if ( $settings['placeholder_switch'] != 'yes' ) {
            $this->add_render_attribute( 'sa_el_fluentform_wrapper', 'class', 'placeholder-hide' );
        }

        if( $settings['labels_switch'] != 'yes' ) {
            $this->add_render_attribute( 'sa_el_fluentform_wrapper', 'class', 'fluent-form-labels-hide' );
        }

        if( $settings['error_messages'] == 'hide' ) {
            $this->add_render_attribute( 'sa_el_fluentform_wrapper', 'class', 'error-message-hide' );
        }

        if ( $settings['custom_radio_checkbox'] == 'yes' ) {
            $this->add_render_attribute( 'sa_el_fluentform_wrapper', 'class', 'sa-el-custom-radio-checkbox' );
        }
        if ( $settings['sa_el_contact_form_alignment'] == 'left' ) {
            $this->add_render_attribute( 'sa_el_fluentform_wrapper', 'class', 'sa-el-fluent-form-top-align-left' );
        }
        elseif ( $settings['sa_el_contact_form_alignment'] == 'center' ) {
            $this->add_render_attribute( 'sa_el_fluentform_wrapper', 'class', 'sa-el-fluent-form-top-align-center' );
        }
        elseif ( $settings['sa_el_contact_form_alignment'] == 'right' ) {
            $this->add_render_attribute( 'sa_el_fluentform_wrapper', 'class', 'sa-el-fluent-form-top-align-right' );
        }
        else {
            $this->add_render_attribute( 'sa_el_fluentform_wrapper', 'class', 'sa-el-fluent-form-top-align-default' );
        }
        
        $shortcode = '[fluentform id="'.$this->get_settings_for_display('form_list').'"]';

        ?>
        <div <?php echo $this->get_render_attribute_string('sa_el_fluentform_wrapper'); ?>>

            <?php if ( $settings['custom_title_description'] == 'yes' ) { ?>
                <div class="sa-el-fluentform-heading">
                    <?php if ( $settings['form_title_custom'] != '' ) { ?>
                        <h3 class="sa-el-fluent-form-title sa-el-fluentform-title">
                            <?php echo esc_attr( $settings['form_title_custom'] ); ?>
                        </h3>
                    <?php } ?>
                    <?php if ( $settings['form_description_custom'] != '' ) { ?>
                        <div class="sa-el-fluent-form-description sa-el-fluentform-description">
                            <?php echo $this->parse_text_editor( $settings['form_description_custom'] ); ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php echo do_shortcode( shortcode_unautop( $shortcode ) ); ?>
        </div>

        <?php
    }

}
