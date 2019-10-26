<?php

namespace SA_EL_ADDONS\Elements\Link_Effects;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Link_Effects
 *
 * @author biplo
 * 
 */
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use \Elementor\Widget_Base as Widget_Base;

class Link_Effects extends Widget_Base {

    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function get_name() {
        return 'sa_el_link_effects';
    }

    public function get_title() {
        return esc_html__('Link Effects', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'eicon-editor-link  oxi-el-admin-icon';
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    protected function _register_controls() {

        /* ----------------------------------------------------------------------------------- */
        /* 	CONTENT TAB
          /*----------------------------------------------------------------------------------- */

        /**
         * Content Tab: Link Effects
         * -------------------------------------------------
         */
        $this->start_controls_section(
                'section_link_effects',
                [
                    'label' => __('Link Effects', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'text',
                [
                    'label' => __('Text', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __('Click Here', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'secondary_text',
                [
                    'label' => __('Secondary Text', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __('Click Here', SA_EL_ADDONS_TEXTDOMAIN),
                    'condition' => [
                        'effect' => 'effect-9',
                    ],
                ]
        );

        $this->add_control(
                'link',
                [
                    'label' => __('Link', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::URL,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'placeholder' => 'https://www.your-link.com',
                    'default' => [
                        'url' => '#',
                    ],
                ]
        );

        $this->add_control(
                'effect',
                [
                    'label' => __('Effect', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'effect-1' => __('Bottom Border Slides In', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-2' => __('Bottom Border Slides Out', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-3' => __('Brackets', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-4' => __('3D Rolling Cube', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-5' => __('Same Word Slide In', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-6' => __('Right Angle Slides Down over Title', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-7' => __('Second Border Slides Up', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-8' => __('Border Slight Translate', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-9' => __('Second Text and Borders', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-10' => __('Push Out', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-11' => __('Text Fill', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-12' => __('Circle', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-13' => __('Three Circles', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-14' => __('Border Switch', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-15' => __('Scale Down', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-16' => __('Fall Down', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-17' => __('Move Up and Push Border', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-18' => __('Cross', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-19' => __('3D Side', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-20' => __('Unfold', SA_EL_ADDONS_TEXTDOMAIN),
                        'effect-21' => __('Borders Slight Yranslate', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                    'default' => 'effect-1',
                ]
        );

        $this->add_responsive_control(
                'align',
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
                        'justify' => [
                            'title' => __('Justified', SA_EL_ADDONS_TEXTDOMAIN),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                    ],
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'section_style',
                [
                    'label' => __('Link Effects', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} a.sa-el-link',
                ]
        );

        $this->add_responsive_control(
                'divider_title_width',
                [
                    'label' => __('Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 200,
                    ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 1000,
                            'step' => 1,
                        ],
                    ],
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-link-effect-19' => 'width: {{SIZE}}{{UNIT}}',
                        '{{WRAPPER}} .sa-el-linsa-el-linkk-effect-19 span' => 'transform-origin: 50% 50% calc(-{{SIZE}}{{UNIT}}/2)',
                    ],
                    'condition' => [
                        'effect' => 'effect-19',
                    ],
                ]
        );

        $this->start_controls_tabs('tabs_link_style');

        $this->start_controls_tab(
                'tab_link_normal',
                [
                    'label' => __('Normal', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'link_color_normal',
                [
                    'label' => __('Link Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} a.sa-el-link, {{WRAPPER}} .sa-el-link-effect-10 span, {{WRAPPER}} .sa-el-link-effect-15:before, {{WRAPPER}} .sa-el-link-effect-16, {{WRAPPER}} .sa-el-link-effect-17:before' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'background_color_normal',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-link-effect-4 span, {{WRAPPER}} .sa-el-link-effect-10 span, {{WRAPPER}} .sa-el-link-effect-19 span, {{WRAPPER}} .sa-el-link-effect-20 span' => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'link_border_color',
                [
                    'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-link-effect-8:before' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-link-effect-11' => 'border-top-color: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-link-effect-1:after, {{WRAPPER}} .sa-el-link-effect-2:after, {{WRAPPER}} .sa-el-link-effect-6:before, {{WRAPPER}} .sa-el-link-effect-6:after, {{WRAPPER}} .sa-el-link-effect-7:before, {{WRAPPER}} .sa-el-link-effect-7:after, {{WRAPPER}} .sa-el-link-effect-14:before, {{WRAPPER}} .sa-el-link-effect-14:after, {{WRAPPER}} .sa-el-link-effect-18:before, {{WRAPPER}} .sa-el-link-effect-18:after' => 'background: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-link-effect-3:before, {{WRAPPER}} .sa-el-link-effect-3:after' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-link-effect-20 span' => 'box-shadow: inset 0 3px {{VALUE}};',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_link_hover',
                [
                    'label' => __('Hover', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'link_color_hover',
                [
                    'label' => __('Link Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} a.sa-el-link:hover, {{WRAPPER}} .sa-el-link-effect-10:before, {{WRAPPER}} .sa-el-link-effect-11:before, {{WRAPPER}} .sa-el-link-effect-15, {{WRAPPER}} .sa-el-link-effect-16:before, {{WRAPPER}} .sa-el-link-effect-20 span:before' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'background_color_hover',
                [
                    'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-link-effect-4 span:before, {{WRAPPER}} .sa-el-link-effect-10:before, {{WRAPPER}} .sa-el-link-effect-19 span:before, {{WRAPPER}} .sa-el-link-effect-20 span:before' => 'background-color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'link_border_color_hover',
                [
                    'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-link-effect-8:after' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-link-effect-11:before' => 'border-bottom-color: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-link-effect-9:before, {{WRAPPER}} .sa-el-link-effect-9:after, {{WRAPPER}} .sa-el-link-effect-14:hover:before, {{WRAPPER}} .sa-el-link-effect-14:focus:before, {{WRAPPER}} .sa-el-link-effect-14:hover:after, {{WRAPPER}} .sa-el-link-effect-14:focus:after, {{WRAPPER}} .sa-el-link-effect-17:after, {{WRAPPER}} .sa-el-link-effect-18:hover:before, {{WRAPPER}} .sa-el-link-effect-18:focus:before, {{WRAPPER}} .sa-el-link-effect-18:hover:after, {{WRAPPER}} .sa-el-link-effect-18:focus:after, {{WRAPPER}} .sa-el-link-effect-21:before, {{WRAPPER}} .sa-el-link-effect-21:after' => 'background: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-link-effect-17' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .sa-el-link-effect-13:hover:before, {{WRAPPER}} .sa-el-link-effect-13:focus:before' => 'color: {{VALUE}}; text-shadow: 10px 0 {{VALUE}}, -10px 0 {{VALUE}}',
                    ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_section();
    }

    /**
     * Render link effects widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        // get our input from the widget settings.

        $sa_el_link_text = !empty($settings['text']) ? $settings['text'] : '';
        $sa_el_link_secondary_text = !empty($settings['secondary_text']) ? $settings['secondary_text'] : '';

        if (!empty($settings['link']['url'])) {
            $this->add_render_attribute('sa-el-link', 'href', $settings['link']['url']);

            if (!empty($settings['link']['is_external'])) {
                $this->add_render_attribute('sa-el-link', 'target', '_blank');
            }
        }

        $this->add_render_attribute('sa-el-link', 'class', 'sa-el-link');

        if ($settings['effect']) {
            $this->add_render_attribute('sa-el-link', 'class', 'sa-el-link-' . $settings['effect']);
        }

        if ($settings['effect'] == 'effect-4' || $settings['effect'] == 'effect-5' || $settings['effect'] == 'effect-19' || $settings['effect'] == 'effect-20') {
            $this->add_render_attribute('sa-el-link-text', 'data-hover', $sa_el_link_text);
        }

        if ($settings['effect'] == 'effect-10' || $settings['effect'] == 'effect-11' || $settings['effect'] == 'effect-15' || $settings['effect'] == 'effect-16' || $settings['effect'] == 'effect-17' || $settings['effect'] == 'effect-18') {
            $this->add_render_attribute('sa-el-link-text-2', 'data-hover', $sa_el_link_text);
        }
        ?>

        <a <?php echo $this->get_render_attribute_string('sa-el-link'); ?><?php echo $this->get_render_attribute_string('sa-el-link-text-2'); ?>>
            <span <?php echo $this->get_render_attribute_string('sa-el-link-text'); ?>>
                <?php echo $sa_el_link_text; ?>
            </span>
            <?php if ($settings['effect'] == 'effect-9') { ?>
                <span><?php echo esc_attr($sa_el_link_secondary_text); ?></span>
            <?php } ?>
        </a>

        <?php
    }

    protected function _content_template() {
        
    }

}
