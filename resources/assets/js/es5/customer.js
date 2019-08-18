(function ($) {
    UbizOIWidget = function () {
        this.page = 0;
        this.sort = {};
        this.sort_default = {};
        this.pos = 0;
        this.rows_num = 0;
        this.o_page = null;
        this.i_page = null;
        this.con_summary_detail = null;
        this.sidebar_scrollbars = null;
        this.output_scrollbars = null;
        this.input_scrollbars = null;
        this.none_img = '../images/avatar.png';
    };

    jQuery.UbizOIWidget = new UbizOIWidget();
    jQuery.extend(UbizOIWidget.prototype, {
        w_init: function () {
            jQuery.UbizOIWidget.o_page = jQuery("#o-put");
            jQuery.UbizOIWidget.i_page = jQuery("#i-put");
            jQuery.UbizOIWidget.sidebar_scrollbars = fnc_set_scrollbars("nicescroll-sidebar");
            jQuery.UbizOIWidget.output_scrollbars = fnc_set_scrollbars("nicescroll-oput");
            jQuery.UbizOIWidget.input_scrollbars = fnc_set_scrollbars("nicescroll-iput");
            jQuery('.utooltip').tooltipster({
                side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
            });
            jQuery.UbizOIWidget.sort_default = jQuery.UbizOIWidget.w_get_sort_info();
        },
        w_sort: function (self) {
            var sort_name = jQuery(self).attr('sort-name');
            var order_by = jQuery(self).attr('order-by') == '' ? 'asc' : (jQuery(self).attr('order-by') == 'asc' ? 'desc' : 'asc');
            var sort = sort_name + "_" + order_by;

            jQuery.UbizOIWidget.o_page.find('div.dWT').removeClass('dWT');
            jQuery(self).attr('order-by', order_by);
            jQuery(self).addClass('dWT');
            jQuery(self).find('svg').removeClass('sVGT');
            jQuery(self).find('svg.' + order_by).addClass('sVGT');

            ubizapis('v1', '/customers', 'get', null, {
                'page': jQuery.UbizOIWidget.page,
                'sort': sort
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_o_delete: function () {
            var ids = jQuery.UbizOIWidget.w_get_checked_rows();
            if (ids.length == 0)
                return false;

            swal({
                title: i18next.t('Do you want to delete the data?'),
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    ubizapis('v1', '/customers/' + ids.join(',') + '/delete', 'delete', null, null, jQuery.UbizOIWidget.w_o_delete_callback);
                }
            })
        },
        w_i_delete: function () {
            var cus_id = jQuery("input[name=cus-id]").val();
            swal({
                title: i18next.t('Do you want to delete the data?'),
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    ubizapis('v1', '/customers/' + cus_id + '/delete', 'delete', null, null, jQuery.UbizOIWidget.w_i_delete_callback);
                }
            })
        },
        w_i_delete_callback: function (response) {
            if (response.data.success == true) {
                swal.fire({
                    type: 'success',
                    title: response.data.message,
                    onClose: () => {
                        jQuery.UbizOIWidget.w_go_back_to_output_page();
                        jQuery.UbizOIWidget.w_refresh_output_page();
                    }
                });
            } else {
                swal.fire({
                    type: 'error',
                    title: response.data.message,
                });
            }
        },
        w_create: function () {
            jQuery.UbizOIWidget.w_go_to_input_page(0);
        },
        w_fuzzy_search: function () {

            jQuery.UbizOIWidget.page = '0';

            var search = jQuery('#fuzzy').val();
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            var sort = sort_info.sort_name + "_" + sort_info.order_by;

            var params = {};
            params.page = '0';
            params.search = search;
            params.sort = sort;

            ubizapis('v1', '/customers', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_fuzzy_search_handle_enter(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                jQuery.UbizOIWidget.w_fuzzy_search();
            }
        },
        w_go_to_input_page: function (pos, id) {
            jQuery.UbizOIWidget.pos = pos;
            if (id == 0 || pos == 0) {
                ubizapis('v1', '/customers/cuscode', 'get', null, null, jQuery.UbizOIWidget.w_go_to_input_page_callback);
            } else {
                jQuery("#btn-delete").show();
                $("input[name=cus_code]").attr('disabled', true);
                $("input[name=cus_code]").closest('div.root_textfield').addClass('rootIsDisabled');
                ubizapis('v1', '/customers/' + id, 'get', null, null, jQuery.UbizOIWidget.w_render_data_to_input_page);
            }
        },
        w_go_to_input_page_callback: function (response) {

            var cus_code = '';
            if (response.data.success == true) {
                cus_code = response.data.cus_code;
            }

            jQuery("#btn-delete").hide();
            jQuery("#i-paging-label").hide();
            jQuery("#i-paging-older").hide();
            jQuery("#i-paging-newer").hide();
            jQuery.UbizOIWidget.w_clean_input_page();

            jQuery.UbizOIWidget.w_sleep_scrollbars(jQuery.UbizOIWidget.output_scrollbars);
            jQuery.UbizOIWidget.w_update_scrollbars(jQuery.UbizOIWidget.input_scrollbars);

            jQuery.UbizOIWidget.o_page.hide();
            jQuery.UbizOIWidget.i_page.fadeIn("slow");
            $("input[name=cus-code]").attr('disabled', false);
            $("input[name=cus-code]").closest('div.root_textfield').removeClass('rootIsDisabled');
            $("input[name=cus-code]").val(cus_code);
        },
        w_clean_input_page: function () {
            $('input[name="cus-id"]').val('0');
            $('input[name="cus-code"]').val('');
            $('input[name="cus-name"]').val('');
            $('input[name="cus-fax"]').val('');
            $('input[name="cus-mail"]').val('');
            $('input[name="cus-phone"]').val('');
            $('input[name="cus-field"]').val('');
            $('input[name="cus-avatar"]').val('');
            $('input[name="cad-id-1"]').val('0');
            $('input[name="cus-address-1"]').val('');
            $('input[name="cad-id-2"]').val('0');
            $('input[name="cus-address-2"]').val('');
            $('input[name="cad-id-3"]').val('0');
            $('input[name="cus-address-3"]').val('');
            $('select[name="cus-type"]').val('');
            $('select[name="cus-pic"]').val('');
            $('input[name="cus-file"]').val('');
            $('input[name="cus-flag"]').val('1');
            $("#con-summary-container").empty();
            $('img[name="cus-img"]').attr('src', jQuery.UbizOIWidget.none_img);
        },
        w_go_back_to_output_page: function (self) {
            jQuery.UbizOIWidget.o_page.fadeIn("slow");
            jQuery.UbizOIWidget.i_page.hide();
            jQuery.UbizOIWidget.w_sleep_scrollbars(jQuery.UbizOIWidget.input_scrollbars);
            jQuery.UbizOIWidget.w_update_scrollbars(jQuery.UbizOIWidget.output_scrollbars);
        },
        w_i_refresh: function () {
            swal({
                title: i18next.t('Do you want to refresh the data.?'),
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var cus_id = jQuery("input[name=cus-id]").val();
                    if (cus_id == '0') {
                        jQuery.UbizOIWidget.w_clean_input_page();
                    } else {
                        ubizapis('v1', '/customers/' + cus_id, 'get', null, null, jQuery.UbizOIWidget.w_render_data_to_input_page);
                    }
                }
            })
        },
        w_refresh_output_page: function () {
            jQuery('#fuzzy').val('');
            jQuery.UbizOIWidget.w_sort_reset();
            jQuery.UbizOIWidget.w_fuzzy_search();
        },
        w_sort_reset: function () {

            var sort_name = jQuery.UbizOIWidget.sort_default.sort_name;
            var order_by = jQuery.UbizOIWidget.sort_default.order_by;
            var sort_default_obj = jQuery.UbizOIWidget.o_page.find('div.dcB').find('div[sort-name=' + sort_name + ']');

            jQuery.UbizOIWidget.o_page.find('div.dcB').find('div.dWT').removeClass('dWT');
            jQuery.UbizOIWidget.o_page.find('div.dcB').find('svg.sVGT').removeClass('sVGT');
            sort_default_obj.attr('order-by', order_by);
            sort_default_obj.addClass('dWT');
            sort_default_obj.find('svg.' + order_by).addClass('sVGT');
        },
        w_get_sort_info: function () {
            var sort_obj = jQuery.UbizOIWidget.o_page.find('div.dWT');
            var sort_name = sort_obj.attr('sort-name');
            var order_by = sort_obj.attr('order-by');
            return {'sort_name': sort_name, 'order_by': order_by};
        },
        w_get_older_data: function (page) {
            jQuery.UbizOIWidget.page = page;
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            jQuery.UbizOIWidget.sort = sort_info;
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/customers', 'get', null, {
                'page': page,
                'sort': sort
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_get_newer_data: function (page) {
            jQuery.UbizOIWidget.page = page;
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            jQuery.UbizOIWidget.sort = sort_info;
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/customers', 'get', null, {
                'page': page,
                'sort': sort
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_o_delete_callback: function (response) {
            if (response.data.success == true) {
                swal.fire({
                    type: 'success',
                    title: response.data.message,
                    onClose: () => {
                        jQuery.UbizOIWidget.w_go_back_to_output_page(this);
                        jQuery.UbizOIWidget.w_fuzzy_search();
                    }
                });
            } else {
                swal.fire({
                    type: 'error',
                    title: response.data.message
                });
            }
        },
        w_render_data_to_ouput_page: function (response) {
            var table_html = "";
            var paging = response.data.paging;
            var customer = response.data.customers;
            if (customer.length > 0) {
                var rows = [];
                for (let i = 0; i < customer.length; i++) {
                    var cols = [];
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_code, 1));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_type_name, 2));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_name, 3));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_phone, 4));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_fax, 5));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_mail, 6));
                    if (customer[i].address[0] != undefined) {
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].address[0].cad_address, 7));
                    } else {
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, '', 7));
                    }
                    rows.push(jQuery.UbizOIWidget.w_make_row_html(customer[i].cus_id, cols, i, paging.page, paging.rows_per_page));
                }
                table_html += rows.join("");
            }
            jQuery.UbizOIWidget.o_page.find("#table-content").empty();
            jQuery.UbizOIWidget.o_page.find("#table-content").append(table_html);
            jQuery.UbizOIWidget.w_reset_f_checkbox_status();
            jQuery.UbizOIWidget.page = response.data.paging.page;
            jQuery.UbizOIWidget.w_o_paging(response.data.paging.page, response.data.paging.rows_num, response.data.paging.rows_per_page);
            jQuery.UbizOIWidget.rows_num = response.data.paging.rows_num;
        },
        w_render_data_to_input_page: function (response) {
            var cus = response.data.cus;
            var con = response.data.con;
            jQuery.UbizOIWidget.w_clean_input_page();
            jQuery.UbizOIWidget.w_set_input_page(cus, con);
            jQuery.UbizOIWidget.w_i_paging();

            jQuery.UbizOIWidget.o_page.hide();
            jQuery.UbizOIWidget.i_page.fadeIn("slow");
        },
        w_set_input_page: function (cus, con) {
            jQuery.UbizOIWidget.w_set_cus_form_data(cus);
            jQuery.UbizOIWidget.w_set_con_form_data(con);
        },
        w_make_row_html: function (id, cols, row_no, page_no, rows_per_page) {
            var row_html = '';
            if (cols.length > 0) {
                var pos = rows_per_page * page_no + row_no + 1;
                row_html = '<div class="jvD" ondblclick="jQuery.UbizOIWidget.w_go_to_input_page(' + pos + ',' + id + ')">';
                row_html += cols.join("");
                row_html += '</div>';
            }
            return row_html;
        },
        w_make_col_html: function (col_id, col_val, col_idx) {
            var col_html = "";
            col_html += '<div class="tcB col-' + col_idx + '">';
            col_html += '<div class="cbo">';
            if (col_idx == 1) {
                col_html += '<div class="jgQ" onclick="jQuery.UbizOIWidget.w_c_checkbox_click(this)">';
                col_html += '<input type="checkbox" class="ckb-i" value="' + col_id + '" style="display: none"/>';
                col_html += '<div class="asU ckb-c"></div>';
                col_html += '</div>';
            }
            if (col_idx == 1) {
                col_html += '<div class="nCT" title="' + col_val + '">';
            } else {
                col_html += '<div class="nCj" title="' + col_val + '">';
            }
            col_html += '<span>' + col_val + '</span>';
            col_html += '</div>';
            col_html += '</div>';
            col_html += '</div>';
            return col_html;
        },
        w_f_checkbox_click: function (self) {
            if (jQuery(self).find('div.ckb-f').hasClass('asU')) {
                jQuery.UbizOIWidget.o_page.find('.ckb-f').removeClass('asU');
                jQuery.UbizOIWidget.o_page.find('.ckb-f').removeClass('asP');
                jQuery.UbizOIWidget.o_page.find('.ckb-f').addClass('asC');
                jQuery.UbizOIWidget.o_page.find('.ckb-c').removeClass('asU');
                jQuery.UbizOIWidget.o_page.find('.ckb-c').addClass('asC');
                jQuery.UbizOIWidget.o_page.find('.ckb-i').prop('checked', true);
            } else {
                jQuery.UbizOIWidget.o_page.find('.ckb-f').removeClass('asC');
                jQuery.UbizOIWidget.o_page.find('.ckb-f').removeClass('asP');
                jQuery.UbizOIWidget.o_page.find('.ckb-f').addClass('asU');
                jQuery.UbizOIWidget.o_page.find('.ckb-c').removeClass('asC');
                jQuery.UbizOIWidget.o_page.find('.ckb-c').addClass('asU');
                jQuery.UbizOIWidget.o_page.find('.ckb-i').prop('checked', false);
            }
        },
        w_c_checkbox_click: function (self) {
            if (jQuery(self).find('.ckb-c').hasClass('asU')) {
                jQuery(self).find('.ckb-c').removeClass('asU');
                jQuery(self).find('.ckb-c').addClass('asC');
                jQuery(self).find('.ckb-i').prop('checked', true);
            } else {
                jQuery(self).find('.ckb-c').removeClass('asC');
                jQuery(self).find('.ckb-c').addClass('asU');
                jQuery(self).find('.ckb-i').prop('checked', false);
            }
            jQuery.UbizOIWidget.w_reset_f_checkbox_status();
        },
        w_reset_f_checkbox_status: function () {
            var row_length = jQuery.UbizOIWidget.o_page.find('.jvD').length;
            var checked_row_length = jQuery.UbizOIWidget.o_page.find('.ckb-i:checked').length;
            if (row_length == checked_row_length) {
                jQuery.UbizOIWidget.o_page.find('.ckb-f').removeClass('asU');
                jQuery.UbizOIWidget.o_page.find('.ckb-f').removeClass('asP');
                jQuery.UbizOIWidget.o_page.find('.ckb-f').addClass('asC');
            } else {
                if (checked_row_length == 0) {
                    jQuery.UbizOIWidget.o_page.find('.ckb-f').removeClass('asC');
                    jQuery.UbizOIWidget.o_page.find('.ckb-f').removeClass('asP');
                    jQuery.UbizOIWidget.o_page.find('.ckb-f').addClass('asU');
                } else {
                    jQuery.UbizOIWidget.o_page.find('.ckb-f').removeClass('asC');
                    jQuery.UbizOIWidget.o_page.find('.ckb-f').removeClass('asU');
                    jQuery.UbizOIWidget.o_page.find('.ckb-f').addClass('asP');
                }
            }
        },
        w_get_checked_rows: function () {
            var ids = [];
            var checked_rows = jQuery.UbizOIWidget.o_page.find('.ckb-i:checked');
            checked_rows.each(function (idx, ele) {
                var id = ele.value;
                ids.push(id);
            });
            return ids;
        },
        w_paging: function (page, rows_num, rows_per_page) {
            var page = parseInt(page);
            var f_num = (page * rows_per_page) + 1;
            var m_num = (page + 1) * rows_per_page;
            if (m_num > rows_num) m_num = rows_num;

            var older_page = page - 1;
            var newer_page = page + 1;

            var max_page = Math.ceil(rows_num / rows_per_page);

            var get_older_data_func = '';
            var get_newer_data_func = '';

            var older_css = 'adS';
            if (older_page > -1) {
                older_css = 'aaT';
                get_older_data_func = 'onclick="jQuery.UbizOIWidget.w_get_older_data(' + older_page + ')"';
            }

            var newer_css = 'adS';
            if (newer_page < max_page) {
                newer_css = 'aaT';
                get_newer_data_func = 'onclick="jQuery.UbizOIWidget.w_get_newer_data(' + newer_page + ')"';
            }

            var paging_label = '<div id="paging-label" class="amH" style="user-select: none"><span class="Dj"><span><span class="ts">' + f_num + '</span>–<span class="ts">' + m_num + '</span></span> / <span class="ts">' + rows_num + '</span></span></div>';
            var paging_older = '<div id="paging-older" ' + get_older_data_func + ' class="amD utooltip" title="Cũ hơn"><span class="amF">&nbsp;</span><img class="amI ' + older_css + '" src="./images/cleardot.gif" alt=""></div>';
            var paging_newer = '<div id="paging-newer" ' + get_newer_data_func + ' class="amD utooltip" title="Mới hơn"><span class="amF">&nbsp;</span><img class="amJ ' + newer_css + '" src="./images/cleardot.gif" alt=""></div>';

            jQuery("#paging-label").replaceWith(paging_label);
            jQuery("#paging-older").replaceWith(paging_older);
            jQuery("#paging-newer").replaceWith(paging_newer);
            jQuery('input[name="pageno"]').val(page);
        },
        w_set_cus_form_data: function (data) {
            jQuery('input[name="cus-id"]').val(data.cus_id);
            jQuery('input[name="cus-code"]').val(data.cus_code);
            jQuery('input[name="cus-name"]').val(data.cus_name);
            jQuery('input[name="cus-fax"]').val(data.cus_fax);
            jQuery('input[name="cus-mail"]').val(data.cus_mail);
            jQuery('input[name="cus-phone"]').val(data.cus_phone);
            jQuery('input[name="cus-field"]').val(data.cus_field);
            if (data.address.length > 0) {
                for (let i = 0; i < data.address.length; i++) {
                    jQuery('input[name="cad-id-' + (i + 1) + '"]').val(data.address[i].cad_id);
                    jQuery('input[name="cus-address-' + (i + 1) + '"]').val(data.address[i].cad_address);
                }
            }
            jQuery('select[name="cus-type"]').val(data.cus_type);
            jQuery('select[name="cus-pic"]').val(data.cus_pic);
            jQuery('input[name="cus-avatar"]').val(data.cus_avatar);
            if (data.cus_avatar != "") {
                jQuery('img[name="cus-img"]').attr('src', data.cus_avatar);
            }
        },
        w_get_cus_form_data: function () {
            var data = {};
            data.cus_id = jQuery('input[name="cus-id"]').val();
            data.cus_code = jQuery('input[name="cus-code"]').val();
            data.cus_name = jQuery('input[name="cus-name"]').val();
            data.cus_fax = jQuery('input[name="cus-fax"]').val();
            data.cus_mail = jQuery('input[name="cus-mail"]').val();
            data.cus_phone = jQuery('input[name="cus-phone"]').val();
            data.cus_field = jQuery('input[name="cus-field"]').val();
            data.cad_id_1 = jQuery('input[name="cad-id-1"]').val();
            data.cus_address_1 = jQuery('input[name="cus-address-1"]').val();
            data.cad_id_2 = jQuery('input[name="cad-id-2"]').val();
            data.cus_address_2 = jQuery('input[name="cus-address-2"]').val();
            data.cad_id_3 = jQuery('input[name="cad-id-3"]').val();
            data.cus_address_3 = jQuery('input[name="cus-address-3"]').val();
            data.cus_type = jQuery('select[name="cus-type"]').val();
            data.cus_pic = jQuery('select[name="cus-pic"]').val();
            data.cus_avatar = jQuery('input[name="cus-avatar"]').val();
            return data;
        },
        w_set_con_form_data: function (data) {
            var data = new Array();
            $("div[name=con-summary-detail]").each(function (index) {
                var con_data = jQuery.UbizOIWidget.w_get_con_form_data_detail($(this));
                data.push(con_data);
            });
            return data;
        },
        w_get_con_form_data: function () {
            var data = new Array();
            $("#con-summary-container").find("div[name=con-summary-detail]").each(function (index) {
                var con_data = jQuery.UbizOIWidget.w_get_con_form_data_detail($(this));
                data.push(con_data);
            });
            return data;
        },
        w_get_con_form_data_detail: function (form) {
            var data = {};
            data.con_id = form.find('input[name=dt-con-id]').val();
            data.con_name = form.find('input[name=dt-con-name]').val();
            data.con_mail = form.find('input[name=dt-con-mail]').val();
            data.con_phone = form.find('input[name=dt-con-phone]').val();
            data.con_duty = form.find('input[name=dt-con-duty]').val();
            data.con_avatar = form.find('input[name=dt-con-avatar]').val();
            return data;
        },
        w_save: function () {

            var data = {};
            data.cus_data = jQuery.UbizOIWidget.w_get_cus_form_data();
            data.con_data = jQuery.UbizOIWidget.w_get_con_form_data();

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
                    if (data.cus_data.cus_id != 0) {
                        ubizapis('v1', '/customers/' + data.cus_data.cus_id + '/update', 'post', {'data': data}, null, jQuery.UbizOIWidget.w_save_callback);
                    } else {
                        ubizapis('v1', '/customers', 'put', data, null, jQuery.UbizOIWidget.w_save_callback);
                    }
                }
            });
        },
        w_save_callback: function (response) {
            if (response.data.success == true) {
                swal.fire({
                    type: 'success',
                    title: response.data.message,
                    onClose: () => {
                        jQuery.UbizOIWidget.w_render_data_to_ouput_page(response);
                        jQuery.UbizOIWidget.w_go_back_to_output_page(this);
                    }
                })
            } else {
                swal.fire({
                    type: 'error',
                    title: response.data.message
                })
            }
        },
        w_i_paging: function () {

            var pos = jQuery.UbizOIWidget.pos;
            var rows_num = jQuery.UbizOIWidget.rows_num;
            var w_get_next_detail_data = '';
            var w_get_prev_detail_data = '';

            var prev_css = 'adS';
            if (pos > 1) {
                prev_css = 'aaT';
                w_get_prev_detail_data = 'onclick="jQuery.UbizOIWidget.w_get_detail_data(' + (pos - 1) + ')"';
            }

            var next_css = 'adS';
            if (pos < rows_num) {
                next_css = 'aaT';
                w_get_next_detail_data = 'onclick="jQuery.UbizOIWidget.w_get_detail_data(' + (pos + 1) + ')"';
            }

            var paging_label = '<div id="i-paging-label" class="amH" style="user-select: none"><span class="Dj"><span class="Dj"><span><span class="ts">' + pos + '</span></span> / <span class="ts">' + jQuery.UbizOIWidget.rows_num + '</span></span></div>';
            var paging_older = '<div id="i-paging-older" ' + w_get_prev_detail_data + ' class="amD itooltip" title="' + i18next.t('Older') + '"><span class="amF">&nbsp;</span><img class="amI ' + prev_css + '" src="/images/cleardot.gif" alt=""></div>';
            var paging_newer = '<div id="i-paging-newer" ' + w_get_next_detail_data + ' class="amD itooltip" title="' + i18next.t('Newer') + '"><span class="amF">&nbsp;</span><img class="amJ ' + next_css + '" src="/images/cleardot.gif" alt=""></div>';

            jQuery("#i-paging-label").replaceWith(paging_label);
            jQuery("#i-paging-older").replaceWith(paging_older);
            jQuery("#i-paging-newer").replaceWith(paging_newer);
            jQuery('.itooltip').tooltipster({
                side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
            });
        },
        w_get_detail_data: function (pos) {

            if (pos > jQuery.UbizOIWidget.rows_num || pos < 1)
                return false;

            var params = {};
            params.pos = pos;
            jQuery.UbizOIWidget.pos = pos;

            var search = jQuery('#fuzzy').val();
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            var sort = sort_info.sort_name + "_" + sort_info.order_by;

            params.search = search;
            params.sort = sort;

            var cus_id = jQuery.UbizOIWidget.i_page.find("input[name=cus-id]").val();

            ubizapis('v1', '/customers/' + cus_id, 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_input_page);
        },
        w_o_paging: function (page, rows_num, rows_per_page) {
            var page = parseInt(page);
            var f_num = (page * rows_per_page) + 1;
            var m_num = (page + 1) * rows_per_page;
            if (m_num > rows_num) m_num = rows_num;
            if (f_num > rows_num) f_num = rows_num;

            var older_page = page - 1;
            var newer_page = page + 1;

            var max_page = Math.ceil(rows_num / rows_per_page);

            var get_older_data_func = '';
            var get_newer_data_func = '';

            var older_css = 'adS';
            if (older_page > -1) {
                older_css = 'aaT';
                get_older_data_func = 'onclick="jQuery.UbizOIWidget.w_get_older_data(' + older_page + ')"';
            }

            var newer_css = 'adS';
            if (newer_page < max_page) {
                newer_css = 'aaT';
                get_newer_data_func = 'onclick="jQuery.UbizOIWidget.w_get_newer_data(' + newer_page + ')"';
            }

            var paging_label = '<div id="paging-label" class="amH" style="user-select: none"><span class="Dj"><span><span class="ts">' + f_num + '</span>–<span class="ts">' + m_num + '</span></span> / <span class="ts">' + rows_num + '</span></span></div>';
            var paging_older = '<div id="paging-older" ' + get_older_data_func + ' class="amD utooltip" title="' + i18next.t('Older') + '"><span class="amF">&nbsp;</span><img class="amI ' + older_css + '" src="http://ubiz.local/images/cleardot.gif" alt=""></div>';
            var paging_newer = '<div id="paging-newer" ' + get_newer_data_func + ' class="amD utooltip" title="' + i18next.t('Newer') + '"><span class="amF">&nbsp;</span><img class="amJ ' + newer_css + '" src="http://ubiz.local/images/cleardot.gif" alt=""></div>';

            jQuery("#paging-label").replaceWith(paging_label);
            jQuery("#paging-older").replaceWith(paging_older);
            jQuery("#paging-newer").replaceWith(paging_newer);
        },
        w_callback_remove_image: function () {
            $("#cus-file").val("");
            $("#cus-flag").val(1);
        },
        w_sleep_scrollbars: function (instance) {
            if (typeof instance == "undefined")
                return false;
            instance.sleep();
        },
        w_update_scrollbars: function (instance) {

            if (typeof instance == "undefined")
                return false;
            instance.update();
        },
        w_cus_avatar_click: function () {
            $('#cus-file').click();
        },
        w_cus_avatar_change: function (self) {
            if (self.files && self.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cus-img').attr('src', e.target.result);
                    $('#cus-avatar').attr('src', e.target.result);
                }
                reader.readAsDataURL(self.files[0]);
            }
            $("#cus-flag").val(2);
        },
        w_con_avatar_change: function (self) {
            if (self.files && self.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#m-con-img').attr('src', e.target.result);
                    $('#m-con-avatar').val(e.target.result);
                }
                reader.readAsDataURL(self.files[0]);
            }
            $("#m-con-flag").val(2);
        },
        w_con_avatar_click: function () {
            $('#m-con-file').click();
        },
        w_con_remove_image: function () {
            $("#m-con-flag").val(1);
            $("#m-con-file").val("");
            $("#m-con-avatar").val("");
        },
        w_con_set_modal_data: function (data) {
            $("#m-con-id").val(data.con_id);
            $("#m-con-name").val(data.con_name);
            $("#m-con-mail").val(data.con_mail);
            $("#m-con-phone").val(data.con_phone);
            $("#m-con-duty").val(data.con_duty);

            if (data.con_avatar == '') {
                data.con_avatar = jQuery.UbizOIWidget.none_img;
            }

            $("#m-con-img").attr('src', data.con_avatar);
            if (data.con_avatar == jQuery.UbizOIWidget.none_img) {
                $("#m-con-avatar").val('');
            } else {
                $("#m-con-avatar").val(data.con_avatar);
            }
        },
        w_con_get_modal_data: function () {
            var data = {};
            data.con_id = $("#contact-modal").find('input[name=m-con-id]').val();
            data.con_name = $("#contact-modal").find('input[name=m-con-name]').val();
            data.con_mail = $("#contact-modal").find('input[name=m-con-mail]').val();
            data.con_phone = $("#contact-modal").find('input[name=m-con-phone]').val();
            data.con_duty = $("#contact-modal").find('input[name=m-con-duty]').val();
            data.con_avatar = $("#contact-modal").find('input[name=m-con-avatar]').val();
            return data;
        },
        w_con_modal_save: function () {
            var summary_data = jQuery.UbizOIWidget.w_con_get_modal_data();
            var summary_html = jQuery.UbizOIWidget.w_con_clone_summary_html();
            if (jQuery.UbizOIWidget.con_summary_detail == null) {
                jQuery.UbizOIWidget.con_summary_detail = jQuery.UbizOIWidget.w_con_add_summary_html(summary_html);
            }
            jQuery.UbizOIWidget.w_con_set_summary_data(jQuery.UbizOIWidget.con_summary_detail, summary_data);
            $('#contact-modal').modal('hide');
        },
        w_con_add: function () {
            var clean_data = {
                con_id: '0',
                con_name: '',
                con_mail: '',
                con_phone: '',
                con_duty: '',
                con_avatar: jQuery.UbizOIWidget.none_img
            };
            jQuery.UbizOIWidget.con_summary_detail = null;
            jQuery.UbizOIWidget.w_con_set_modal_data(clean_data);
            $("#contact-modal").modal('show');
        },
        w_con_edit: function (self, event) {
            jQuery.UbizOIWidget.con_summary_detail = $(self).closest('div[name=con-summary-detail]');
            var data = jQuery.UbizOIWidget.w_get_con_form_data_detail(jQuery.UbizOIWidget.con_summary_detail);
            jQuery.UbizOIWidget.w_con_set_modal_data(data);
            $('#contact-modal').modal('show');
        },
        w_con_del: function (self, event) {
            swal({
                title: i18next.t('Do you want to delete the data?'),
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var form = $(self).closest('div[name=con-summary-detail]');
                    var con_id = form.find('input[name=dt-con-id]').val();
                    if (con_id == '0') {
                        form.remove();
                    } else {
                        form.addClass('deleted');
                    }
                }
            });
        },
        w_con_clone_summary_html: function () {
            return $("div[name=con-summary]").clone(true).html();
        },
        w_con_add_summary_html: function (summary_html) {
            $("#con-summary-container").append(summary_html);
            return $("#con-summary-container").find("div[name=con-summary-detail]:last-child");
        },
        w_con_set_summary_data: function (form, data) {
            form.find('input[name=dt-con-id]').val(data.con_id);
            form.find('input[name=dt-con-name]').val(data.con_name);
            form.find('input[name=dt-con-mail]').val(data.con_mail);
            form.find('input[name=dt-con-phone]').val(data.con_phone);
            form.find('input[name=dt-con-duty]').val(data.con_duty);
            form.find('input[name=dt-con-avatar]').val(data.con_avatar);
            form.find('img[name=dt-con-avatar-view]').attr('src', data.con_avatar);
            form.find('span[name=dt-con-name-view]').text(data.con_name);
        }
    });
})(jQuery);
jQuery(document).ready(function () {
    jQuery.UbizOIWidget.w_init();
    $('#contact-modal').on('shown.bs.modal', function () {
        $('#m-con-name').trigger('focus');
        var con_id = $(self).closest('div[name=con-summary-detail]').find('input[name=dt-con-id]').val();
        if (con_id == '0') {
            $("#contact-modal").find(".modal-title").text('Thêm người liên hệ');
        } else {
            $("#contact-modal").find(".modal-title").text('Sửa người liên hệ');
        }
    });
    $('#contact-modal').on('hidden.bs.modal', function () {
        $("img[name=ajax-loader]").hide();
    })
});