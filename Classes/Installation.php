<?php

namespace SA_EL_ADDONS\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Installation
 * Content of Elementor Addons Plugins
 *
 * @author $biplob018
 */
    
class Installation {
    use \SA_EL_ADDONS\Helper\Public_Helper;

    protected static $lfe_instance = NULL;

    /**
     * Access plugin instance. You can create further instances by calling
     */
    public static function get_instance() {
        if (NULL === self::$lfe_instance)
            self::$lfe_instance = new self;

        return self::$lfe_instance;
    }

    /**
     * Plugin activation hook
     *
     * @since 1.0.0
     */
    public function plugin_activation_hook() {
        // remove old cache files
        $this->empty_dir(SA_EL_ADDONS_ASSETS);

        // save default values
        $this->Get_Active_Elements();
    }

    /**
     * Plugin deactivation hook
     *
     * @since 3.0.0
     */
    public function plugin_deactivation_hook() {
        $this->empty_dir(SA_EL_ADDONS_ASSETS);
    }

    /**
     * Plugin upgrade hook
     *
     * @since 1.0.0
     */
    public function plugin_upgrade_hook($upgrader_object, $options) {
        if ($options['action'] == 'update' && $options['type'] == 'plugin') {
            if (isset($options['plugins'][SA_EL_ADDONS_BASENAME])) {
                $this->empty_dir(SA_EL_ADDONS_ASSETS);
            }
        }
    }

}
