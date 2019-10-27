<?php

namespace SA_EL_ADDONS\Elements\Post_Carousel\Files;

if (!defined('ABSPATH')) {
    exit;
}

class Post_Query
{

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
                <div class="swiper-slide">
                    <?php
                        $post_hover_style = !empty($settings['sa_el_post_block_hover_animation']) ? ' grid-hover-style-' . $settings['sa_el_post_block_hover_animation'] : 'none';
                        $post_carousel_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);

                     ?>
                    <article class="sa-el-grid-post sa-el-post-grid-column">
                        <div class="sa-el-grid-post-holder">
                            <div class="sa-el-grid-post-holder-inner">
                                <?php if (has_post_thumbnail() && $settings['sa_el_show_image'] == 1) : ?>
                                    <div class="sa-el-entry-media <?php echo esc_attr($post_hover_style); ?>">

                                        <?php if (isset($settings['sa_el_post_block_hover_animation']) && 'none' !== $settings['sa_el_post_block_hover_animation']) : ?>
                                            <div class="sa-el-entry-overlay<?php echo ' ' . esc_attr($settings['sa_el_post_block_hover_animation']); ?>">
                                                <?php if (!empty($settings['sa_el_post_grid_bg_hover_icon'])) : ?>
                                                    <i class="<?php echo esc_attr($settings['sa_el_post_grid_bg_hover_icon']); ?>" aria-hidden="true"></i>
                                                <?php else : ?>
                                                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                                <?php endif; ?>
                                                <a href="<?php echo get_permalink(); ?>"></a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($post_carousel_image)) : ?>
                                            <div class="sa-el-entry-thumbnail">
                                                <img src="<?php echo esc_url($post_carousel_image); ?>" alt="<?php echo esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)); ?>">
                                                <a href="<?php the_permalink(); ?>"></a>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                <?php endif; ?>

                                <?php
                                                if (
                                                    $settings['sa_el_show_title']
                                                    || $settings['sa_el_show_meta']
                                                    || $settings['sa_el_show_excerpt']
                                                ) :
                                                    ?>
                                    <div class="sa-el-entry-wrapper">
                                        <header class="sa-el-entry-header">
                                            <?php if ($settings['sa_el_show_title']) { ?>
                                                <h2 class="sa-el-entry-title"><a class="sa-el-grid-post-link" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                                            <?php } ?>

                                            <?php if ($settings['sa_el_show_meta'] && $settings['meta_position'] == 'meta-entry-header') { ?>
                                                <div class="sa-el-entry-meta">
                                                    <span class="sa-el-posted-by"><?php the_author_posts_link(); ?></span>
                                                    <span class="sa-el-posted-on"><time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time></span>
                                                </div>
                                            <?php } ?>
                                        </header>

                                        <?php if ($settings['sa_el_show_excerpt']) { ?>
                                            <div class="sa-el-entry-content">
                                                <div class="sa-el-grid-post-excerpt">
                                                    <p><?php echo implode(" ", array_slice(explode(" ", strip_tags(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()))), 0, $settings['sa_el_excerpt_length'])) . $settings['expanison_indicator']; ?></p>

                                                    <?php if ($settings['sa_el_show_read_more_button']) : ?>
                                                        <a href="<?php the_permalink(); ?>" class="sa-el-post-elements-readmore-btn"><?php echo esc_attr($settings['read_more_button_text']); ?></a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <?php if ($settings['sa_el_show_meta'] && $settings['meta_position'] == 'meta-entry-footer') { ?>
                                        <div class="sa-el-entry-footer">
                                            <div class="sa-el-author-avatar">
                                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')); ?>"><?php echo get_avatar(get_the_author_meta('ID'), 96); ?> </a>
                                            </div>
                                            <div class="sa-el-entry-meta">
                                                <div class="sa-el-posted-by"><?php the_author_posts_link(); ?></div>
                                                <div class="sa-el-posted-on"><time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time></div>
                                            </div>
                                        </div>
                                    <?php } ?>


                            </div>

                        <?php endif; ?>
                        </div>
                    </article>
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
