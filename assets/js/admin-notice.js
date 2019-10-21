
jQuery.noConflict();
(function ($) {
    "use strict";
    $(document).on("click", ".elementor-addons-support-reviews", function (e) {
        e.preventDefault();
        $.ajax({
            url: elementor_addons_admin_notice.ajaxurl,
            type: 'post',
            data: {
                action: 'elementor_addons_notice_dissmiss',
                _wpnonce: elementor_addons_admin_notice.nonce,
                notice: $(this).attr('sup-data'),
            },
            success: function (response) {
                console.log(response);
                $('.shortcode-addons-review-notice').hide();
            },
            error: function (error) {
                console.log('Something went wrong!');
            }
        });
    });
})(jQuery);
