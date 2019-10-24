<?php

namespace SA_EL_ADDONS\Helper;

if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
trait Post_Query {
    // All Controls For Query
    public function sa_el_query_controls()
    {
        $this->add_control(
            'post_type',
            [
                'label' => __('Source', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => self::post_type(),
                'default' => key(self::post_type()),
            ]
        );
        $this->add_control(
            'authors',
            [
                'label' => __('Author', SA_EL_ADDONS_TEXTDOMAIN),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => [],
                'options' => self::post_author(),
                'condition' => [
                    'post_type!' => 'by_id',
                ],
            ]
        );
        foreach (self::post_type() as $key => $value) {
            if ($key != 'page') :
                $this->add_control(
                    $key . '_category',
                    [
                        'label' => __('Category', SA_EL_ADDONS_TEXTDOMAIN),
                        'label_block' => true,
                        'type' => Controls_Manager::SELECT2,
                        'multiple' => true,
                        'default' => [],
                        'options' => self::post_category($key),
                        'condition' => [
                            'post_type' => $key,
                        ],
                    ]
                );
                $this->add_control(
                    $key . '_tag',
                    [
                        'label' => __('Tags', SA_EL_ADDONS_TEXTDOMAIN),
                        'label_block' => true,
                        'type' => Controls_Manager::SELECT2,
                        'multiple' => true,
                        'default' => [],
                        'options' => self::post_tags($key),
                        'condition' => [
                            'post_type' => $key,
                        ],
                    ]
                );
            endif;
            $this->add_control(
                $key . '_include',
                [
                    'label' => __('Include', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_block' => true,
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'default' => [],
                    'options' => self::post_include($key),
                    'condition' => [
                        'post_type' => $key,
                    ],
                ]
            );
            $this->add_control(
                $key . '_exclude',
                [
                    'label' => __('Exclude', SA_EL_ADDONS_TEXTDOMAIN),
                    'label_block' => true,
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'default' => [],
                    'options' => self::post_exclude($key),
                    'condition' => [
                        'post_type' => $key,
                    ],
                ]
            );
        }
        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
            ]
        );
    
        $this->add_control(
            'offset',
            [
                'label' => __('Offset', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
            ]
        );
    
        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => self::get_post_orderby_options(),
                'default' => 'date',
    
            ]
        );
    
        $this->add_control(
            'order',
            [
                'label' => __('Order', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
                'default' => 'desc',
    
            ]
        );
    }
    // All Query Layout Controls
    public function sa_el_layout_controls()
    {
        $this->add_responsive_control(
            'sa_el_post_grid_columns',
            [
                'label' => esc_html__('Number of Columns', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'default' => 'sa-el-col-4',
                'options' => [
                    'sa-el-col-1' => esc_html__('Single Column', SA_EL_ADDONS_TEXTDOMAIN),
                    'sa-el-col-2' => esc_html__('Two Columns', SA_EL_ADDONS_TEXTDOMAIN),
                    'sa-el-col-3' => esc_html__('Three Columns', SA_EL_ADDONS_TEXTDOMAIN),
                    'sa-el-col-4' => esc_html__('Four Columns', SA_EL_ADDONS_TEXTDOMAIN),
                    'sa-el-col-5' => esc_html__('Five Columns', SA_EL_ADDONS_TEXTDOMAIN),
                    'sa-el-col-6' => esc_html__('Six Columns', SA_EL_ADDONS_TEXTDOMAIN),
                ],
            ]
        );
        $this->add_control(
            'show_load_more',
            [
                'label' => __('Show Load More', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-ban',
                    ],
                ],
                'default' => '0',
            ]
        );

        $this->add_control(
            'show_load_more_text',
            [
                'label' => esc_html__('Label Text', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => esc_html__('Load More', SA_EL_ADDONS_TEXTDOMAIN),
                'condition' => [
                    'show_load_more' => '1',
                ],
            ]
        );
        $this->add_control(
            'sa_el_show_image',
            [
                'label' => __('Show Image', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-ban',
                    ],
                ],
                'default' => '1',
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'exclude' => ['custom'],
                'default' => 'medium',
                'condition' => [
                    'sa_el_show_image' => '1',
                ],
            ]
        );
        $this->add_control(
            'sa_el_show_title',
            [
                'label' => __('Show Title', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-ban',
                    ],
                ],
                'default' => '1',
            ]
        );

