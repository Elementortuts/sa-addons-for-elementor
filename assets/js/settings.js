jQuery(document).ready(function ($) {
    var fristtabs = '#tabs-elements';
    $(".ctu-ulimate-style-2 .vc-tabs-li[ref='" + fristtabs + "']").addClass("active");
    $(".ctu-ulitate-style-2-tabs" + fristtabs).css("display", "block");
    $(".ctu-ulimate-style-2 .vc-tabs-li").click(function () {
        if ($(this).hasClass("active")) {
            return false;
        } else {
            $(".ctu-ulimate-style-2 .vc-tabs-li").removeClass("active");
            $(this).toggleClass("active");
            $(".ctu-ulitate-style-2-tabs").css("display", "none");
            var activeTab = $(this).attr("ref");
            $(activeTab).css("display", "block");
        }
    });
});