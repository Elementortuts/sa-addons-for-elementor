<?php

namespace SA_EL_ADDONS\Elements\Advanced_Menu;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Advanced_Menu
 *
 * @author biplo
 * 
 */
use \Elementor\Controls_Manager as Controls_Manager;
use \Elementor\Widget_Base as Widget_Base;
use \SA_EL_ADDONS\Skins\Skin_Default;
use \SA_EL_ADDONS\Skins\Skin_Five;
use \SA_EL_ADDONS\Skins\Skin_Four;
use \SA_EL_ADDONS\Skins\Skin_One;
use \SA_EL_ADDONS\Skins\Skin_Seven;
use \SA_EL_ADDONS\Skins\Skin_Six;
use \SA_EL_ADDONS\Skins\Skin_Three;
use \SA_EL_ADDONS\Skins\Skin_Two;

class Advanced_Menu extends Widget_Base {

    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function get_name() {
        return 'sa-el-advanced-menu';
    }

    public function get_title() {
        return esc_html__('Advanced Menu', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'eicon-accordion oxi-el-admin-icon';
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    protected function _register_skins() {
        $this->add_skin(new Skin_Default($this));
        $this->add_skin(new Skin_One($this));
        $this->add_skin(new Skin_Two($this));
        $this->add_skin(new Skin_Three($this));
        $this->add_skin(new Skin_Four($this));
        $this->add_skin(new Skin_Five($this));
        $this->add_skin(new Skin_Six($this));
        $this->add_skin(new Skin_Seven($this));
    }

    protected function _register_controls() {
        /**
         * Content: General
         */
        $this->start_controls_section(
                'sa_el_advanced_menu_section_general',
                [
                    'label' => esc_html__('General', SA_EL_ADDONS_TEXTDOMAIN),
                ]
        );

        $this->add_control(
                'sa_el_advanced_menu_menu',
                [
                    'label' => esc_html__('Select Menu', SA_EL_ADDONS_TEXTDOMAIN),
                    'description' => sprintf(__('Go to the <a href="%s" target="_blank">Menu screen</a> to manage your menus.', SA_EL_ADDONS_TEXTDOMAIN), admin_url('nav-menus.php')),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => false,
                    'options' => $this->sa_el_get_menus(),
                    'separator' => 'before',
                ]
        );

        $this->end_controls_section();

        /**
         * Style: Main Menu
         */
        $this->start_controls_section(
                'sa_el_advanced_menu_section_style_menu',
                [
                    'label' => __('Main Menu', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->end_controls_section();

        /**
         * Style: Dropdown Menu
         */
        $this->start_controls_section(
                'sa_el_advanced_menu_section_style_dropdown',
                [
                    'label' => __('Dropdown Menu', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->end_controls_section();

        /**
         * Style: Top Level Items
         */
        $this->start_controls_section(
                'sa_el_advanced_menu_section_style_top_level_item',
                [
                    'label' => __('Top Level Item', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->end_controls_section();

        /**
         * Style: Main Menu (Hover)
         */
        $this->start_controls_section(
                'sa_el_advanced_menu_section_style_dropdown_item',
                [
                    'label' => __('Dropdown Item', SA_EL_ADDONS_TEXTDOMAIN),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->end_controls_section();
    }

}
