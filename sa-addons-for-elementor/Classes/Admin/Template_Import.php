<?php

namespace SA_EL_ADDONS\Classes\Admin;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Template_Import
 * Content of Shortcode Addons Plugins
 *
 * @author $biplob018
 */
use Elementor\TemplateLibrary\Source_Remote;

class Template_Import extends Source_Remote {

    public function __construct($id = '', $page = '') {
        if (!function_exists('wp_crop_image')):
            include ABSPATH . 'wp-admin/includes/image.php';
        endif;

        if (!empty($id)):
            $this->template_loads($id, $page);
        endif;
    }

    /**
     * Import template ajax action
     */
    public function template_loads($id, $page) {


        $template = \SA_EL_ADDONS\Classes\Rest_API::get_instance()->get_template_content($id);

        if (is_wp_error($template)):
            return $template;
        endif;
        // Finally create the page.
        $page_id = $this->create_page($template, $page);
        echo ((int) $page_id ? $page_id : 'problem');
    }

    private function create_page($template, $with_page = false) {
        if (!$template) {
            return _e('Invalid Template ID.', SA_EL_ADDONS_TEXTDOMAIN);
        }
        $content = json_decode($template['content'], true);
        $template['content'] = $this->replace_elements_ids($content);
        $template['content'] = $this->process_export_import_content($content, 'on_import');

        $args = [
            'post_type' => $with_page ? 'page' : 'elementor_library',
            'post_status' => $with_page ? 'draft' : 'publish',
            'post_name' => $template['post_name'],
            'post_title' => $with_page ? $with_page : $template['title'],
            'post_content' => '',
        ];

        $new_post_id = wp_insert_post($args);

        if ($new_post_id && !is_wp_error($new_post_id)) {
            update_post_meta($new_post_id, '_elementor_data', $template['content']);
            update_post_meta($new_post_id, '_elementor_template_type', $template['type']);
            update_post_meta($new_post_id, '_elementor_edit_mode', 'builder');
            update_post_meta($new_post_id, '_sael_import_type', $with_page ? 'page' : 'library' );
            update_post_meta($new_post_id, '_sael_template_id', $template['id']);
            update_post_meta($new_post_id, '_wp_page_template', !empty($template['page_template']) ? $template['page_template'] : 'elementor_canvas' );

            if (!$with_page) {
                wp_set_object_terms($new_post_id, !empty($template['elementor_library_type']) ? $template['elementor_library_type'] : 'page', 'elementor_library_type');
            }

            return $new_post_id;
        }

        return new \WP_Error('import_error', 'Unable to create page.');
    }

}
