<?php

namespace SA_EL_ADDONS\Helper;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Elementor_Helper
 *
 * @author biplob018
 */
use \SA_EL_ADDONS\Classes\Front\Sa_Foreground_Control;
use Elementor\Icons_Manager;
use \Elementor\Controls_Manager as Controls_Manager;

trait Elementor_Helper {

    /**
     * Register Widget Category 
     *
     * @since v1.0.0
     */
    public function register_widget_categories($elements_manager) {
        $elements_manager->add_category(
                'sa-el-addons', [
            'title' => __('Shortcode Addons', SA_EL_ADDONS_TEXTDOMAIN),
            'icon' => 'font',
                ], 1
        );
    }

    /**
     * Add new elementor group control
     *
     * @since v1.0.0
     */
    public function register_controls_group($controls_manager) {
        $controls_manager->add_group_control('saforegroundcolor', new Sa_Foreground_Control);
    }

    /**
     * Get all elementor page templates
     *
     * @return array
     */
    public function get_elementor_page_templates($type = null) {
        $args = [
            'post_type' => 'elementor_library',
            'posts_per_page' => -1,
        ];

        if ($type) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'elementor_library_type',
                    'field' => 'slug',
                    'terms' => $type,
                ],
            ];
        }

        $page_templates = get_posts($args);
        $options = array();

        if (!empty($page_templates) && !is_wp_error($page_templates)) {
            foreach ($page_templates as $post) {
                $options[$post->ID] = $post->post_title;
            }
        } else {
            $options[] = 'No ' . ucfirst($type) . ' Found';
        }
        return $options;
    }

    /**
     * Get all User Roles
     *
     * @return array
     */
    public function sa_el_user_roles() {
        global $wp_roles;
        $all = $wp_roles->roles;
        $all_roles = array();
        if (!empty($all)) {
            foreach ($all as $key => $value) {
                $all_roles[$key] = $all[$key]['name'];
            }
        }
        return $all_roles;
    }

    /**
     * Protected Form Input Fields
     */
    public function sa_el_get_block_pass_protected_form($settings) {
        echo '<div class="sa-el-password-protected-content-fields">';
        echo '<form method="post">';
        echo '<input type="password" name="sa_protection_password" class="sa-el-password" placeholder="' . $settings['sa_protection_password_placeholder'] . '">';
        echo '<input type="submit" value="' . $settings['sa_protection_password_submit_btn_txt'] . '" class="sa-el-submit">';
        echo '</form>';
        if (isset($_POST['sa_protection_password']) && ($settings['sa_protection_password'] !== $_POST['sa_protection_password'])) {
            echo sprintf(__('<p class="protected-content-error-msg">Password does not match.</p>', SA_EL_ADDONS_TEXTDOMAIN));
        }
        echo '</div>';
    }

    /**
     *  Get all WordPress registered widgets
     *  @return array
     */
    public function sa_get_registered_sidebars() {
        global $wp_registered_sidebars;
        $options = [];

        if (!$wp_registered_sidebars) {
            $options[''] = __('No sidebars were found', SA_EL_ADDONS_TEXTDOMAIN);
        } else {
            $options['---'] = __('Choose Sidebar', SA_EL_ADDONS_TEXTDOMAIN);

            foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
                $options[$sidebar_id] = $sidebar['name'];
            }
        }
        return $options;
    }

    /**
     *  Price Table Feature Function
     */
    protected function render_feature_list($settings, $obj) {
        if (empty($settings['sa_el_pricing_table_items'])) {
            return;
        }

        $counter = 0;
        ?>
        <ul>
            <?php
            foreach ($settings['sa_el_pricing_table_items'] as $item) :

                if ('yes' !== $item['sa_el_pricing_table_icon_mood']) {
                    $obj->add_render_attribute('pricing_feature_item' . $counter, 'class', 'disable-item');
                }

                if ('yes' === $item['sa_el_pricing_item_tooltip']) {
                    $obj->add_render_attribute(
                            'pricing_feature_item' . $counter, [
                        'class' => 'tooltip',
                        'title' => $item['sa_el_pricing_item_tooltip_content'],
                        'id' => $obj->get_id() . $counter,
                            ]
                    );
                }

                if ('yes' == $item['sa_el_pricing_item_tooltip']) {

                    if ($item['sa_el_pricing_item_tooltip_side']) {
                        $obj->add_render_attribute('pricing_feature_item' . $counter, 'data-side', $item['sa_el_pricing_item_tooltip_side']);
                    }

                    if ($item['sa_el_pricing_item_tooltip_trigger']) {
                        $obj->add_render_attribute('pricing_feature_item' . $counter, 'data-trigger', $item['sa_el_pricing_item_tooltip_trigger']);
                    }

                    if ($item['sa_el_pricing_item_tooltip_animation']) {
                        $obj->add_render_attribute('pricing_feature_item' . $counter, 'data-animation', $item['sa_el_pricing_item_tooltip_animation']);
                    }

                    if (!empty($item['pricing_item_tooltip_animation_duration'])) {
                        $obj->add_render_attribute('pricing_feature_item' . $counter, 'data-animation_duration', $item['pricing_item_tooltip_animation_duration']);
                    }

                    if (!empty($item['sa_el_pricing_table_toolip_arrow'])) {
                        $obj->add_render_attribute('pricing_feature_item' . $counter, 'data-arrow', $item['sa_el_pricing_table_toolip_arrow']);
                    }

                    if (!empty($item['sa_el_pricing_item_tooltip_theme'])) {
                        $obj->add_render_attribute('pricing_feature_item' . $counter, 'data-theme', $item['sa_el_pricing_item_tooltip_theme']);
                    }
                }
                ?>
                <li <?php echo $obj->get_render_attribute_string('pricing_feature_item' . $counter); ?>>
                    <?php if ('show' === $settings['sa_el_pricing_table_icon_enabled']) : ?>
                        <span class="li-icon" style="color:<?php echo esc_attr($item['sa_el_pricing_table_list_icon_color']); ?>"><i class="<?php echo esc_attr($item['sa_el_pricing_table_list_icon']); ?>"></i></span>
                        <?php endif; ?>
                        <?php echo $item['sa_el_pricing_table_item']; ?>
                </li>
                <?php
                $counter++;
            endforeach;
            ?>
        </ul>
        <?php
    }

    /**
     * Elementor icon libray type

     */
    public function Sa_El_Icon_Type() {
        return (version_compare(ELEMENTOR_VERSION, '2.6', '>=') ? Controls_Manager::ICONS : Controls_Manager::ICON);
    }

    /**
     * Default icon class fa5 and fa4
     *
     */
    public function Sa_El_Default_Icon($FA5_Class, $libray, $FA4_Class) {
        return (version_compare(ELEMENTOR_VERSION, '2.6', '>=') ? ['value' => $FA5_Class, 'library' => $libray,] : $FA4_Class);
    }

    /**
     * Elementor icon render
     *
     * @return void
     */
    public function Sa_El_Icon_Render($settings) {
        if (version_compare(ELEMENTOR_VERSION, '2.6', '>=')) {
            ob_start();
            Icons_Manager::render_icon($settings, ['aria-hidden' => 'true']);
            $list = ob_get_contents();
            ob_end_clean();
            $rt = $list;
        } else {
            $rt = '<i aria-hidden="true" class="' . esc_attr($settings) . '"></i>';
        }
        return $rt;
    }

}
