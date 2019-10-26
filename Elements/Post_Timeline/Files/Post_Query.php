<?php

namespace SA_EL_ADDONS\Elements\Post_Timeline\Files;

if (!defined('ABSPATH')) {
    exit;
}

class Post_Query
{
    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function __construct()
    { }

    public static function __ajax_template($args, $settings, $optional)
    {
        if (!is_array($args)) :
            $args = json_decode($args, TRUE);
        endif;
        $args['offset'] = (int) $args['offset'] + (((int) $optional - 1) * (int) $args['posts_per_page']);
        if (!is_array($settings)) :
            $settings = json_decode($settings, TRUE);
        endif;
        echo self::__post_template($args, $settings);
    }

    public static function __post_template($args, $settings)
    {
        $html = '';
        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $html .= '<article class="sa-el-timeline-post sa-el-timeline-column">
                            <div class="sa-el-timeline-bullet"></div>
                    <div class="sa-el-timeline-post-inner">
                        <a class="sa-el-timeline-post-link" href="' . get_the_permalink() . '" title="' . get_the_title() . '">
                            <time datetime="' . get_the_date() . '">' . get_the_date() . '</time>
                            <div class="sa-el-timeline-post-image" ' . ($settings['sa_el_show_image'] == 1 ? 'style="background-image: url(' . wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']) . ');"' : null) . '></div>';
                if ($settings['sa_el_show_excerpt']) {
                    $html .= '<div class="sa-el-timeline-post-excerpt">
                                    <p>' . implode(" ", array_slice(explode(" ", strip_tags(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()))), 0, $settings['sa_el_excerpt_length'])) . $settings['expanison_indicator'] . '</p>
                                </div>';
                }

                if ($settings['sa_el_show_title']) {
                    $html .= '<div class="sa-el-timeline-post-title">
                                    <h3>' . get_the_title() . '</h3>
                                    <div class="sa-el-author-avatar">
                                        <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_avatar(get_the_author_meta('ID'), 96) . '</a>
                                    </div>
                                </div>';
                }
                $html .= '</a>
                    </div>
                </article>';
            }
        } else {
            $html .= __('<p class="no-posts-found">No posts found!</p>', SA_EL_ADDONS_TEXTDOMAIN);
        }

        wp_reset_postdata();

        return $html;
    }
}
