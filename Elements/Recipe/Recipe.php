<?php

namespace SA_EL_ADDONS\Elements\Recipe;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use \Elementor\Widget_Base as Widget_Base;

class Recipe extends Widget_Base {

    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function get_name() {
        return 'sa-el-recipe';
    }

    public function get_title() {
        return esc_html__('Recipe', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'eicon-menu-card oxi-el-admin-icon';
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    public function get_keywords() {
        return ['recipe', 'dish'];
    }

    protected function _register_controls() {

        /* ----------------------------------------------------------------------------------- */
        /* 	CONTENT TAB
          /*----------------------------------------------------------------------------------- */

        /**
         * Content Tab: Recipe
         */
        $this->start_controls_section(
                'section_recipe_info',
                [
                    'label' => __('Recipe Info', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'recipe_name',
                [
                    'label' => __('Name', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __('Fudgy Chocolate Brownies', SA_EL_ADDONS_TEXTDOMAIN),
                    'title' => __('Enter recipe name', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'recipe_description',
                [
                    'label' => __('Description', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXTAREA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __('These heavenly brownies are pure chocolate overload, featuring a fudgy center, slightly crusty top and layers of decadence. It doesn\'t get better than this.', SA_EL_ADDONS_TEXTDOMAIN),
                    'title' => __('Recipe description', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'image',
                [
                    'label' => __('Image', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::MEDIA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                    'default' => 'full',
                    'separator' => 'none',
                ]
        );

        $this->add_control(
                'title_separator',
                [
                    'label' => __('Title Separator', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'no',
                    'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                    'return_value' => 'yes',
                ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Recipe Meta
         */
        $this->start_controls_section(
                'section_recipe_meta',
                [
                    'label' => __('Recipe Meta', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'author',
                [
                    'label' => __('Author', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                    'return_value' => 'yes',
                ]
        );

        $this->add_control(
                'date',
                [
                    'label' => __('Date', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'label_on' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_off' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                    'return_value' => 'yes',
                ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Recipe Details
         */
        $this->start_controls_section(
                'section_recipe_details',
                [
                    'label' => __('Recipe Details', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'prep_time',
                [
                    'label' => __('Prep Time', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __('15', SA_EL_ADDONS_TEXTDOMAIN),
                    'title' => __('In minutes', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'cook_time',
                [
                    'label' => __('Cook Time', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __('30', SA_EL_ADDONS_TEXTDOMAIN),
                    'title' => __('In minutes', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'total_time',
                [
                    'label' => __('Total Time', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __('45', SA_EL_ADDONS_TEXTDOMAIN),
                    'title' => __('In minutes', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'servings',
                [
                    'label' => __('Servings', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __('2', SA_EL_ADDONS_TEXTDOMAIN),
                    'title' => __('Number of people', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'calories',
                [
                    'label' => __('Calories', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __('200', SA_EL_ADDONS_TEXTDOMAIN),
                    'title' => __('In kcal', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Ingredients
         */
        $this->start_controls_section(
                'section_ingredients',
                [
                    'label' => __('Ingredients', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'recipe_ingredients',
                [
                    'label' => '',
                    'type' => Controls_Manager::REPEATER,
                    'default' => [
                        [
                            'recipe_ingredient' => __('Ingredient #1', SA_EL_ADDONS_TEXTDOMAIN),
                        ],
                        [
                            'recipe_ingredient' => __('Ingredient #2', SA_EL_ADDONS_TEXTDOMAIN),
                        ],
                        [
                            'recipe_ingredient' => __('Ingredient #3', SA_EL_ADDONS_TEXTDOMAIN),
                        ],
                    ],
                    'fields' => [
                        [
                            'name' => 'recipe_ingredient',
                            'label' => __('Text', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::TEXT,
                            'dynamic' => [
                                'active' => true,
                            ],
                            'label_block' => true,
                            'placeholder' => __('Ingredient', SA_EL_ADDONS_TEXTDOMAIN),
                            'default' => __('Ingredient #1', SA_EL_ADDONS_TEXTDOMAIN),
                        ],
                    ],
                    'title_field' => '{{{ recipe_ingredient }}}',
                ]
        );

        $this->add_control(
                'ingredients_list_icon',
                [
                    'label' => __('Icon', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::ICON,
                    'default' => 'fa fa-square-o',
                ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Instructions
         */
        $this->start_controls_section(
                'section_instructions',
                [
                    'label' => __('Instructions', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'recipe_instructions',
                [
                    'label' => '',
                    'type' => Controls_Manager::REPEATER,
                    'default' => [
                        [
                            'recipe_instruction' => __('Step #1', SA_EL_ADDONS_TEXTDOMAIN),
                        ],
                        [
                            'recipe_instruction' => __('Step #2', SA_EL_ADDONS_TEXTDOMAIN),
                        ],
                        [
                            'recipe_instruction' => __('Step #3', SA_EL_ADDONS_TEXTDOMAIN),
                        ],
                    ],
                    'fields' => [
                        [
                            'name' => 'recipe_instruction',
                            'label' => __('Text', SA_EL_ADDONS_TEXTDOMAIN),
                            'type' => Controls_Manager::TEXT,
                            'dynamic' => [
                                'active' => true,
                            ],
                            'label_block' => true,
                            'placeholder' => __('Instruction', SA_EL_ADDONS_TEXTDOMAIN),
                            'default' => __('Instruction', SA_EL_ADDONS_TEXTDOMAIN),
                        ],
                    ],
                    'title_field' => '{{{ recipe_instruction }}}',
                ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Notes
         */
        $this->start_controls_section(
                'section_notes',
                [
                    'label' => __('Notes', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'item_notes',
                [
                    'label' => __('Notes', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::WYSIWYG,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __('', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->end_controls_section();

        /* ----------------------------------------------------------------------------------- */
        /* 	STYLE TAB
          /*----------------------------------------------------------------------------------- */

        /**
         * Style Tab: Box Style
         */
        $this->start_controls_section(
                'section_box_style',
                [
                    'label' => __('Box Style', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'box_bg',
                    'label' => __('Background', SA_EL_ADDONS_TEXTDOMAIN),
                    'types' => ['none', 'classic', 'gradient'],
                    'selector' => '{{WRAPPER}} .sa-el-recipe-container',
                ]
        );

        $this->add_control(
                'border_color',
                [
                    'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-container, {{WRAPPER}} .sa-el-recipe-section' => 'border-color: {{VALUE}};',
                    ],
                    'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'border_width',
                [
                    'label' => __('Border Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 10,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-container, {{WRAPPER}} .sa-el-recipe-section' => 'border-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_control(
                'box_border_radius',
                [
                    'label' => __('Border Radius', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Box Style
         */
        $this->start_controls_section(
                'section_recipe_info_style',
                [
                    'label' => __('Recipe Info', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'title_style',
                [
                    'label' => __('Title', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'title_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-title' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'selector' => '{{WRAPPER}} .sa-el-recipe-title',
                ]
        );

        $this->add_control(
                'title_separator_heading',
                [
                    'label' => __('Title Separator', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'condition' => [
                        'title_separator' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'title_separator_border_type',
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
                        '{{WRAPPER}} .sa-el-recipe-title' => 'border-bottom-style: {{VALUE}}',
                    ],
                    'condition' => [
                        'title_separator' => 'yes',
                    ],
                ]
        );

        $this->add_responsive_control(
                'title_separator_border_height',
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
                        '{{WRAPPER}} .sa-el-recipe-title' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
                    ],
                    'condition' => [
                        'title_separator' => 'yes',
                    ],
                ]
        );

        $this->add_control(
                'title_separator_border_color',
                [
                    'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-title' => 'border-bottom-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'title_separator' => 'yes',
                    ],
                ]
        );

        $this->add_responsive_control(
                'title_separator_spacing',
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
                        '{{WRAPPER}} .sa-el-recipe-title' => 'padding-bottom: {{SIZE}}{{UNIT}}',
                    ],
                ]
        );

        $this->add_control(
                'description_style',
                [
                    'label' => __('Description', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'description_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-description' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'description_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-recipe-description',
                ]
        );

        $this->add_control(
                'image_style',
                [
                    'label' => __('Image', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_responsive_control(
                'image_width',
                [
                    'label' => __('Width', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range' => [
                        'px' => [
                            'min' => 50,
                            'max' => 500,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-header-image' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Recipe Meta
         */
        $this->start_controls_section(
                'section_meta_style',
                [
                    'label' => __('Recipe Meta', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'meta_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-meta' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'meta_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-recipe-meta',
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Recipe Details
         */
        $this->start_controls_section(
                'section_recipe_details_style',
                [
                    'label' => __('Recipe Details', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'recipe_details_bg',
                    'label' => __('Background', SA_EL_ADDONS_TEXTDOMAIN),
                    'types' => ['none', 'classic', 'gradient'],
                    'selector' => '{{WRAPPER}} .sa-el-recipe-details',
                ]
        );

        $this->add_responsive_control(
                'recipe_details_padding',
                [
                    'label' => __('Padding', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_control(
                'detail_list_title_style_heading',
                [
                    'label' => __('Title', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'details_title_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-detail-title' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'details_title_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-recipe-detail-title',
                ]
        );

        $this->add_control(
                'details_content_style_heading',
                [
                    'label' => __('Content', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'details_text_color',
                [
                    'label' => __('Text Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-detail-value' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'details_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-recipe-detail-value',
                ]
        );

        $this->add_control(
                'icon_style_heading',
                [
                    'label' => __('Icons', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'meta_icon_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-detail-icon' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_responsive_control(
                'meta_icon_size',
                [
                    'label' => __('Size', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 40,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-detail-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Ingredients
         */
        $this->start_controls_section(
                'section_ingredients_style',
                [
                    'label' => __('Ingredients', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'ingredients_title_style',
                [
                    'label' => __('Title', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'ingredients_title_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-ingredients-heading' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'ingredients_title_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-recipe-ingredients-heading',
                ]
        );

        $this->add_control(
                'ingredients_content_style',
                [
                    'label' => __('Content', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'ingredients_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-ingredients-list' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'ingredients_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-recipe-ingredients-list',
                ]
        );

        $this->add_control(
                'ingredients_list_style',
                [
                    'label' => __('List', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'ingredients_list_border_type',
                [
                    'label' => __('Border Type', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'solid',
                    'options' => [
                        'none' => __('None', SA_EL_ADDONS_TEXTDOMAIN),
                        'solid' => __('Solid', SA_EL_ADDONS_TEXTDOMAIN),
                        'dotted' => __('Dotted', SA_EL_ADDONS_TEXTDOMAIN),
                        'dashed' => __('Dashed', SA_EL_ADDONS_TEXTDOMAIN),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-container .sa-el-recipe-ingredients li:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
                    ],
                ]
        );

        $this->add_control(
                'ingredients_list_border_color',
                [
                    'label' => __('Border Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-container .sa-el-recipe-ingredients li:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
                    ],
                    'condition' => [
                        'ingredients_list_border_type!' => 'none',
                    ],
                ]
        );

        $this->add_responsive_control(
                'ingredients_list_border_width',
                [
                    'label' => __('Border Weight', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 10,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-container .sa-el-recipe-ingredients li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'ingredients_list_border_type!' => 'none',
                    ],
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Instructions
         */
        $this->start_controls_section(
                'section_instructions_style',
                [
                    'label' => __('Instructions', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'instructions_title_style',
                [
                    'label' => __('Title', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'instructions_title_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-instructions-heading' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'instructions_title_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-recipe-instructions-heading',
                ]
        );

        $this->add_control(
                'instructions_content_style',
                [
                    'label' => __('Content', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'instructions_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-instructions-list' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'instructions_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-recipe-instructions-list',
                ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Notes
         */
        $this->start_controls_section(
                'section_notes_style',
                [
                    'label' => __('Notes', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'notes_title_style',
                [
                    'label' => __('Title', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'notes_title_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-notes-heading' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'notes_title_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-recipe-notes-heading',
                ]
        );

        $this->add_control(
                'notes_content_style',
                [
                    'label' => __('Content', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'notes_color',
                [
                    'label' => __('Color', SA_EL_ADDONS_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .sa-el-recipe-notes-content' => 'color: {{VALUE}}',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'notes_typography',
                    'label' => __('Typography', SA_EL_ADDONS_TEXTDOMAIN),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sa-el-recipe-notes-content',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('recipe_name', 'class', 'sa-el-recipe-title');
        $this->add_render_attribute('recipe_name', 'itemprop', 'name');
        $this->add_inline_editing_attributes('recipe_name', 'none');

        $this->add_render_attribute('recipe_description', 'class', 'sa-el-recipe-description');
        $this->add_render_attribute('recipe_description', 'itemprop', 'description');
        $this->add_inline_editing_attributes('recipe_description', 'basic');

        $this->add_inline_editing_attributes('prep_time', 'none');
        $this->add_inline_editing_attributes('cook_time', 'none');
        $this->add_inline_editing_attributes('total_time', 'none');
        $this->add_inline_editing_attributes('servings', 'none');
        $this->add_inline_editing_attributes('calories', 'none');

        $this->add_render_attribute('item_notes', 'class', 'sa-el-recipe-notes-content');
        $this->add_inline_editing_attributes('item_notes', 'advanced');
        ?>
        <div class="sa-el-recipe-container" itemscope="" itemtype="http://schema.org/Recipe">
            <div class="sa-el-recipe-header">
                    <?php if (!empty($settings['image']['url'])) { ?>
                    <div class="sa-el-recipe-header-image" itemprop="image" itemscope="" itemtype="https://schema.org/ImageObject">
                        <?php
                        $this->add_render_attribute('image-url', 'content', $settings['image']['url']);
                        ?>
                        <meta itemprop="url" <?php echo $this->get_render_attribute_string('image-url'); ?>>
                        <?php
                        $image_id = $settings['image']['id'];
                        $sa_el_img_url = Group_Control_Image_Size::get_attachment_image_src($image_id, 'image', $settings);

                        $this->add_render_attribute('image', 'src', $sa_el_img_url);
                        $this->add_render_attribute('image', 'itemprop', 'image');
                        $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
                        $this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));

                        echo '<img ' . $this->get_render_attribute_string('image') . '>';
                        ?>
                        <meta itemprop="height" content="">
                        <meta itemprop="width" content="">
                    </div><!-- .sa-el-recipe-header-image -->
                    <?php } ?>
                <div class="sa-el-recipe-header-content">
                        <?php if (!empty($settings['recipe_name'])) { ?>
                        <h2 <?php echo $this->get_render_attribute_string('recipe_name'); ?>>
                        <?php echo $settings['recipe_name']; ?>
                        </h2>
                        <?php } ?>
                    <div class="sa-el-recipe-meta">
                            <?php if ($settings['author'] == 'yes') { ?>
                            <span class="sa-el-recipe-meta-item" itemprop="author">
                            <?php echo get_the_author(); ?>
                            </span>
                        <?php } ?>
                            <?php if ($settings['date'] == 'yes') { ?>
                            <span class="sa-el-recipe-meta-item" itemprop="datePublished">
                            <?php the_time('F d, Y'); ?>
                            </span>
                    <?php } ?>
                    </div>
                        <?php if (!empty($settings['recipe_description'])) { ?>
                        <div <?php echo $this->get_render_attribute_string('recipe_description'); ?>>
                        <?php echo $this->parse_text_editor($settings['recipe_description']); ?>
                        </div><!-- .sa-el-recipe-description -->
        <?php } ?>
                </div><!-- .sa-el-recipe-header-content -->
            </div><!-- .sa-el-recipe-header -->
            <div class="sa-el-recipe-details sa-el-recipe-section">
                <ul class="sa-el-recipe-detail-list">
        <?php if ($settings['prep_time']) { ?>
                        <li itemprop="prepTime" content="PT15MIN">
                            <span class="sa-el-recipe-detail-icon">
                                <i class="fa fa-leaf" aria-hidden="true"></i>
                            </span>
                            <span class="sa-el-recipe-detail-content">
                                <span class="sa-el-recipe-detail-title">
            <?php esc_html_e('Prep Time', SA_EL_ADDONS_TEXTDOMAIN); ?>
                                </span>
                                <span class="sa-el-recipe-detail-value">
                                    <?php
                                    printf(esc_html__('%s Minutes', SA_EL_ADDONS_TEXTDOMAIN), '<span ' . $this->get_render_attribute_string('prep_time') . '>' . $settings['prep_time'] . '</span>');
                                    ?>
                                </span>
                            </span>
                        </li>
                    <?php } ?>
        <?php if ($settings['cook_time']) { ?>
                        <li itemprop="cookTime" content="PT30MIN">
                            <span class="sa-el-recipe-detail-icon">
                                <i class="fa fa-cutlery" aria-hidden="true"></i>
                            </span>
                            <span class="sa-el-recipe-detail-content">
                                <span class="sa-el-recipe-detail-title">
            <?php esc_html_e('Cook Time', SA_EL_ADDONS_TEXTDOMAIN); ?>
                                </span>
                                <span class="sa-el-recipe-detail-value">
                                    <?php
                                    printf(esc_html__('%s Minutes', SA_EL_ADDONS_TEXTDOMAIN), '<span ' . $this->get_render_attribute_string('cook_time') . '>' . $settings['cook_time'] . '</span>');
                                    ?>
                                </span>
                            </span>
                        </li>
                    <?php } ?>
        <?php if ($settings['total_time']) { ?>
                        <li itemprop="totalTime" content="PT45MIN">
                            <span class="sa-el-recipe-detail-icon">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                            </span>
                            <span class="sa-el-recipe-detail-content">
                                <span class="sa-el-recipe-detail-title">
            <?php esc_html_e('Total Time', SA_EL_ADDONS_TEXTDOMAIN); ?>
                                </span>
                                <span class="sa-el-recipe-detail-value">
                                    <?php
                                    printf(esc_html__('%s Minutes', SA_EL_ADDONS_TEXTDOMAIN), '<span ' . $this->get_render_attribute_string('total_time') . '>' . $settings['total_time'] . '</span>');
                                    ?>
                                </span>
                            </span>
                        </li>
                    <?php } ?>
        <?php if ($settings['servings']) { ?>
                        <li itemprop="recipeYield">
                            <span class="sa-el-recipe-detail-icon">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </span>
                            <span class="sa-el-recipe-detail-content">
                                <span class="sa-el-recipe-detail-title">
            <?php esc_html_e('Serves', SA_EL_ADDONS_TEXTDOMAIN); ?>
                                </span>
                                <span class="sa-el-recipe-detail-value">
                                    <?php
                                    printf(esc_html__('%s People', SA_EL_ADDONS_TEXTDOMAIN), '<span ' . $this->get_render_attribute_string('servings') . '>' . $settings['servings'] . '</span>');
                                    ?>
                                </span>
                            </span>
                        </li>
                    <?php } ?>
        <?php if ($settings['calories']) { ?>
                        <li itemprop="nutrition" itemscope="" itemtype="http://schema.org/NutritionInformation">
                            <span itemprop="calories">
                                <span class="sa-el-recipe-detail-icon">
                                    <i class="fa fa-bolt" aria-hidden="true"></i>
                                </span>
                                <span class="sa-el-recipe-detail-content">
                                    <span class="sa-el-recipe-detail-title">
            <?php esc_html_e('Calories', SA_EL_ADDONS_TEXTDOMAIN); ?>
                                    </span>
                                    <span class="sa-el-recipe-detail-value">
                                        <?php
                                        printf(esc_html__('%s kcal', SA_EL_ADDONS_TEXTDOMAIN), '<span ' . $this->get_render_attribute_string('calories') . '>' . $settings['calories'] . '</span>');
                                        ?>
                                    </span>
                                </span>
                            </span>
                        </li>
        <?php } ?>
                </ul>
            </div><!-- .sa-el-recipe-details -->
            <div class="sa-el-recipe-ingredients sa-el-recipe-section">
                <h3 class="sa-el-recipe-section-heading sa-el-recipe-ingredients-heading">
        <?php esc_attr_e('Ingredients', SA_EL_ADDONS_TEXTDOMAIN); ?>
                </h3>
                <ul class="sa-el-recipe-ingredients-list">
                    <?php
                    foreach ($settings['recipe_ingredients'] as $index => $item) :

                        $ingredient_key = $this->get_repeater_setting_key('recipe_ingredient', 'recipe_ingredients', $index);
                        $this->add_render_attribute($ingredient_key, 'class', 'sa-el-recipe-ingredient-text');
                        $this->add_inline_editing_attributes($ingredient_key, 'none');

                        if ($item['recipe_ingredient']) :
                            ?>
                            <li class="sa-el-recipe-ingredient">
                                <?php if ($settings['ingredients_list_icon'] != '') { ?>
                                    <span class="<?php echo $settings['ingredients_list_icon']; ?>" aria-hidden="true"></span>
                                    <?php } ?>
                                <span itemprop="recipeIngredient" <?php echo $this->get_render_attribute_string($ingredient_key); ?>>
                <?php echo $item['recipe_ingredient']; ?>
                                </span>
                            </li>
                            <?php
                        endif;
                    endforeach;
                    ?>
                </ul>
            </div><!-- .sa-el-recipe-ingredients -->
            <div class="sa-el-recipe-instructions sa-el-recipe-section">
                <h3 class="sa-el-recipe-section-heading sa-el-recipe-instructions-heading">
        <?php esc_attr_e('Instructions', SA_EL_ADDONS_TEXTDOMAIN); ?>
                </h3>
                <ol class="sa-el-recipe-instructions-list">
                    <?php
                    foreach ($settings['recipe_instructions'] as $index => $item) :

                        $instruction_key = $this->get_repeater_setting_key('recipe_instruction', 'recipe_instructions', $index);
                        $this->add_render_attribute($instruction_key, 'class', 'sa-el-recipe-instruction');
                        $this->add_inline_editing_attributes($instruction_key, 'none');

                        if ($item['recipe_instruction']) :
                            ?>
                            <li itemprop="recipeInstructions" <?php echo $this->get_render_attribute_string($instruction_key); ?>>
                            <?php echo $item['recipe_instruction']; ?>
                            </li>
                            <?php
                        endif;
                    endforeach;
                    ?>
                </ol>
            </div><!-- .sa-el-recipe-instructions -->
        <?php if ($settings['item_notes']) { ?>
                <div class="sa-el-recipe-notes sa-el-recipe-section">
                    <h3 class="sa-el-recipe-section-heading sa-el-recipe-notes-heading">
            <?php esc_attr_e('Notes', SA_EL_ADDONS_TEXTDOMAIN); ?>
                    </h3>
                    <div <?php echo $this->get_render_attribute_string('item_notes'); ?>>
                        <?php
                        $pa_allowed_html = wp_kses_allowed_html();
                        echo wp_kses($settings['item_notes'], $pa_allowed_html);
                        ?>
                    </div>
                </div><!-- .sa-el-recipe-notes -->
        <?php } ?>
        </div><!-- .sa-el-recipe-container -->
        <?php
    }

    /**
     * Render recipe details output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @access protected
     */
    protected function _recipe_details_template() {
        ?>
        <div class="sa-el-recipe-details sa-el-recipe-section">
            <ul class="sa-el-recipe-detail-list">
                <# if ( settings.prep_time != '' ) { #>
                <li>
                    <span class="sa-el-recipe-detail-icon">
                        <i class="fa fa-leaf" aria-hidden="true"></i>
                    </span>
                    <span class="sa-el-recipe-detail-content">
                        <span class="sa-el-recipe-detail-title">
        <?php esc_html_e('Prep Time', SA_EL_ADDONS_TEXTDOMAIN); ?>
                        </span>
                        <span class="sa-el-recipe-detail-value">
                            <#
                            if ( settings.prep_time != '' ) {
                            var prep_time = settings.prep_time;

                            view.addInlineEditingAttributes( 'prep_time', 'none' );

                            var prep_time_html = '<span' + ' ' + view.getRenderAttributeString( 'prep_time' ) + '>' + prep_time + '</span>';

                            print( prep_time_html );
                            }
                            #> <?php esc_attr_e('Minutes', SA_EL_ADDONS_TEXTDOMAIN); ?>
                        </span>
                    </span>
                </li>
                <# } #>
                <# if ( settings.cook_time != '' ) { #>
                <li>
                    <span class="sa-el-recipe-detail-icon">
                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                    </span>
                    <span class="sa-el-recipe-detail-content">
                        <span class="sa-el-recipe-detail-title">
        <?php esc_html_e('Cook Time', SA_EL_ADDONS_TEXTDOMAIN); ?>
                        </span>
                        <span class="sa-el-recipe-detail-value">
                            <#
                            if ( settings.cook_time != '' ) {
                            var cook_time = settings.cook_time;

                            view.addInlineEditingAttributes( 'cook_time', 'none' );

                            var cook_time_html = '<span' + ' ' + view.getRenderAttributeString( 'cook_time' ) + '>' + cook_time + '</span>';

                            print( cook_time_html );
                            }
                            #> <?php esc_attr_e('Minutes', SA_EL_ADDONS_TEXTDOMAIN); ?>
                        </span>
                    </span>
                </li>
                <# } #>
                <# if ( settings.total_time != '' ) { #>
                <li itemprop="totalTime" content="PT45MIN">
                    <span class="sa-el-recipe-detail-icon">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                    </span>
                    <span class="sa-el-recipe-detail-content">
                        <span class="sa-el-recipe-detail-title">
        <?php esc_html_e('Total Time', SA_EL_ADDONS_TEXTDOMAIN); ?>
                        </span>
                        <span class="sa-el-recipe-detail-value">
                            <#
                            if ( settings.total_time != '' ) {
                            var total_time = settings.total_time;

                            view.addInlineEditingAttributes( 'total_time', 'none' );

                            var total_time_html = '<span' + ' ' + view.getRenderAttributeString( 'total_time' ) + '>' + total_time + '</span>';

                            print( total_time_html );
                            }
                            #> <?php esc_attr_e('Minutes', SA_EL_ADDONS_TEXTDOMAIN); ?>
                        </span>
                    </span>
                </li>
                <# } #>
                <# if ( settings.servings != '' ) { #>
                <li>
                    <span class="sa-el-recipe-detail-icon">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </span>
                    <span class="sa-el-recipe-detail-content">
                        <span class="sa-el-recipe-detail-title">
        <?php esc_html_e('Serves', SA_EL_ADDONS_TEXTDOMAIN); ?>
                        </span>
                        <span class="sa-el-recipe-detail-value">
                            <#
                            if ( settings.servings != '' ) {
                            var servings = settings.servings;

                            view.addInlineEditingAttributes( 'servings', 'none' );

                            var servings_html = '<span' + ' ' + view.getRenderAttributeString( 'servings' ) + '>' + servings + '</span>';

                            print( servings_html );
                            }
                            #> <?php esc_attr_e('People', SA_EL_ADDONS_TEXTDOMAIN); ?>
                        </span>
                    </span>
                </li>
                <# } #>
                <# if ( settings.calories != '' ) { #>
                <li>
                    <span itemprop="calories">
                        <span class="sa-el-recipe-detail-icon">
                            <i class="fa fa-bolt" aria-hidden="true"></i>
                        </span>
                        <span class="sa-el-recipe-detail-content">
                            <span class="sa-el-recipe-detail-title">
        <?php esc_html_e('Calories', SA_EL_ADDONS_TEXTDOMAIN); ?>
                            </span>
                            <span class="sa-el-recipe-detail-value">
                                <#
                                if ( settings.calories != '' ) {
                                var calories = settings.calories;

                                view.addInlineEditingAttributes( 'calories', 'none' );

                                var calories_html = '<span' + ' ' + view.getRenderAttributeString( 'calories' ) + '>' + calories + '</span>';

                                print( calories_html );
                                }
                                #> <?php esc_attr_e('kcal', SA_EL_ADDONS_TEXTDOMAIN); ?>
                            </span>
                        </span>
                    </span>
                </li>
                <# } #>
            </ul>
        </div><!-- .sa-el-recipe-details -->
        <?php
    }

    /**
     * Render recipe widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @access protected
     */
    protected function _content_template() {
        ?>
        <# var i = 1; #>
        <div class="sa-el-recipe-container">
            <div class="sa-el-recipe-header">
                <# if ( settings.image.url != '' ) { #>
                <div class="sa-el-recipe-header-image">
                    <#
                    var image = {
                    id: settings.image.id,
                    url: settings.image.url,
                    size: settings.image_size,
                    dimension: settings.image_custom_dimension,
                    model: view.getEditModel()
                    };
                    var image_url = elementor.imagesManager.getImageUrl( image );
                    #>
                    <img src="{{{ image_url }}}" />
                </div><!-- .sa-el-recipe-header-image -->
                <# } #>
                <div class="sa-el-recipe-header-content">
                    <#
                    if ( settings.recipe_name != '' ) {
                    var name = settings.recipe_name;

                    view.addRenderAttribute( 'recipe_name', 'class', 'sa-el-recipe-title' );

                    view.addInlineEditingAttributes( 'recipe_name' );

                    var recipe_name_html = '<h2' + ' ' + view.getRenderAttributeString( 'recipe_name' ) + '>' + name + '</h2>';

                    print( recipe_name_html );
                    }
                    #>
                    <div class="sa-el-recipe-meta">
                        <# if ( settings.author == 'yes' ) { #>
                        <span class="sa-el-recipe-meta-item" itemprop="author">
        <?php echo get_the_author(); ?>
                        </span>
                        <# } #>
                        <# if ( settings.date == 'yes' ) { #>
                        <span class="sa-el-recipe-meta-item" itemprop="datePublished">
        <?php the_time('F d, Y'); ?>
                        </span>
                        <# } #>
                    </div>
                    <#
                    if ( settings.recipe_description != '' ) {
                    var description = settings.recipe_description;

                    view.addRenderAttribute( 'recipe_description', 'class', 'sa-el-recipe-description' );

                    view.addInlineEditingAttributes( 'recipe_description', 'basic' );

                    var description_html = '<div' + ' ' + view.getRenderAttributeString( 'recipe_description' ) + '>' + description + '</div>';

                    print( description_html );
                    }
                    #>
                </div><!-- .sa-el-recipe-header-content -->
            </div><!-- .sa-el-recipe-header -->
            <?php
            // Recipe Details
            $this->_recipe_details_template();
            ?>
            <div class="sa-el-recipe-ingredients sa-el-recipe-section">
                <h3 class="sa-el-recipe-section-heading sa-el-recipe-ingredients-heading">
        <?php esc_attr_e('Ingredients', SA_EL_ADDONS_TEXTDOMAIN); ?>
                </h3>
                <ul class="sa-el-recipe-ingredients-list">
                    <# _.each( settings.recipe_ingredients, function( item ) { #>
                    <# if ( item.recipe_ingredient != '' ) { #>
                    <li class="sa-el-recipe-ingredient">
                        <# if ( settings.ingredients_list_icon != '' ) { #>
                        <span class="{{ settings.ingredients_list_icon }}" aria-hidden="true"></span>
                        <# } #>

                        <#
                        var ingredient = item.recipe_ingredient,
                        ingredient_key = 'recipe_ingredients.' + (i - 1) + '.recipe_ingredient';

                        view.addRenderAttribute( ingredient_key, 'class', 'sa-el-recipe-ingredient-text' );

                        view.addRenderAttribute( ingredient_key, 'itemprop', 'recipeIngredient' );

                        view.addInlineEditingAttributes( ingredient_key );

                        var ingredient_html = '<span' + ' ' + view.getRenderAttributeString( ingredient_key ) + '>' + ingredient + '</span>';

                        print( ingredient_html );
                        #>
                    </li>
                    <# } #>
                    <# } ); #>
                </ul>
            </div><!-- .sa-el-recipe-ingredients -->
            <div class="sa-el-recipe-instructions sa-el-recipe-section">
                <h3 class="sa-el-recipe-section-heading sa-el-recipe-instructions-heading">
        <?php esc_attr_e('Instructions', SA_EL_ADDONS_TEXTDOMAIN); ?>
                </h3>
                <ol class="sa-el-recipe-instructions-list">
                    <# _.each( settings.recipe_instructions, function( item ) { #>
                    <# if ( item.recipe_instruction != '' ) { #>
                    <#
                    var instruction = item.recipe_instruction,
                    instruction_key = 'recipe_instructions.' + (i - 1) + '.recipe_instruction';

                    view.addRenderAttribute( instruction_key, 'class', 'sa-el-recipe-instruction' );

                    view.addRenderAttribute( instruction_key, 'itemprop', 'recipeInstructions' );

                    view.addInlineEditingAttributes( instruction_key );

                    var instruction_html = '<li' + ' ' + view.getRenderAttributeString( instruction_key ) + '>' + instruction + '</li>';

                    print( instruction_html );
                    #>
                    <# } #>
                    <# i++; } ); #>
                </ol>
            </div><!-- .sa-el-recipe-instructions -->
            <# if ( settings.item_notes != '' ) { #>
            <div class="sa-el-recipe-notes sa-el-recipe-section">
                <h3 class="sa-el-recipe-section-heading sa-el-recipe-notes-heading">
        <?php esc_attr_e('Notes', SA_EL_ADDONS_TEXTDOMAIN); ?>
                </h3>

                <#
                var notes = settings.item_notes,
                notes_key = 'item_notes';

                view.addRenderAttribute( notes_key, 'class', 'sa-el-recipe-notes-content' );

                view.addInlineEditingAttributes( notes_key, 'advanced' );

                var notes_html = '<div' + ' ' + view.getRenderAttributeString( notes_key ) + '>' + notes + '</div>';

                print( notes_html );
                #>
            </div><!-- .sa-el-recipe-notes -->
            <# } #>
        </div><!-- .sa-el-recipe-container -->
        <?php
    }

}
