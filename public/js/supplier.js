(function ($) {
    UbizOIWidget = function () {
        this.page = 0;
        this.sort = {};
        this.o_page = null;
        this.i_page = null;
        this.defaultImage = "../images/avatar.png";
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
        },
        w_sort: function (self) {
            var sort_name = jQuery(self).attr('sort-name');
            var order_by = jQuery(self).attr('order-by') == '' ? 'asc' : (jQuery(self).attr('order-by') == 'asc' ? 'desc' : 'asc');
            var sort = sort_name + "_" + order_by;
            jQuery.UbizOIWidget.sort = sort;
            jQuery.UbizOIWidget.o_page.find('div.dWT').removeClass('dWT');
            jQuery(self).attr('order-by', order_by);
            jQuery(self).addClass('dWT');
            jQuery(self).find('svg').removeClass('sVGT');
            jQuery(self).find('svg.' + order_by).addClass('sVGT');

            ubizapis('v1', '/suppliers', 'get', null, {'page': jQuery.UbizOIWidget.page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_delete: function (id) {
            var listId = jQuery.UbizOIWidget.w_get_checked_rows();
            if (listId.length == 0) {
                if (id == undefined)
                    return false;
                listId.push(id);
            }

            swal({
                title: "Bạn có muốn xóa dữ liệu không?",
                text: "Một khi xóa, bạn sẽ không có khả năng khôi phục dữ liệu này!",
                icon: "warning",
                buttons: true,
                buttons: {
                    cancel: "Không",
                    catch: {
                        text: "Có",
                        value: "catch",
                    }
                },
                dangerMode: true,
            }).then((value) => {
                switch (value) {
                    case "catch":
                        listId = JSON.stringify(listId);
                        ubizapis('v1','/suppliers/delete', 'get',null, {'listId':listId},jQuery.UbizOIWidget.w_process_callback);
                        break;
                }
            });
        },
        w_create:function(){
            jQuery.UbizOIWidget.w_clear_input_page();
            jQuery.UbizOIWidget.w_go_to_input_page(0);
        },
        w_save: function(id) {
            const ALERT_TITLE = "Bạn có muốn lưu lại không?";
            const ALERT_ICON = "warning";

            //validate
            if (jQuery.UbizOIWidget.w_validate_input() == false) {
                return;
            }

            var formData = jQuery.UbizOIWidget.w_get_images_upload();
            formData.append("supplier", JSON.stringify(jQuery.UbizOIWidget.w_get_data_input_form()));
            if (id == 0) {
                swal({
                    title:ALERT_TITLE,
                    icon: ALERT_ICON,
                    buttons: true,
                    buttons: {
                        cancel: "Không",
                        catch: {
                            text: "Có",
                            value: "catch",
                        }
                    },
                    dangerMode: true,
                }).then((value) => {
                    switch (value) {
                        case "catch":
                            ubizapis('v1','/suppliers/insert', 'post', formData, null, jQuery.UbizOIWidget.w_process_callback);
                            break;
                    }
                });
            } else {
                if (jQuery.UbizOIWidget.w_is_input_changed() == false) {
                    swal({
                        title: "Không có gì thay đổi!",
                        icon: "error"
                    });
                    return false;
                }
                swal({
                    title: ALERT_TITLE,
                    icon: ALERT_ICON,
                    buttons: true,
                    buttons: {
                        cancel: "Không",
                        catch: {
                            text: "Có",
                            value: "catch",
                        }
                    },
                    dangerMode: true,
                }).then((value) => {
                    switch (value) {
                        case "catch":
                            ubizapis('v1','/suppliers/update/' + id, 'post', formData, null, jQuery.UbizOIWidget.w_process_callback);
                            break;
                    }
                });
            }

        },
        w_get_images_upload: function() {
            var formData = new FormData();
            var images = $(".image-upload .file-upload");
            if ($(images).attr("is-change") == "true") {
                formData.append('image-upload',images[0].files[0]);
            }
            return formData;
        },
        w_get_data_input_form: function() {
            var data = {
                sup_code: $("#i-put #txt_sup_code").val(),
                sup_name: $("#i-put #txt_sup_name").val(),
                sup_website: $("#i-put #txt_sup_website").val(),
                sup_phone: $("#i-put #txt_sup_phone").val(),
                sup_fax: $("#i-put #txt_sup_fax").val(),
                sup_mail: $("#i-put #txt_sup_mail").val(),
                sup_avatar: $(".image-upload .img-show").attr("img-name")
            };
            return data;
        },
        w_open_searh_form: function (self) {
            swal('ok');
        },
        w_go_to_input_page: function (id, index) {
            if (id != 0)
                jQuery.UbizOIWidget.w_get_specific_supplier_by_id(id, index);
            if (isEmpty(index)) {
                $("#i-put .GtF .save").attr("onclick", "jQuery.UbizOIWidget.w_save(0)");
            }
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
        w_set_paging_for_detail_page: function(page, totalPage, isReset = false) {
            var previous = $("#i-put .aqK .previous");
            var next = $("#i-put .aqK .next");
            var currentPage = $("#i-put .aqK .current-page");
            var rowNumbers = $("#i-put .aqK .row-numbers");
            page = Number(page);
            totalPage = Number(totalPage);
            if (page == 0) {
                $(previous).find(".amI").removeClass("aaT").addClass("adS");
                $(next).find(".amJ").removeClass("adS").addClass("aaT");
                $(previous).removeAttr("onclick");
                $(next).attr("onclick", "jQuery.UbizOIWidget.w_go_to_input_page(-1,"+(page + 1)+")");
            } else if (page >= totalPage - 1) {
                $(next).find(".amJ").removeClass("aaT").addClass("adS");
                $(previous).find(".amI").removeClass("adS").addClass("aaT");
                $(next).removeAttr("onclick");
                $(previous).attr("onclick", "jQuery.UbizOIWidget.w_go_to_input_page(-1,"+(page - 1)+")");
            } else {
                $(next).find(".amJ").removeClass("adS").addClass("aaT");
                $(previous).find(".amI").removeClass("adS").addClass("aaT");
                $(next).attr("onclick", "jQuery.UbizOIWidget.w_go_to_input_page(-1,"+(page + 1)+")");
                $(previous).attr("onclick", "jQuery.UbizOIWidget.w_go_to_input_page(-1,"+(page - 1)+")");
            }
            $(currentPage).html(page + 1);
            $(rowNumbers).html(totalPage);
            if (isReset) {
                $(next).removeAttr("onclick");
                $(previous).removeAttr("onclick");
                $(previous).find(".amI").removeClass("aaT").addClass("adS");
                $(next).find(".amJ").removeClass("aaT").addClass("adS");
                $(currentPage).html(0);
                $(rowNumbers).html(0);
            }
        },
        w_go_back_to_output_page: function (self) {
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
            jQuery.UbizOIWidget.w_clear_input_page();
        },
        w_refresh_output_page: function () {
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/suppliers', 'get', null, {'page': jQuery.UbizOIWidget.page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
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
            ubizapis('v1', '/suppliers', 'get', null, {'page': page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_get_newer_data: function (page) {
            jQuery.UbizOIWidget.page = page;
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            jQuery.UbizOIWidget.sort = sort_info;
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/suppliers', 'get', null, {'page': page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_process_callback: function (response) {
            if (response.data.success == true) {
                jQuery.UbizOIWidget.w_render_data_to_ouput_page(response);
                swal(response.data.message, {
                    icon: "success",
                });
            } else {
                swal(response.data.message, {
                    icon: "error",
                });
            }
            jQuery.UbizOIWidget.w_go_back_to_output_page();
        },
        w_render_data_to_ouput_page: function (response) {
            var table_html = "";
            var suppliers = response.data.supplier;
            if (suppliers.length > 0) {
                var rows = [];
                var index = 0 + (Number(response.data.paging.page) * Number(response.data.paging.rows_per_page));
                for (let i = 0; i < suppliers.length; i++) {
                    var cols = [];
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(suppliers[i].sup_id, suppliers[i].sup_code, 1));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(suppliers[i].sup_id, suppliers[i].sup_name, 2));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(suppliers[i].sup_id, suppliers[i].sup_website, 3));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(suppliers[i].sup_id, suppliers[i].sup_phone, 4));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(suppliers[i].sup_id, suppliers[i].sup_fax, 5));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(suppliers[i].sup_id, suppliers[i].sup_mail, 6));
                    rows.push(jQuery.UbizOIWidget.w_make_row_html(suppliers[i].sup_id, cols, index));
                    index++;
                }
                table_html += rows.join("");
            }
            jQuery.UbizOIWidget.o_page.find("#table-content").empty();
            jQuery.UbizOIWidget.o_page.find("#table-content").append(table_html);
            jQuery.UbizOIWidget.w_reset_f_checkbox_status();
            jQuery.UbizOIWidget.page = response.data.paging.page;
            jQuery.UbizOIWidget.w_paging(response.data.paging.page, response.data.paging.rows_num, response.data.paging.rows_per_page);
        },
        w_render_data_to_input_page: function(response) {
            if (response == undefined || response.data == undefined || response.data.supplier.length <= 0) {
                return;
            }
            data = response.data.supplier[0];
            $("#i-put .GtF .delete").attr("onclick","jQuery.UbizOIWidget.w_delete("+data.sup_id+")");
            $("#i-put .GtF .save").attr("onclick", "jQuery.UbizOIWidget.w_save("+data.sup_id+")");
            $("#i-put #nicescroll-iput #txt_sup_code").val(data.sup_code);
            $("#i-put #nicescroll-iput #txt_sup_name").val(data.sup_name).change(function() {inputChange(this, data.sup_name)});
            $("#i-put #nicescroll-iput #txt_sup_website").val(data.sup_website).change(function() {inputChange(this, data.sup_website)});
            $("#i-put #nicescroll-iput #txt_sup_phone").val(data.sup_phone).change(function() {inputChange(this, data.sup_phone)});
            $("#i-put #nicescroll-iput #txt_sup_fax").val(data.sup_fax).change(function() {inputChange(this, data.sup_fax)});
            $("#i-put #nicescroll-iput #txt_sup_mail").val(data.sup_mail).change(function() {inputChange(this, data.sup_mail)});
            if (isEmpty(data.src)) {
                data.src = jQuery.UbizOIWidget.defaultImage;
            }
            $("#i-put #nicescroll-iput .image-upload .img-show").attr("src", data.src);
            $("#i-put #nicescroll-iput .image-upload .img-show").attr("img-name", data.sup_avatar);

            jQuery.UbizOIWidget.w_set_paging_for_detail_page(response.data.paging.page, response.data.paging.rows_num);
        },
        w_is_input_changed: function() {
            var txt_input = $("#i-put .jAQ input");
            for(var i = 0; i < txt_input.length; i++) {
                if ($(txt_input[i]).isChange() == "true") {
                    return true;
                }
            }
            return false;
        },
        w_validate_input: function() {
            var isValid = true;
            removeErrorInput();
            var txt_input = $("#i-put .jAQ input.input_field");
            // Validate Requirement
            for(var i = 0; i < txt_input.length; i++) {
                if ($(txt_input[i]).prop("required") == true) {
                    if ($(txt_input[i]).val() == "") {
                        isValid = false;
                        showErrorInput(txt_input[i], "Thông tin bắt buộc nhập");
                    }
                }
            }
            return isValid;
        },
        w_clear_input_page: function() {
            $("#i-put #nicescroll-iput #txt_sup_code").val("").isChange("false");
            $("#i-put #nicescroll-iput #txt_sup_name").val("").isChange("false");
            $("#i-put #nicescroll-iput #txt_sup_website").val("").isChange("false");
            $("#i-put #nicescroll-iput #txt_sup_phone").val("").isChange("false");
            $("#i-put #nicescroll-iput #txt_sup_fax").val("").isChange("false");
            $("#i-put #nicescroll-iput #txt_sup_mail").val("").isChange("false");
            $("#i-put #nicescroll-iput .file-upload").isChange("false");
            $("#i-put #nicescroll-iput .image-upload .img-show").attr("src", jQuery.UbizOIWidget.defaultImage);
            jQuery.UbizOIWidget.sort = {'sort_name': 'sup_id', 'order_by': 'asc'};
            jQuery.UbizOIWidget.w_set_paging_for_detail_page(0,0,true);
            removeErrorInput();
        },
        w_get_specific_supplier_by_id(id, index) {
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1','/suppliers/' + id, 'get', null, {'page': index, 'sort': sort},jQuery.UbizOIWidget.w_render_data_to_input_page);
        },
        w_make_row_html: function (id, cols, index) {
            var row_html = '';
            if (cols.length > 0) {
                row_html = '<div class="jvD" ondblclick="jQuery.UbizOIWidget.w_go_to_input_page(' + id + ','+index+')">';
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
            var paging_older = '<div id="paging-older" ' + get_older_data_func + ' class="amD utooltip" title="Cũ hơn"><span class="amF">&nbsp;</span><img class="amI ' + older_css + '" src="http://ubiz.local/images/cleardot.gif" alt=""></div>';
            var paging_newer = '<div id="paging-newer" ' + get_newer_data_func + ' class="amD utooltip" title="Mới hơn"><span class="amF">&nbsp;</span><img class="amJ ' + newer_css + '" src="http://ubiz.local/images/cleardot.gif" alt=""></div>';

            jQuery("#paging-label").replaceWith(paging_label);
            jQuery("#paging-older").replaceWith(paging_older);
            jQuery("#paging-newer").replaceWith(paging_newer);
        }
    });
})(jQuery);
jQuery(document).ready(function () {
    jQuery.UbizOIWidget.w_init();
});

function isEmpty(str) {
    if (str == null || str == undefined || str == "") {
        return true;
    }
    return false;
}