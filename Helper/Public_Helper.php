<?php

namespace SA_EL_ADDONS\Helper;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Public_Helper
 *
 * @author biplo
 */
trait Public_Helper {

    /**
     * Plugin admin menu
     *
     * @since 1.0.0
     */
    public function check_version($agr) {
        $vs = get_option($this->fixed_data('6f78695f6164646f6e735f6c6963656e73655f737461747573'));
        if ($vs == $this->fixed_data('76616c6964')) {
            return TRUE;
        } else {
            return TRUE;
        }
    }

    /**
     * Plugin fixed
     *
     * @since 1.0.0
     */
    public function fixed_data($agr) {
        return hex2bin($agr);
    }

    /**
     * Remove files in dir
     *
     * @since 1.0.0
     */
    public function empty_dir($path) {
        if (!is_dir($path) || !file_exists($path)) {
            return;
        }

        foreach (scandir($path) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            unlink($this->public_safe_path($path . DIRECTORY_SEPARATOR . $item));
        }
    }

    /**
     * Generate safe path
     * @since v1.0.0
     */
    public function public_safe_path($path) {
        $path = str_replace(['//', '\\\\'], ['/', '\\'], $path);

        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }

    /**
     * Generate safe path
     * @since v1.0.0
     */
    public function check_folder($path) {
        $path = str_replace(['//', '\\\\'], ['/', '\\'], $path);

        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }

    public function Get_Active_Elements() {
        $installed = get_option('shortcode-addons-elementor');
        if (empty($installed) || $installed == '') {
            $installed = 'accordion=on&button=on&tabs=on&feature_list=on&flip_box=on&info_box=on&tooltip=on&single_product=on&team_member=on&testimonial=on&toggle=on&card=on&icon_box=on&number=on÷r=on&counter=on&count_down=on&image_hotspots=on&interactive_card=on&interactive_promo=on&progress_bar=on&protected_content=on&call_to_action=on&pricing_table=on';
            update_option('shortcode-addons-elementor', $installed);
        }

        parse_str($installed, $settings);
        ksort($settings);
        return $settings;
    }

    public function Get_Registered_elements($force_update = FALSE) {
        return \SA_EL_ADDONS\Classes\Rest_API::get_instance()->Register_Elements($force_update);
    }

    /**
     * Register widgets
     *
     * @since v1.6.0
     */
    public function register_elements($widgets_manager) {
        $active_elements = $this->Get_Active_Elements();
        foreach ($active_elements as $key => $active_element) {
            if (array_key_exists($key, $this->registered_elements) && class_exists($this->registered_elements[$key]['class'])) {
                if ($this->registered_elements[$key]['category'] == 'Extension') {
                    new $this->registered_elements[$key]['class'];
                } else {
                    $widgets_manager->register_widget_type(new $this->registered_elements[$key]['class']);
                }
            }
        }
    }

    public function has_cache_files($post_type = null, $post_id = null) {
        $css_path = SA_EL_ADDONS_ASSETS . ($post_type ? SA_EL_ADDONS_TEXTDOMAIN . $post_type : SA_EL_ADDONS_TEXTDOMAIN) . ($post_id ? '-' . $post_id : '') . '.min.css';
        $js_path = SA_EL_ADDONS_ASSETS . ($post_type ? SA_EL_ADDONS_TEXTDOMAIN . $post_type : SA_EL_ADDONS_TEXTDOMAIN) . ($post_id ? '-' . $post_id : '') . '.min.js';

        if (is_readable($this->safe_path($css_path)) && is_readable($this->safe_path($js_path))) {
            return true;
        }

        return false;
    }

    public function sl_enqueue_scripts() {
        if (!$this->has_cache_files()) {
            $this->generate_scripts(array_keys($this->Get_Active_Elements()));
        }
        wp_enqueue_style(SA_EL_ADDONS_TEXTDOMAIN, content_url('uploads/' . SA_EL_ADDONS_TEXTDOMAIN . '/' . SA_EL_ADDONS_TEXTDOMAIN . '.min.css'));
        wp_enqueue_script(SA_EL_ADDONS_TEXTDOMAIN . '-js', content_url('uploads/' . SA_EL_ADDONS_TEXTDOMAIN . '/' . SA_EL_ADDONS_TEXTDOMAIN . '.min.js'), ['jquery']);
        // hook extended assets
        do_action(SA_EL_ADDONS_TEXTDOMAIN . '/after_enqueue_scripts', $this->has_cache_files());
    }

    public function enqueue_editor_scripts() {
        wp_enqueue_style(SA_EL_ADDONS_TEXTDOMAIN . '-before', SA_EL_ADDONS_URL . '/assets/css/before-elementor.css', false, SA_EL_ADDONS_TEXTDOMAIN);
        wp_enqueue_script(SA_EL_ADDONS_TEXTDOMAIN . '-before', SA_EL_ADDONS_URL . '/assets/js/before-elementor.js', false, SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function font_familly_validation($data = []) {
        foreach ($data as $value) {
            wp_enqueue_style('' . $value . '', 'https://fonts.googleapis.com/css?family=' . $value . '');
        }
    }

}
