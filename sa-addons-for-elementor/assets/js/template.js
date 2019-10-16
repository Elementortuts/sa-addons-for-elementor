jQuery(document).ready(function ($) {

    function alignModal() {
        var modalDialog = $(this).find(".modal-dialog");
        /* Applying the top margin on modal dialog to align it vertically center */
        modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
    }
    $(".sa-el-template-preview-import-modal").on("shown.bs.modal", alignModal);

    $(window).on("resize", function () {
        $(".sa-el-template-preview-import-modal:visible").each(alignModal);
    });
    $(window).load(function () {
        var height = $("#wpbody").height();
        $('.oxi-addons-sa-el-paren-loader').css('min-height', height + 'px');
    });
    function SA_Elementor_Addons_Loader(functionname, rawdata, satype, callback) {
        if (functionname !== "") {
            $.ajax({
                url: saelemetoraddons.ajaxurl,
                type: "post",
                data: {
                    action: 'saelemetoraddons_settings',
                    _wpnonce: saelemetoraddons.nonce,
                    functionname: functionname,
                    rawdata: rawdata,
                    satype: satype
                },
                success: function (response) {
                    callback(response);
                }
            });
        }
    }
    $(window).load(function () {
        var urlParams = new URLSearchParams(window.location.search);
        var satype = urlParams.has('sa-el-section') ? urlParams.get('sa-el-section') : '';
        var page = urlParams.get('page');
        if (page === 'sa-el-addons-pre-design') {
            rawdata = 'pre_design_render';
        } else if (page === 'sa-el-addons-blocks') {
            rawdata = 'blocks_render';
        } else {
            rawdata = 'template_render';
        }
        functionname = 'template_blocks_loader';

        SA_Elementor_Addons_Loader(functionname, rawdata, satype, function (callback) {
            setTimeout(function () {
                $("#oxi-addons-sa-el-parent").html(callback);
            }, 1000);
        });
    });

    $(document).on("click", ".sa-el-preview-button", function (e) {
        e.preventDefault();
        var dataurl = $(this).attr('data-url');
        var datatitle = $(this).attr('sa-el-title');
        var IframeData = '<iframe id="sa-el-iframe-loader" src="' + dataurl + '">Your browser doesn\'t support iframes</iframe>';
        $("#SA-EL-IFRAME .modal-body").html(IframeData);
        $("#SA-EL-IFRAME #SA-el-ModalLabelTitle").html(datatitle);
        $("#SA-EL-IFRAME").modal();
        return false;
    });
    $("#SA-EL-IFRAME").on("hidden.bs.modal", function () {
        $("#sa-el-iframe-loader").remove();
    });
    $(document).on("click", ".sa-el-import-start", function (e) {
        e.preventDefault();
        var datatitle = $(this).attr('sa-el-title');
        var datasaelid = $(this).attr('sael-id');
        var required = require = $(this).attr('sael_required');
        $(".sa-el-reqired-plugins").remove();
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('page') == 'sa-el-addons-blocks') {
            type = 'Blocks';
        } else if (urlParams.get('page') == 'sa-el-addons-pre-design') {
            type = 'Pre Design';
        } else {
            type = 'Template';
        }

        $("#sa-el-template-preview-import-modal .sa-el-final-import-start").attr("sa-elid", datasaelid);
        $("#sa-el-template-preview-import-modal .sa-el-final-create-start").attr("sa-elid", datasaelid);
        $("#sa-el-template-preview-import-modal .sa-el-final-import-start").attr("sael_required", '');
        $("#sa-el-template-preview-import-modal .sa-el-final-create-start").attr("sael_required", '');
        $("#sa-el-template-preview-import-modal h5.modal-title").html(datatitle);
        $("#sa-el-template-preview-import-modal .sa-el-final-import-start").html('Import ' + type);
        $("#sa-el-template-preview-import-modal .sa-el-final-create-start").html('Create New Page');
        if (required !== '') {
            var res = required.split(",");
            var require = '<div class="sa-el-reqired-plugins"><p class="sa-el-msg"><span class="dashicons dashicons-admin-tools"></span> Required </p><ul class="required-plugins-list">';

            $.each(res, function (index, value) {
                if (value !== '') {
                    require += '<li class="sa-el-card">' + value.split("/")[0] + '</li>';
                }
            });
            require += '</ul><div>';
            $("#sa-el-template-preview-import-modal .sa-el-final-import-start").attr('sael_required', required);
            $("#sa-el-template-preview-import-modal .sa-el-final-create-start").attr('sael_required', required);

        }
        $("#sa-el-template-preview-import-modal .modal-body").before(require);
        $(".sa-el-final-edit-start").slideUp();
        $(".sa-el-page-edit").slideUp();
        $(".sa-el-final-import-start").slideDown();
        $(".sa-el-page-create").slideDown();
        $('#sa-el-page-name').val('');
        $("#sa-el-template-preview-import-modal").modal();
        return false;
    });

    $(".sa-el-final-edit-start").slideToggle();
    $(".sa-el-page-edit").slideToggle();
    $(document).on("click", ".sa-el-final-import-start", function (e) {
        var template_id = $(this).attr('sa-elid');
        var required = $(this).attr('sael_required');
        if (required !== '') {
            var res = required.split(",");
            var alertdata = 'For import this layouts kindly Install first ';
            $.each(res, function (index, value) {
                if (value !== '') {
                    alertdata += value.split("/")[0] + ', ';
                }
            });
            alert(alertdata);
            e.preventDefault();
            return false;
        } else {
            $(".sa-el-final-import-start").html('Importing...');
            var functionname = 'template_blocks_import';
            var rawdata = template_id;
            var satype = '';

            SA_Elementor_Addons_Loader(functionname, rawdata, satype, function (callback) {
                console.log(callback);
                if (callback === 'problem') {
                    alert('Error Data :( Kindly contact to Shortcode Addons');
                } else {
                    $(".sa-el-final-import-start").slideToggle();
                    $(".sa-el-final-edit-start").attr('href', $(".sa-el-final-edit-start").attr('data-hr') + callback + '&action=elementor');
                    $(".sa-el-final-edit-start").slideToggle();
                }
            });
            e.preventDefault();
            return false;
        }
    });
    $(document).on("click", ".sa-el-final-create-start", function (e) {
        var template_id = $(this).attr('sa-elid');
        var required = $(this).attr('sael_required');
        if (required !== '') {
            var res = required.split(",");
            var alertdata = 'For import this layouts kindly Install first ';
            $.each(res, function (index, value) {
                if (value !== '') {
                    alertdata += value.split("/")[0] + ', ';
                }
            });
            alert(alertdata);
            e.preventDefault();
            return false;
        } else {
            var with_page = $('#sa-el-page-name').val();
            if (with_page === '') {
                alert('kindly Add Page Title');
                e.preventDefault();
                return false;
            }
            var functionname = 'template_blocks_import';
            var rawdata = template_id;
            $(".sa-el-final-create-start").html('Creating...');
            $('#sa-el-page-name').val('');
            SA_Elementor_Addons_Loader(functionname, rawdata, with_page, function (callback) {
                if (callback === 'problem') {
                    alert('Error Data :( Kindly contact to Shortcode Addons');
                } else {
                    $(".sa-el-final-edit-page").attr('href', $(".sa-el-final-edit-page").attr('data-hr') + callback + '&action=elementor');
                    $(".sa-el-page-create").slideToggle();
                    $(".sa-el-page-edit").slideToggle();
                }
            });
            e.preventDefault();
            return false;
        }
    });


});