<?php

namespace SA_EL_ADDONS\Classes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bootstrap
 *
 * @author biplo
 */
class Bootstrap {

    use \SA_EL_ADDONS\Helper\Scripts_Loader;
    use \SA_EL_ADDONS\Helper\Public_Helper;
    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';

    // instance container
    private static $instance = null;
    // registered elements container
    public $registered_elements;
    // transient elements container
    public $transient_elements;

    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __construct() {
        do_action('sa-el-addons/before_init');
        // Load translation
        add_action('init', array($this, 'i18n'));
        add_filter('sa-el-addons/check_version', array($this, 'check_version'));
        // Init Plugin
        $this->registered_elements = $this->Get_Registered_elements(); // register hooks

        $this->register_hooks();
        if (is_admin()) {
            $this->init();
            $this->Admin();
        }
    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     * Fired by `init` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function i18n() {
        load_plugin_textdomain('sa-el-addons');
    }

    public function Admin() {
        $this->admin_notice();
        add_action('admin_init', [$this, 'plugin_settings']);
        add_action('admin_init', [$this, 'license']);
        new \SA_EL_ADDONS\Classes\Admin\Admin();
        add_action('wp_ajax_saelemetoraddons_settings', array($this, 'saelemetoraddons_settings'));
    }

    // Elements
    public function register_hooks() {
        add_action('wp_ajax_sa_el_addons_loader', array($this, 'sa_el_addons_loader'));
        add_action('wp_ajax_nopriv_sa_el_addons_loader', [$this, 'sa_el_addons_loader']);
        add_action('elementor/elements/categories_registered', array($this, 'register_widget_categories'));
        add_action('elementor/controls/controls_registered', array($this, 'register_controls_group'));
        add_action('elementor/widgets/widgets_registered', array($this, 'register_elements'));

        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'sl_enqueue_scripts'));
        add_action('elementor/editor/after_enqueue_scripts', array($this, 'enqueue_editor_scripts'));
    }

    /**
     * Initialize the plugin
     *
     * Validates that Elementor is already loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed include the plugin class.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function init() {

        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', array($this, 'admin_notice_missing_main_plugin'));
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', array($this, 'admin_notice_minimum_elementor_version'));
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', array($this, 'admin_notice_minimum_php_version'));
            return;
        }
        // Once we get here, We have passed all validation checks so we can safely include our plugin
    }

    public function admin_notice_missing_main_plugin() {
        $screen = get_current_screen();
        if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
            return;
        }
        $plugin = 'elementor';
        $file_path = 'elementor/elementor.php';
        $installed_plugins = get_plugins();

        if (isset($installed_plugins[$file_path])) { // check if plugin is installed
            if (!current_user_can('activate_plugins')) {
                return;
            }
            $activation_url = wp_nonce_url(admin_url('plugins.php?action=activate&plugin=' . $file_path), 'activate-plugin_' . $file_path);

            $message = '<p><strong>' . __('Elementor Addons - Premium Elementor Addons with Templates & Blocks', SA_EL_ADDONS_TEXTDOMAIN) . '</strong>' . __(' widgets not working because you need to activate the Elementor plugin.', SA_EL_ADDONS_TEXTDOMAIN) . '</p>';
            $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $activation_url, __('Activate Elementor Now', SA_EL_ADDONS_TEXTDOMAIN)) . '</p>';
        } else {
            if (!current_user_can('install_plugins')) {
                return;
            }
            $install_url = wp_nonce_url(add_query_arg(array('action' => 'install-plugin', 'plugin' => $plugin), admin_url('update.php')), 'install-plugin' . '_' . $plugin);
            $message = '<p><strong>' . __('Elementor Addons - Premium Elementor Addons with Templates & Blocks', SA_EL_ADDONS_TEXTDOMAIN) . '</strong>' . __(' widgets not working because you need to install the Elementor plugin', SA_EL_ADDONS_TEXTDOMAIN) . '</p>';
            $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $install_url, __('Install Elementor Now', SA_EL_ADDONS_TEXTDOMAIN)) . '</p>';
        }

        echo '<div class="error"><p>' . $message . '</p></div>';
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_elementor_version() {
        if (!current_user_can('update_plugins')) {
            return;
        }

        $file_path = 'elementor/elementor.php';

        $upgrade_link = wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=') . $file_path, 'upgrade-plugin_' . $file_path);
        $message = '<p><strong>' . __('SA Elementor Addons', SA_EL_ADDONS_TEXTDOMAIN) . '</strong>' . __(' widgets not working because you are using an old version of Elementor.', SA_EL_ADDONS_TEXTDOMAIN) . '</p>';
        $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $upgrade_link, __('Update Elementor Now', SA_EL_ADDONS_TEXTDOMAIN)) . '</p>';
        echo '<div class="error">' . $message . '</div>';
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
                esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', SA_EL_ADDONS_TEXTDOMAIN),
                '<strong>' . esc_html__('SA Elementor Addons', SA_EL_ADDONS_TEXTDOMAIN) . '</strong>',
                '<strong>' . esc_html__('PHP', SA_EL_ADDONS_TEXTDOMAIN) . '</strong>',
                self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

}
