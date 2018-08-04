(function ($) {
    UbizOIWidget = function () {
        this.page = 0;
        this.sort = {};
        this.pos = 0;
        this.rows_num = 0;
        this.o_page = null;
        this.i_page = null;
    };

    jQuery.UbizOIWidget = new UbizOIWidget();
    jQuery.extend(UbizOIWidget.prototype, {
        w_init: function () {
            jQuery.UbizOIWidget.o_page = jQuery("#o-put");
            jQuery.UbizOIWidget.i_page = jQuery("#i-put");
            jQuery('#nicescroll-sidebar').niceScroll({
                cursorcolor: "#9fa8b0",
                cursorwidth: "5px",
                cursorborder: "none",
                cursorborderradius: 5,
                cursoropacitymin: 0.4,
                scrollbarid: 'nc-sidebar',
                autohidemode: false,
                horizrailenabled: false
            });
            jQuery('#nicescroll-oput').niceScroll({
                cursorcolor: "#9fa8b0",
                cursorwidth: "5px",
                cursorborder: "none",
                cursorborderradius: 5,
                cursoropacitymin: 0.4,
                scrollbarid: 'nc-oput',
                autohidemode: false,
                horizrailenabled: false
            });
            jQuery('.utooltip').tooltipster({
                side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
            });
            jQuery(".i-numeric").forceNumeric();
        },
        w_sort: function (self) {

            var params = {};
            params.page = jQuery.UbizOIWidget.page;

            var search_info = jQuery.UbizOIWidget.w_get_search_info();
            Object.assign(params, search_info);

            var sort_name = jQuery(self).attr('sort-name');
            var order_by = jQuery(self).attr('order-by') == '' ? 'asc' : (jQuery(self).attr('order-by') == 'asc' ? 'desc' : 'asc');
            params.sort = sort_name + "_" + order_by;

            jQuery.UbizOIWidget.o_page.find('div.dWT').removeClass('dWT');
            jQuery(self).attr('order-by', order_by);
            jQuery(self).addClass('dWT');
            jQuery(self).find('svg').removeClass('sVGT');
            jQuery(self).find('svg.' + order_by).addClass('sVGT');

            ubizapis('v1', '/currency', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_save: function () {
            var form_data = jQuery.UbizOIWidget.w_get_form_data();
            var id = jQuery("#txt_id").val();
            form_data.append("id", id);
            if (id == "0") {
                form_data.append('_method', 'put');
                ubizapis('v1', '/currency', 'post', form_data, null, function(response){
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
                        }).then((result) => {
                            if (result.value) {
                                jQuery.UbizOIWidget.w_clean_input_page();
                            } else if (result.dismiss === swal.DismissReason.cancel) {
                                jQuery.UbizOIWidget.w_go_back_to_output_page();
                                jQuery.UbizOIWidget.w_refresh_output_page();
                            }
                        })
                    } else {
                        swal({
                            type: 'error',
                            text: response.data.message
                        });
                    }
                });
            } else {
                ubizapis('v1', '/currency/' + id + '/update', 'post', form_data, null, jQuery.UbizOIWidget.w_save_callback);
            }
        },
        w_o_delete: function () {
            var ids = jQuery.UbizOIWidget.w_get_checked_rows();
            if (ids.length == 0)
                return false;

            swal({
                title: i18next.t('Do you want to delete the data?'),
                text: i18next.t('Once deleted, you will not be able to recover this data!'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    ubizapis('v1', '/currency/' + ids.join(',') + '/delete', 'delete', null, null, jQuery.UbizOIWidget.w_o_delete_callback);
                }
            })
        },
        w_i_delete: function () {
            var id = jQuery("#txt_id").val();
            swal({
                title: i18next.t('Do you want to delete the data?'),
                text: i18next.t('Once deleted, you will not be able to recover this data!'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    ubizapis('v1', '/currency/' + id + '/delete', 'delete', null, null, jQuery.UbizOIWidget.w_i_delete_callback);
                }
            })
        },
        w_refresh: function () {
            var id = jQuery("#txt_id").val();
            if (id == '0') {
                jQuery.UbizOIWidget.w_clean_input_page();
            } else {
                ubizapis('v1', '/currency/' + id, 'get', null, null, jQuery.UbizOIWidget.w_render_data_to_input_page);
            }
        },
        w_save_callback: function (response) {
            if (response.data.success == true) {
                jQuery.UbizOIWidget.w_go_back_to_output_page();
                jQuery.UbizOIWidget.w_refresh_output_page();
            } else {
                swal({
                    type: 'error',
                    text: response.data.message
                });
            }
        },
        w_search: function () {

            var params = {};
            params.page = '0';

            var search_info = jQuery.UbizOIWidget.w_get_search_info();
            Object.assign(params, search_info);

            if (jQuery.isEmptyObject(search_info) === false) {
                var fuzzy = jQuery.UbizOIWidget.w_convert_search_info_to_fuzzy(search_info);
                jQuery('#fuzzy').val(fuzzy);
            }

            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            params.sort = sort_info.sort_name + "_" + sort_info.order_by;

            var event = new CustomEvent("click");
            document.body.dispatchEvent(event);
            ubizapis('v1', '/currency', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_clear_search_form: function () {
            jQuery('#fuzzy').val("");
            jQuery.UbizOIWidget.w_clear_advance_search_form();
            jQuery.UbizOIWidget.w_refresh_output_page();

        },
        w_clear_advance_search_form: function () {
            jQuery('#code').val("");
            jQuery('#name').val("");
            jQuery('#symbol').val("");
            jQuery('#state').val("");
            jQuery('#contain').val("");
            jQuery('#notcontain').val("");
        },
        w_update_search_form: function (search_info) {
            jQuery.UbizOIWidget.w_clear_advance_search_form();
            jQuery.each(search_info, function (key, val) {
                var search_item = jQuery('#' + key);
                if (search_item.length == 1) {
                    search_item.val(val);
                }
            });
        },
        w_fuzzy_search: function () {
            var params = {};
            params.page = '0';
            jQuery.UbizOIWidget.page = '0';

            var fuzzy = jQuery('#fuzzy').val();
            var search_info = jQuery.UbizOIWidget.w_convert_fuzzy_to_search_info(fuzzy);
            jQuery.UbizOIWidget.w_update_search_form(search_info);
            Object.assign(params, search_info);

            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            params.sort = sort;

            ubizapis('v1', '/currency', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_fuzzy_search_handle_enter(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                jQuery.UbizOIWidget.w_fuzzy_search();
            }
        },
        w_go_to_input_page: function (pos ,id) {
            jQuery.UbizOIWidget.pos = pos;
            if (id == 0 || pos == 0) {
                jQuery("#btn-delete").hide();
                jQuery("#i-paging-label").hide();
                jQuery("#i-paging-older").hide();
                jQuery("#i-paging-newer").hide();
                jQuery.UbizOIWidget.w_clean_input_page();
                jQuery.UbizOIWidget.o_page.hide();
                jQuery.UbizOIWidget.i_page.fadeIn("slow");
                jQuery('#nicescroll-oput').getNiceScroll().remove();
                jQuery('#nicescroll-iput').getNiceScroll().remove();
                jQuery('#nicescroll-iput').niceScroll({
                    cursorcolor: "#9fa8b0",
                    cursorwidth: "5px",
                    cursorborder: "none",
                    cursorborderradius: 5,
                    cursoropacitymin: 0.4,
                    scrollbarid: 'nc-input',
                    autohidemode: false,
                    horizrailenabled: false
                });
            } else {
                jQuery("#btn-delete").show();
                ubizapis('v1', '/currency/' + id, 'get', null, null, jQuery.UbizOIWidget.w_render_data_to_input_page);
            }
        },
        w_go_back_to_output_page: function () {
            jQuery.UbizOIWidget.o_page.fadeIn("slow");
            jQuery.UbizOIWidget.i_page.hide();
            jQuery('#nicescroll-oput').getNiceScroll().remove();
            jQuery('#nicescroll-iput').getNiceScroll().remove();
            jQuery('#nicescroll-oput').niceScroll({
                cursorcolor: "#9fa8b0",
                cursorwidth: "5px",
                cursorborder: "none",
                cursorborderradius: 5,
                cursoropacitymin: 0.4,
                scrollbarid: 'nc-oput',
                autohidemode: false,
                horizrailenabled: false
            });
        },
        w_refresh_output_page: function () {
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/currency', 'get', null, {
                'page': jQuery.UbizOIWidget.page,
                'sort': sort
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_get_sort_info: function () {
            var sort_obj = jQuery.UbizOIWidget.o_page.find('div.dWT');
            var sort_name = sort_obj.attr('sort-name');
            var order_by = sort_obj.attr('order-by');
            return {'sort_name': sort_name, 'order_by': order_by};
        },
        w_get_search_info: function () {

            var search_info = {};

            if (jQuery('#code').val().replace(/\s/g, '') != '') {
                search_info.code = jQuery('#code').val();
            }

            if (jQuery('#name').val().replace(/\s/g, '') != '') {
                search_info.name = jQuery('#name').val();
            }

            if (jQuery('#symbol').val().replace(/\s/g, '') != '') {
                search_info.symbol = jQuery('#symbol').val();
            }

            if (jQuery('#state').val().replace(/\s/g, '') != '') {
                search_info.state = jQuery('#state').val();
            }


            if (jQuery('#contain').val().replace(/\s/g, '') != '') {
                search_info.contain = jQuery('#contain').val();
            }

            if (jQuery('#notcontain').val().replace(/\s/g, '') != '') {
                search_info.notcontain = jQuery('#notcontain').val();
            }

            return search_info;
        },
        w_convert_search_info_to_fuzzy: function (search_info) {
            var fuzzy = JSON.stringify(search_info);
            return fuzzy;
        },
        w_convert_fuzzy_to_search_info: function (fuzzy) {
            var search_info = {};
            try {
                search_info = JSON.parse(fuzzy);
            } catch (e) {
                var fuzzy_info = fuzzy.split('-');
                if (fuzzy_info.length == 1) {
                    search_info.contain = fuzzy;
                } else {
                    fuzzy_info.shift();
                    search_info.notcontain = fuzzy_info.join('-');
                }
            }
            return search_info;
        },
        w_get_older_data: function (page) {
            jQuery.UbizOIWidget.page = page;
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            jQuery.UbizOIWidget.sort = sort_info;
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/currency', 'get', null, {
                'page': page,
                'sort': sort
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_get_newer_data: function (page) {
            jQuery.UbizOIWidget.page = page;
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            jQuery.UbizOIWidget.sort = sort_info;
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/currency', 'get', null, {
                'page': page,
                'sort': sort
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_o_delete_callback: function (response) {
            if (response.data.success == true) {
                jQuery.UbizOIWidget.w_render_data_to_ouput_page(response);
                swal({
                    type: 'success',
                    text: response.data.message
                });
            } else {
                swal({
                    type: 'error',
                    text: response.data.message
                });
            }
        },
        w_i_delete_callback: function (response) {
            if (response.data.success == true) {
                swal({
                    type: 'success',
                    text: response.data.message,
                    onClose: function(){
                        jQuery.UbizOIWidget.w_go_back_to_output_page();
                        jQuery.UbizOIWidget.w_refresh_output_page();
                    }
                });
            } else {
                swal({
                    type: 'error',
                    text: response.data.message
                });
            }
        },
        w_render_data_to_ouput_page: function (response) {
            var table_html = "";
            var currency = response.data.currency;
            if (currency.length > 0) {
                var rows = [];
                for (let i = 0; i < currency.length; i++) {
                    var cols = [];
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(currency[i].cur_id, currency[i].cur_id, 1));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(currency[i].cur_id, currency[i].cur_name, 2));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(currency[i].cur_id, currency[i].cur_code, 3));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(currency[i].cur_id, currency[i].cur_symbol, 4));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(currency[i].cur_id, currency[i].cur_state, 5));
                    rows.push(jQuery.UbizOIWidget.w_make_row_html(currency[i].cur_id, cols));
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
            var currency = response.data.currency;
            jQuery.UbizOIWidget.w_clean_input_page();
            jQuery.UbizOIWidget.w_set_input_page(currency);
            jQuery.UbizOIWidget.w_i_paging();

            jQuery.UbizOIWidget.o_page.hide();
            jQuery.UbizOIWidget.i_page.fadeIn("slow");
            jQuery('#nicescroll-oput').getNiceScroll().remove();
            jQuery('#nicescroll-iput').getNiceScroll().remove();
            jQuery('#nicescroll-iput').niceScroll({
                cursorcolor: "#9fa8b0",
                cursorwidth: "5px",
                cursorborder: "none",
                cursorborderradius: 5,
                cursoropacitymin: 0.4,
                scrollbarid: 'nc-input',
                autohidemode: false,
                horizrailenabled: false
            });
        },
        w_clean_input_page: function () {
            jQuery.UbizOIWidget.i_page.find("#txt_id").val("0");
            jQuery.UbizOIWidget.i_page.find("#txt_code").val("");
            jQuery.UbizOIWidget.i_page.find("#txt_name").val("");
            jQuery.UbizOIWidget.i_page.find("#txt_symbol").val("");
            jQuery.UbizOIWidget.i_page.find("#txt_state").val("");
            jQuery.UbizOIWidget.i_page.find("img.img-thumbnail").attr('src', "../images/avatar.png");
        },
        w_set_input_page: function (data) {
            jQuery.UbizOIWidget.i_page.find("#txt_id").val(data.cur_id);
            jQuery.UbizOIWidget.i_page.find("#txt_code").val(data.cur_code);
            jQuery.UbizOIWidget.i_page.find("#txt_name").val(data.cur_name);
            jQuery.UbizOIWidget.i_page.find("#txt_symbol").val(data.cur_symbol);
            jQuery.UbizOIWidget.i_page.find("#txt_state").val(data.cur_state);
            if(data.cur_avatar != ''){
                jQuery.UbizOIWidget.i_page.find("img.img-thumbnail").attr('src', data.cur_avatar);
            }
        },
        w_make_row_html: function (id, cols) {
            var row_html = '';
            if (cols.length > 0) {
                row_html = '<div class="jvD" ondblclick="jQuery.UbizOIWidget.w_go_to_input_page(' + id + ',this)">';
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
        w_get_form_data: function () {
            var form_data = new FormData();
            form_data.append('txt_name', jQuery("#txt_name").val());
            form_data.append('txt_code', jQuery("#txt_code").val());

            if (jQuery('input[name=inp-upload-image]')[0].files.length > 0) {
                form_data.append('avatar', jQuery('input[name=inp-upload-image]')[0].files[0]);
            }

            form_data.append('txt_symbol', jQuery("#txt_symbol").val());
            form_data.append('txt_state', jQuery("#txt_state").val());

            return form_data;
        },
        w_get_detail_data: function (pos) {

            if (pos > jQuery.UbizOIWidget.rows_num || pos < 1)
                return false;

            var params = {};
            params.pos = pos;
            jQuery.UbizOIWidget.pos = pos;

            var search_info = jQuery.UbizOIWidget.w_get_search_info();
            Object.assign(params, search_info);

            if (jQuery.isEmptyObject(search_info) === false) {
                var fuzzy = jQuery.UbizOIWidget.w_convert_search_info_to_fuzzy(search_info);
                jQuery('#fuzzy').val(fuzzy);
            }

            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            params.sort = sort_info.sort_name + "_" + sort_info.order_by;

            var id = jQuery.UbizOIWidget.i_page.find("#txt_id").val();

            ubizapis('v1', '/currency/' + id, 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_input_page);
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
        }
    });
})(jQuery);
jQuery(document).ready(function () {
    jQuery.UbizOIWidget.w_init();
});