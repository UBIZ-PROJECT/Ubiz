(function ($) {
    UbizOIWidget = function () {
        this.page = 0;
        this.sort = {};
        this.sort_default = {};
        this.o_page = null;
        this.sidebar_scrollbars = null;
        this.output_scrollbars = null;
    };
    jQuery.UbizOIWidget = new UbizOIWidget();
    jQuery.extend(UbizOIWidget.prototype, {
        w_init: function () {
            jQuery.UbizOIWidget.o_page = jQuery("#o-put");
            jQuery.UbizOIWidget.sidebar_scrollbars = fnc_set_scrollbars("nicescroll-sidebar");
            jQuery.UbizOIWidget.output_scrollbars = fnc_set_scrollbars("nicescroll-oput");
            jQuery('.utooltip').tooltipster({
                side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
            });
            jQuery.UbizOIWidget.sort_default = jQuery.UbizOIWidget.w_get_sort_info();
        },
        w_sort: function (self) {
            var sort_name = jQuery(self).attr('sort-name');
            var order_by = jQuery(self).attr('order-by') == '' ? 'asc' : (jQuery(self).attr('order-by') == 'asc' ? 'desc' : 'asc');
            var sort = sort_name + "_" + order_by;
            var search = jQuery('#fuzzy').val();

            jQuery.UbizOIWidget.o_page.find('div.dWT').removeClass('dWT');
            jQuery(self).attr('order-by', order_by);
            jQuery(self).addClass('dWT');
            jQuery(self).find('svg').removeClass('sVGT');
            jQuery(self).find('svg.' + order_by).addClass('sVGT');

            ubizapis('v1', '/contracts', 'get', null, {
                'search': search,
                'page': jQuery.UbizOIWidget.page,
                'sort': sort
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
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
        w_delete: function (ids) {
            if (ids == 0) {
                var ids = jQuery.UbizOIWidget.w_get_checked_rows();
            }
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
                    var uri = '/contracts/' + ids.join(',') + '/delete';
                    ubizapis('v1', uri, 'delete', null, null, jQuery.UbizOIWidget.w_delete_callback);
                }
            });
        },
        w_delete_callback: function (response) {
            if (response.data.success == true) {
                swal.fire({
                    type: 'success',
                    title: response.data.message,
                    onClose: () => {
                        jQuery.UbizOIWidget.w_fuzzy_search();
                    }
                })
            } else {
                swal.fire({
                    type: 'error',
                    title: response.data.message
                })
            }
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

            ubizapis('v1', '/contracts', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_fuzzy_search_handle_enter(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                jQuery.UbizOIWidget.w_fuzzy_search();
            }
        },
        w_refresh_output_page: function () {
            jQuery('#fuzzy').val('');
            jQuery.UbizOIWidget.w_sort_reset();
            jQuery.UbizOIWidget.w_fuzzy_search();
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
            var search = jQuery('#fuzzy').val();
            ubizapis('v1', '/contracts', 'get', null, {
                'page': page,
                'sort': sort,
                'search': search
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_get_newer_data: function (page) {
            jQuery.UbizOIWidget.page = page;
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            jQuery.UbizOIWidget.sort = sort_info;
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            var search = jQuery('#fuzzy').val();
            ubizapis('v1', '/contracts', 'get', null, {
                'page': page,
                'sort': sort,
                'search': search
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_render_data_to_ouput_page: function (response) {
            var table_html = "";
            var contracts = response.data.contracts;
            if (contracts.length > 0) {
                var rows = [];
                for (let i = 0; i < contracts.length; i++) {
                    var cols = [];
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(contracts[i].ctr_id, contracts[i].ctr_no, 1));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(contracts[i].ctr_id, moment(contracts[i].ord_date).format('YYYY/MM/DD'), 2));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(contracts[i].ctr_id, contracts[i].sale_name, 3));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(contracts[i].ctr_id, contracts[i].cus_name, 4));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(contracts[i].ctr_id, numeral(contracts[i].ctr_amount_tax).format('0,0'), 5));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(contracts[i].ctr_id, numeral(contracts[i].ctr_paid).format('0,0'), 6));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(contracts[i].ctr_id, numeral(contracts[i].ctr_debt).format('0,0'), 7));
                    rows.push(jQuery.UbizOIWidget.w_make_row_html(contracts[i].ctr_id, cols));
                }
                table_html += rows.join("");
            }
            jQuery.UbizOIWidget.o_page.find("#table-content").empty();
            jQuery.UbizOIWidget.o_page.find("#table-content").append(table_html);
            jQuery.UbizOIWidget.w_reset_f_checkbox_status();
            jQuery.UbizOIWidget.page = response.data.paging.page;
            jQuery.UbizOIWidget.w_paging(response.data.paging.page, response.data.paging.rows_num, response.data.paging.rows_per_page);
        },
        w_render_sale_step: function (sale_step) {
            var sale_step_name = "";
            switch (sale_step) {
                case '1':
                    sale_step_name = i18next.t('QP');
                    break;
                case '1':
                    sale_step_name = i18next.t('Order');
                    break;
                case '1':
                    sale_step_name = i18next.t('Contract');
                    break;
                case '1':
                    sale_step_name = i18next.t('Delivery');
                    break;
            }
            return '<span className="badge badge-success">' + sale_step_name + '</span>';
        },
        w_go_to_input_page: function (id) {
            window.location.href = '/contracts/' + id;
        },
        w_make_row_html: function (id, cols) {
            var row_html = '';
            if (cols.length > 0) {
                row_html = '<div class="jvD" ondblclick="jQuery.UbizOIWidget.w_go_to_input_page(' + id + ')">';
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
        w_make_col_status_html: function (col_htm, col_idx) {
            var col_html = "";
            col_html += '<div class="tcB col-' + col_idx + '">';
            col_html += '<div class="cbo">';
            col_html += '<div class="nCj">';
            col_html += col_htm;
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
        w_sleep_scrollbars: function (instance) {
            if (typeof instance == "undefined")
                return false;
            instance.sleep();
        },
        w_update_scrollbars: function (instance) {

            if (typeof instance == "undefined")
                return false;
            instance.update();
        }
    });
})(jQuery);
jQuery(document).ready(function () {
    jQuery.UbizOIWidget.w_init();
});