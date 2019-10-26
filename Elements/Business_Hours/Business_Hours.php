<?php

namespace SA_EL_ADDONS\Elements\Business_Hours;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Business_Hours
 *
 * @author biplo
 * 
 */
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use \Elementor\Widget_Base as Widget_Base;

class Business_Hours extends Widget_Base {

    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function get_name() {
        return 'sa_el_business_hours';
    }

    public function get_title() {
        return esc_html__('Business Hours', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'eicon-heading  oxi-el-admin-icon';
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    /**
     * Register business hours widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @access protected
     */
    protected function _register_controls() {

        /* ----------------------------------------------------------------------------------- */
        /* 	CONTENT TAB
          /*----------------------------------------------------------------------------------- */

        /**
         * Content Tab: Business Hours
         */
        $this->start_controls_section(
                'section_price_menu',
                [
                    'label' => __('Business Hours', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'business_timings',
                [
                    'label' => __('Business Timings', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'predefined',
                    'options' => [
                        'predefined' => __('Predefined', SA_EL_ADDONS_TEXTDOMAIN),
                        'custom' => __('Custom', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                ]
        );

        $sa_el_hours = [
            '00:00' => '12:00 AM',
            '00:30' => '12:30 AM',
            '01:00' => '1:00 AM',
            '01:30' => '1:30 AM',
            '02:00' => '2:00 AM',
            '02:30' => '2:30 AM',
            '03:00' => '3:00 AM',
            '03:30' => '3:30 AM',
            '04:00' => '4:00 AM',
            '04:30' => '4:30 AM',
            '05:00' => '5:00 AM',
            '05:30' => '5:30 AM',
            '06:00' => '6:00 AM',
            '06:30' => '6:30 AM',
            '07:00' => '7:00 AM',
            '07:30' => '7:30 AM',
            '08:00' => '8:00 AM',
            '08:30' => '8:30 AM',
            '09:00' => '9:00 AM',
            '09:30' => '9:30 AM',
            '10:00' => '10:00 AM',
            '10:30' => '10:30 AM',
            '11:00' => '11:00 AM',
            '11:30' => '11:30 AM',
            '12:00' => '12:00 PM',
            '12:30' => '12:30 PM',
            '13:00' => '1:00 PM',
            '13:30' => '1:30 PM',
            '14:00' => '2:00 PM',
            '14:30' => '2:30 PM',
            '15:00' => '3:00 PM',
            '15:30' => '3:30 PM',
            '16:00' => '4:00 PM',
            '16:30' => '4:30 PM',
            '17:00' => '5:00 PM',
            '17:30' => '5:30 PM',
            '18:00' => '6:00 PM',
            '18:30' => '6:30 PM',
            '19:00' => '7:00 PM',
            '19:30' => '7:30 PM',
            '20:00' => '8:00 PM',
            '20:30' => '8:30 PM',
            '21:00' => '9:00 PM',
            '21:30' => '9:30 PM',
            '22:00' => '10:00 PM',
            '22:30' => '10:30 PM',
            '23:00' => '11:00 PM',
            '23:30' => '11:30 PM',
            '24:00' => '12:00 PM',
            '24:30' => '12:30 PM',
        ];

        $this->add_control(
                'business_hours',
                [
                    'label' => '',
                    'type' => Controls_Manager::REPEATER,
                    'default' => [
                        [
                            'day' => 'Monday',
                        ],
                        [
                            'day' => 'Tuesday',
                        ],
                        [
                            'day' => 'Wednesday',
                        ],
                        [
                            'day' => 'Thursday',
                        ],
                        [
                            'day' => 'Friday',
                        ],
                        [
                            'day' => 'Saturday',
                            'closed' => 'yes',
                            'highlight' => 'yes',
                            'highlight_color' => '#bc1705',
                        ],
                        [
                            'day' => 'Sunday',
                            'closed' => 'yes',
                            'highlight' => 'yes',
                            'highlight_color' => '#bc1705',
                        ],
                    ],
                    'fields' => [
                        [
                            'name' => 'day',
                            'label' => __('Day', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::SELECT,
                            'default' => 'Monday',
                            'options' => [
                                'Monday' => __('Monday', SA_EL_ADDONS_TEXTDOMAIN),
                                'Tuesday' => __('Tuesday', SA_EL_ADDONS_TEXTDOMAIN),
                                'Wednesday' => __('Wednesday', SA_EL_ADDONS_TEXTDOMAIN),
                                'Thursday' => __('Thursday', SA_EL_ADDONS_TEXTDOMAIN),
                                'Friday' => __('Friday', SA_EL_ADDONS_TEXTDOMAIN),
                                'Saturday' => __('Saturday', SA_EL_ADDONS_TEXTDOMAIN),
                                'Sunday' => __('Sunday', SA_EL_ADDONS_TEXTDOMAIN),
                            ],
                        ],
                        [
                            'name' => 'closed',
                            'label' => __('Closed?', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::SWITCHER,
                            'default' => 'no',
                            'label_on' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                            'label_off' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                            'return_value' => 'no',
                        ],
                        [
                            'name' => 'opening_hours',
                            'label' => __('Opening Hours', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::SELECT,
                            'default' => '09:00',
                            'options' => $sa_el_hours,
                            'condition' => [
                                'closed' => 'no',
                            ],
                        ],
                        [
                            'name' => 'closing_hours',
                            'label' => __('Closing Hours', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::SELECT,
                            'default' => '17:00',
                            'options' => $sa_el_hours,
                            'condition' => [
                                'closed' => 'no',
                            ],
                        ],
                        [
                            'name' => 'closed_text',
                            'label' => __('Closed Text', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::TEXT,
                            'label_block' => true,
                            'placeholder' => __('Closed', SA_EL_ADDONS_TEXTDOMAIN),
                            'default' => __('Closed', SA_EL_ADDONS_TEXTDOMAIN),
                            'conditions' => [
                                'terms' => [
                                    [
                                        'name' => 'closed',
                                        'operator' => '!=',
                                        'value' => 'no',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'name' => 'highlight',
                            'label' => __('Highlight', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::SWITCHER,
                            'default' => 'no',
                            'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                            'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                            'return_value' => 'yes',
                        ],
                        [
                            'name' => 'highlight_bg',
                            'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::COLOR,
                            'default' => '',
                            'selectors' => [
                                '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row{{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
                            ],
                            'condition' => [
                                'highlight' => 'yes',
                            ],
                        ],
                        [
                            'name' => 'highlight_color',
                            'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::COLOR,
                            'default' => '',
                            'selectors' => [
                                '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row{{CURRENT_ITEM}} .sa-el-business-day, {{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row{{CURRENT_ITEM}} .sa-el-business-timing' => 'color: {{VALUE}}',
                            ],
                            'condition' => [
                                'highlight' => 'yes',
                            ],
                        ]
                    ],
                    'title_field' => '{{{ day }}}',
                    'condition' => [
                        'business_timings' => 'predefined',
                    ],
                ]
        );

        $this->add_control(
                'business_hours_custom',
                [
                    'label' => '',
                    'type' => Controls_Manager::REPEATER,
                    'default' => [
                        [
                            'day' => 'Monday',
                        ],
                        [
                            'day' => 'Tuesday',
                        ],
                        [
                            'day' => 'Wednesday',
                        ],
                        [
                            'day' => 'Thursday',
                        ],
                        [
                            'day' => 'Friday',
                        ],
                        [
                            'day' => 'Saturday',
                            'closed' => 'yes',
                            'highlight' => 'yes',
                            'highlight_color' => '#bc1705',
                        ],
                        [
                            'day' => 'Sunday',
                            'closed' => 'yes',
                            'highlight' => 'yes',
                            'highlight_color' => '#bc1705',
                        ],
                    ],
                    'fields' => [
                        [
                            'name' => 'day',
                            'label' => __('Day', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::TEXT,
                            'default' => 'Monday',
                        ],
                        [
                            'name' => 'closed',
                            'label' => __('Closed?', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::SWITCHER,
                            'default' => 'no',
                            'label_on' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                            'label_off' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                            'return_value' => 'no',
                        ],
                        [
                            'name' => 'time',
                            'label' => __('Time', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::TEXT,
                            'default' => '09:00 AM - 05:00 PM',
                            'condition' => [
                                'closed' => 'no',
                            ],
                        ],
                        [
                            'name' => 'closed_text',
                            'label' => __('Closed Text', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::TEXT,
                            'label_block' => true,
                            'placeholder' => __('Closed', SA_EL_ADDONS_TEXTDOMAIN),
                            'default' => __('Closed', SA_EL_ADDONS_TEXTDOMAIN),
                            'conditions' => [
                                'terms' => [
                                    [
                                        'name' => 'closed',
                                        'operator' => '!=',
                                        'value' => 'no',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'name' => 'highlight',
                            'label' => __('Highlight', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::SWITCHER,
                            'default' => 'no',
                            'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                            'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                            'return_value' => 'yes',
                        ],
                        [
                            'name' => 'highlight_bg',
                            'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::COLOR,
                            'default' => '',
                            'selectors' => [
                                '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row{{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
                            ],
                            'condition' => [
                                'highlight' => 'yes',
                            ],
                        ],
                        [
                            'name' => 'highlight_color',
                            'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::COLOR,
                            'default' => '',
                            'selectors' => [
                                '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row{{CURRENT_ITEM}} .sa-el-business-day, {{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row{{CURRENT_ITEM}} .sa-el-business-timing' => 'color: {{VALUE}}',
                            ],
                            'condition' => [
                                'highlight' => 'yes',
                            ],
                        ]
                    ],
                    'title_field' => '{{{ day }}}',
                    'condition' => [
                        'business_timings' => 'custom',
                    ],
                ]
        );

        $this->add_control(
                'hours_format',
                [
                    'label' => __('24 Hours Format?', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'no',
                    'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                    'return_value' => 'yes',
                    'condition' => [
                        'business_timings' => 'predefined',
                    ],
                ]
        );

        $this->add_control(
                'days_format',
                [
                    'label' => __('Days Format', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'long',
                    'options' => [
                        'long' => __('Long', SA_EL_ADDONS_TEXTDOMAIN),
                        'short' => __('Short', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                    'condition' => [
                        'business_timings' => 'predefined',
                    ],
                ]
        );

        $this->end_controls_section();

        /* ----------------------------------------------------------------------------------- */
        /* 	STYLE TAB
          /*----------------------------------------------------------------------------------- */

        /**
         * Style Tab: Row Style
         */
        $this->start_controls_section(
                'section_rows_style',
                [
                    'label' => __('Rows Style', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->start_controls_tabs('tabs_rows_style');

        $this->start_controls_tab(
                'tab_row_normal',
                [
                    'label' => __('Normal', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'row_bg_color_normal',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row' => 'background-color: {{VALUE}}',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_row_hover',
                [
                    'label' => __('Hover', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'row_bg_color_hover',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row:hover' => 'background-color: {{VALUE}}',
                    ],
                ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
                'stripes',
                [
                    'label' => __('Striped Rows', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'no',
                    'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                    'return_value' => 'yes',
                    'separator' => 'before',
                ]
        );

        $this->start_controls_tabs('tabs_alternate_style');

        $this->start_controls_tab(
                'tab_even',
                [
                    'label' => __('Even Row', SA_EL_ADDONS_TEXTDOMAIN),
                    'condition' => [
                        'stripes' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'row_even_bg_color',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#f5f5f5',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row:nth-child(even)' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'stripes' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'row_even_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row:nth-child(even)' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'stripes' => 'yes',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_odd',
                [
                    'label' => __('Odd Row', SA_EL_ADDONS_TEXTDOMAIN),
                    'condition' => [
                        'stripes' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'row_odd_bg_color',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row:nth-child(odd)' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'stripes' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'row_odd_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row:nth-child(odd)' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'stripes' => 'yes',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
                'rows_padding',
                [
                    'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'default' => [
                        'top' => '8',
                        'right' => '10',
                        'bottom' => '8',
                        'left' => '10',
                        'unit' => 'px',
                        'isLinked' => false,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'rows_margin',
                [
                    'label' => __('Margin Bottom', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 80,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_control(
                'closed_row_heading',
                [
                    'label' => __('Closed Row', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'closed_row_bg_color',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row.row-closed' => 'background-color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'closed_row_day_color',
                [
                    'label' => __('Day Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row.row-closed .sa-el-business-day' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'closed_row_tex_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row.row-closed .sa-el-business-timing' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'divider_heading',
                [
                    'label' => __('Rows Divider', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'rows_divider_style',
                [
                    'label' => __('Divider Style', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none' => __('None', SA_EL_ADDONS_TEXTDOMAIN),
                        'solid' => __('Solid', SA_EL_ADDONS_TEXTDOMAIN),
                        'dashed' => __('Dashed', SA_EL_ADDONS_TEXTDOMAIN),
                        'dotted' => __('Dotted', SA_EL_ADDONS_TEXTDOMAIN),
                        'groove' => __('Groove', SA_EL_ADDONS_TEXTDOMAIN),
                        'ridge' => __('Ridge', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row:not(:last-child)' => 'border-bottom-style: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'rows_divider_color',
                [
                    'label' => __('Divider Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row:not(:last-child)' => 'border-bottom-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'rows_divider_style!' => 'none',
                    ],
                ]
        );

        $this->add_responsive_control(
                'rows_divider_weight',
                [
                    'label' => __('Divider Weight', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'default' => ['size' => 1],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 30,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'rows_divider_style!' => 'none',
                    ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Business Hours
         */
        $this->start_controls_section(
                'section_pricing_table_style',
                [
                    'label' => __('Business Hours', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->start_controls_tabs('tabs_hours_style');

        $this->start_controls_tab(
                'tab_hours_normal',
                [
                    'label' => __('Normal', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'title_heading',
                [
                    'label' => __('Day', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'day_alignment',
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
                    'default' => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-day' => 'text-align: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'day_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-day' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-business-hours .sa-el-business-day',
                ]
        );

        $this->add_control(
                'hours_heading',
                [
                    'label' => __('Hours', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'hours_alignment',
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
                    'default' => 'right',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-timing' => 'text-align: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'hours_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-timing' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'hours_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-business-hours .sa-el-business-timing',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_hours_hover',
                [
                    'label' => __('Hover', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'day_color_hover',
                [
                    'label' => __('Day Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row:hover .sa-el-business-day' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_control(
                'hours_color_hover',
                [
                    'label' => __('Hours Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-business-hours .sa-el-business-hours-row:hover .sa-el-business-timing' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Render business hours widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings();

        $this->add_render_attribute('business-hours', 'class', 'sa-el-business-hours');
        $i = 1;
        ?>
        <div <?php echo $this->get_render_attribute_string('business-hours'); ?>>
            <?php
            if ($settings['business_timings'] == 'predefined') {
                $this->render_business_hours_predefined();
            } elseif ($settings['business_timings'] == 'custom') {
                $this->render_business_hours_custom();
            }
            ?>
        </div>
        <?php
    }

    /**
     * Render predefined business hours widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render_business_hours_predefined() {
        $settings = $this->get_settings();
        $i = 1;
        ?>
        <?php foreach ($settings['business_hours'] as $index => $item) : ?>
            <?php
            $this->add_render_attribute('row' . $i, 'class', 'sa-el-business-hours-row clearfix elementor-repeater-item-' . esc_attr($item['_id']));
            if ($item['closed'] != 'no') {
                $this->add_render_attribute('row' . $i, 'class', 'row-closed');
            }
            ?>
            <div <?php echo $this->get_render_attribute_string('row' . $i); ?>>
                <span class="sa-el-business-day">
                    <?php
                    if ($settings['days_format'] == 'long') {
                        echo ucwords(esc_attr($item['day']));
                    } else {
                        echo ucwords(esc_attr(substr($item['day'], 0, 3)));
                    }
                    ?>
                </span>
                <span class="sa-el-business-timing">
                        <?php if ($item['closed'] == 'no') { ?>
                        <span class="sa-el-opening-hours">
                            <?php
                            if ($settings['hours_format'] == 'yes') {
                                echo esc_attr($item['opening_hours']);
                            } else {
                                echo esc_attr(date("g:i A", strtotime($item['opening_hours'])));
                            }
                            ?>
                        </span>
                        -
                        <span class="sa-el-closing-hours">
                            <?php
                            if ($settings['hours_format'] == 'yes') {
                                echo esc_attr($item['closing_hours']);
                            } else {
                                echo esc_attr(date("g:i A", strtotime($item['closing_hours'])));
                            }
                            ?>
                        </span>
                        <?php
                    } else {
                        if ($item['closed_text']) {
                            echo $item['closed_text'];
                        } else {
                            esc_attr_e('Closed', SA_EL_ADDONS_TEXTDOMAIN);
                        }
                    }
                    ?>
                </span>
            </div>
            <?php
            $i++;
        endforeach;
        ?>
        <?php
    }

    /**
     * Render custom business hours widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render_business_hours_custom() {
        $settings = $this->get_settings();
        $i = 1;
        ?>
        <?php foreach ($settings['business_hours_custom'] as $index => $item) : ?>
            <?php
            $this->add_render_attribute('row' . $i, 'class', 'sa-el-business-hours-row clearfix elementor-repeater-item-' . esc_attr($item['_id']));
            if ($item['closed'] != 'no') {
                $this->add_render_attribute('row' . $i, 'class', 'row-closed');
            }
            ?>
            <div <?php echo $this->get_render_attribute_string('row' . $i); ?>>
                    <?php if ($item['day'] != '') { ?>
                    <span class="sa-el-business-day">
                        <?php
                        echo esc_attr($item['day']);
                        ?>
                    </span>
                    <?php } ?>
                <span class="sa-el-business-timing">
                    <?php
                    if ($item['closed'] == 'no' && $item['time'] != '') {
                        echo esc_attr($item['time']);
                    } else {
                        if ($item['closed_text']) {
                            echo $item['closed_text'];
                        } else {
                            esc_attr_e('Closed', SA_EL_ADDONS_TEXTDOMAIN);
                        }
                    }
                    ?>
                </span>
            </div>
            <?php
            $i++;
        endforeach;
        ?>
        <?php
    }

    /**
     * Render business hours widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @access protected
     */
    protected function _content_template() {
        ?>
        <div class="sa-el-business-hours">

            <# if ( settings.business_timings == 'predefined' ) { #>
            <?php $this->_business_hours_predefined_template(); ?>
            <# } else { #>
        <?php $this->_business_hours_custom_template(); ?>
            <# } #>

        </div>
        <?php
    }

    /**
     * Render predefined business hours widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @access protected
     */
    protected function _business_hours_predefined_template() {
        ?>
        <#
        function sa_el_timeTo12HrFormat(time) {
        // Take a time in 24 hour format and format it in 12 hour format
        var time_part_array = time.split(":");
        var ampm = 'AM';

        var first_part = time_part_array[0];
        var second_part = time_part_array[1];

        if (first_part >= 12) {
        ampm = 'PM';
        }

        if (first_part == 00) {
        first_part = 12;
        }

        if (first_part >= 1 && first_part < 10) {
        var first_part = first_part.substr(1, 2);
        }

        if (first_part > 12) {
        first_part = first_part - 12;
        }

        formatted_time = first_part + ':' + second_part + ' ' + ampm;

        return formatted_time;
        }
        #>
        <# _.each( settings.business_hours, function( item ) { #>
        <#
        var closed = ( item.closed != 'no' ) ? 'row-closed' : '';
        #>
        <div class="sa-el-business-hours-row clearfix elementor-repeater-item-{{ item._id }} {{ closed }}">
            <span class="sa-el-business-day">
                <# if ( settings.days_format == 'long' ) { #>
                {{ item.day }}
                <# } else { #>
                {{ item.day.substring(0,3) }}
                <# } #>
            </span>
            <span class="sa-el-business-timing">
                <# if ( item.closed == 'no' ) { #>
                <span class="sa-el-opening-hours">
                    <# if ( settings.hours_format == 'yes' ) { #>
                    {{ item.opening_hours }}
                    <# } else { #>
                    {{ sa_el_timeTo12HrFormat( item.opening_hours ) }}
                    <# } #>
                </span>
                -
                <span class="sa-el-closing-hours">
                    <# if ( settings.hours_format == 'yes' ) { #>
                    {{ item.closing_hours }}
                    <# } else { #>
                    {{ sa_el_timeTo12HrFormat( item.closing_hours ) }}
                    <# } #>
                </span>
                <# } else { #>
                <# if ( item.closed_text != '' ) { #>
                {{ item.closed_text }}
                <# } else { #>
        <?php esc_attr_e('Closed', SA_EL_ADDONS_TEXTDOMAIN); ?>
                <# } #>
                <# } #>
            </span>
        </div>
        <# } ); #>
        <?php
    }

    /**
     * Render custom business hours widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @access protected
     */
    protected function _business_hours_custom_template() {
        ?>
        <# _.each( settings.business_hours_custom, function( item ) { #>
        <#
        var closed = ( item.closed != 'no' ) ? 'row-closed' : '';
        #>
        <div class="sa-el-business-hours-row clearfix elementor-repeater-item-{{ item._id }} {{ closed }}">
            <# if ( item.day != '' ) { #>
            <span class="sa-el-business-day">
                {{ item.day }}
            </span>
            <# } #>
            <span class="sa-el-business-timing">
                <# if ( item.closed == 'no' && item.time != '' ) { #>
                {{ item.time }}
                <# } else { #>
                <# if ( item.closed_text != '' ) { #>
                {{ item.closed_text }}
                <# } else { #>
        <?php esc_attr_e('Closed', SA_EL_ADDONS_TEXTDOMAIN); ?>
                <# } #>
                <# } #>
            </span>
        </div>
        <# } ); #>
        <?php
    }

}
