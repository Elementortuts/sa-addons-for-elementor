<?php

/**
 * Plugin Name: Elementor Addons - Premium Elementor Addons with Templates & Blocks 
 * Description: Ultimate elements library for Elementor WordPress Page Builder. Premium elements with endless customization options.
 * Plugin URI: https://www.sa-elementor-addons.com
 * Version: 8.0.0
 * Author: biplob018
 * Author URI: https://www.oxilab.org/
 * Text Domain: sa-el-addons
 */
if (!defined('ABSPATH'))
    exit;
// Exit if accessed directly

/**
 * Defining plugin constants.
 *
 * @since 8.0.0
 */
define('SA_EL_ADDONS_FILE', __FILE__);
define('SA_EL_ADDONS_BASENAME', plugin_basename(__FILE__));
define('SA_EL_ADDONS_PATH', plugin_dir_path(__FILE__));
define('SA_EL_ADDONS_URL', plugins_url('/', __FILE__));
define('SA_EL_ADDONS_PLUGIN_VERSION', '8.0.0');
define('SA_EL_ADDONS_TEXTDOMAIN', 'sa-el-addons');
$upload = wp_upload_dir();
define('SA_EL_ADDONS_ASSETS', $upload['basedir'] . '/sa-el-addons/');
/**
 * Including composer autoloader globally.
 *
 * @since 8.0.0
 */
require_once SA_EL_ADDONS_PATH . 'autoloader.php';

/**
 * Run plugin after all others plugins
 *
 * @since 8.0.0
 */
add_action('plugins_loaded', function () {
    \SA_EL_ADDONS\Classes\Bootstrap::instance();
});


/**
 * Activation hook
 *
 * @since 8.0.0
 */
register_activation_hook(__FILE__, function () {
    $Installation = new \SA_EL_ADDONS\Classes\Installation();
    $Installation->plugin_activation_hook();
});

/**
 * Deactivation hook
 *
 * @since 8.0.0
 */
register_deactivation_hook(__FILE__, function () {
    $Installation = new \SA_EL_ADDONS\Classes\Installation();
    $Installation->plugin_deactivation_hook();
});

/**
 * Upgrade hook
 *
 * @since 8.0.0
 */
add_action('upgrader_process_complete', function ($upgrader_object, $options) {
    $Installation = new \SA_EL_ADDONS\Classes\Installation();
    $Installation->plugin_upgrade_hook($upgrader_object, $options);
}, 10, 2);
