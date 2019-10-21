<?php

namespace SA_EL_ADDONS\Elements\Step_Flow;

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Scheme_Typography;
use \Elementor\Widget_Base as Widget_Base;

class Step_Flow extends Widget_Base {

     use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function get_name() {
        return 'sa_el_step_flow';
    }

    public function get_title() {
        return esc_html__('Step Flow', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'eicon-flow oxi-el-admin-icon';
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            '_section_step',
            [
                'label' => __( 'Step Flow', SA_EL_ADDONS_TEXTDOMAIN ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => __( 'Icon', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => $this->Sa_El_Icon_Type(),
                'label_block' => true,
                'default' => $this->Sa_El_Default_Icon('fas fa-hand-point-right', 'solid', 'fa fa-hand-o-right'),
            ]
        );

        $this->add_control(
            'badge',
            [
                'label' => __( 'Badge', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Badge', SA_EL_ADDONS_TEXTDOMAIN ),
                'description' => __( 'Keep it blank, if you want to remove the Badge', SA_EL_ADDONS_TEXTDOMAIN ),
                'default' => __( 'Step 1', SA_EL_ADDONS_TEXTDOMAIN ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title & Description', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __( 'Title', SA_EL_ADDONS_TEXTDOMAIN ),
                'default' => __( 'Start Marketing', SA_EL_ADDONS_TEXTDOMAIN ),
                'separator' => 'before',
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __( 'Description', SA_EL_ADDONS_TEXTDOMAIN ),
                'show_label' => false,
                'description' => __( 'intermediate', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => __( 'Description', SA_EL_ADDONS_TEXTDOMAIN ),
                'default' => 'consectetur adipiscing elit, sed do<br>eiusmod Lorem ipsum dolor sit amet,<br> consectetur.',
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://happyaddons.com/',
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'content_alignment',
            [
                'label' => __( 'Alignment', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', SA_EL_ADDONS_TEXTDOMAIN ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', SA_EL_ADDONS_TEXTDOMAIN ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', SA_EL_ADDONS_TEXTDOMAIN ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'show_indicator',
            [
                'label' => __( 'Show Direction', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', SA_EL_ADDONS_TEXTDOMAIN ),
                'label_off' => __( 'No', SA_EL_ADDONS_TEXTDOMAIN ),
                'return_value' => 'yes',
                'default' => 'yes',
                'style_transfer' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_icon_style',
            [
                'label' => __( 'Icon', SA_EL_ADDONS_TEXTDOMAIN ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __( 'Size', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => __( 'Padding', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => __( 'Bottom Spacing', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'label' => __( 'Border', SA_EL_ADDONS_TEXTDOMAIN ),
                'selector' => '{{WRAPPER}} .sa-el-steps-icon',
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius',
            [
                'label' => __( 'Border Radius', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_box_shadow',
                'selector' => '{{WRAPPER}} .sa-el-steps-icon',
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Color', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_background_color',
            [
                'label' => __( 'Background Color', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_badge_style',
            [
                'label' => __('Badge', SA_EL_ADDONS_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'badge!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_padding',
            [
                'label' => __( 'Padding', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'condition' => [
                    'badge!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon .sa-el-steps-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'badge_border',
                'label' => __( 'Border', SA_EL_ADDONS_TEXTDOMAIN ),
                'selector' => '{{WRAPPER}} .sa-el-steps-icon .sa-el-steps-label',
                'condition' => [
                    'badge!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_border_radius',
            [
                'label' => __( 'Border Radius', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'condition' => [
                    'badge!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon .sa-el-steps-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'badge_color',
            [
                'label' => __( 'Color', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'badge!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon .sa-el-steps-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'badge_background_color',
            [
                'label' => __( 'Background Color', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'badge!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon .sa-el-steps-label' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'badge_typography',
                'selector' => '{{WRAPPER}} .sa-el-steps-icon .sa-el-steps-label',
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'condition' => [
                    'badge!' => '',
                ],
            ]
        );

        $this->add_control(
            'badge_direction_offset_toggle',
            [
                'label' => __( 'Offset', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', SA_EL_ADDONS_TEXTDOMAIN ),
                'label_on' => __( 'Custom', SA_EL_ADDONS_TEXTDOMAIN ),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'badge_direction_offset_y',
            [
                'label' => __( 'Offset Top', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'badge_direction_offset_toggle' => 'yes'
                ],
                'render_type' => 'ui',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon .sa-el-steps-label' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_direction_offset_x',
            [
                'label' => __( 'Offset Right', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'badge_direction_offset_toggle' => 'yes'
                ],
                'render_type' => 'ui',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-icon .sa-el-steps-label' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_title_style',
            [
                'label' => __( 'Title & Description', SA_EL_ADDONS_TEXTDOMAIN ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            '_heading_title',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Title', SA_EL_ADDONS_TEXTDOMAIN ),
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __( 'Bottom Spacing', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_link_color',
            [
                'label' => __( 'Link Color', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'link[url]!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __( 'Hover Color', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'link[url]!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-steps-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_shadow',
                'selector' => '{{WRAPPER}} .sa-el-steps-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .sa-el-steps-title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
            ]
        );

        $this->add_control(
            '_heading_description',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Description', SA_EL_ADDONS_TEXTDOMAIN ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __( 'Color', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sa-el-step-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'description_shadow',
                'selector' => '{{WRAPPER}} .sa-el-step-description',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .sa-el-step-description',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_direction_style',
            [
                'label' => __( 'Direction', SA_EL_ADDONS_TEXTDOMAIN ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_indicator' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'direction_style',
            [
                'label' => __( 'Style', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'solid' => __( 'Solid', SA_EL_ADDONS_TEXTDOMAIN ),
                    'dotted' => __( 'Dotted', SA_EL_ADDONS_TEXTDOMAIN ),
                    'dashed' => __( 'Dashed', SA_EL_ADDONS_TEXTDOMAIN ),
                ],
                'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-step-arrow, {{WRAPPER}} .sa-el-step-arrow:after' => 'border-top-style: {{VALUE}};',
                    '{{WRAPPER}} .sa-el-step-arrow:after' => 'border-right-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'direction_width',
            [
                'label' => __( 'Width', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sa-el-step-arrow' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'direction_offset_toggle',
            [
                'label' => __( 'Offset', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', SA_EL_ADDONS_TEXTDOMAIN ),
                'label_on' => __( 'Custom', SA_EL_ADDONS_TEXTDOMAIN ),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'direction_offset_y',
            [
                'label' => __( 'Offset Top', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'direction_offset_toggle' => 'yes'
                ],
                'render_type' => 'ui',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-step-arrow' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'direction_offset_x',
            [
                'label' => __( 'Offset Left', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'direction_offset_toggle' => 'yes'
                ],
                'render_type' => 'ui',
                'selectors' => [
                    '{{WRAPPER}} .sa-el-step-arrow' => 'left: calc( 100% + {{SIZE}}{{UNIT}} );',
                ],
            ]
        );

        $this->end_popover();

        $this->add_control(
            'direction_color',
            [
                'label' => __( 'Color', SA_EL_ADDONS_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sa-el-step-arrow' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .sa-el-step-arrow:after' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes( 'title', 'basic' );
        $this->add_render_attribute( 'title', 'class', 'sa-el-steps-title' );

        $this->add_inline_editing_attributes( 'description', 'intermediate' );
        $this->add_render_attribute( 'description', 'class', 'sa-el-step-description' );

        $this->add_render_attribute( 'badge', 'class', 'sa-el-steps-label' );
        $this->add_inline_editing_attributes( 'badge', 'none' );

        if ( $settings['link']['url'] ) {
            $this->add_inline_editing_attributes( 'link', 'basic', 'title' );
            $this->add_render_attribute( 'link', 'href', esc_url( $settings['link']['url'] ) );
            if ( ! empty( $settings['link']['is_external'] ) ) {
                $this->add_render_attribute( 'link', 'target', '_blank' );
            }
            if ( ! empty( $settings['link']['nofollow'] ) ) {
                $this->set_render_attribute( 'link', 'rel', 'nofollow' );
            }
        } else {
            $this->add_inline_editing_attributes( 'title', 'basic' );
        }
        ?>

        <div class="sa-el-steps-icon">
            <?php if ( $settings['show_indicator'] === 'yes' ) : ?>
                <div class="sa-el-step-arrow"></div>
            <?php endif; ?>

            <?php if ( ! empty( $settings['icon'] )) :
                echo $this->Sa_El_Icon_Render($settings['icon']);
            endif; ?>

            <?php if ( $settings['badge'] ) : ?>
                <span <?php $this->print_render_attribute_string( 'badge' ); ?>><?php echo $this->sa_el_kses_basic( $settings['badge'] ); ?></span>
            <?php endif; ?>
        </div>

        <div <?php $this->print_render_attribute_string( 'title' ); ?>>
            <?php if ( ! empty( $settings['link']['url'] ) ) : ?>
                <a <?php $this->print_render_attribute_string( 'link' ); ?>><?php echo $this->sa_el_kses_basic( $settings['title'] ); ?></a>
            <?php else : ?>
                <?php echo $this->sa_el_kses_basic( $settings['title'] ); ?>
            <?php endif; ?>
        </div>

        <?php if ( $settings['description'] ) : ?>
            <p <?php $this->print_render_attribute_string( 'description' ); ?>><?php echo $this->sa_el_kses_intermediate( $settings['description'] ); ?></p>
        <?php endif; ?>

        <?php
    }

}