        $this->add_control(
            'sa_el_show_excerpt',
            [
                'label' => __('Show excerpt', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-ban',
                    ],
                ],
                'default' => '1',
            ]
        );

        $this->add_control(
            'sa_el_excerpt_length',
            [
                'label' => __('Excerpt Words', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::NUMBER,
                'default' => '10',
                'condition' => [
                    'sa_el_show_excerpt' => '1',
                ],
            ]
        );

        $this->add_control(
            'excerpt_expanison_indicator',
            [
                'label' => esc_html__('Expanison Indicator', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => esc_html__('...', SA_EL_ADDONS_TEXTDOMAIN),
                'condition' => [
                    'sa_el_show_excerpt' => '1',
                ],
            ]
        );
        $this->add_control(
            'sa_el_show_read_more_button',
            [
                'label' => __('Show Read More Button', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-ban',
                    ],
                ],
                'default' => '1',
            ]
        );

        $this->add_control(
            'read_more_button_text',
            [
                'label' => __('Button Text', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::TEXT,
                'default' => __('Read More', SA_EL_ADDONS_TEXTDOMAIN),
                'condition' => [
                    'sa_el_show_read_more_button' => '1',
                ],
            ]
        );
        $this->add_control(
            'sa_el_show_meta',
            [
                'label' => __('Show Meta', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __('Yes', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __('No', SA_EL_ADDONS_TEXTDOMAIN),
                        'icon' => 'fa fa-ban',
                    ],
                ],
                'default' => '1',
            ]
        );

        $this->add_control(
            'meta_position',
            [
                'label' => esc_html__('Meta Position', SA_EL_ADDONS_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'default' => 'meta-entry-footer',
                'options' => [
                    'meta-entry-header' => esc_html__('Entry Header', SA_EL_ADDONS_TEXTDOMAIN),
                    'meta-entry-footer' => esc_html__('Entry Footer', SA_EL_ADDONS_TEXTDOMAIN),
                ],
                'condition' => [
                    'sa_el_show_meta' => '1',
                ],
            ]
        );
    }
    // Query Rander
    public function query_args($settings) {
        $settings = wp_parse_args($settings, [
            'post_type' => 'post',
            'orderby' => 'date',
            'order' => 'desc',
            'posts_per_page' => 3,
            'offset' => 0,
            'post__not_in' => [],
        ]);

        $args = [
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post_status' => 'publish',
            'posts_per_page' => $settings['posts_per_page'],
            'offset' => $settings['offset']
        ];
        $args['post_type'] = $settings['post_type'];
        $args['tax_query'] = [];
        if (!empty($settings['authors'])) {
            $args['author__in'] = $settings['authors'];
        }
        $type = $settings['post_type'];
        if (!empty($settings[$type . '_exclude'])) {
            $args['post__not_in'] = $settings[$type . '_exclude'];
        }
        if (!empty($settings[$type . '_include'])) {
            $args['post__in'] = $settings[$type . '_include'];
        }
        if ($type != 'page'):
            if (!empty($settings[$type . '_category'])):
                $args['tax_query'][] = [
                    'taxonomy' => $type . '_category',
                    'field' => 'term_id',
                    'terms' => $settings[$type . '_category'],
                ];
            endif;
            if (!empty($settings[$type . '_tag'])):
                $args['tax_query'][] = [
                    'taxonomy' => $type . '_tag',
                    'field' => 'term_id',
                    'terms' => $settings[$type . '_tag'],
                ];
            endif;
            if (!empty($args['tax_query'])):
                $args['tax_query']['relation'] = 'OR';
            endif;
        endif;
        return $args;
    }

    // All Query start
    public static function post_type() {
        return get_post_types(array('public' => true, 'show_in_nav_menus' => true), 'names');
    }

    public static function post_author() {
        $us = [];
        $users = get_users();
        if ($users) {
            foreach ($users as $user) {
                $us[$user->ID] = ucfirst($user->display_name);
            }
        }
        return $us;
    }

    public static function post_category($type) {
        $cat = [];
        $categories = get_terms(array(
            'taxonomy' => $type == 'post' ? 'category' : $type . '_category',
            'hide_empty' => true,
        ));
        if (empty($categories) || is_wp_error($categories)):
            return [];
        endif;

        foreach ($categories as $categorie) {
            $cat[$categorie->term_id] = ucfirst($categorie->name);
        }
        return $cat;
    }

    public static function post_tags($type) {
        $tg = [];
        $tags = get_terms(array(
            'taxonomy' => $type . '_tag',
            'hide_empty' => true,
        ));
        if (empty($tags) || is_wp_error($tags)):
            return [];
        endif;

        foreach ($tags as $tag) {
            $tg[$tag->term_id] = ucfirst($tag->name);
        }

        return $tg;
    }

    public static function post_include($type) {
        $post_list = get_posts(array(
            'post_type' => $type,
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => -1,
        ));
        if (empty($post_list) && is_wp_error($post_list)):
            return [];
        endif;
        $posts = array();
        foreach ($post_list as $post) {
            $posts[$post->ID] = ucfirst($post->post_title);
        }
        return $posts;
    }

    public static function post_exclude($type) {
        $post_list = get_posts(array(
            'post_type' => $type,
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => -1,
        ));
        if (empty($post_list) && is_wp_error($post_list)):
            return [];
        endif;
        $posts = array();
        foreach ($post_list as $post) {
            $posts[$post->ID] = ucfirst($post->post_title);
        }
        return $posts;
    }

    public static function thumbnail_sizes() {
        $default_image_sizes = get_intermediate_image_sizes();
        $thumbnail_sizes = array();
        foreach ($default_image_sizes as $size) {
            $image_sizes[$size] = $size . ' - ' . intval(get_option("{$size}_size_w")) . ' x ' . intval(get_option("{$size}_size_h"));
            $thumbnail_sizes[$size] = str_replace('_', ' ', ucfirst($image_sizes[$size]));
        }
        return $thumbnail_sizes;
    }

    /**
     * POst Orderby Options
     *
     */
    public static function get_post_orderby_options() {
        $orderby = array(
            'ID' => 'Post ID',
            'author' => 'Post Author',
            'title' => 'Title',
            'date' => 'Date',
            'modified' => 'Last Modified Date',
            'parent' => 'Parent Id',
            'rand' => 'Random',
            'comment_count' => 'Comment Count',
            'menu_order' => 'Menu Order',
        );

        return $orderby;
    }
    // All Query End
}