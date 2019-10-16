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
        $installed = get_option('shortcode-addons-elementor');
        if (empty($installed) || $installed == '') {
            $installed = 'accordion=on&button=on&tabs=on&feature_list=on&flip_box=on&info_box=on&tooltip=on&single_product=on&team_member=on&testimonial=on&toggle=on&card=on&icon_box=on&number=on÷r=on&counter=on&count_down=on&image_hotspots=on&interactive_card=on&interactive_promo=on&progress_bar=on&protected_content=on&call_to_action=on&pricing_table=on';
            update_option('shortcode-addons-elementor', $installed);
        }

        parse_str($installed, $settings);
        ksort($settings);
        return $settings;
    }

    public function Get_Registered_elements() {
        $response = [
            'accordion' => [
                'class' => '\SA_EL_ADDONS\Elements\Accordion\Accordion',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Accordion/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'Elements/Accordion/assets/index.min.js',
                    ],
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'button' => [
                'class' => '\SA_EL_ADDONS\Elements\Button\Button',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Button/assets/index.min.css',
                    ],
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'call_to_action' => [
                'class' => '\SA_EL_ADDONS\Elements\Call_To_Action\Call_To_Action',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Call_To_Action/assets/index.min.css',
                    ],
                ],
                'category' => 'Marketing Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'tabs' => [
                'class' => '\SA_EL_ADDONS\Elements\Tabs\Tabs',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Tabs/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'Elements/Tabs/assets/index.min.js',
                    ],
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'divider' => [
                'class' => '\SA_EL_ADDONS\Elements\Divider\Divider',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Divider/assets/index.min.css',
                    ]
                ],
                'category' => 'Creative Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'counter' => [
                'class' => '\SA_EL_ADDONS\Elements\Counter\Counter',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/odometer/css/odometer-theme-default.min.css',
                        SA_EL_ADDONS_PATH . 'Elements/Counter/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/waypoints/js/waypoints.min.js',
                        SA_EL_ADDONS_PATH . 'assets/vendor/odometer/js/odometer.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Counter/assets/index.min.js',
                    ],
                ],
                'category' => 'Creative Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'count_down' => [
                'class' => '\SA_EL_ADDONS\Elements\Count_Down\Count_Down',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Count_Down/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/countdown/js/countdown.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Count_Down/assets/index.min.js',
                    ],
                ],
                'category' => 'Creative Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'fancy_text' => [
                'class' => '\SA_EL_ADDONS\Elements\Fancy_Text\Fancy_Text',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Fancy_Text/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/fancy-text/js/fancy-text.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Fancy_Text/assets/index.min.js',
                    ],
                ],
                'category' => 'Creative Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'feature_list' => [
                'class' => '\SA_EL_ADDONS\Elements\Feature_List\Feature_List',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Feature_List/assets/index.min.css',
                    ]
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'filterable_gallery' => [
                'class' => '\SA_EL_ADDONS\Elements\Filterable_Gallery\Filterable_Gallery',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/magnific-popup/css/index.min.css',
                        SA_EL_ADDONS_PATH . 'Elements/Filterable_Gallery/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/imagesLoaded/js/imagesloaded.pkgd.min.js',
                        SA_EL_ADDONS_PATH . 'assets/vendor/isotope/js/isotope.pkgd.min.js',
                        SA_EL_ADDONS_PATH . 'assets/vendor/magnific-popup/js/jquery.magnific-popup.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Filterable_Gallery/assets/index.min.js',
                    ],
                ],
                'category' => 'Creative Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'advanced_heading' => [
                'class' => '\SA_EL_ADDONS\Elements\Advanced_Heading\Advanced_Heading',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Advanced_Heading/assets/index.min.css',
                    ],
                ],
                'category' => 'Content Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'flip_box' => [
                'class' => '\SA_EL_ADDONS\Elements\Flip_Box\Flip_Box',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Flip_Box/assets/index.min.css',
                    ],
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'flip_carousel' => [
                'class' => '\SA_EL_ADDONS\Elements\Flip_Carousel\Flip_Carousel',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/flipster/css/jquery.flipster.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/flipster/js/jquery.flipster.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Flip_Carousel/assets/index.min.js',
                    ]
                ],
                'category' => 'Carousel & Slider',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'image_accordion' => [
                'class' => '\SA_EL_ADDONS\Elements\Image_Accordion\Image_Accordion',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Image_Accordion/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'Elements/Image_Accordion/assets/index.min.js',
                    ]
                ],
                'category' => 'Creative Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'image_hotspots' => [
                'class' => '\SA_EL_ADDONS\Elements\Image_Hotspots\Image_Hotspots',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Image_Hotspots/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/tipso/js/tipso.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Image_Hotspots/assets/index.min.js',
                    ]
                ],
                'category' => 'Creative Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'image_scroller' => [
                'class' => '\SA_EL_ADDONS\Elements\Image_Scroller\Image_Scroller',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Image_Scroller/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'Elements/Image_Scroller/assets/index.min.js',
                    ]
                ],
                'category' => 'Creative Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'image_comparison' => [
                'class' => '\SA_EL_ADDONS\Elements\Image_Comparison\Image_Comparison',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/twentytwenty/css/twentytwenty.min.css',
                        SA_EL_ADDONS_PATH . 'Elements/Image_Comparison/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/event_move/js/jquery.event.move.min.js',
                        SA_EL_ADDONS_PATH . 'assets/vendor/twentytwenty/js/jquery.twentytwenty.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Image_Comparison/assets/index.min.js',
                    ],
                ],
                'category' => 'Creative Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'info_box' => [
                'class' => '\SA_EL_ADDONS\Elements\Info_Box\Info_Box',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Info_Box/assets/index.min.css',
                    ]
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'interactive_card' => [
                'class' => '\SA_EL_ADDONS\Elements\Interactive_Card\Interactive_Card',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/interactive-cards/css/interactive-cards.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/nicescroll/js/jquery.nicescroll.min.js',
                        SA_EL_ADDONS_PATH . 'assets/vendor/interactive-cards/js/interactive-cards.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Interactive_Card/assets/index.min.js',
                    ],
                ],
                'category' => 'Creative Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'interactive_promo' => [
                'class' => '\SA_EL_ADDONS\Elements\Interactive_Promo\Interactive_Promo',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Interactive_Promo/assets/index.min.css',
                    ],
                ],
                'category' => 'Creative Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'lightbox_and_modal' => [
                'class' => '\SA_EL_ADDONS\Elements\Lightbox_Modal\Lightbox_Modal',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/magnific-popup/css/index.min.css',
                        SA_EL_ADDONS_PATH . 'Elements/Lightbox_Modal/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/magnific-popup/js/jquery.magnific-popup.min.js',
                        SA_EL_ADDONS_PATH . 'assets/vendor/cookie/js/jquery.cookie.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Lightbox_Modal/assets/index.min.js',
                    ],
                ],
                'category' => 'Creative Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'logo_carousel' => [
                'class' => '\SA_EL_ADDONS\Elements\Logo_Carousel\Logo_Carousel',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Logo_Carousel/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'Elements/Logo_Carousel/assets/index.min.js',
                    ],
                ],
                'category' => 'Carousel & Slider',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'offcanvas' => [
                'class' => '\SA_EL_ADDONS\Elements\Offcanvas\Offcanvas',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Offcanvas/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/offcanvas/js/offcanvas.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Offcanvas/assets/index.min.js',
                    ],
                ],
                'category' => 'Content Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'tooltip' => [
                'class' => '\SA_EL_ADDONS\Elements\Tooltip\Tooltip',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Tooltip/assets/index.min.css',
                    ],
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'price_menu' => [
                'class' => '\SA_EL_ADDONS\Elements\Price_Menu\Price_Menu',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Price_Menu/assets/index.min.css',
                    ],
                ],
                'category' => 'Marketing Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'pricing_table' => [
                'class' => '\SA_EL_ADDONS\Elements\Pricing_Table\Pricing_Table',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/tooltipster/css/tooltipster.bundle.min.css',
                        SA_EL_ADDONS_PATH . 'Elements/Pricing_Table/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/tooltipster/js/tooltipster.bundle.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Pricing_Table/assets/index.min.js',
                    ],
                ],
                'category' => 'Marketing Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'progress_bar' => [
                'class' => '\SA_EL_ADDONS\Elements\Progress_Bar\Progress_Bar',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Progress_Bar/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/inview/js/inview.min.js',
                        SA_EL_ADDONS_PATH . 'assets/vendor/progress-bar/js/progress-bar.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Progress_Bar/assets/index.min.js',
                    ],
                ],
                'category' => 'Creative Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'protected_content' => [
                'class' => '\SA_EL_ADDONS\Elements\Protected_Content\Protected_Content',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Protected_Content/assets/index.min.css',
                    ],
                ],
                'category' => 'Creative Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'single_product' => [
                'class' => '\SA_EL_ADDONS\Elements\Single_Product\Single_Product',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Single_Product/assets/index.min.css',
                        SA_EL_ADDONS_PATH . 'Elements/Single_Product/assets/overlay.min.css',
                    ],
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'team_member_carousel' => [
                'class' => '\SA_EL_ADDONS\Elements\Team_Member_Carousel\Team_Member_Carousel',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Team_Member_Carousel/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'Elements/Team_Member_Carousel/assets/index.min.js',
                    ],
                ],
                'category' => 'Carousel & Slider',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'team_member' => [
                'class' => '\SA_EL_ADDONS\Elements\Team_Member\Team_Member',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Team_Member/assets/index.min.css',
                    ]
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'testimonial_slider' => [
                'class' => '\SA_EL_ADDONS\Elements\Testimonial_Slider\Testimonial_Slider',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Testimonial_Slider/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'Elements/Testimonial_Slider/assets/index.min.js',
                    ],
                ],
                'category' => 'Carousel & Slider',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'testimonial' => [
                'class' => '\SA_EL_ADDONS\Elements\Testimonial\Testimonial',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Testimonial/assets/index.min.css',
                    ]
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'toggle' => [
                'class' => '\SA_EL_ADDONS\Elements\Toggle\Toggle',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Toggle/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'Elements/Toggle/assets/index.min.js',
                    ],
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'card' => [
                'class' => '\SA_EL_ADDONS\Elements\Card\Card',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Card/assets/index.min.css',
                    ],
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'justified_gallery' => [
                'class' => '\SA_EL_ADDONS\Elements\Justified_Gallery\Justified_Gallery',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/justifiedGallery/css/justifiedGallery.min.css',
                        SA_EL_ADDONS_PATH . 'Elements/Justified_Gallery/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/justifiedGallery/js/jquery.justifiedGallery.min.js',
                        SA_EL_ADDONS_PATH . 'Elements/Justified_Gallery/assets/index.min.js',
                    ],
                ],
                'category' => 'Creative Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'content_protection' => [
                'class' => '\SA_EL_ADDONS\Extensions\SA_Content_Protection\SA_Content_Protection',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Extensions/SA_Content_Protection/assets/index.min.css',
                    ]
                ],
                'category' => 'Extension',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'advance_tooltip' => [
                'class' => '\SA_EL_ADDONS\Extensions\SA_Advance_Tooltip\SA_Advance_Tooltip',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/tippy/css/tippy.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'assets/vendor/popper/js/popper.min.js',
                        SA_EL_ADDONS_PATH . 'assets/vendor/tippy/js/tippy.min.js',
                        SA_EL_ADDONS_PATH . 'Extensions/SA_Advance_Tooltip/assets/index.min.js',
                    ],
                ],
                'category' => 'Extension',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            '3D_css_effect' => [
                'class' => '\SA_EL_ADDONS\Extensions\CSS_3D_effect\CSS_3D_effect',
                'dependency' => [
                    'js' => [
                        SA_EL_ADDONS_PATH . 'Extensions/CSS_3D_effect/assets/index.min.js',
                    ],
                ],
                'category' => 'Extension',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'gradient_heading' => [
                'class' => '\SA_EL_ADDONS\Elements\Gradient_Heading\Gradient_Heading',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Gradient_Heading/assets/index.min.css',
                    ]
                ],
                'category' => 'Creative Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'dual_button' => [
                'class' => '\SA_EL_ADDONS\Elements\Dual_Button\Dual_Button',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Dual_Button/assets/index.min.css',
                    ]
                ],
                'category' => 'Content Elements',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'icon_box' => [
                'class' => '\SA_EL_ADDONS\Elements\Icon_Box\Icon_Box',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Icon_Box/assets/index.min.css',
                    ]
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'number' => [
                'class' => '\SA_EL_ADDONS\Elements\Number\Number',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Number/assets/index.min.css',
                    ]
                ],
                'category' => 'Content Elements',
                'Premium' => FALSE,
                'condition' => '',
                'API' => ''
            ],
            'data_table' => [
                'class' => '\SA_EL_ADDONS\Elements\Data_Table\Data_Table',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Elements/Data_Table/assets/index.min.css',
                    ],
                    'js' => [
                        SA_EL_ADDONS_PATH . 'Elements/Data_Table/assets/index.min.js',
                        SA_EL_ADDONS_PATH . 'assets/vendor/table-sorter/js/jquery.tablesorter.min.js',
                    ],
                ],
                'category' => 'Dynamic Contents',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
            'ribon' => [
                'class' => '\SA_EL_ADDONS\Extensions\SA_Ribon\SA_Ribon',
                'dependency' => [
                    'css' => [
                        SA_EL_ADDONS_PATH . 'Extensions/SA_Ribon/assets/index.min.css',
                    ],
                ],
                'category' => 'Extension',
                'Premium' => TRUE,
                'condition' => '',
                'API' => ''
            ],
        ];
        return $response;
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
