<?php

namespace SA_EL_ADDONS\Elements\Post_Grid\Files;

if (!defined('ABSPATH')) {
    exit;
}

Class Post_Query {

    public function __construct() {
        
    }

    public static function __ajax_template($args, $settings, $optional) {
        if(!is_array($args)):
            $args = json_decode($args, TRUE);
        endif;
        $args ['offset'] = (int) $args['offset'] + (((int) $optional - 1) * (int) $args['posts_per_page']);
        if(!is_array($settings)):
            $settings = json_decode($settings, TRUE);
        endif;
        echo self::__post_template($args, $settings);
    }

    public static function __post_template($args, $settings) {
        $query = new \WP_Query($args);
        ob_start();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo '<article class="sa-el-grid-post sa-el-post-grid-column">
                    <div class="sa-el-grid-post-holder">
                        <div class="sa-el-grid-post-holder-inner">';
                if (has_post_thumbnail() && $settings['sa_el_show_image'] == 1) {
                    echo '<div class="sa-el-entry-media">';
                    if ('none' !== $settings['sa_el_post_grid_hover_animation']) {
                        echo '<div class="sa-el-entry-overlay ' . $settings['sa_el_post_grid_hover_animation'] . '">';
                        if (isset($settings['sa_el_post_grid_bg_hover_icon']['url'])) {
                            echo '<img src="' . esc_url($settings['sa_el_post_grid_bg_hover_icon']['url']) . '" alt="' . esc_attr(get_post_meta($settings['sa_el_post_grid_bg_hover_icon']['id'], '_wp_attachment_image_alt', true)) . '" />';
                        } else {
                            echo '<i class="' . $settings['sa_el_post_grid_bg_hover_icon'] . '" aria-hidden="true"></i>';
                        }
                        echo '<a href="' . get_the_permalink() . '"></a>';
                        echo '</div>';
                    }

                    echo '<div class="sa-el-entry-thumbnail">
                                        <img src="' . esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])) . '" alt="' . esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) . '">
                                    </div>';
                    echo '</div>';
                }

                if ($settings['sa_el_show_title'] || $settings['sa_el_show_meta'] || $settings['sa_el_show_excerpt']) {
                    echo '<div class="sa-el-entry-wrapper">
                                    <header class="sa-el-entry-header">';
                    if ($settings['sa_el_show_title']) {
                        echo '<h2 class="sa-el-entry-title"><a class="sa-el-grid-post-link" href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h2>';
                    }

                    if ($settings['sa_el_show_meta'] && $settings['meta_position'] == 'meta-entry-header') {
                        echo '<div class="sa-el-entry-meta">
                                <span class="sa-el-posted-by">' . get_the_author_meta('display_name') . '</span>
                                <span class="sa-el-posted-on"><time datetime="' . get_the_date() . '">' . get_the_date() . '</time></span>
                            </div>';
                    }
                    echo '</header>';

                    if ($settings['sa_el_show_excerpt']) {
                        echo '<div class="sa-el-entry-content">
                                            <div class="sa-el-grid-post-excerpt">
                                                <p>' . implode(" ", array_slice(explode(" ", strip_tags(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()))), 0, $settings['sa_el_excerpt_length'])) . $settings['expanison_indicator'] . '</p>';
                        if ($settings['sa_el_show_read_more_button']) {
                            echo '<a href="' . get_the_permalink() . '" class="sa-el-post-elements-readmore-btn">' . esc_attr($settings['read_more_button_text']) . '</a>';
                        }
                        echo '</div>
                                        </div>';
                    }
                    echo '</div>';

                    if ($settings['sa_el_show_meta'] && $settings['meta_position'] == 'meta-entry-footer') {
                        echo '<div class="sa-el-entry-footer">
                                        <div class="sa-el-author-avatar">
                                            <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_avatar(get_the_author_meta('ID'), 96) . '</a>
                                        </div>
                                        <div class="sa-el-entry-meta">
                                            <div class="sa-el-posted-by">' . get_the_author_posts_link() . '</div>
                                            <div class="sa-el-posted-on"><time datetime="' . get_the_date() . '">' . get_the_date() . '</time></div>
                                        </div>
                                    </div>';
                    }
                }
                echo '</div>
                    </div>
                </article>';
            }
        } else {
            _e('<p class="no-posts-found">No posts found!</p>', SA_EL_ADDONS_TEXTDOMAIN);
        }
        wp_reset_postdata();

        return ob_get_clean();
    }

}
