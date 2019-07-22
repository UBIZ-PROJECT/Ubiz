(function ($) {
    Permission = function () {
        this.dep_id = null;
        this.usr_id = null;
        this.scr_id = null;
        this.nicescroll_1 = null;
        this.nicescroll_2 = null;
        this.nicescroll_3 = null;
    };
    jQuery.Permission = new Permission();
    jQuery.extend(Permission.prototype, {
        init: function () {
            jQuery.Permission.nicescroll_1 = fnc_set_scrollbars("nicescroll-1");
            jQuery.Permission.nicescroll_2 = fnc_set_scrollbars("nicescroll-2");
            jQuery.Permission.nicescroll_3 = fnc_set_scrollbars("nicescroll-3");
            jQuery('.utooltip').tooltipster({
                side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
            });
        },
        department_click: function (dep_id, self) {

            if (jQuery(self).hasClass('dep-sel'))
                return false;

            var dep_ctn = jQuery(self).closest('div[id=dep-ctn]');
            dep_ctn.find('div.dep').removeClass('dep-sel');
            dep_ctn.find('div.user').removeClass('user-sel');
            jQuery(self).addClass('dep-sel');

            jQuery.Permission.dep_id = dep_id;
            jQuery.Permission.scr_id = jQuery.Permission.get_scr_id();
            jQuery.Permission.get_permission_data_for_department(jQuery.Permission.dep_id, jQuery.Permission.scr_id);
        },
        expand_click: function (self, event) {

            event.stopPropagation();

            var closest_tr = jQuery(self).closest('tr');
            closest_tr.removeClass('exp');
            closest_tr.addClass('clp');
        },
        collapse_click: function (self, event) {

            event.stopPropagation();

            var closest_tr = jQuery(self).closest('tr');
            closest_tr.removeClass('clp');
            closest_tr.addClass('exp');
        },
        user_click: function (dep_id, usr_id, self) {

            if (jQuery(self).hasClass('user-sel')) {
                return false;
            }

            var dep_ctn = jQuery(self).closest('div[id=dep-ctn]');


            jQuery.Permission.dep_id = dep_id;
            jQuery.Permission.usr_id = usr_id;
            jQuery.Permission.scr_id = jQuery.Permission.get_scr_id();

            dep_ctn.find('div.user').removeClass('user-sel');
            dep_ctn.find('div.dep').removeClass('dep-sel');

            jQuery(self).addClass('user-sel');

            jQuery.Permission.get_permission_data_for_user(jQuery.Permission.dep_id, jQuery.Permission.scr_id, jQuery.Permission.usr_id);

        },
        screen_click: function (scr_id, self) {

            if (jQuery(self).hasClass('scr-sel')) {
                return false;
            }

            var scr_ctn = jQuery(self).closest('div[id=scr-ctn]');
            scr_ctn.find('div.scr').removeClass('scr-sel');
            jQuery(self).addClass('scr-sel');

            jQuery.Permission.scr_id = scr_id;
            jQuery.Permission.dep_id = jQuery.Permission.get_dep_id();
            jQuery.Permission.usr_id = jQuery.Permission.get_usr_id();

            if (jQuery.Permission.dep_id == null && jQuery.Permission.usr_id == null) {
                swal({
                    type: 'error',
                    text: i18next.t('Please choose department or user.')
                });
                return false;
            }

            if (jQuery.Permission.dep_id == null) {
                jQuery.Permission.usr_id = jQuery.Permission.get_usr_id();
                jQuery.Permission.dep_id = jQuery.Permission.get_dep_id_by_selected_user();
                jQuery.Permission.get_permission_data_for_user(jQuery.Permission.dep_id, jQuery.Permission.scr_id, jQuery.Permission.usr_id);
            } else {
                jQuery.Permission.get_permission_data_for_department(jQuery.Permission.dep_id, jQuery.Permission.scr_id);
            }
        },
        get_dep_id: function () {
            var dep_ctn = jQuery('div[id=dep-ctn]');
            var selected_dep = dep_ctn.find('div.dep-sel');
            if (selected_dep.length == 0)
                return null;
            return selected_dep.attr('dep_id');
        },
        get_dep_id_by_selected_user: function () {
            var dep_ctn = jQuery('div[id=dep-ctn]');
            var selected_user = dep_ctn.find('div.user-sel');
            if (selected_user.length == 0)
                return null;
            return selected_user.attr('dep_id');
        },
        get_usr_id: function () {
            var dep_ctn = jQuery('div[id=dep-ctn]');
            var selected_user = dep_ctn.find('div.user-sel');
            if (selected_user.length == 0)
                return null;
            return selected_user.attr('usr_id');
        },
        get_scr_id: function () {
            var scr_ctn = jQuery('div[id=scr-ctn]');
            return scr_ctn.find('div.scr-sel').attr('scr_id');
        },
        get_permission_data_for_user: function (dep_id, scr_id, usr_id) {
            console.log(dep_id);
            console.log(scr_id);
            console.log(usr_id);
            ubizapis(
                'v1',
                '/permission/' + dep_id + "/" + scr_id + "/" + usr_id,
                'get',
                null,
                null,
                function (response) {
                    if (response.data.success == true) {
                        jQuery.Permission.render_permissions(response.data.permissions, 'usr');
                    } else {
                        swal({
                            type: 'error',
                            text: response.data.message
                        });
                    }
                }
            );
        },
        get_permission_data_for_department: function (dep_id, scr_id) {
            console.log(dep_id);
            console.log(scr_id);
            ubizapis(
                'v1',
                '/permission/' + dep_id + "/" + scr_id,
                'get',
                null,
                null,
                function (response) {
                    if (response.data.success == true) {
                        jQuery.Permission.render_permissions(response.data.permissions, 'dep');
                    } else {
                        swal({
                            type: 'error',
                            text: response.data.message
                        });
                    }
                }
            );
        },
        render_permissions: function (permissions, opt) {

            var tbl_html = "";
            var tbl_thead = "";
            var tbl_tbody = "";

            tbl_thead += "<thead>";
            tbl_thead += "<tr>";
            tbl_thead += "<th class='cst-col-1'>&nbsp</th>";
            if (opt == 'usr') {
                tbl_thead += "<th class='cst-col-2'><span class='qYt'>" + i18next.t('Allow') + "</span></th>";
                tbl_thead += "<th class='cst-col-3'><span class='qYt'>" + i18next.t('Inherited') + "</span></th>";
            } else {
                tbl_thead += "<th class='cst-col-2'><span class='qYt'>" + i18next.t('Allow') + "</span></th>";
                tbl_thead += "<th class='cst-col-3'>&nbsp</th>";
            }
            tbl_thead += "</tr>";
            tbl_thead += "</thead>";

            tbl_tbody += "<tbody>";
            for (let i = 0; i < permissions.length; i++) {
                tbl_tbody += "<tr>";
                tbl_tbody += "<td class='cst-col-1'>";
                tbl_tbody += "<div class='klk'>";
                tbl_tbody += "<div class='pad'>";
                tbl_tbody += "<i class='material-icons'>";
                tbl_tbody += permissions[i].fnc_icon;
                tbl_tbody += "</i>";
                tbl_tbody += "</div>";
                tbl_tbody += "<div class='kao'>";
                tbl_tbody += "<span class='qYt'>" + permissions[i].fnc_name + "</span>";
                tbl_tbody += "</div>";
                tbl_tbody += "</div>";
                tbl_tbody += "</td>";
                if (opt == 'usr') {
                    var usr_allow_checked = '';
                    var dep_allow_checked = '';
                    if (permissions[i].usr_allow == '1') {
                        usr_allow_checked = 'checked';
                    }
                    if (permissions[i].dep_allow == '1') {
                        dep_allow_checked = 'checked';
                    }

                    tbl_tbody += "<td class='cst-col-2'>";
                    tbl_tbody += "<input name='usr_allow' class='chk' pkey='" + permissions[i].pkey + "' dep_id='" + permissions[i].dep_id + "' scr_id='" + permissions[i].scr_id + "' fnc_id='" + permissions[i].fnc_id + "' usr_id='" + permissions[i].usr_id + "' type='checkbox' " + usr_allow_checked + ">";
                    tbl_tbody += "</td>";
                    tbl_tbody += "<td class='cst-col-3'>";
                    tbl_tbody += "<input disabled name='dep_allow' class='chk' dep_id='" + permissions[i].dep_id + "' scr_id='" + permissions[i].scr_id + "' fnc_id='" + permissions[i].fnc_id + "' type='checkbox'" + dep_allow_checked + ">";
                    tbl_tbody += "</td>";
                } else {
                    var dep_allow_checked = '';
                    if (permissions[i].dep_allow == '1') {
                        dep_allow_checked = 'checked';
                    }
                    tbl_tbody += "<td class='cst-col-2'>";
                    tbl_tbody += "<input name='dep_allow' class='chk' pkey='" + permissions[i].pkey + "' dep_id='" + permissions[i].dep_id + "' scr_id='" + permissions[i].scr_id + "' fnc_id='" + permissions[i].fnc_id + "' type='checkbox'" + dep_allow_checked + ">";
                    tbl_tbody += "</td>";
                    tbl_tbody += "<td class='cst-col-3'>&nbsp;</td>";
                }
                tbl_tbody += "</tr>";
            }
            tbl_tbody += "</tbody>";

            tbl_html = tbl_thead + tbl_tbody;
            var fnc_ctn = jQuery('div[id=fnc-ctn]');
            fnc_ctn.find('table.ngv').empty();
            fnc_ctn.find('table.ngv').html(tbl_html);

        },
        collect_permission_data: function () {

            var form_data = new Array();
            var fnc_ctn = jQuery('div[id=fnc-ctn]');
            var usr_allows = fnc_ctn.find('input[name=usr_allow]');
            if (usr_allows.length > 0) {
                usr_allows.each(function (index) {
                    var id = $(this).attr('pkey');
                    var dep_id = $(this).attr('dep_id');
                    var scr_id = $(this).attr('scr_id');
                    var fnc_id = $(this).attr('fnc_id');
                    var usr_id = $(this).attr('usr_id');
                    var usr_allow = $(this).is(':checked') ? '1' : '0';
                    form_data.push({
                        'id': id,
                        'dep_id': dep_id,
                        'scr_id': scr_id,
                        'fnc_id': fnc_id,
                        'usr_id': usr_id,
                        'usr_allow': usr_allow
                    });
                });
            } else {
                var dep_allows = fnc_ctn.find('input[name=dep_allow]');
                if (dep_allows.length > 0) {
                    dep_allows.each(function (index) {
                        var id = $(this).attr('pkey');
                        var dep_id = $(this).attr('dep_id');
                        var scr_id = $(this).attr('scr_id');
                        var fnc_id = $(this).attr('fnc_id');
                        var dep_allow = $(this).is(':checked') ? '1' : '0';
                        form_data.push({
                            'id': id,
                            'dep_id': dep_id,
                            'scr_id': scr_id,
                            'fnc_id': fnc_id,
                            'dep_allow': dep_allow
                        });
                    });
                }
            }

            return form_data;
        },
        save: function (self) {
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
                    var form_data = jQuery.Permission.collect_permission_data();
                    ubizapis('v1', '/permission', 'post', form_data, null, function (response) {
                        if (response.data.success == true) {
                            swal.fire({
                                type: 'success',
                                title: response.data.message,
                                onClose: () => {
                                    jQuery.Permission.render_permissions(response.data.permissions, response.data.opt);
                                }
                            })
                        } else {
                            swal.fire({
                                type: 'error',
                                title: response.data.message
                            })
                        }
                    });
                }
            });
        }
    });
})(jQuery);

jQuery(document).ready(function () {
    jQuery.Permission.init();
});