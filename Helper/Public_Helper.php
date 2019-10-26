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
            return FALSE;
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
        $installed = json_decode(get_option('shortcode-addons-elementor'), true);
        if (empty($installed)) {
            $installed = [];
            $D = \SA_EL_ADDONS\Classes\Rest_API::get_instance()->Register_Elements();
            foreach ($D as $key => $value) {
                if (array_key_exists('Premium', $value) == FALSE || $value['Premium'] == false):
                    $installed[$key] = 'on';
                endif;
            }
            $update = json_encode($installed);
            update_option('shortcode-addons-elementor', $update);
        }
        ksort($installed);
        return $installed;
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

    /**
     * Get Gravity Form [ if exists ]
     *
     * @return array
     */
    public function select_gravity_form() {
        $options = array();

        if (class_exists('GFCommon')) {
            $gravity_forms = \RGFormsModel::get_forms(null, 'title');

            if (!empty($gravity_forms) && !is_wp_error($gravity_forms)) {

                $options[0] = esc_html__('Select Gravity Form', SA_EL_ADDONS_TEXTDOMAIN);
                foreach ($gravity_forms as $form) {
                    $options[$form->id] = $form->title;
                }
            } else {
                $options[0] = esc_html__('Create a Form First', SA_EL_ADDONS_TEXTDOMAIN);
            }
        }

        return $options;
    }

    public function sl_enqueue_scripts() {
        if (!$this->has_cache_files()) {
            $this->generate_scripts(array_keys($this->Get_Active_Elements()));
        }
        wp_enqueue_style(SA_EL_ADDONS_TEXTDOMAIN, content_url('uploads/' . SA_EL_ADDONS_TEXTDOMAIN . '/' . SA_EL_ADDONS_TEXTDOMAIN . '.min.css'));
        wp_enqueue_script(SA_EL_ADDONS_TEXTDOMAIN . '-js', content_url('uploads/' . SA_EL_ADDONS_TEXTDOMAIN . '/' . SA_EL_ADDONS_TEXTDOMAIN . '.min.js'), ['jquery']);
        wp_localize_script(SA_EL_ADDONS_TEXTDOMAIN . '-js', 'sa_el_addons_loader', array('ajaxurl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('sa-el-addons-loader')));
        // hook extended assets
        do_action(SA_EL_ADDONS_TEXTDOMAIN . '/after_enqueue_scripts', $this->has_cache_files());
        if (defined('FLUENTFORM')) {
            wp_enqueue_style(
                    'fluent-form-styles', WP_PLUGIN_URL . '/fluentform/public/css/fluent-forms-public.css', array(), FLUENTFORM_VERSION
            );

            wp_enqueue_style(
                    'fluentform-public-default', WP_PLUGIN_URL . '/fluentform/public/css/fluentform-public-default.css', array(), FLUENTFORM_VERSION
            );
        }
        // Gravity forms Compatibility
        if (class_exists('GFCommon')) {
            foreach ($this->select_gravity_form() as $form_id => $form_name) {
                if ($form_id != '0') {
                    gravity_form_enqueue_scripts($form_id);
                }
            }
        }
        // Caldera forms compatibility
        if (class_exists('Caldera_Forms')) {
            add_filter('caldera_forms_force_enqueue_styles_early', '__return_true');
        }
        // WPforms compatibility
        if (function_exists('wpforms')) {
            wpforms()->frontend->assets_css();
        }
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

    //register our settings
    public function plugin_settings() {
        register_setting('oxielementoraddonsuserdata-group', 'oxi_addons_user_permission');
    }

    public function license() {
        register_setting('sa_el_oxilab_license', 'sa_el_oxilab_license_key', [$this, 'sa_el_oxilab_license_key']);
        
        if (isset($_POST['sa_el_oxilab_activate'])):
            if (!check_admin_referer('sa_el_oxilab_nonce', 'sa_el_oxilab_nonce'))
                return;
            $license = trim(get_option('sa_el_oxilab_license_key'));
            $plugin = 'Elementor Addons';
            $VENDOR = 'https://www.oxilab.org';
            $api_params = array(
                'edd_action' => 'activate_license',
                'license' => $license,
                'item_name' => urlencode($plugin),
                'url' => home_url()
            );
            $response = wp_remote_post($VENDOR, array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));
            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)):
                if (is_wp_error($response)):
                    $message = $response->get_error_message();
                else:
                    $message = __('An error occurred, please try again.');
                endif;
            else:
                $license_data = json_decode(wp_remote_retrieve_body($response));
                if (false === $license_data->success):
                    switch ($license_data->error) {
                        case 'expired' :
                            $message = sprintf(
                                    __('Your license key expired on %s.'), date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')))
                            );
                            break;
                        case 'revoked' :
                            $message = __('Your license key has been disabled.');
                            break;
                        case 'missing' :
                            $message = __('Invalid license.');
                            break;
                        case 'invalid' :
                        case 'site_inactive' :
                            $message = __('Your license is not active for this URL.');
                            break;
                        case 'item_name_mismatch' :
                            $message = sprintf(__('This appears to be an invalid license key for %s.'), SA_EL_ADDONS_TEXTDOMAIN);
                            break;
                        case 'no_activations_left':
                            $message = __('Your license key has reached its activation limit.');
                            break;
                        default :
                            $message = __('An error occurred, please try again.');
                            break;
                    }
                endif;
            endif;
            if (!empty($message)):
                $base_url = admin_url('admin.php?page=sa-el-addons-settings');
                $redirect = add_query_arg(array('sa_el_activation' => 'false', 'message' => urlencode($message)), $base_url);
                wp_redirect($redirect);
                exit();
            endif;
            update_option('oxi_addons_license_status', $license_data->license);
            wp_redirect(admin_url('admin.php?page=sa-el-addons-settings'));
            exit();
        endif;

        if (isset($_POST['sa_el_oxilab_deactivate'])) {
            if (!check_admin_referer('sa_el_oxilab_nonce', 'sa_el_oxilab_nonce'))
                return;
            $license = trim(get_option('sa_el_oxilab_license_key'));
            $plugin = 'Elementor Addons';
            $VENDOR = 'https://www.oxilab.org';
            $api_params = array(
                'edd_action' => 'deactivate_license',
                'license' => $license,
                'item_name' => urlencode($plugin),
                'url' => home_url()
            );
            $response = wp_remote_post($VENDOR, array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));
            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
                if (is_wp_error($response)) {
                    $message = $response->get_error_message();
                } else {
                    $message = __('An error occurred, please try again.');
                }
                $base_url = admin_url('admin.php?page=sa-el-addons-settings');
                $redirect = add_query_arg(array('sa_el_activation' => 'false', 'message' => urlencode($message)), $base_url);
                wp_redirect($redirect);
                exit();
            }
            $license_data = json_decode(wp_remote_retrieve_body($response));
            if ($license_data->license == 'deactivated') {
                delete_option('oxi_addons_license_status');
            }
            wp_redirect(admin_url('admin.php?page=sa-el-addons-settings'));
            exit();
        }

        if (isset($_GET['sa_el_activation']) && !empty($_GET['message'])) {
            switch ($_GET['sa_el_activation']) {
                case 'false':
                    $message = urldecode($_GET['message']);
                    ?>
                    <div class="error">
                        <p><?php echo $message; ?></p>
                    </div>
                    <?php
                    break;
                case 'true':
                default:
                    break;
            }
        }
    }

    public function sa_el_oxilab_license_key($new) {
        $old = get_option('sa_el_oxilab_license_key');
        if ($old && $old != $new) {
            delete_option('oxi_addons_license_status');
        }
        return $new;
    }

    /**
     * Admin Notice Check
     *
     * @since 2.0.0
     */
    public function admin_notice_status() {

        $data = get_option('elementor-addons-reviews-notice');
        return $data;
    }

    /**
     * Admin Install date Check
     *
     * @since 2.0.0
     */
    public function installation_date() {
        $data = get_option('elementor-addons-reviews-date');
        if (empty($data)):
            $data = strtotime("now");
            update_option('elementor-addons-reviews-date', $data);
        endif;
        return $data;
    }

    /**
     * Admin Notice
     *
     * @since 2.0.0
     */
    public function admin_notice() {
        if (!empty($this->admin_notice_status())):
            return;
        endif;
        if (strtotime('-7 days') < $this->installation_date()):
            return;
        endif;
        new \SA_EL_ADDONS\Classes\Admin\Support_Reviews();
    }

    public function sa_el_addons_loader() {
        if (isset($_POST['_wpnonce']) && wp_verify_nonce(sanitize_key(wp_unslash($_POST['_wpnonce'])), 'sa-el-addons-loader')):

            $class = isset($_POST['class']) ? '\\' . str_replace('\\\\', '\\', sanitize_text_field($_POST['class'])) : '';
            $function = isset($_POST['function']) ? sanitize_text_field($_POST['function']) : '';
            $settings = isset($_POST['settings']) ? sanitize_post($_POST['settings']) : '';
            $args = isset($_POST['args']) ? sanitize_post($_POST['args']) : '';
            $optional = isset($_POST['optional']) ? sanitize_text_field($_POST['optional']) : '';
            if (!empty($class) && !empty($function)):
                $class::$function($args, $settings, $optional);
            endif;
        else:
            return;
        endif;
        die();
    }

}
