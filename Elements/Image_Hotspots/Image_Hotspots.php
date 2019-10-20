<?php

namespace SA_EL_ADDONS\Elements\Image_Hotspots;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Image Hotspots
 *
 * @author biplo
 * 
 */
use \Elementor\Controls_Manager as Controls_Manager;
use \Elementor\Group_Control_Background as Group_Control_Background;
use \Elementor\Scheme_Typography as Scheme_Typography;
use \Elementor\Group_Control_Border as Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography as Group_Control_Typography;
use \Elementor\Utils as Utils;
use \Elementor\Widget_Base as Widget_Base;
use \Elementor\Group_Control_Image_Size;
use \SA_EL_ADDONS\Classes\Bootstrap;

class Image_Hotspots extends Widget_Base {

     use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function get_name() {
        return 'sa_el_img_hotspots';
    }

    public function get_title() {
        return esc_html__('Image Hotspots', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'eicon-image-hotspot oxi-el-admin-icon';
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    protected function _register_controls() {

        /* ----------------------------------------------------------------------------------- */
        /* 	CONTENT TAB
          /*----------------------------------------------------------------------------------- */

        /**
         * Content Tab: Image
         */
        $this->start_controls_section(
                'section_image', [
            'label' => __('Image', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'image', [
            'label' => __('Image', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Image_Size::get_type(), [
            'name' => 'image',
            'label' => __('Image Size', SA_EL_ADDONS_TEXTDOMAIN),
            'default' => 'full',
                ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Hotspots
         */
        $this->start_controls_section(
                'section_hotspots', [
            'label' => __('Hotspots', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->start_controls_tabs('hot_spots_tabs');

        $repeater->start_controls_tab('tab_content', ['label' => __('Content', SA_EL_ADDONS_TEXTDOMAIN)]);

        $repeater->add_control(
                'hotspot_type', [
            'label' => __('Type', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => 'icon',
            'options' => [
                'icon' => __('Icon', SA_EL_ADDONS_TEXTDOMAIN),
                'text' => __('Text', SA_EL_ADDONS_TEXTDOMAIN),
                'blank' => __('Blank', SA_EL_ADDONS_TEXTDOMAIN),
            ],
                ]
        );

        $repeater->add_control(
                'hotspot_icon', [
            'label' => __('Icon', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => $this->Sa_El_Icon_Type(),
            'default' => $this->Sa_El_Default_Icon('fas fa-plus', 'solid', 'fa fa-plus'),
            'condition' => [
                'hotspot_type' => 'icon',
            ],
                ]
        );

        $repeater->add_control(
                'hotspot_text', [
            'label' => __('Text', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => 'Go',
            'condition' => [
                'hotspot_type' => 'text',
            ],
                ]
        );

        $repeater->add_control(
                'hotspot_link', [
            'label' => __('Link', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => '#',
                ]
        );

        $repeater->add_control(
                'hotspot_link_target', [
            'label' => __('Open Link in New Tab', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
            'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
            'return_value' => 'yes',
                ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab('tab_position', ['label' => __('Position', SA_EL_ADDONS_TEXTDOMAIN)]);

        $repeater->add_control(
                'left_position', [
            'label' => __('Left Position', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 0.1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}%;',
            ],
                ]
        );

        $repeater->add_control(
                'top_position', [
            'label' => __('Top Position', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 0.1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}%;',
            ],
                ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab('tab_tooltip', ['label' => __('Tooltip', SA_EL_ADDONS_TEXTDOMAIN)]);

        $repeater->add_control(
                'tooltip', [
            'label' => __('Tooltip', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __('Show', SA_EL_ADDONS_TEXTDOMAIN),
            'label_off' => __('Hide', SA_EL_ADDONS_TEXTDOMAIN),
            'return_value' => 'yes',
                ]
        );

        $repeater->add_control(
                'tooltip_position_local', [
            'label' => __('Tooltip Position', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => 'global',
            'options' => [
                'global' => __('Global', SA_EL_ADDONS_TEXTDOMAIN),
                'top' => __('Top', SA_EL_ADDONS_TEXTDOMAIN),
                'bottom' => __('Bottom', SA_EL_ADDONS_TEXTDOMAIN),
                'left' => __('Left', SA_EL_ADDONS_TEXTDOMAIN),
                'right' => __('Right', SA_EL_ADDONS_TEXTDOMAIN),
                'top-left' => __('Top Left', SA_EL_ADDONS_TEXTDOMAIN),
                'top-right' => __('Top Right', SA_EL_ADDONS_TEXTDOMAIN),
                'bottom-left' => __('Bottom Left', SA_EL_ADDONS_TEXTDOMAIN),
                'bottom-right' => __('Bottom Right', SA_EL_ADDONS_TEXTDOMAIN),
            ],
            'condition' => [
                'tooltip' => 'yes',
            ],
                ]
        );

        $repeater->add_control(
                'tooltip_content', [
            'label' => __('Tooltip Content', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::WYSIWYG,
            'default' => __('Tooltip Content', SA_EL_ADDONS_TEXTDOMAIN),
            'condition' => [
                'tooltip' => 'yes',
            ],
                ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
                'hot_spots', [
            'label' => '',
            'type' => Controls_Manager::REPEATER,
            'default' => [
                [
                    'feature_text' => __('Hotspot #1', SA_EL_ADDONS_TEXTDOMAIN),
                    'feature_icon' => 'fa fa-plus',
                    'left_position' => 20,
                    'top_position' => 30,
                ],
            ],
            'fields' => array_values($repeater->get_controls()),
            'title_field' => '{{{ hotspot_text }}}',
                ]
        );

        $this->add_control(
                'hotspot_pulse', [
            'label' => __('Glow Effect', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
            'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
            'return_value' => 'yes',
                ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Tooltip Settings
         */
        $this->start_controls_section(
                'section_tooltip', [
            'label' => __('Tooltip Settings', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'tooltip_arrow', [
            'label' => __('Show Arrow', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
            'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
            'return_value' => 'yes',
                ]
        );

        $this->add_control(
                'tooltip_size', [
            'label' => __('Size', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => __('Default', SA_EL_ADDONS_TEXTDOMAIN),
                'tiny' => __('Tiny', SA_EL_ADDONS_TEXTDOMAIN),
                'small' => __('Small', SA_EL_ADDONS_TEXTDOMAIN),
                'large' => __('Large', SA_EL_ADDONS_TEXTDOMAIN)
            ],
                ]
        );

        $this->add_control(
                'tooltip_position', [
            'label' => __('Global Position', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => 'top',
            'options' => [
                'top' => __('Top', SA_EL_ADDONS_TEXTDOMAIN),
                'bottom' => __('Bottom', SA_EL_ADDONS_TEXTDOMAIN),
                'left' => __('Left', SA_EL_ADDONS_TEXTDOMAIN),
                'right' => __('Right', SA_EL_ADDONS_TEXTDOMAIN),
                'top-left' => __('Top Left', SA_EL_ADDONS_TEXTDOMAIN),
                'top-right' => __('Top Right', SA_EL_ADDONS_TEXTDOMAIN),
                'bottom-left' => __('Bottom Left', SA_EL_ADDONS_TEXTDOMAIN),
                'bottom-right' => __('Bottom Right', SA_EL_ADDONS_TEXTDOMAIN),
            ],
                ]
        );

        $this->add_control(
                'tooltip_animation_in', [
            'label' => __('Animation In', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            'default' => '',
            'options' => [
                'bounce' => __('Bounce', SA_EL_ADDONS_TEXTDOMAIN),
                'flash' => __('Flash', SA_EL_ADDONS_TEXTDOMAIN),
                'pulse' => __('Pulse', SA_EL_ADDONS_TEXTDOMAIN),
                'rubberBand' => __('rubberBand', SA_EL_ADDONS_TEXTDOMAIN),
                'shake' => __('Shake', SA_EL_ADDONS_TEXTDOMAIN),
                'swing' => __('Swing', SA_EL_ADDONS_TEXTDOMAIN),
                'tada' => __('Tada', SA_EL_ADDONS_TEXTDOMAIN),
                'wobble' => __('Wobble', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceIn' => __('bounceIn', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceInDown' => __('bounceInDown', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceInLeft' => __('bounceInLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceInRight' => __('bounceInRight', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceInUp' => __('bounceInUp', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceOut' => __('bounceOut', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceOutDown' => __('bounceOutDown', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceOutLeft' => __('bounceOutLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceOutRight' => __('bounceOutRight', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceOutUp' => __('bounceOutUp', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeIn' => __('fadeIn', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInDown' => __('fadeInDown', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInDownBig' => __('fadeInDownBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInLeft' => __('fadeInLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInLeftBig' => __('fadeInLeftBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInRight' => __('fadeInRight', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInRightBig' => __('fadeInRightBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInUp' => __('fadeInUp', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInUpBig' => __('fadeInUpBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOut' => __('fadeOut', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutDown' => __('fadeOutDown', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutDownBig' => __('fadeOutDownBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutLeft' => __('fadeOutLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutLeftBig' => __('fadeOutLeftBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutRight' => __('fadeOutRight', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutRightBig' => __('fadeOutRightBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutUp' => __('fadeOutUp', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutUpBig' => __('fadeOutUpBig', SA_EL_ADDONS_TEXTDOMAIN),
                'flip' => __('flip', SA_EL_ADDONS_TEXTDOMAIN),
                'flipInX' => __('flipInX', SA_EL_ADDONS_TEXTDOMAIN),
                'flipInY' => __('flipInY', SA_EL_ADDONS_TEXTDOMAIN),
                'flipOutX' => __('flipOutX', SA_EL_ADDONS_TEXTDOMAIN),
                'flipOutY' => __('flipOutY', SA_EL_ADDONS_TEXTDOMAIN),
                'lightSpeedIn' => __('lightSpeedIn', SA_EL_ADDONS_TEXTDOMAIN),
                'lightSpeedOut' => __('lightSpeedOut', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateIn' => __('rotateIn', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateInDownLeft' => __('rotateInDownLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateInDownLeft' => __('rotateInDownRight', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateInUpLeft' => __('rotateInUpLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateInUpRight' => __('rotateInUpRight', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateOut' => __('rotateOut', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateOutDownLeft' => __('rotateOutDownLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateOutDownLeft' => __('rotateOutDownRight', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateOutUpLeft' => __('rotateOutUpLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateOutUpRight' => __('rotateOutUpRight', SA_EL_ADDONS_TEXTDOMAIN),
                'hinge' => __('Hinge', SA_EL_ADDONS_TEXTDOMAIN),
                'rollIn' => __('rollIn', SA_EL_ADDONS_TEXTDOMAIN),
                'rollOut' => __('rollOut', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomIn' => __('zoomIn', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomInDown' => __('zoomInDown', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomInLeft' => __('zoomInLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomInRight' => __('zoomInRight', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomInUp' => __('zoomInUp', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomOut' => __('zoomOut', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomOutDown' => __('zoomOutDown', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomOutLeft' => __('zoomOutLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomOutRight' => __('zoomOutRight', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomOutUp' => __('zoomOutUp', SA_EL_ADDONS_TEXTDOMAIN),
            ],
                ]
        );

        $this->add_control(
                'tooltip_animation_out', [
            'label' => __('Animation Out', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            'default' => '',
            'options' => [
                'bounce' => __('Bounce', SA_EL_ADDONS_TEXTDOMAIN),
                'flash' => __('Flash', SA_EL_ADDONS_TEXTDOMAIN),
                'pulse' => __('Pulse', SA_EL_ADDONS_TEXTDOMAIN),
                'rubberBand' => __('rubberBand', SA_EL_ADDONS_TEXTDOMAIN),
                'shake' => __('Shake', SA_EL_ADDONS_TEXTDOMAIN),
                'swing' => __('Swing', SA_EL_ADDONS_TEXTDOMAIN),
                'tada' => __('Tada', SA_EL_ADDONS_TEXTDOMAIN),
                'wobble' => __('Wobble', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceIn' => __('bounceIn', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceInDown' => __('bounceInDown', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceInLeft' => __('bounceInLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceInRight' => __('bounceInRight', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceInUp' => __('bounceInUp', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceOut' => __('bounceOut', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceOutDown' => __('bounceOutDown', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceOutLeft' => __('bounceOutLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceOutRight' => __('bounceOutRight', SA_EL_ADDONS_TEXTDOMAIN),
                'bounceOutUp' => __('bounceOutUp', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeIn' => __('fadeIn', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInDown' => __('fadeInDown', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInDownBig' => __('fadeInDownBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInLeft' => __('fadeInLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInLeftBig' => __('fadeInLeftBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInRight' => __('fadeInRight', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInRightBig' => __('fadeInRightBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInUp' => __('fadeInUp', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeInUpBig' => __('fadeInUpBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOut' => __('fadeOut', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutDown' => __('fadeOutDown', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutDownBig' => __('fadeOutDownBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutLeft' => __('fadeOutLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutLeftBig' => __('fadeOutLeftBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutRight' => __('fadeOutRight', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutRightBig' => __('fadeOutRightBig', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutUp' => __('fadeOutUp', SA_EL_ADDONS_TEXTDOMAIN),
                'fadeOutUpBig' => __('fadeOutUpBig', SA_EL_ADDONS_TEXTDOMAIN),
                'flip' => __('flip', SA_EL_ADDONS_TEXTDOMAIN),
                'flipInX' => __('flipInX', SA_EL_ADDONS_TEXTDOMAIN),
                'flipInY' => __('flipInY', SA_EL_ADDONS_TEXTDOMAIN),
                'flipOutX' => __('flipOutX', SA_EL_ADDONS_TEXTDOMAIN),
                'flipOutY' => __('flipOutY', SA_EL_ADDONS_TEXTDOMAIN),
                'lightSpeedIn' => __('lightSpeedIn', SA_EL_ADDONS_TEXTDOMAIN),
                'lightSpeedOut' => __('lightSpeedOut', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateIn' => __('rotateIn', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateInDownLeft' => __('rotateInDownLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateInDownLeft' => __('rotateInDownRight', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateInUpLeft' => __('rotateInUpLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateInUpRight' => __('rotateInUpRight', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateOut' => __('rotateOut', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateOutDownLeft' => __('rotateOutDownLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateOutDownLeft' => __('rotateOutDownRight', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateOutUpLeft' => __('rotateOutUpLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'rotateOutUpRight' => __('rotateOutUpRight', SA_EL_ADDONS_TEXTDOMAIN),
                'hinge' => __('Hinge', SA_EL_ADDONS_TEXTDOMAIN),
                'rollIn' => __('rollIn', SA_EL_ADDONS_TEXTDOMAIN),
                'rollOut' => __('rollOut', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomIn' => __('zoomIn', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomInDown' => __('zoomInDown', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomInLeft' => __('zoomInLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomInRight' => __('zoomInRight', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomInUp' => __('zoomInUp', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomOut' => __('zoomOut', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomOutDown' => __('zoomOutDown', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomOutLeft' => __('zoomOutLeft', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomOutRight' => __('zoomOutRight', SA_EL_ADDONS_TEXTDOMAIN),
                'zoomOutUp' => __('zoomOutUp', SA_EL_ADDONS_TEXTDOMAIN),
            ],
                ]
        );

        $this->end_controls_section();
        if (apply_filters(SA_EL_ADDONS_TEXTDOMAIN . '/check_version', TRUE) == FALSE) {
            $this->start_controls_section(
                    'sa_el_section_pro', [
                'label' => __('Go Premium for More Features', SA_EL_ADDONS_TEXTDOMAIN)
                    ]
            );

            $this->add_control(
                    'sa_el_control_get_pro', [
                'label' => __('Unlock more possibilities', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __('', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-unlock-alt',
                    ],
                ],
                'default' => '1',
                'description' => '<span class="pro-feature"> Get the  <a href="https://www.oxilab.org/downloads/short-code-addons/" target="_blank">Pro version</a> for more stunning elements and customization options.</span>'
                    ]
            );

            $this->end_controls_section();
        }
        /* ----------------------------------------------------------------------------------- */
        /* 	STYLE TAB
          /*----------------------------------------------------------------------------------- */

        /**
         * Style Tab: Image
         */
        $this->start_controls_section(
                'section_image_style', [
            'label' => __('Image', SA_EL_ADDONS_TEXTDOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'image_width', [
            'label' => __('Width', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 1200,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .sa-el-hot-spot-image' => 'width: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Hotspot
         */
        $this->start_controls_section(
                'section_hotspots_style', [
            'label' => __('Hotspot', SA_EL_ADDONS_TEXTDOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'hotspot_icon_size', [
            'label' => __('Size', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SLIDER,
            'default' => ['size' => '14'],
            'range' => [
                'px' => [
                    'min' => 6,
                    'max' => 40,
                    'step' => 1,
                ],
            ],
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}} .sa-el-hot-spot-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'icon_color_normal', [
            'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::COLOR,
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .sa-el-hot-spot-wrap, {{WRAPPER}} .sa-el-hot-spot-inner, {{WRAPPER}} .sa-el-hot-spot-inner:before' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'icon_bg_color_normal', [
            'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .sa-el-hot-spot-wrap, {{WRAPPER}} .sa-el-hot-spot-inner, {{WRAPPER}} .sa-el-hot-spot-inner:before, {{WRAPPER}} .sa-el-hotspot-icon-wrap' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'icon_border_normal',
            'label' => __('Border', SA_EL_ADDONS_TEXTDOMAIN),
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} .sa-el-hot-spot-wrap'
                ]
        );

        $this->add_control(
                'icon_border_radius', [
            'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .sa-el-hot-spot-wrap, {{WRAPPER}} .sa-el-hot-spot-inner, {{WRAPPER}} .sa-el-hot-spot-inner:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'icon_padding', [
            'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .sa-el-hot-spot-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'icon_box_shadow',
            'selector' => '{{WRAPPER}} .sa-el-hot-spot-wrap',
            'separator' => 'before',
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Tooltip
         */
        $this->start_controls_section(
                'section_tooltips_style', [
            'label' => __('Tooltip', SA_EL_ADDONS_TEXTDOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'tooltip_bg_color', [
            'label' => __('Background Color', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::COLOR,
            'default' => '#d30038',
                ]
        );

        $this->add_control(
                'tooltip_color', [
            'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::COLOR,
            'default' => '',
                ]
        );

        $this->add_control(
                'tooltip_width', [
            'label' => __('Width', SA_EL_ADDONS_TEXTDOMAIN),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 50,
                    'max' => 400,
                    'step' => 1,
                ],
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'tooltip_typography',
            'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            'selector' => '.sa-el-tooltip-{{ID}}',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        if (empty($settings['image']['url'])) {
            return;
        }
        ?>
        <div class="sa-el-image-hotspots">
            <div class="sa-el-hot-spot-image">
                <?php
                $i = 1;
                foreach ($settings['hot_spots'] as $index => $item) :

                    $this->add_render_attribute('hotspot' . $i, 'class', 'sa-el-hot-spot-wrap elementor-repeater-item-' . esc_attr($item['_id']));

                    if ($item['tooltip'] == 'yes' && $item['tooltip_content'] != '') {
                        $this->add_render_attribute('hotspot' . $i, 'class', 'sa-el-hot-spot-tooptip');
                        $this->add_render_attribute('hotspot' . $i, 'data-tipso', '<span class="sa-el-single-tooltip sa-el-tooltip-' . $this->get_id() . '">' . $this->parse_text_editor($item['tooltip_content']) . '</span>');
                    }

                    $this->add_render_attribute('hotspot' . $i, 'data-tooltip-position-global', $settings['tooltip_position']);

                    if ($item['hotspot_link'] != '#' && $item['hotspot_link'] != '') {
                        $this->add_render_attribute('hotspot' . $i, 'data-link', esc_url($item['hotspot_link']));
                    }

                    if ($item['hotspot_link_target']) {
                        $this->add_render_attribute('hotspot' . $i, 'data-link-target', '_blank');
                    }

                    if ($item['tooltip_position_local'] != 'global') {
                        $this->add_render_attribute('hotspot' . $i, 'data-tooltip-position-local', $item['tooltip_position_local']);
                    }

                    if ($settings['tooltip_size']) {
                        $this->add_render_attribute('hotspot' . $i, 'data-tooltip-size', $settings['tooltip_size']);
                    }

                    if ($settings['tooltip_width']) {
                        $this->add_render_attribute('hotspot' . $i, 'data-tooltip-width', $settings['tooltip_width']['size']);
                    }

                    if ($settings['tooltip_animation_in']) {
                        $this->add_render_attribute('hotspot' . $i, 'data-tooltip-animation-in', $settings['tooltip_animation_in']);
                    }

                    if ($settings['tooltip_animation_out']) {
                        $this->add_render_attribute('hotspot' . $i, 'data-tooltip-animation-out', $settings['tooltip_animation_out']);
                    }

                    if ($settings['tooltip_bg_color']) {
                        $this->add_render_attribute('hotspot' . $i, 'data-tooltip-background', $settings['tooltip_bg_color']);
                    }

                    if ($settings['tooltip_color']) {
                        $this->add_render_attribute('hotspot' . $i, 'data-tooltip-text-color', $settings['tooltip_color']);
                    }

                    if ($settings['tooltip_arrow'] == 'yes') {
                        $this->add_render_attribute('hotspot' . $i, 'data-tooltip-arrow', $settings['tooltip_arrow']);
                    }

                    $this->add_render_attribute('hotspot_inner_' . $i, 'class', 'sa-el-hot-spot-inner');

                    if ($settings['hotspot_pulse'] == 'yes') {
                        $this->add_render_attribute('hotspot_inner_' . $i, 'class', 'hotspot-animation');
                    }
                    ?>
                    <span <?php echo $this->get_render_attribute_string('hotspot' . $i); ?>>
                        <span <?php echo $this->get_render_attribute_string('hotspot_inner_' . $i); ?>>
                            <?php
                            if ($item['hotspot_type'] == 'icon') {
                                printf('<span class="sa-el-hotspot-icon-wrap"><span class="sa-el-hotspot-icon tooltip ">%1$s</span></span>', $this->Sa_El_Icon_Render($item['hotspot_icon']));
                            } elseif ($item['hotspot_type'] == 'text') {
                                printf('<span class="sa-el-hotspot-icon-wrap"><span class="sa-el-hotspot-text">%1$s</span></span>', esc_attr($item['hotspot_text']));
                            }
                            ?>
                        </span>
                    </span>
                    <?php $i++;
                endforeach;
                ?>

        <?php echo Group_Control_Image_Size::get_attachment_image_html($settings); ?>
            </div>
        </div>
        <?php
    }

}
