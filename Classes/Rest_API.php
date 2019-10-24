<?php

namespace SA_EL_ADDONS\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Rest_API
 * Content of Shortcode Addons Plugins
 *
 * @author $biplob018
 */
class Rest_API {

    protected static $lfe_instance = NULL;

    const MENU = 'get_oxilab_addons_menu';
    const TRANSIENT_TEMPLATE = 'sa_el_addons_template';
    const TRANSIENT_REGISTER_ELEMENTS = 'sa_el_addons_register_elements';
    const TRANSIENT_CATEGORY = 'sa_el_addons_category';
    const TEMPLATES = 'https://www.shortcode-addons.com/wp-json/shortcode-elementor/v1/category/template';
    const CATEGORIES = 'https://www.shortcode-addons.com/wp-json/shortcode-elementor/v1/category/';

    private static $template_url = 'https://www.shortcode-addons.com/wp-json/shortcode-elementor/v1/category/template/%d';

    public function __construct() {
        
    }

    /**
     * Access plugin instance. You can create further instances by calling
     */
    public static function get_instance() {
        if (NULL === self::$lfe_instance)
            self::$lfe_instance = new self;

        return self::$lfe_instance;
    }

    /**
     * Get  SA Elementor Addons Menu.
     * @return mixed
     */
    public function Menu($force_update = FALSE) {
        $res = get_transient(self::MENU);
        $response = (!$res ? [] : $res);
        if ($force_update) {
            $response['Elementor']['Addons'] = [
                'name' => 'Addons',
                'homepage' => 'sa-el-addons'
            ];
            $response['Elementor']['Template'] = [
                'name' => 'Template',
                'homepage' => 'sa-el-addons-template'
            ];
            $response['Elementor']['Blocks'] = [
                'name' => 'Blocks',
                'homepage' => 'sa-el-addons-blocks'
            ];
            $response['Elementor']['Pre-Design'] = [
                'name' => 'Pre-Design',
                'homepage' => 'sa-el-addons-pre-design'
            ];
            set_transient(self::MENU, $response, 10 * DAY_IN_SECONDS);
        }
        return $response;
    }

    /**
     * Get a templates list.
     * @return mixed|\WP_Error
     */
    public function Templates($force_update = FALSE) {

        $response = get_transient(self::TRANSIENT_TEMPLATE);

        if (!$response || $force_update) {

            $request = wp_remote_request(self::TEMPLATES);
            if (!is_wp_error($request)) {

                $response = json_decode(wp_remote_retrieve_body($request), true);
                set_transient(self::TRANSIENT_TEMPLATE, $response, 5 * DAY_IN_SECONDS);
            } else {
                $response = $request->get_error_message();
            }
        }

        return $response;
    }

    /**
     * Get a templates categories.
     * @return mixed|\WP_Error
     */
    public function Categories($force_update = FALSE) {
        $response = get_transient(self::TRANSIENT_CATEGORY);

        if (!$response || $force_update) {

            $request = wp_remote_request(self::CATEGORIES);
            if (!is_wp_error($request)) {

                $response = json_decode(wp_remote_retrieve_body($request), true);
                set_transient(self::TRANSIENT_CATEGORY, $response, 5 * DAY_IN_SECONDS);
            } else {
                $response = $request->get_error_message();
            }
        }
        return $response;
    }

    /**
     * Get a single template content.
     *
     * @param int $template_id Template ID.
     * @return mixed|\WP_Error
     */
    public function get_template_content($template_id) {
        $url = sprintf(self::$template_url, $template_id);

        $response = wp_remote_request($url);
        if (is_wp_error($response)) {
            return $response;
        }

        $response_code = (int) wp_remote_retrieve_response_code($response);
        if (200 !== $response_code) {
            return new \WP_Error('response_code_error', sprintf('The request returned with a status code of %s.', $response_code));
        }

        $template_content = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($template_content['error'])) {
            return new \WP_Error('response_error', $template_content['error']);
        }

        if (empty($template_content['content'])) {
            return new \WP_Error('template_data_error', 'An invalid data was returned.');
        }
        return $template_content;
    }

    /**
     * Get a single template content.
     *
     * @param int $template_id Template ID.
     * @return mixed|\WP_Error
     */
    public function Register_Elements($force_update = false) {
        $Register = get_transient(self::TRANSIENT_REGISTER_ELEMENTS);
        if (!$Register || $force_update) {
            $Register = [];
            $file = glob(SA_EL_ADDONS_PATH . 'Elements' . '/*', GLOB_ONLYDIR);
            foreach ($file as $V) {

                $F = explode('/Elements/', $V);
                if (file_exists(SA_EL_ADDONS_PATH . 'Elements' . '/' . $F[1] . '/Register.php')):
                    $R = include_once SA_EL_ADDONS_PATH . 'Elements' . '/' . $F[1] . '/Register.php';
                    if (is_array($R) && array_key_exists('name', $R)):
                        $Register[$R['name']] = $R;
                    endif;
                endif;
            }
            $file = glob(SA_EL_ADDONS_PATH . 'Extensions' . '/*', GLOB_ONLYDIR);
            foreach ($file as $V) {
                $F = explode('/Extensions/', $V);
                if (file_exists(SA_EL_ADDONS_PATH . 'Extensions' . '/' . $F[1] . '/Register.php')):
                    $R = include_once SA_EL_ADDONS_PATH . 'Extensions' . '/' . $F[1] . '/Register.php';
                    if (is_array($R) && array_key_exists('name', $R)):
                        $Register[$R['name']] = $R;
                    endif;
                endif;
            }
            set_transient(self::TRANSIENT_REGISTER_ELEMENTS, $Register, 5 * DAY_IN_SECONDS);
        }
        return $Register;
    }

}
