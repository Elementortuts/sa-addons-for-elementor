'use strict';

(function ($, w) {
    window.isEditMode = false;

    $(window).on("elementor/frontend/init", function () {
        window.isEditMode = elementorFrontend.isEditMode();
    });
    
    $.fn.getShortcodeSettings = function() {
        return this.data('shortcode-settings');
    };
    setTimeout(function () {
        $(".OxiAddonsELEqualHeightWidth").each(function () {
            var cw = $(this).outerWidth();
            var ch = $(this).outerHeight();
            if (cw > ch) {
                $(this).css({"height": cw + "px"});
                $(this).css({"width": cw + "px"});
            } else {
                $(this).css({"height": ch + "px"});
                $(this).css({"width": ch + "px"});
            }
        });
    }, 1500);

}(jQuery, window));



