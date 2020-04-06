(function ($) {
    UbizOIWidget = function () {};

    jQuery.UbizOIWidget = new UbizOIWidget();
    jQuery.extend(UbizOIWidget.prototype, {
        w_save: function () {
            var html = "<span style='display: none'><input type='checkbox' id='keep_info'> Giữ lại thông tin cho đơn hàng.</span>";
            swal({
                title: i18next.t('Do you want to save the data.?'),
                type: 'question',
                html: jQuery("#txt_id").val() == "0" ? "" : html,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var form_data = jQuery.UbizOIWidget.w_get_form_data();
                    var id = jQuery("#txt_id").val();
                    form_data.append("id", id);
                    form_data.append("keep_info", $("#keep_info").prop("checked"));
                    ubizapis('v1', '/myaccount/' + id + '/update', 'post', form_data, null, jQuery.UbizOIWidget.w_save_callback);
                }
            })
        },
        w_save_callback: function (response) {
            if (response.data.success == true) {
                swal.fire({
                    type: 'success',
                    title: response.data.message
                });
            } else {
                swal.fire({
                    type: 'error',
                    title: response.data.message
                });
            }
        },
        w_change_passwd: function () {
            jQuery("#change-passwd-modal").modal('show');
        },
        w_change_passwd_execute: function () {
            swal({
                title: i18next.t('Do you want to save the data.?'),
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var id = jQuery("#txt_id").val();
                    var form_data = new FormData();
                    form_data.append('old_passwd', jQuery("#old_passwd").val());
                    form_data.append('new_passwd', jQuery("#new_passwd").val());
                    form_data.append('ver_passwd', jQuery("#ver_passwd").val());
                    ubizapis('v1', '/myaccount/' + id + '/passwd', 'post', form_data, null, jQuery.UbizOIWidget.w_change_passwd_callback);
                }
            })
        },
        w_change_passwd_callback: function (response) {
            if (response.data.success == true) {
                jQuery("#change-passwd-modal").modal('hide');
                jQuery("#old_passwd").val("");
                jQuery("#new_passwd").val("");
                jQuery("#ver_passwd").val("");
                swal.fire({
                    type: 'success',
                    title: response.data.message
                });
            } else {
                swal.fire({
                    type: 'error',
                    title: response.data.message
                });
            }
        },
        w_get_form_data: function () {
            var form_data = new FormData();
            form_data.append('txt_name', jQuery("#txt_name").val());

            if (jQuery('input[name=inp-upload-image]')[0].files.length > 0) {
                form_data.append('avatar', jQuery('input[name=inp-upload-image]')[0].files[0]);
            }
            form_data.append('txt_phone', jQuery("#txt_phone").val());
            form_data.append('txt_address', jQuery("#txt_address").val());
            return form_data;
        },
    });
})(jQuery);