<?php

namespace SA_EL_ADDONS\Helper;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Scripts_Loader
 *
 * @author biplo
 */
trait Scripts_Loader {

    /**
     * Collect dependencies for modules
     *
     * @since 1.0.0
     */
    public function generate_dependency(array $elements, $type) {
        $paths = [];

        foreach ($elements as $element) {
            if (array_key_exists($element, $this->registered_elements)) {
                if (!empty($this->registered_elements[$element]['dependency'][$type])) {
                    foreach ($this->registered_elements[$element]['dependency'][$type] as $path) {
                        $paths[] = $path;
                    }
                }
            }
        }

        return array_unique($paths);
    }

    public function minify($data = '') {
        $data = preg_replace('/\/\*((?!\*\/).)*\*\//', ' ', $data);
        $data = preg_replace('/\s{2,}/', ' ', $data);
        $data = preg_replace('/\s*([:;{}])\s*/', '$1', $data);
        $data = preg_replace('/;}/', ' }', $data);
        return $data;
    }

    /**
     * Combine files into one
     *
     * @since 1.0.0
     */
    public function combine_files($paths = array(), $file = 'sa-el-addons.min.css') {
        $output = '';

        if (!empty($paths)) {
            foreach ($paths as $path) {
                $output .= $this->minify(file_get_contents($this->safe_path($path)));
            }
        }
        return file_put_contents($this->safe_path(SA_EL_ADDONS_ASSETS . $file), $output);
    }

    /**
     * Created minify CSS JS for modules
     *
     * @since 1.0.0
     */
    public function generate_scripts($elements, $file_name = null) {
        if (empty($elements)) {
            return;
        }
        $cachedir = SA_EL_ADDONS_ASSETS;
        // if folder not exists, create new folder
        if (!file_exists($cachedir)) {
            wp_mkdir_p($cachedir);
        }
        // collect sa-el-addons js
        $js_paths = array(
            SA_EL_ADDONS_PATH . 'assets/js/jquery.js',
        );
        $css_paths = array(
            SA_EL_ADDONS_PATH . 'assets/css/style.css',
        );

        // collect library scripts & styles
        $js_paths = array_merge($js_paths, $this->generate_dependency($elements, 'js'));
        $css_paths = array_merge($css_paths, $this->generate_dependency($elements, 'css'));
//        // combine files

        $this->combine_files($css_paths, ($file_name ? $file_name : 'sa-el-addons') . '.min.css');
        $this->combine_files($js_paths, ($file_name ? $file_name : 'sa-el-addons') . '.min.js');
    }

    /**
     * Generate safe path
     * @since v1.0.0
     */
    public function safe_path($path) {
        $path = str_replace(['//', '\\\\'], ['/', '\\'], $path);

        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }

    /**
     * Admin Ajax Loader
     * @since v1.0.0
     */
    public function saelemetoraddons_settings() {
        if (isset($_POST['_wpnonce']) && wp_verify_nonce(sanitize_key(wp_unslash($_POST['_wpnonce'])), 'sa_elemetor_addons')):
            $functionname = isset($_POST['functionname']) ? sanitize_text_field($_POST['functionname']) : '';
            $rawdata = isset($_POST['rawdata']) ? sanitize_post($_POST['rawdata']) : '';
            $satype = isset($_POST['satype']) ? sanitize_text_field($_POST['satype']) : '';
            if (!empty($functionname) && !empty($rawdata)):
                new \SA_EL_ADDONS\Classes\Admin\Admin_Render($functionname, $rawdata, $satype);
            endif;
        else:
            return;
        endif;
        die();
    }

}
