const _YES = i18next.t("Yes");
const _NO = i18next.t("No");
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
                title: i18next.t('Do you want to delete the data?'),
                text: i18next.t('Once deleted, you will not be able to recover this data!'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: _NO,
                confirmButtonText: _YES,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    listId = JSON.stringify(listId);
                    var params = jQuery.UbizOIWidget.w_get_param_search_sort();
                    ubizapis('v1','/suppliers/'+listId+'/delete', 'delete',null, params,jQuery.UbizOIWidget.w_process_callback);
                }
            });
        },
        w_create:function(){
            jQuery.UbizOIWidget.w_clear_input_page();
            jQuery.UbizOIWidget.w_go_to_input_page(0);
        },
        w_save: function(id) {
            const ALERT_TITLE = i18next.t("Do you want to save it?");
            const ALERT_ICON = "warning";

            //validate
            if (jQuery.UbizOIWidget.w_validate_input() == false) {
                return;
            }

            var formData = jQuery.UbizOIWidget.w_get_images_upload();
            formData.append("supplier", JSON.stringify(jQuery.UbizOIWidget.w_get_data_input_form()));

            var params = jQuery.UbizOIWidget.w_get_param_search_sort();
            if (id == 0) {
                swal({
                    title:ALERT_TITLE,
                    type: ALERT_ICON,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: _NO,
                    confirmButtonText: _YES,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        ubizapis('v1','/suppliers/insert', 'post', formData, params, jQuery.UbizOIWidget.w_process_callback);
                    }
                });
            } else {
                if (jQuery.UbizOIWidget.w_is_input_changed() == false) {
                    swal({
                        title: i18next.t("Nothing change!"),
                        type: "error"
                    });
                    return false;
                }
                swal({
                    title: ALERT_TITLE,
                    type: ALERT_ICON,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: _NO,
                    confirmButtonText: _YES,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        formData.append("_method","put");
                        ubizapis('v1','/suppliers/'+id+'/update', 'post', formData,params, jQuery.UbizOIWidget.w_process_callback);
                    }
                });
            }

        },
        w_search:function(){

            var params = jQuery.UbizOIWidget.w_get_param_search_sort();

            var event = new CustomEvent("click");
            document.body.dispatchEvent(event);
            ubizapis('v1', '/suppliers', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_get_search_info: function () {

            var search_info = {};

            if (jQuery('#search-form #sup_code').val().replace(/\s/g, '') != '') {
                search_info.sup_code = jQuery('#search-form #sup_code').val();
            }

            if (jQuery('#search-form #sup_name').val().replace(/\s/g, '') != '') {
                search_info.sup_name = jQuery('#search-form #sup_name').val();
            }

            if (jQuery('#search-form #sup_mail').val().replace(/\s/g, '') != '') {
                search_info.sup_mail = jQuery('#search-form #sup_mail').val();
            }

            if (jQuery('#search-form #sup_phone').val().replace(/\s/g, '') != '') {
                search_info.sup_phone = jQuery('#search-form #sup_phone').val();
            }

            if (jQuery('#search-form #sup_website').val().replace(/\s/g, '') != '') {
                search_info.sup_website = jQuery('#search-form #sup_website').val();
            }

            if (jQuery('#search-form #sup_fax').val().replace(/\s/g, '') != '') {
                search_info.sup_fax = jQuery('#search-form #sup_fax').val();
            }

            if (jQuery('#search-form #contain').val().replace(/\s/g, '') != '') {
                search_info.contain = jQuery('#search-form #contain').val();
            }

            if (jQuery('#search-form #notcontain').val().replace(/\s/g, '') != '') {
                search_info.notcontain = jQuery('#search-form #notcontain').val();
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
        w_update_search_form:function(search_info){
            jQuery.each(search_info, function (key, val) {
                var search_item = jQuery('#search-form #' + key);
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
            params.search = search_info;

            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            params.sort = sort;

            ubizapis('v1', '/suppliers', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_fuzzy_search_handle_enter(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                jQuery.UbizOIWidget.w_fuzzy_search();
            }
        },
        w_get_param_search_sort: function() {
            var params = {};
            params.page = '0';

            var search_info = jQuery.UbizOIWidget.w_get_search_info();
            params.search = search_info;

            if (jQuery.isEmptyObject(search_info) === false) {
                var fuzzy = jQuery.UbizOIWidget.w_convert_search_info_to_fuzzy(search_info);
                jQuery('#fuzzy').val(fuzzy);
            }

            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            params.sort = sort_info.sort_name + "_" + sort_info.order_by;
            return params;
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
            var addresses = $("#i-put .txt_address");
            var addParam = [];
            for(var i = 0; i < addresses.length; i++) {
                var addObj = {
                    sad_id: $(addresses[i]).attr("sad_id"),
                    address: $(addresses[i]).val()
                }
                addParam.push(addObj);
            }
            var data = {
                sup_id: $("#i-put #txt_sup_id").val(),
                sup_code: $("#i-put #txt_sup_code").val(),
                sup_name: $("#i-put #txt_sup_name").val(),
                sup_website: $("#i-put #txt_sup_website").val(),
                sup_phone: $("#i-put #txt_sup_phone").val(),
                sup_fax: $("#i-put #txt_sup_fax").val(),
                sup_mail: $("#i-put #txt_sup_mail").val(),
                sup_avatar: $(".image-upload .img-show").attr("img-name"),
                addresses: addParam
            };
            return data;
        },
        w_open_searh_form: function (self) {
            swal('ok');
        },
        w_go_to_input_page: function (id, index) {
            if (id != 0) {
                if (id == -1) {
                    if (jQuery.UbizOIWidget.w_is_input_changed() == true) {
                        const ALERT_TITLE = i18next.t("Do you want to save it?");
                        const ALERT_ICON = "warning";
                        swal({
                            title: ALERT_TITLE,
                            type: ALERT_ICON,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: _NO,
                            confirmButtonText: _YES,
                            reverseButtons: true
                        }).then((result) => {
                            if (result.value) {
                                var formInput = jQuery.UbizOIWidget.w_get_data_input_form();
                                var formData = jQuery.UbizOIWidget.w_get_images_upload();
                                formData.append("supplier", JSON.stringify(formInput));
                                formData.append("_method","put");
                                var params = jQuery.UbizOIWidget.w_get_param_search_sort();
                                ubizapis('v1','/suppliers/'+formInput.sup_id+'/updatePaging', 'post', formData,params,function(){
                                    jQuery.UbizOIWidget.w_reset_input_change();
                                    jQuery.UbizOIWidget.w_get_specific_supplier_by_id(id, index);
                                    $("#i-put .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidget.w_delete("+id+")");
                                });
                            } else {
                                jQuery.UbizOIWidget.w_get_specific_supplier_by_id(id, index);
                                $("#i-put .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidget.w_delete("+id+")");
                            }
                        });
                    } else {
                        jQuery.UbizOIWidget.w_get_specific_supplier_by_id(id, index);
                        $("#i-put .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidget.w_delete("+id+")");
                    }
                } else {
                    jQuery.UbizOIWidget.w_get_specific_supplier_by_id(id, index);
                    $("#i-put .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidget.w_delete("+id+")");
                }
            }
            else{
                $("#i-put .GtF .delete").css("display","none").removeAttr("onclick");
            }

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
            var params = jQuery.UbizOIWidget.w_get_param_search_sort();
            params.page = jQuery.UbizOIWidget.page;
            ubizapis('v1', '/suppliers', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
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
                if (response.data.method == "insert") {
                    swal({
                        title:response.data.message,
                        text: i18next.t("Do you want to continue insert Supplier?"),
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: _NO,
                        confirmButtonText: _YES,
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {
                            jQuery.UbizOIWidget.w_clear_input_page();
                        } else {
                            jQuery.UbizOIWidget.w_render_data_to_ouput_page(response);
                            jQuery.UbizOIWidget.w_go_back_to_output_page();
                        }
                    });
                } else {
                    jQuery.UbizOIWidget.w_render_data_to_ouput_page(response);
                    jQuery.UbizOIWidget.w_go_back_to_output_page();
                    swal(response.data.message, {
                        type: "success",
                    });
                }

            } else {
                swal(response.data.message, {
                    type: "error",
                });
            }

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
            var data = response.data.supplier[0];
            var addresses = data.sad_address;
            $("#i-put .GtF .delete").attr("onclick","jQuery.UbizOIWidget.w_delete("+data.sup_id+")");
            $("#i-put .GtF .save").attr("onclick", "jQuery.UbizOIWidget.w_save("+data.sup_id+")");
            $("#i-put #nicescroll-iput #txt_sup_id").val(data.sup_id);
            $("#i-put #nicescroll-iput #txt_sup_code").val(data.sup_code);
            $("#i-put #nicescroll-iput #txt_sup_name").val(data.sup_name).change(function() {inputChange(this, data.sup_name)});
            $("#i-put #nicescroll-iput #txt_sup_website").val(data.sup_website).change(function() {inputChange(this, data.sup_website)});
            $("#i-put #nicescroll-iput #txt_sup_phone").val(data.sup_phone).change(function() {inputChange(this, data.sup_phone)});
            $("#i-put #nicescroll-iput #txt_sup_fax").val(data.sup_fax).change(function() {inputChange(this, data.sup_fax)});
            $("#i-put #nicescroll-iput #txt_sup_mail").val(data.sup_mail).change(function() {inputChange(this, data.sup_mail)});
            if (isEmpty(data.src)) {
                data.src = jQuery.UbizOIWidget.defaultImage;
            }
            var addrLength = addresses.length >= 3 ? addresses.length : 3;
            for(let i = 0; i < addrLength; i++) {
                if (i <= 2) {
                    $($("#i-put #nicescroll-iput #txt_adr" + (i+1)).val(addresses[i] != undefined ? addresses[i].address : "" )).change(function() {
                        inputChange(this, addresses[i] != undefined ? addresses[i].address : "" );
                    }).attr("sad_id",addresses[i] != undefined ? addresses[i].id : "");
                } else {
                    var address = $("#i-put #nicescroll-iput .txt_adr1_container").clone();
                    $(address).removeClass("txt_adr1_container").addClass("txt_adr"+(i+1)+"_container").addClass("clone-address");
                    $($(address).find("input").attr("id","txt_adr"+(i+1)).val(addresses[i].address)).change(function() {inputChange(this, addresses[i].address)}).attr("sad_id",addresses[i].id);
                    $(address).find("label.lbl-primary").html(i18next.t("Address") + " " + (i+1));
                    $(address).insertAfter("#i-put #nicescroll-iput .txt_adr"+i+"_container");
                }
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
                        showErrorInput(txt_input[i], i18next.t("This input is required"));
                    }
                }
                var txt_id = $(txt_input[i]).attr("id");
                var txt_val = $(txt_input[i]).val().trim();
                switch(txt_id) {
                    case "txt_sup_name":
                        if (txt_val.length > 100) {
                            isValid = false;
                            showErrorInput(txt_input[i], i18next.t("invalid length",{length: "100"}));
                        }
                        break;
                    case "txt_sup_website":
                        var regex = new RegExp('^(https?:\\/\\/)?'+ // protocol
                            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|'+ // domain name
                            '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
                            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
                            '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
                            '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
                        if (txt_val.length == 0) {
                            break;
                        } else if (txt_val.length > 100) {
                            isValid = false;
                            showErrorInput(txt_input[i], i18next.t("invalid length",{length: "100"}));
                        } else if (regex.test(String(txt_val).toLowerCase()) == false) {
                            isValid = false;
                            showErrorInput(txt_input[i], i18next.t("invalid input", {control: i18next.t("Website")}));
                        }
                        break;
                    case "txt_sup_phone":
                        var regex = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
                        if (txt_val.length > 15) {
                            isValid = false;
                            showErrorInput(txt_input[i], i18next.t("invalid length",{length: "15"}));
                        } else if (regex.test(String(txt_val).toLowerCase()) == false || txt_val.length < 9) {
                            isValid = false;
                            showErrorInput(txt_input[i], i18next.t("invalid input", {control: i18next.t("Phone")}));
                        }
                        break;
                    case "txt_sup_fax":
                        var regex = /^\+?[0-9]{6,}$/;
                        if (txt_val.length == 0) {
                            break;
                        } else if (txt_val.length > 20) {
                            isValid = false;
                            showErrorInput(txt_input[i], i18next.t("invalid length",{length: "20"}));
                        } else if (regex.test(String(txt_val).toLowerCase()) == false) {
                            isValid = false;
                            showErrorInput(txt_input[i], i18next.t("invalid input",{control: i18next.t("Fax")}));
                        }
                        break;
                    case "txt_sup_mail":
                        var regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
                        if (txt_val.length > 100) {
                            isValid = false;
                            showErrorInput(txt_input[i], i18next.t("invalid length",{length: "100"}));
                        } else if (regex.test(String(txt_val).toLowerCase()) == false) {
                            isValid = false;
                            showErrorInput(txt_input[i], i18next.t("invalid input", {control: i18next.t("E-Mail")}));
                        }
                        break;
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
            $("#i-put .txt_address").val("");
            $("#i-put .clone-address").remove();
            jQuery.UbizOIWidget.sort = {'sort_name': 'sup_code', 'order_by': 'asc'};
            jQuery.UbizOIWidget.w_set_paging_for_detail_page(0,0,true);
            removeErrorInput();
        },
        w_reset_input_change: function() {
            $("#i-put #nicescroll-iput #txt_sup_code").val("").isChange("false");
            $("#i-put #nicescroll-iput #txt_sup_name").val("").isChange("false");
            $("#i-put #nicescroll-iput #txt_sup_website").val("").isChange("false");
            $("#i-put #nicescroll-iput #txt_sup_phone").val("").isChange("false");
            $("#i-put #nicescroll-iput #txt_sup_fax").val("").isChange("false");
            $("#i-put #nicescroll-iput #txt_sup_mail").val("").isChange("false");
            $("#i-put #nicescroll-iput .file-upload").isChange("false");
        },
        w_clear_search_form:function(){
            jQuery('#search-form  #sup_code').val("");
            jQuery('#search-form  #sup_name').val("");
            jQuery('#search-form  #sup_mail').val("");
            jQuery('#search-form  #sup_phone').val("");
            jQuery('#search-form  #sup_fax').val("");
            jQuery('#search-form  #sup_website').val("");
            jQuery('#search-form  #sup_contain').val("");
            jQuery('#search-form  #sup_notcontain').val("");
            jQuery('#search-form  #sup_fuzzy').val("");
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