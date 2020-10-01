/*globals ajaxurl, wpml_sticky_links_ajxloaderimg, data */

var wpml_sticky_links_ajax_loader_img = data.wpml_sticky_links_ajxloaderimg;

jQuery(document).ready(function ($) {
    var saveButton = jQuery('#icl_save_sl_options').find('#save');
    var sticky_links = sticky_links || {};

    sticky_links.save_options = function (event) {

        if (typeof (event.preventDefault) !== 'undefined') {
            event.preventDefault();
        } else {
            event.returnValue = false;
        }

        saveButton.prop('disabled', true)
        $(this).after(wpml_sticky_links_ajax_loader_img);
        var form = $(this).closest('form');
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: "action=wpml_sticky_links_save_options&" + form.serialize(),
            success: function () {
                saveButton.prop('disabled', false)
                saveButton.next().fadeOut();
            }
        });
        return false;

    };

    saveButton.on('click', sticky_links.save_options);

});