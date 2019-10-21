<?php

namespace SA_EL_ADDONS\Classes\Admin;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Addons
 * Content of Shortcode Addons Plugins
 *
 * @author $biplob018
 */
class Settings {

    use \SA_EL_ADDONS\Helper\Public_Helper;

    public function __construct() {
      
        $this->menu();
        $this->CSS_JSS();
        $this->Handler();
        $this->Render();
    }


    /**
     * Plugin admin menu
     *
     * @since 1.0.0
     */
    public function menu() {
        echo apply_filters('sa-el-addons/admin_nav_menu', false);
    }

    /**
     * Plugin CSS_JSS
     *
     * @since 1.0.0
     */
    public function CSS_JSS() {
        wp_enqueue_style('sa-el-admin-css', SA_EL_ADDONS_URL . '/assets/css/admin.css', false, SA_EL_ADDONS_PLUGIN_VERSION);
        wp_enqueue_style('bootstrap.min-css', SA_EL_ADDONS_URL . '/assets/css/bootstrap.min.css', false, SA_EL_ADDONS_PLUGIN_VERSION);
        wp_enqueue_script("jquery");
        wp_enqueue_script('bootstrap.min', SA_EL_ADDONS_URL . '/assets/js/bootstrap.min.js', false, SA_EL_ADDONS_PLUGIN_VERSION);
        $this->font_familly_validation(['Bree+Serif', 'Source+Sans+Pro']);
    }

    /**
     * Plugin Handler
     *
     * @since 1.0.0
     */
    public function Handler() {
        wp_enqueue_script('sa-elemetor-addons-settings', SA_EL_ADDONS_URL . '/assets/js/settings.js', false, SA_EL_ADDONS_PLUGIN_VERSION);
    }

    /**
     * Plugin Elements Name Convert to View
     *
     * @since 1.0.0
     */
    public function name_converter($data) {
        $data = str_replace('_', ' ', $data);
        $data = str_replace('-', ' ', $data);
        $data = str_replace('+', ' ', $data);
        return ucwords($data);
    }

    /**
     * Plugin Render
     *
     * @since 1.0.0
     */
    public function Render() {
        global $wp_roles;
        $roles = $wp_roles->get_names();
        $saved_role = get_option('oxi_addons_user_permission');
        ?>
        <div class="wrap">  
            <div class="oxi-addons-wrapper">
                <div class="oxi-addons-row">
                    <h1><?php _e('Elementor Addons Settings'); ?></h1>
                    <p>Set Elementor Addons With Your Theme and Development.</p>
                    <form method="post" action="options.php" id="oxielementoraddonsuserdata">
                        <div class="oxi-addons-settings-tab-general">
                            <!--- first tab of settings page---->
                            <?php settings_fields('oxielementoraddonsuserdata-group'); ?>
        <?php do_settings_sections('oxielementoraddonsuserdata-group'); ?>
                            <table class="form-table">
                                <tr valign="top">
                                    <td scope="row">Who Can Edit?</td>
                                    <td>
                                        <select name="oxi_addons_user_permission">
                                            <?php foreach ($roles as $key => $role) { ?>
                                                <option value="<?php echo $key; ?>" <?php selected($saved_role, $key); ?>><?php echo $role; ?></option>
        <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <label class="description" for="oxi_addons_user_permission"><?php _e('Select the Role who can manage This Plugins.'); ?> <a target="_blank" href="https://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table">Help</a></label>
                                    </td>
                                </tr> 
                            </table>
                            <?php
                            submit_button();
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

}
