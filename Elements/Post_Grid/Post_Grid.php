<?php

namespace SA_EL_ADDONS\Elements\Post_Grid;

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use \Elementor\Widget_Base as Widget_Base;

class Post_Grid extends Widget_Base {
    
    use \SA_EL_ADDONS\Helper\Elementor_Helper;
    use \SA_EL_ADDONS\Elements\Post_Grid\Files\Post_Query;

    public function get_name() {
        return 'sa_el_post_grid';
    }

    public function get_title() {
        return esc_html__('Post Grid', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon() {
        return 'eicon-flow oxi-el-admin-icon';
    }

    public function get_categories() {
        return ['sa-el-addons'];
    }

    protected function _register_controls() {
        $taxonomies = get_taxonomies([], 'objects');
        $this->start_controls_section(
            '_section_step',
            [
                'label' => __( 'Post Grid', SA_EL_ADDONS_TEXTDOMAIN ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'post_type',
            [
                'label' => __('Source', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => $this->post_type(),
                'default' => key($this->post_type()),
            ]
        );
        $this->add_control(
            'authors', [
                'label' => __('Author', SA_EL_ADDONS_TEXTDOMAIN),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => [],
                'options' => $this->post_author(),
                'condition' => [
                    'post_type!' => 'by_id',
                ],
            ]
        );
        foreach ($taxonomies as $taxonomy => $object) {
            if (!in_array($object->object_type[0], array_keys($this->post_type()))) {
                continue;
            }

            $this->add_control(
                $taxonomy . '_ids',
                [
                    'label' => $object->label,
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'object_type' => $taxonomy,
                    'options' => wp_list_pluck(get_terms($taxonomy), 'name', 'term_id'),
                    'condition' => [
                        'post_type' => $object->object_type,
                    ],
                ]
            );
        }
        $this->add_control(
            'post__not_in',
            [
                'label' => __('Exclude', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->post_type(),
                'label_block' => true,
                'post_type' => '',
                'multiple' => true,
                // 'condition' => [
                //     'post_type!' => 'by_id',
                // ],
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

        
        $this->end_controls_section();
    }

    protected function render() {

       
    }

}
