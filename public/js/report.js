(function ($) {
    UbizOIWidget = function () {
        this.page = 0;
        this.sort = {};
        this.o_page = null;
        this.i_page = null;
        this.sidebar_scrollbars = null;
        this.output_scrollbars = null;
        this.input_scrollbars = null;
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
            var current_path = $(location).attr('pathname');
            if (current_path == "/report/revenue")
            {
                $("#rp_rev").attr('class', 'aW aT');
            } else if (current_path == "/report/quoteprice") {
                $("#rp_pri").attr('class', 'aW aT');
            } else {
                $("#rp_rep").attr('class', 'aW aT');
            }

            $("#rp_rep").click(function(){
                window.location.href = "/report/repository";
            });

            $("#rp_rev").click(function(){
                window.location.href = "/report/revenue";
            });

            $("#rp_pri").click(function(){
                window.location.href = "/report/quoteprice";
            });

            fnc_datepicker('input[name=report_from_date]');
            fnc_datepicker('input[name=report_to_date]');
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

            var current_path = $(location).attr('pathname');

            ubizapis('v1', current_path, 'get', null, {
                'page': jQuery.UbizOIWidget.page,
                'sort': sort,
                'report_from_date': jQuery("#report_from_date").val(),
                'report_to_date': jQuery("#report_to_date").val(),
                'cus_name': jQuery("#cus_name").val(),
                'sale_name': jQuery("#sale_name").val(),
                'prd_name': jQuery("#prd_name").val(),
                'brd_name': jQuery("#brd_name").val(),
                'prd_query_type': jQuery("#prd_query_type option:selected").val()
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
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
        w_get_sort_info: function () {
            var sort_obj = jQuery.UbizOIWidget.o_page.find('div.dWT');
            var sort_name = sort_obj.attr('sort-name');
            var order_by = sort_obj.attr('order-by');
            return {'sort_name': sort_name, 'order_by': order_by};
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
        w_get_older_data: function (page) {
            jQuery.UbizOIWidget.page = page;
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            jQuery.UbizOIWidget.sort = sort_info;
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            var current_path = $(location).attr('pathname');
            ubizapis('v1', current_path, 'get', null, {
                'page': page,
                'sort': sort,
                'report_from_date': jQuery("#report_from_date").val(),
                'report_to_date': jQuery("#report_to_date").val(),
                'cus_name': jQuery("#cus_name").val(),
                'sale_name': jQuery("#sale_name").val()
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_get_newer_data: function (page) {
            jQuery.UbizOIWidget.page = page;
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            jQuery.UbizOIWidget.sort = sort_info;
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            var current_path = $(location).attr('pathname');
            ubizapis('v1', current_path, 'get', null, {
                'page': page,
                'sort': sort,
                'report_from_date': jQuery("#report_from_date").val(),
                'report_to_date': jQuery("#report_to_date").val(),
                'cus_name': jQuery("#cus_name").val(),
                'sale_name': jQuery("#sale_name").val()
            }, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_render_data_to_ouput_page: function (response) {
            var table_html = "";
            var report = response.data.report;
            // console.log(response)
            if (report.length > 0) {
                var rows = [];
                for (let i = 0; i < report.length; i++) {
                    var cols = [];
                    if (response.data.type == "revenue") {
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].ord_no, 1));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].ord_date, 2));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].ord_rel_fee + ' ₫', 3));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].ord_amount + ' ₫', 4));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].cus_name, 5));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].contact_name, 6));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].contact_phone, 7));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].contact_email, 8));
                        if(response.data.permission == '1') {
                            cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].sale_name, 9));
                        }

                        rows.push(jQuery.UbizOIWidget.w_make_row_html(report[i].ord_id, cols));
                    } else if (response.data.type == "quoteprice") {
                        if (report[i].ord_amount) {
                            report[i].ord_amount += ' ₫';
                        }
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].qp_no, 1));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].qp_date, 2));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].qp_exp_date, 3));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].qp_amount + ' ₫', 4));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].ord_amount, 4));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].cus_name, 5));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].contact_name, 6));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].contact_phone, 7));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].contact_email, 8));
                        if(response.data.permission == '1') {
                            cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].sale_name, 9));
                        }

                        rows.push(jQuery.UbizOIWidget.w_make_row_html(report[i].qp_id, cols));
                    } else {
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].brd_name, 1));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].prd_name, 2));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].prd_unit, 3));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].start_time_cnt, 4));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].import_cnt, 5));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].export_cnt, 6));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].end_time_cnt, 7));
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].keep_prd_cnt, 8));
                        if (report[i].serial_no_list) {
                            cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].serial_no_list, 9));
                        } else {
                            cols.push(jQuery.UbizOIWidget.w_make_col_html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;–', 9));
                        }
                        cols.push(jQuery.UbizOIWidget.w_make_col_html(report[i].prd_note, 10));

                        rows.push(jQuery.UbizOIWidget.w_make_row_html(report[i].prd_id, cols));
                    }
                }
                table_html += rows.join("");
            }
            jQuery.UbizOIWidget.o_page.find("#table-content").empty();
            jQuery.UbizOIWidget.o_page.find("#table-content").append(table_html);
            jQuery.UbizOIWidget.page = response.data.paging.page;
            jQuery.UbizOIWidget.w_paging(response.data.paging.page, response.data.paging.rows_num, response.data.paging.rows_per_page);

            jQuery("#report_count").text(response.data.paging.rows_num);
            jQuery("#report_sum").text(response.data.report_sum);
            jQuery("#total_start_time_cnt").text(response.data.total_start_time_cnt);
            jQuery("#total_end_time_cnt").text(response.data.total_end_time_cnt);
            jQuery("#total_qp_amount").text(response.data.total_qp_amount);
            jQuery("#total_ord_amount").text(response.data.total_ord_amount);
            var success_rate = 0;
            if (parseInt(response.data.total_qp_amount.replace(",", "")) > 0) {
                success_rate = parseInt(response.data.total_ord_amount.replace(",", "")) / parseInt(response.data.total_qp_amount.replace(",", "")) * 100;
            }
            jQuery("#success_rate").text(success_rate.toFixed(2));
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
        w_make_col_html: function (col_val, col_idx) {
            var col_html = "";
            col_html += '<div class="tcB col-' + col_idx + '">';
            col_html += '<div class="cbo">';
            if (col_idx == 1) {
                col_html += '<div class="nCT" title="' + col_val + '">';
            } else {
                col_html += '<div class="nCj" title="' + col_val + '">';
            }
            col_html += '<span>' + (col_val || "") + '</span>';
            col_html += '</div>';
            col_html += '</div>';
            col_html += '</div>';
            return col_html;
        },
        w_refresh_output_page: function () {
            jQuery.UbizOIWidget.w_sort_reset();
        },
        w_statis: function () {
            jQuery.UbizOIWidget.page = '0';

            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            var params = {};
            params.page = '0';
            params.sort = sort;
            var current_path = $(location).attr('pathname');
            params.report_from_date = jQuery("#report_from_date").val();
            params.report_to_date = jQuery("#report_to_date").val();
            params.cus_name = jQuery("#cus_name").val();
            params.sale_name = jQuery("#sale_name").val();
            params.prd_name = jQuery("#prd_name").val();
            params.brd_name = jQuery("#brd_name").val();
            params.prd_query_type = jQuery("#prd_query_type option:selected").val();

            ubizapis('v1', current_path, 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_export: function (type) {
            jQuery("#f-export").attr("action", "/report/" + type + "/export");
            jQuery("#f-export").trigger("submit");
        },
        w_export_rep: function () {
            swal({
                title: i18next.t('Are you sure you want to update repository?'),
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    jQuery(".close-modal-btn").click();
                    formData = new FormData(jQuery("#f-export-rep")[0]);
                    ubizapis('v1','report/export-rep', 'post', formData, null,jQuery.UbizOIWidget.w_process_callback);
                }
            });
        },
        w_import_rep: function () {
            swal({
                title: i18next.t('Are you sure you want to update repository?'),
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    jQuery(".close-modal-btn").click();
                    formData = new FormData(jQuery("#f-import-rep")[0]);
                    ubizapis('v1','report/import-rep', 'post', formData, null,jQuery.UbizOIWidget.w_process_callback);
                }
            });
        },
        w_process_callback: function (response) {
            if (response.data.success == true) {
                swal.fire({
                    type: 'success',
                    title: response.data.message,
                    onClose: () => {
                        jQuery.UbizOIWidget.w_statis();
                    }
                });
            } else {
                swal.fire({
                    type: 'error',
                    title: response.data.message
                });
            }
        }
    });
})(jQuery);
jQuery(document).ready(function () {
    jQuery.UbizOIWidget.w_init();
    // Get the modal
    var modal_export = document.getElementById("export-rep-modal");
    var modal_import = document.getElementById("import-rep-modal");

    // Get the button that opens the modal
    var btn_export = document.getElementById("export-rep-btn");
    var btn_import = document.getElementById("import-rep-btn");

    // Get the <span> element that closes the modal
    var close_modal_export = document.getElementsByClassName("close-modal-export")[0];
    var close_modal_import = document.getElementsByClassName("close-modal-import")[0];

    // When the user clicks on the button, open the modal
    btn_export.onclick = function() {
        modal_export.style.display = "block";
    }
    btn_import.onclick = function() {
        modal_import.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    close_modal_export.onclick = function() {
        modal_export.style.display = "none";
    }
    close_modal_import.onclick = function() {
        modal_import.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal_export) {
            modal_export.style.display = "none";
        }
        if (event.target == modal_import) {
            modal_import.style.display = "none";
        }
    }
});

function qp_date_change(self) {
    var qp_date = $(self).val();
    if (qp_date != '') {
        if (moment(qp_date).isValid() == false) {
            var qp_date_old = $('input[name=qp_date_old]').val();
            $(self).val(qp_date_old);

            var message = i18next.t("Sai định dạng ngày YYYY/MM/DD");
            swal({
                type: 'error',
                text: message
            });
            return false;
        }

        qp_date = moment(qp_date).format('YYYY/MM/DD');
        $(self).val(qp_date);
        $('input[name=qp_date_old]').val(qp_date);
    }
}