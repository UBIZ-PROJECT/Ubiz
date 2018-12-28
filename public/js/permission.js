(function ($) {
    Permission = function () {
        this.dep_id = null;
        this.user_id = null;
        this.scr_id = null;
    };
    jQuery.Permission = new Permission();
    jQuery.extend(Permission.prototype, {
        select_department: function (dep_id, self) {
            jQuery.Permission.dep_id = dep_id;
        },
        select_user: function (dep_id, user_id, self) {
            jQuery.Permission.dep_id = dep_id;
            jQuery.Permission.user_id = dep_id;
        },
        select_screen: function (scr_id, self) {
            jQuery.Permission.scr_id = scr_id;
        },
        get_permission_data: function (dep_id, scr_id, user_id) {

        },
        get_permission_form_data: function () {

            var form_data = new FormData();
            form_data.append('txt_com_id', jQuery("#txt_id").val());
            form_data.append('txt_com_nm', jQuery("#txt_com_nm").val());
            form_data.append('txt_com_address', jQuery("#txt_com_address").val());
            form_data.append('txt_com_phone', jQuery("#txt_com_phone").val());
            form_data.append('txt_com_fax', jQuery("#txt_com_fax").val());
            form_data.append('txt_com_web', jQuery("#txt_com_web").val());
            form_data.append('txt_com_email', jQuery("#txt_com_email").val());
            form_data.append('txt_com_mst', jQuery("#txt_com_mst").val());

            return form_data;
        },
        save: function (self) {
            var form_data = jQuery.Permission.get_permission_form_data();
            ubizapis('v1', '/permission', 'post', form_data, null, function(response){
                if (response.data.success == true) {
                    swal({
                        title: i18next.t('Successfully processed.'),
                        text: i18next.t('Do you want to continue or go back to the list page?'),
                        type: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#3085d6',
                        cancelButtonText: i18next.t('Back to the list page'),
                        confirmButtonText: i18next.t('Continue'),
                        reverseButtons: true
                    });
                } else {
                    swal({
                        type: 'error',
                        text: response.data.message
                    });
                }
            });
        }
    });
})(jQuery);

jQuery(document).ready(function () {
    jQuery('#nicescroll-1').niceScroll({
        cursorcolor: "#9fa8b0",
        cursorwidth: "5px",
        cursorborder: "none",
        cursorborderradius: 5,
        cursoropacitymin: 0.4,
        scrollbarid: 'nc-sidebar',
        autohidemode: false,
        horizrailenabled: false
    });
    jQuery('#nicescroll-2').niceScroll({
        cursorcolor: "#9fa8b0",
        cursorwidth: "5px",
        cursorborder: "none",
        cursorborderradius: 5,
        cursoropacitymin: 0.4,
        scrollbarid: 'nc-sidebar',
        autohidemode: false,
        horizrailenabled: false
    });
    jQuery('#nicescroll-3').niceScroll({
        cursorcolor: "#9fa8b0",
        cursorwidth: "5px",
        cursorborder: "none",
        cursorborderradius: 5,
        cursoropacitymin: 0.4,
        scrollbarid: 'nc-sidebar',
        autohidemode: false,
        horizrailenabled: false
    });
});