<?php

namespace SA_EL_ADDONS\Elements\Content_Timeline\Files;

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
        $query = new \WP_Query($args);
        ob_start();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                ?>

                <div class="sa-el-content-timeline-block">
                    <div class="sa-el-content-timeline-line">
                        <div class="sa-el-content-timeline-inner"></div>
                    </div>
                    <div class="sa-el-content-timeline-img sa-el-picture <?php if ('bullet' === $settings['sa_el_show_image_or_icon']) : echo 'sa-el-content-timeline-bullet';
                                                                                        endif; ?>">
                        <?php if ('img' === $settings['sa_el_show_image_or_icon']) : ?>
                            <img src="<?php echo esc_url($settings['sa_el_icon_image']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($settings['sa_el_icon_image']['id'], '_wp_attachment_image_alt', true)); ?>">
                        <?php endif; ?>
                        <?php if ('icon' === $settings['sa_el_show_image_or_icon']) : ?>
                            <i class="<?php echo esc_attr($settings['sa_el_content_timeline_circle_icon']); ?>"></i>
                        <?php endif; ?>
                    </div>

                    <div class="sa-el-content-timeline-content">
                        <?php if ('1' == $settings['sa_el_show_title']) : ?>
                            <h2><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo the_title(); ?></a></h2>
                        <?php endif; ?>
                        <?php if ('1' == $settings['sa_el_show_excerpt']) : ?>
                            <p><?php echo implode(" ", array_slice(explode(" ", strip_tags(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()))), 0, $settings['sa_el_excerpt_length'])) . $settings['expanison_indicator']; ?></p>
                        <?php endif; ?>
                        <?php if ('1' === $settings['sa_el_show_read_more'] && !empty($settings['sa_el_read_more_text'])) : ?>
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="sa-el-read-more"><?php echo esc_html__($settings['sa_el_read_more_text'], SA_EL_ADDONS_TEXTDOMAIN); ?></a>
                        <?php endif; ?>
                        <span class="sa-el-date"><?php echo get_the_date(); ?></span>
                    </div>
                </div>
<?php
            }
        } else {
            _e('<p class="no-posts-found">No posts found!</p>', SA_EL_ADDONS_TEXTDOMAIN);
        }

        wp_reset_postdata();

        return ob_get_clean();
    }
}
