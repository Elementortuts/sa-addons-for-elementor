<?php

namespace SA_EL_ADDONS\Classes\Admin;

if (!defined('ABSPATH')) {
    exit;
}

class Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_filter('sa-el-addons/admin_nav_menu', array($this, 'admin_nav_menu'));
        add_action('admin_head', array($this, 'menu_icon'));
    }

    /**
     * SA Elementor Addons menu Icon
     * @since 1.0.0
     */
    public function menu_icon() {
        ?>
        <style type='text/css' media='screen'>
            @keyframes SAGRADIENT {
                0%,
                100% {
                    background-position: 0 50%
                }
                50% {
                    background-position: 100% 50%
                }
            }
            #adminmenu li.menu-top.toplevel_page_sa-el-addons,
            #adminmenu li.menu-top.toplevel_page_sa-el-addons:hover,
            #adminmenu li.opensub > a.menu-top.toplevel_page_sa-el-addons,
            #adminmenu li > a.menu-top.toplevel_page_sa-el-addons:focus {
                background: linear-gradient(-45deg, #EE7752, #E73C7E, #23A6D5, #23D5AB)!important;
                animation: SAGRADIENT 15s ease infinite;
                background-size: 400% 400%!important;
                color: #fff!important;
            }
            #adminmenu #toplevel_page_sa-el-addons  div.wp-menu-image img {
                width: 26px!important;
                margin: 4px 5px;
                display: block;
                padding: 0;
                opacity: 1;
                filter: alpha(opacity=100);
            }
        </style>
        <?php

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
     * Plugin admin menu
     *
     * @since 1.0.0
     */
    public function admin_nav_menu($agr) {
        $elements = \SA_EL_ADDONS\Classes\Rest_API::get_instance()->Menu();
        if (!array_key_exists('Elementor', $elements)):
            $elements = \SA_EL_ADDONS\Classes\Rest_API::get_instance()->Menu(TRUE);
        endif;
        $bgimage = SA_EL_ADDONS_URL . 'image/sa-logo.png';
        $sub = '';

        $menu = '<div class="oxi-addons-wrapper">
                    <div class="oxilab-new-admin-menu">
                        <div class="oxi-site-logo">
                            <a href="' . admin_url('admin.php?page=sa-el-addons') . '" class="header-logo" style=" background-image: url(' . $bgimage . ');">
                            </a>
                        </div>
                        <nav class="oxilab-sa-admin-nav">
                            <ul class="oxilab-sa-admin-menu">';


        $GETPage = sanitize_text_field($_GET['page']);
        $oxitype = (!empty($_GET['oxitype']) ? sanitize_text_field($_GET['oxitype']) : '');

        if (count($elements) == 1):
            foreach ($elements['Elementor'] as $key => $value) {
                $active = ($GETPage == $value['homepage'] ? (empty($oxitype) ? ' class="active" ' : '') : '');
                $menu .= '<li ' . $active . '><a href="' . admin_url('admin.php?page=' . $value['homepage'] . '') . '">' . $this->name_converter($value['name']) . '</a></li>';
            }
        else:
            foreach ($elements as $key => $value) {
                $active = ($key == 'Elementor' ? 'active' : '');
                $menu .= '<li class="' . $active . '"><a class="oxi-nev-drop-menu" href="#">' . $this->name_converter($key) . '</a>';
                $menu .= '     <div class="oxi-nev-d-menu">
                                                    <div class="oxi-nev-drop-menu-li">';
                foreach ($value as $key2 => $submenu) {
                    $menu .= '<a href="' . admin_url('admin.php?page=' . $submenu['homepage'] . '') . '">' . $this->name_converter($submenu['name']) . '</a>';
                }
                $menu .= '                                                                                                  </div>';
                $menu .= '</li>';
            }
            if ($GETPage == 'sa-el-addons' || $GETPage == 'sa-el-addons-template' || $GETPage == 'sa-el-addons-blocks' || $GETPage == 'sa-el-addons-pre-design'):
                $sub .= '<div class="shortcode-addons-main-tab-header">';
                foreach ($elements['Elementor'] as $key => $value) {
                    $active = ($GETPage == $value['homepage'] ? (empty($oxitype) ? 'oxi-active' : '') : '');
                    $sub .= '<a href="' . admin_url('admin.php?page=' . $value['homepage'] . '') . '">
                                <div class="shortcode-addons-header ' . $active . '">' . $this->name_converter($value['name']) . '</div>
                              </a>';
                }
                $sub .= '</div>';
            endif;
        endif;
        $menu .= '              </ul>
                            <ul class="oxilab-sa-admin-menu2">
                               ' . (!apply_filters('sa-el-addons/check_version', '') ? ' <li class="fazil-class" ><a target="_blank" href="https://www.oxilab.org/downloads/elementor-addons/">Upgrade</a></li>' : '') . '
                               <li class="saadmin-doc"><a target="_black" href="https://www.sa-elementor-addons.com/docs/">Docs</a></li>
                               <li class="saadmin-doc"><a target="_black" href="https://wordpress.org/support/plugin/sa-addons-for-elementor/">Support</a></li>
                               <li class="saadmin-set"><a href="' . admin_url('admin.php?page=sa-el-addons-settings') . '"><span class="dashicons dashicons-admin-generic"></span></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                ' . $sub;
        echo __($menu, SA_EL_ADDONS_TEXTDOMAIN);
    }

    /**
     * Plugin menu Permission
     *
     * @since 1.0.0
     */
    public function menu_permission() {
        $user_role = get_option('oxi_addons_user_permission');
        $role_object = get_role($user_role);
        if (isset($role_object->capabilities) && is_array($role_object->capabilities)):
            reset($role_object->capabilities);
            return key($role_object->capabilities);
        else:
            return 'manage_options';
        endif;
    }

    /**
     * Plugin admin menu
     *
     * @since 1.0.0
     */
    public function admin_menu() {
        $permission = $this->menu_permission();
        add_menu_page('Elementor Addons', 'Elementor Addons', $permission, 'sa-el-addons', [$this, 'Addons'], SA_EL_ADDONS_URL . 'image/white-logo.png');
        add_submenu_page('sa-el-addons', 'Addons', 'Addons', $permission, 'sa-el-addons', [$this, 'Addons']);
        add_submenu_page('sa-el-addons', 'Template', 'Template', $permission, 'sa-el-addons-template', [$this, 'Template']);
        add_submenu_page('sa-el-addons', 'Blocks', 'Blocks', $permission, 'sa-el-addons-blocks', [$this, 'Blocks']);
        add_submenu_page('sa-el-addons', 'Pre-Design', 'Pre-Design', $permission, 'sa-el-addons-pre-design', [$this, 'Pre_Design']);
        add_submenu_page('sa-el-addons', 'Elementor Addons Settings', 'Settings', $permission, 'sa-el-addons-settings', [$this, 'Settings']);
    }

    public function Addons() {
        new \SA_EL_ADDONS\Classes\Admin\Addons();
    }

    public function Template() {
        new \SA_EL_ADDONS\Classes\Admin\Template();
    }

    public function Blocks() {
        new \SA_EL_ADDONS\Classes\Admin\Blocks();
    }

    public function Pre_Design() {
        new \SA_EL_ADDONS\Classes\Admin\Pre_Design();
    }

    public function settings() {
        new \SA_EL_ADDONS\Classes\Admin\Settings();
    }

}
