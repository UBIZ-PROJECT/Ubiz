const _YES = i18next.t("Yes");
const _NO = i18next.t("No");
const _ADD_BRANDS = 1;
const _ADD_PRODUCT = 2;
var current_screen;
var current_brd_id = 0;
var is_image_delete = false;
(function ($) {
    UbizOIWidget = function () {
        this.page = 0;
        this.sort = {};
        this.o_page = null;
        this.i_page = null;
        this.i_page_2 = null;
        this.defaultImage = "../images/avatar.png";
        this.sidebar_scrollbars = null;
        this.output_scrollbars = null;
        this.input_scrollbars = null;
    };

    jQuery.UbizOIWidget = new UbizOIWidget();
    jQuery.extend(UbizOIWidget.prototype, {
        w_init: function () {
            jQuery.UbizOIWidget.o_page = jQuery("#o-put");
            jQuery.UbizOIWidget.i_page = jQuery("#i-put");
            jQuery.UbizOIWidget.i_page_2 = jQuery("#i-put-2");
            jQuery.UbizOIWidget.sidebar_scrollbars = fnc_set_scrollbars("nicescroll-sidebar");
            jQuery.UbizOIWidget.output_scrollbars = fnc_set_scrollbars("nicescroll-oput");
            jQuery.UbizOIWidget.input_scrollbars = fnc_set_scrollbars("nicescroll-iput");
            jQuery('.utooltip').tooltipster({
                side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
            });
            jQuery('.utooltip-prd').tooltipster({
                side: 'top', theme: 'tooltipster-prd', animation: 'swing', delay: 100
            });
        },
        w_sort: function (self) {
            var sort_name = jQuery(self).attr('sort-name');
            var order_by = jQuery(self).attr('order-by') == '' ? 'asc' : (jQuery(self).attr('order-by') == 'asc' ? 'desc' : 'asc');
            var sort = sort_name + "_" + order_by;
            jQuery.UbizOIWidget.sort = sort;
            jQuery.UbizOIWidget.i_page.find('div.dWT').removeClass('dWT');
            jQuery(self).attr('order-by', order_by);
            jQuery(self).addClass('dWT');
            jQuery(self).find('svg').removeClass('sVGT');
            jQuery(self).find('svg.' + order_by).addClass('sVGT');
            var params = {'page': jQuery.UbizOIWidget.page, 'sort': sort, "search": {}};
            params.search['brd_id'] = current_brd_id;
            ubizapis('v1', '/products', 'get', null, params , jQuery.UbizOIWidget.w_render_data_to_ouput_page);
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
                type: "warning",
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
                    params.search['type'] = "0";
                    ubizapis('v1','/brands/'+listId+'/delete', 'delete',null, params,jQuery.UbizOIWidget.w_process_callback);
                }
            });
        },
        w_delete_prd: function (id) {
            var listId = jQuery.UbizOIWidget.w_get_checked_rows();
            if (listId.length == 0) {
                if (id == undefined)
                    return false;
                listId.push(id);
            }

            swal({
                title: i18next.t('Do you want to delete the data?'),
                type: "warning",
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
                    params.search['brd_id'] = current_brd_id;
                    ubizapis('v1','/products/'+listId+'/delete', 'delete',null, params,jQuery.UbizOIWidget.w_process_callback);
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
            formData.append("brand", JSON.stringify(jQuery.UbizOIWidget.w_get_data_input_form()));

            var params = {};
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
                        ubizapis('v1','/brands/insert', 'post', formData, params, jQuery.UbizOIWidget.w_process_callback);
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
                        ubizapis('v1','/brands/'+id+'/update', 'post', formData,params, jQuery.UbizOIWidget.w_process_callback);
                    }
                });
            }

        },
        w_search:function(){

            var params = jQuery.UbizOIWidget.w_get_param_search_sort();
            params.search['type'] = "0";
            var event = new CustomEvent("click");
            document.body.dispatchEvent(event);
            ubizapis('v1', '/brands', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_get_search_info: function () {

            var search_info = {};
            //
            if (jQuery('#search-form #name').val().replace(/\s/g, '') != '') {
                search_info.name = jQuery('#search-form #name').val();
            }

            // if (jQuery('#search-form #branch').val().replace(/\s/g, '') != '') {
            //     search_info.branch = jQuery('#search-form #branch').val();
            // }
            //
            // if (jQuery('#search-form #model').val().replace(/\s/g, '') != '') {
            //     search_info.model = jQuery('#search-form #model').val();
            // }
            //
            // if (jQuery('#search-form #detail').val().replace(/\s/g, '') != '') {
            //     search_info.detail = jQuery('#search-form #detail').val();
            // }
            //
            // if (jQuery('#search-form #type_id').val().replace(/\s/g, '') != '') {
            //     search_info.type_id = jQuery('#search-form #type_id').val();
            // }
            //
            if (jQuery('#search-form #contain').val().replace(/\s/g, '') != '') {
                search_info.contain = jQuery('#search-form #contain').val();
            }

            if (jQuery('#search-form #notcontain').val().replace(/\s/g, '') != '') {
                search_info.notcontain = jQuery('#search-form #notcontain').val();
            }
            //
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
            params.search['type'] = "0";
            ubizapis('v1', '/brands', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
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

            if (sort_info.sort_name != '' || sort_info.order_by != '') {
                params.sort = sort_info.sort_name + "_" + sort_info.order_by;
            }

            return params;
        },
        w_get_images_upload: function() {
            var formData = new FormData();
            var images = $(".image-upload .file-upload");
            $(images).each(function(){
                image = $(this);
                if ($(this).attr("is-change") == "true") {
                    formData.append('image-upload[]',image[0].files[0]);
                }
            });

            return formData;
        },
        w_get_data_input_form: function() {

            var data = {
                brd_id: $("#i-put #txt_brd_id").val(),
                brd_name: $("#i-put #txt_brd_name").val(),
                type: "0",
                brd_img: is_image_delete
            };
            return data;
        },
        w_open_searh_form: function (self) {
            swal('ok');
        },
        w_go_to_input_page: function (id) {
            current_brd_id = id;
            if (id != 0) {
                if (id == -1) {
                    if (jQuery.UbizOIWidget.w_is_input_changed() == true) {
                        removeErrorInput();
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
                                //validate
                                if (jQuery.UbizOIWidget.w_validate_input() == false) {
                                    return;
                                }
                                var formInput = jQuery.UbizOIWidget.w_get_data_input_form();
                                var formData = jQuery.UbizOIWidget.w_get_images_upload();
                                formData.append("brand", JSON.stringify(formInput));
                                var params = jQuery.UbizOIWidget.w_get_param_search_sort();
                                params.search['type'] = "0";

                                formData.append("_method","put");
                                ubizapis('v1','/brands/'+formInput.id+'/updatePaging', 'post', formData,params,function() {
                                    jQuery.UbizOIWidget.w_reset_input_change();
                                    jQuery.UbizOIWidget.w_get_specific_brand_by_id(id);
                                    $("#i-put .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidgetPrd.w_delete("+id+")");
                                });
                            } else {
                                jQuery.UbizOIWidget.w_reset_input_change();
                                jQuery.UbizOIWidget.w_get_specific_brand_by_id(id);
                                $("#i-put .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidgetPrd.w_delete("+id+")");
                            }
                        });
                    } else {
                        jQuery.UbizOIWidget.w_get_specific_brand_by_id(id);
                        $("#i-put .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidgetPrd.w_delete("+id+")");
                    }
                } else {
                    jQuery.UbizOIWidget.w_get_specific_brand_by_id(id);
                    $("#i-put .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidgetPrd.w_delete("+id+")");
                }
            }
            else{
                $("#i-put .GtF .delete").css("display","none").removeAttr("onclick");
            }

            // if (isEmpty(index)) {
            $("#i-put .GtF .save").attr("onclick", "jQuery.UbizOIWidget.w_save(0)");
            // }
            jQuery.UbizOIWidget.w_sleep_scrollbars(jQuery.UbizOIWidget.output_scrollbars);
            jQuery.UbizOIWidget.w_update_scrollbars(jQuery.UbizOIWidget.input_scrollbars);

            jQuery.UbizOIWidget.o_page.hide();
            jQuery.UbizOIWidget.i_page.fadeIn("slow");

        },w_reset_input_change: function() {
            $("#i-put-2 #nicescroll-iput-2 #txt_name").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 #txt_model").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 #txt_name_type").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 #txt_detail").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 .file-upload").isChange("false");
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
            jQuery.UbizOIWidget.w_sleep_scrollbars(jQuery.UbizOIWidget.input_scrollbars);
            jQuery.UbizOIWidget.w_update_scrollbars(jQuery.UbizOIWidget.output_scrollbars);
            jQuery.UbizOIWidget.w_clear_input_page();
        },
        w_refresh_output_page: function () {
            var params = {};
            params.page = jQuery.UbizOIWidget.page;
            params.search['type'] = "0";
            ubizapis('v1', '/brands', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_get_sort_info: function () {
            var sort_obj = jQuery.UbizOIWidget.i_page.find('div.dWT');
            var sort_name = sort_obj.attr('sort-name');
            var order_by = sort_obj.attr('order-by');
            return {'sort_name': sort_name, 'order_by': order_by};
        },
        w_get_older_data: function (page) {
            var params = jQuery.UbizOIWidget.w_get_param_search_sort();
            params.page = page;
            params.search["brd_id"] = current_brd_id;
            jQuery.UbizOIWidget.page = page;
            ubizapis('v1', '/products', 'get', null, params, jQuery.UbizOIWidget.w_render_product_data_to_input);
        },
        w_get_newer_data: function (page) {
            jQuery.UbizOIWidget.page = page;
            var params = jQuery.UbizOIWidget.w_get_param_search_sort();
            params.page = page;
            params.search["brd_id"] = current_brd_id;
            jQuery.UbizOIWidget.page = page;
            ubizapis('v1', '/products', 'get', null, params, jQuery.UbizOIWidget.w_render_product_data_to_input);
        },
        w_process_callback: function (response) {
            if (response.data.success == true) {
                if (response.data.method == "insert") {
                    swal({
                        title:response.data.message,
                        text: i18next.t("Do you want to continue insert Brands?"),
                        type: "success",
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

                    // jQuery.UbizOIWidget.w_render_data_to_ouput_page(response);
                    // jQuery.UbizOIWidget.w_go_back_to_output_page();
                    swal(response.data.message, {
                        type: "success",
                    }).then(function(){
                        location.reload();
                    });
                }

            } else {
                swal(response.data.message, {
                    type: "error",
                });
            }

        },
        w_render_data_to_ouput_page: function (response) {
            var brands = response.data.brand;
            var html ='';
            for(var i = 0; i < brands.length; i++) {
                html +='<div class="brd-box" onclick="jQuery.UbizOIWidget.w_go_to_input_page('+ brands[i].brd_id +')">';
                html +='<img src="'+brands[i].brdImage["src"]+'" class="brd-img rounded mx-auto d-block">';
                html +='<div class="brd-name">'+brands[i].brd_name+'</div></div>';
            }


            jQuery.UbizOIWidget.o_page.find(".brd-content").empty();
            jQuery.UbizOIWidget.o_page.find(".brd-content").append(html);
        },
        w_render_product_data_to_input: function(response) {
            var product_data = response.data.product;
            initProduct(product_data, response.data.paging.page);
            jQuery.UbizOIWidget.page = response.data.paging.page;
            jQuery.UbizOIWidget.w_paging(response.data.paging.page, response.data.paging.rows_num, response.data.paging.rows_per_page);
        },
        w_render_data_to_input_page: function(response) {
            if (response == undefined || response.data == undefined || response.data.brand.length <= 0) {
                return;
            }
            var data = response.data.brand;
            var product_data = response.data.product;
            initProduct(product_data, response.data.paging_prd.page);
            jQuery.UbizOIWidget.page = response.data.paging_prd.page;
            jQuery.UbizOIWidget.w_paging(response.data.paging_prd.page, response.data.paging_prd.rows_num, response.data.paging_prd.rows_per_page);

            $("#i-put .GtF .delete").attr("onclick","jQuery.UbizOIWidgetPrd.w_delete()");
            $("#i-put .GtF .refresh").attr("onclick","jQuery.UbizOIWidgetPrd.w_refresh_output_page()");
            $("#i-put .GtF .save").attr("onclick", "jQuery.UbizOIWidget.w_save("+data.brd_id+")");
            $("#i-put #nicescroll-iput #txt_brd_id").val(data.brd_id);
            $("#i-put #nicescroll-iput #txt_brd_name").val(data.brd_name).change(function() {inputChange(this, data.brd_name)});
            if (data.brdImage != undefined ) {
                var controlImages = $("#i-put .img-show");
                $(controlImages[0]).attr("src",data.brdImage.src).setName(data.brdImage.name);
            }
            // if (isEmpty(data.images)) {
            //     data.src = jQuery.UbizOIWidget.defaultImage;  // THY Fix image
            // }
            // var addrLength = addresses.length >= 3 ? addresses.length : 3;
            // for(let i = 0; i < addrLength; i++) {
            //     if (i <= 2) {
            //         $($("#i-put #nicescroll-iput #txt_adr" + (i+1)).val(addresses[i] != undefined ? addresses[i].address : "" )).change(function() {
            //             inputChange(this, addresses[i] != undefined ? addresses[i].address : "" );
            //         }).attr("sad_id",addresses[i] != undefined ? addresses[i].id : "");
            //     } else {
            //         var address = $("#i-put #nicescroll-iput .txt_adr1_container").clone();
            //         $(address).removeClass("txt_adr1_container").addClass("txt_adr"+(i+1)+"_container").addClass("clone-address");
            //         $($(address).find("input").attr("id","txt_adr"+(i+1)).val(addresses[i].address)).change(function() {inputChange(this, addresses[i].address)}).attr("sad_id",addresses[i].id);
            //         $(address).find("label.lbl-primary").html(i18next.t("Address") + " " + (i+1));
            //         $(address).insertAfter("#i-put #nicescroll-iput .txt_adr"+i+"_container");
            //     }
            // }
            // $("#i-put #nicescroll-iput .image-upload .img-show").attr("src", data.src);
            // $("#i-put #nicescroll-iput .image-upload .img-show").attr("img-name", data.sup_avatar);

            // jQuery.UbizOIWidget.w_set_paging_for_detail_page(response.data.paging.page, response.data.paging.rows_num);
        },
        w_is_input_changed: function() {
            var txt_input = $("#i-put .jAQ input, #i-put .jAQ textarea,  #i-put .jAQ select");
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
            var txt_input = $("#i-put .jAQ input.input_field, #i-put .jAQ textarea#txt_detail");
            // Validate Requirement
            for(var i = 0; i < txt_input.length; i++) {
                if ($(txt_input[i]).prop("required") == true) {
                    if ($(txt_input[i]).val() == "") {
                        isValid = false;
                        showErrorInput(txt_input[i], i18next.t("This input is required"));
                    }
                }
            }
            var image =$($("#i-put .jAQ .image-upload").find("img")[0]).prop("src");
            if (image.indexOf("images/avatar.png") > -1) {
                isValid = false;
                swal({
                    title: i18next.t("Error!!!"),
                    text: i18next.t("You didn't select any image yet."),
                    type: "warning",
                });
            }
            return isValid;
        },
        w_clear_input_page: function() {
            jQuery.UbizOIWidget.sort = {'sort_name': 'prd_name', 'order_by': 'asc'};
            jQuery.UbizOIWidget.w_set_paging_for_detail_page(0,0,true);
            jQuery.UbizOIWidget.i_page.find(".input_field ").val("").isChange("false");
            // jQuery.UbizOIWidget.i_page.find("#txt_brd_id").val("");
            removeErrorInput();
            is_image_delete = false;
            $(".img-show").attr("src","../images/avatar.png").setName("");
            $(".file-upload").val("").isChange("false");
        },
        w_clear_search_form:function(){
            jQuery('#search-form  #name').val("");
            jQuery('#search-form  #sup_contain').val("");
            jQuery('#search-form  #sup_notcontain').val("");
            jQuery('#search-form  #sup_fuzzy').val("");
        },
        w_get_specific_brand_by_id(id) {
            $(".ubiz-search.ubiz-search-brand").remove();
            $(".ubiz-search.ubiz-search-product").addClass("active");
            changeCreateFunction(_ADD_PRODUCT);
            ubizapis('v1','/brands/detail', 'get', null, {'brd_id': id, 'type': "0"},jQuery.UbizOIWidget.w_render_data_to_input_page);
        },
        w_callback_remove_image: function(self) {
            is_image_delete = true;
        },
        w_f_checkbox_click: function (self) {
            if (jQuery(self).find('div.ckb-f').hasClass('asU')) {
                jQuery.UbizOIWidget.i_page.find('.ckb-f').removeClass('asU');
                jQuery.UbizOIWidget.i_page.find('.ckb-f').removeClass('asP');
                jQuery.UbizOIWidget.i_page.find('.ckb-f').addClass('asC');
                jQuery.UbizOIWidget.i_page.find('.ckb-c').removeClass('asU');
                jQuery.UbizOIWidget.i_page.find('.ckb-c').addClass('asC');
                jQuery.UbizOIWidget.i_page.find('.ckb-i').prop('checked', true);
            } else {
                jQuery.UbizOIWidget.i_page.find('.ckb-f').removeClass('asC');
                jQuery.UbizOIWidget.i_page.find('.ckb-f').removeClass('asP');
                jQuery.UbizOIWidget.i_page.find('.ckb-f').addClass('asU');
                jQuery.UbizOIWidget.i_page.find('.ckb-c').removeClass('asC');
                jQuery.UbizOIWidget.i_page.find('.ckb-c').addClass('asU');
                jQuery.UbizOIWidget.i_page.find('.ckb-i').prop('checked', false);
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
                get_older_data_func = 'onclick="jQuery.UbizOIWidgetPrd.w_get_older_data(' + older_page + ')"';
            }

            var newer_css = 'adS';
            if (newer_page < max_page) {
                newer_css = 'aaT';
                get_newer_data_func = 'onclick="jQuery.UbizOIWidgetPrd.w_get_newer_data(' + newer_page + ')"';
            }

            var paging_label = '<div id="paging-label" class="amH" style="user-select: none"><span class="Dj"><span><span class="ts">' + f_num + '</span>–<span class="ts">' + m_num + '</span></span> / <span class="ts">' + rows_num + '</span></span></div>';
            var paging_older = '<div id="paging-older" ' + get_older_data_func + ' class="amD utooltip" title="Cũ hơn"><span class="amF">&nbsp;</span><img class="amI ' + older_css + '" src="/images/cleardot.gif" alt=""></div>';
            var paging_newer = '<div id="paging-newer" ' + get_newer_data_func + ' class="amD utooltip" title="Mới hơn"><span class="amF">&nbsp;</span><img class="amJ ' + newer_css + '" src="/images/cleardot.gif" alt=""></div>';

            jQuery("#paging-label").replaceWith(paging_label);
            jQuery("#paging-older").replaceWith(paging_older);
            jQuery("#paging-newer").replaceWith(paging_newer);
        },
        w_goto_product_by_brands_id: function (brd_id) {
            window.location.href = "/products/" + brd_id;
        },
        w_active_direct_product: function(productType) {
            $("#nicescroll-sidebar .sP .aW").removeClass("aT");
            $("#nicescroll-sidebar .sP .aW").addClass("NaT");
            $(productType).removeClass("NaT").addClass("aT");
            var prodcuctTypeId = $(productType).prop("id");
            switch (prodcuctTypeId) {
                case "ds_bom":
                    console.log("Danh Sách Bơm");
                    break;
                case "ds_phutung":
                    console.log("Danh Sách Phụ Tùng");
                    break;
                case "tk_tonkho":
                    console.log("Thống Kê Tồn Kho");
                    break;
            }
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


var lst_image_delete = [];
(function ($) {
    UbizOIWidgetPrd = function () {
        this.page = 0;
        this.sort = {};
        this.i_page = null;
        this.i_page_2 = null;
        this.defaultImage = "../images/avatar.png";
        this.sidebar_scrollbars = null;
        this.output_scrollbars = null;
        this.input_scrollbars = null;
    };

    jQuery.UbizOIWidgetPrd = new UbizOIWidgetPrd();
    jQuery.extend(UbizOIWidgetPrd.prototype, {
        w_init: function () {
            jQuery.UbizOIWidgetPrd.i_page = jQuery("#i-put");
            jQuery.UbizOIWidgetPrd.i_page_2 = jQuery("#i-put-2");
            jQuery.UbizOIWidgetPrd.sidebar_scrollbars = fnc_set_scrollbars("nicescroll-sidebar");
            jQuery.UbizOIWidgetPrd.output_scrollbars = fnc_set_scrollbars("nicescroll-oput");
            jQuery.UbizOIWidgetPrd.input_scrollbars = fnc_set_scrollbars("nicescroll-iput");
            jQuery('.utooltip').tooltipster({
                side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
            });
        },
        w_sort: function (self) {
            var sort_name = jQuery(self).attr('sort-name');
            var order_by = jQuery(self).attr('order-by') == '' ? 'asc' : (jQuery(self).attr('order-by') == 'asc' ? 'desc' : 'asc');
            var sort = sort_name + "_" + order_by;
            jQuery.UbizOIWidgetPrd.sort = sort;
            jQuery.UbizOIWidgetPrd.i_page.find('div.dWT').removeClass('dWT');
            jQuery(self).attr('order-by', order_by);
            jQuery(self).addClass('dWT');
            jQuery(self).find('svg').removeClass('sVGT');
            jQuery(self).find('svg.' + order_by).addClass('sVGT');
            var params = {'page': jQuery.UbizOIWidgetPrd.page, 'sort': sort, "search":{}};
            params.search['brd_id'] = current_brd_id;
            ubizapis('v1', '/products', 'get', null, params, jQuery.UbizOIWidgetPrd.w_render_data_to_ouput_page);
        },
        w_delete: function (id) {
            var listId = jQuery.UbizOIWidgetPrd.w_get_checked_rows();
            if (listId.length == 0) {
                if (id == undefined)
                    return false;
                listId.push(id);
            }

            swal({
                title: i18next.t('Do you want to delete the data?'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: _NO,
                confirmButtonText: _YES,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    listId = JSON.stringify(listId);
                    var params = jQuery.UbizOIWidgetPrd.w_get_param_search_sort();
                    params.search['brd_id'] = current_brd_id;
                    ubizapis('v1','/products/'+listId+'/delete', 'delete',null, params,jQuery.UbizOIWidgetPrd.w_process_callback);
                }
            });
        },
        w_create:function(){
            jQuery.UbizOIWidgetPrd.w_clear_input_page();
            jQuery.UbizOIWidgetPrd.w_go_to_input_page(0);
        },
        w_save: function(id) {
            const ALERT_TITLE = i18next.t("Do you want to save it?");
            const ALERT_ICON = "warning";

            //validate
            if (jQuery.UbizOIWidgetPrd.w_validate_input() == false) {
                return;
            }

            var formData = jQuery.UbizOIWidgetPrd.w_get_images_upload();
            formData.append("product", JSON.stringify(jQuery.UbizOIWidgetPrd.w_get_data_input_form()));
            formData.append("series", JSON.stringify(getSeriesDataForCreatePrd()));

            var params = jQuery.UbizOIWidgetPrd.w_get_param_search_sort();
            params.search['brd_id'] = current_brd_id;
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
                        ubizapis('v1','/products/insert', 'post', formData, params, jQuery.UbizOIWidgetPrd.w_process_callback);
                    }
                });
            } else {
                if (jQuery.UbizOIWidgetPrd.w_is_input_changed() == false) {
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
                        ubizapis('v1','/products/'+id+'/update', 'post', formData,params, jQuery.UbizOIWidgetPrd.w_process_callback);
                    }
                });
            }

        },
        w_search:function(){

            var params = jQuery.UbizOIWidgetPrd.w_get_param_search_sort();
            params.search['brd_id'] = current_brd_id;
            var event = new CustomEvent("click");
            document.body.dispatchEvent(event);
            ubizapis('v1', '/products', 'get', null, params, jQuery.UbizOIWidgetPrd.w_render_data_to_ouput_page);
        },
        w_get_search_info: function () {

            var search_info = {};

            if (jQuery('#search-form #prd_name').val().replace(/\s/g, '') != '') {
                search_info.prd_name = jQuery('#search-form #prd_name').val();
            }

            if (jQuery('#search-form #prd_model').val().replace(/\s/g, '') != '') {
                search_info.prd_model = jQuery('#search-form #prd_model').val();
            }

            if (jQuery('#search-form #prd_note').val().replace(/\s/g, '') != '') {
                search_info.prd_note = jQuery('#search-form #prd_note').val();
            }

            if (jQuery('#search-form #type_id').val().replace(/\s/g, '') != '') {
                search_info.type_id = jQuery('#search-form #type_id').val();
            }

            if (jQuery('#search-form #contain').val().replace(/\s/g, '') != '') {
                search_info.contain = jQuery('#search-form #contain').val();
            }

            if (jQuery('#search-form #notcontain').val().replace(/\s/g, '') != '') {
                search_info.notcontain = jQuery('#search-form #notcontain').val();
            }

            search_info.brd_id = jQuery("#i-put #nicescroll-iput #txt_brd_id").val();

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
            jQuery.UbizOIWidgetPrd.page = '0';

            var fuzzy = jQuery('#fuzzy').val();
            var search_info = jQuery.UbizOIWidgetPrd.w_convert_fuzzy_to_search_info(fuzzy);
            jQuery.UbizOIWidgetPrd.w_update_search_form(search_info);
            params.search = search_info;
            params.search['brd_id'] = current_brd_id;

            var sort_info = jQuery.UbizOIWidgetPrd.w_get_sort_info();
            if (sort_info.sort_name != '' || sort_info.order_by != '') {
                params.sort = sort_info.sort_name + "_" + sort_info.order_by;
            }

            ubizapis('v1', '/products', 'get', null, params, jQuery.UbizOIWidgetPrd.w_render_data_to_ouput_page);
        },
        w_fuzzy_search_handle_enter(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                jQuery.UbizOIWidgetPrd.w_fuzzy_search();
            }
        },
        w_get_param_search_sort: function() {
            var params = {};
            params.page = '0';

            var search_info = jQuery.UbizOIWidgetPrd.w_get_search_info();
            params.search = search_info;

            if (jQuery.isEmptyObject(search_info) === false) {
                var fuzzy = jQuery.UbizOIWidgetPrd.w_convert_search_info_to_fuzzy(search_info);
                jQuery('#fuzzy').val(fuzzy);
            }

            var sort_info = jQuery.UbizOIWidgetPrd.w_get_sort_info();
            if (sort_info.sort_name != '' || sort_info.order_by != '') {
                params.sort = sort_info.sort_name + "_" + sort_info.order_by;
            }
            return params;
        },
        w_get_images_upload: function() {
            var formData = new FormData();
            var images = $(".image-upload .file-upload");
            $(images).each(function(){
                image = $(this);
                if ($(this).attr("is-change") == "true") {
                    formData.append('image-upload[]',image[0].files[0]);
                }
            });

            return formData;
        },
        w_get_data_input_form: function() {
            var data = {
                brd_id: $("#i-put-2 #txt_brd_id").val(),
                id: $("#i-put-2 #txt_prd_id").val(),
                name: $("#i-put-2 #txt_name").val(),
                prd_model: $("#i-put-2 #txt_model").val(),
                prd_unit: $("#i-put-2 #txt_unit").val(),
                type_id: $("#i-put-2 #txt_name_type").val(),
                prd_note: $("#i-put-2 #txt_prd_note").val(),
                images: {
                    "delete": lst_image_delete
                }
            };
            return data;
        },
        w_open_searh_form: function (self) {
            swal('ok');
        },
        w_go_to_input_page: function (id, index) {
            if (id != 0) {
                if (id == -1) {
                    if (jQuery.UbizOIWidgetPrd.w_is_input_changed() == true) {
                        removeErrorInput();
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
                                //validate
                                if (jQuery.UbizOIWidgetPrd.w_validate_input() == false) {
                                    return;
                                }
                                var formInput = jQuery.UbizOIWidgetPrd.w_get_data_input_form();
                                var formData = jQuery.UbizOIWidgetPrd.w_get_images_upload();
                                formData.append("product", JSON.stringify(formInput));
                                var params = jQuery.UbizOIWidgetPrd.w_get_param_search_sort();
                                params.search['brd_id'] = current_brd_id;
                                formData.append("_method","put");
                                ubizapis('v1','/products/'+formInput.id+'/updatePaging', 'post', formData,params,function() {
                                    jQuery.UbizOIWidgetPrd.w_reset_input_change();
                                    jQuery.UbizOIWidgetPrd.w_get_specific_product_by_id(id, index);
                                    $("#i-put-2 .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidgetPrd.w_delete("+id+")");
                                });
                            } else {
                                jQuery.UbizOIWidgetPrd.w_reset_input_change();
                                jQuery.UbizOIWidgetPrd.w_get_specific_product_by_id(id, index);
                                $("#i-put-2 .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidgetPrd.w_delete("+id+")");
                            }
                        });
                    } else {
                        jQuery.UbizOIWidgetPrd.w_get_specific_product_by_id(id, index);
                        $("#i-put-2 .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidgetPrd.w_delete("+id+")");
                    }
                } else {
                    jQuery.UbizOIWidgetPrd.w_get_specific_product_by_id(id, index);
                    $("#i-put-2 .GtF .delete").css("display","block").attr("onclick","jQuery.UbizOIWidgetPrd.w_delete("+id+")");
                }
            }
            else{
                $("#i-put-2 .GtF .delete").css("display","none").removeAttr("onclick");
            }

            if (isEmpty(index)) {
                $("#i-put-2 .GtF .save").attr("onclick", "jQuery.UbizOIWidgetPrd.w_save(0)");
            }

            jQuery.UbizOIWidgetPrd.i_page.hide();
            jQuery.UbizOIWidgetPrd.i_page_2.fadeIn("slow");
            jQuery.UbizOIWidgetPrd.w_sleep_scrollbars(jQuery.UbizOIWidgetPrd.output_scrollbars);
            jQuery.UbizOIWidgetPrd.w_update_scrollbars(jQuery.UbizOIWidgetPrd.input_scrollbars);
        },w_reset_input_change: function() {
            $("#i-put-2 #nicescroll-iput-2 #txt_name").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 #txt_model").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 #txt_name_type").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 #txt_detail").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 .file-upload").isChange("false");
        },
        w_set_paging_for_detail_page: function(page, totalPage, isReset = false) {
            var previous = $("#i-put-2 .aqK .previous");
            var next = $("#i-put-2 .aqK .next");
            var currentPage = $("#i-put-2 .aqK .current-page");
            var rowNumbers = $("#i-put-2 .aqK .row-numbers");
            page = Number(page);
            totalPage = Number(totalPage);
            if (page == 0) {
                $(previous).find(".amI").removeClass("aaT").addClass("adS");
                $(next).find(".amJ").removeClass("adS").addClass("aaT");
                $(previous).removeAttr("onclick");
                $(next).attr("onclick", "jQuery.UbizOIWidgetPrd.w_go_to_input_page(-1,"+(page + 1)+")");
            } else if (page >= totalPage - 1) {
                $(next).find(".amJ").removeClass("aaT").addClass("adS");
                $(previous).find(".amI").removeClass("adS").addClass("aaT");
                $(next).removeAttr("onclick");
                $(previous).attr("onclick", "jQuery.UbizOIWidgetPrd.w_go_to_input_page(-1,"+(page - 1)+")");
            } else {
                $(next).find(".amJ").removeClass("adS").addClass("aaT");
                $(previous).find(".amI").removeClass("adS").addClass("aaT");
                $(next).attr("onclick", "jQuery.UbizOIWidgetPrd.w_go_to_input_page(-1,"+(page + 1)+")");
                $(previous).attr("onclick", "jQuery.UbizOIWidgetPrd.w_go_to_input_page(-1,"+(page - 1)+")");
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
            changeCreateFunction(_ADD_PRODUCT);
            jQuery.UbizOIWidgetPrd.i_page.fadeIn("slow");
            jQuery.UbizOIWidgetPrd.i_page_2.hide();
            jQuery.UbizOIWidgetPrd.w_sleep_scrollbars(jQuery.UbizOIWidgetPrd.input_scrollbars);
            jQuery.UbizOIWidgetPrd.w_update_scrollbars(jQuery.UbizOIWidgetPrd.output_scrollbars);
            jQuery.UbizOIWidgetPrd.w_clear_input_page();
        },
        w_refresh_output_page: function () {
            var params = jQuery.UbizOIWidgetPrd.w_get_param_search_sort();
            params.page = jQuery.UbizOIWidgetPrd.page;
            params.search['brd_id'] = current_brd_id;
            ubizapis('v1', '/products', 'get', null, params, jQuery.UbizOIWidgetPrd.w_render_data_to_ouput_page);
        },
        w_get_sort_info: function () {
            var sort_obj = jQuery.UbizOIWidgetPrd.i_page.find('div.dWT');
            var sort_name = sort_obj.attr('sort-name');
            var order_by = sort_obj.attr('order-by');
            return {'sort_name': sort_name, 'order_by': order_by};
        },
        w_get_older_data: function (page) {
            var params = jQuery.UbizOIWidgetPrd.w_get_param_search_sort();
            params.page = page;
            params.search['brd_id'] = current_brd_id;
            jQuery.UbizOIWidgetPrd.page = page;
            ubizapis('v1', '/products', 'get', null, params, jQuery.UbizOIWidgetPrd.w_render_data_to_ouput_page);
        },
        w_get_newer_data: function (page) {
            jQuery.UbizOIWidgetPrd.page = page;
            var params = jQuery.UbizOIWidgetPrd.w_get_param_search_sort();
            params.search['brd_id'] = current_brd_id;
            params.page = page;
            jQuery.UbizOIWidgetPrd.page = page;
            ubizapis('v1', '/products', 'get', null, params, jQuery.UbizOIWidgetPrd.w_render_data_to_ouput_page);
        },
        w_process_callback: function (response) {
            if (response.data.success == true) {
                if (response.data.method == "insert") {
                    swal({
                        title:response.data.message,
                        text: i18next.t("Do you want to continue insert Product?"),
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: _NO,
                        confirmButtonText: _YES,
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {
                            jQuery.UbizOIWidgetPrd.w_clear_input_page();
                        } else {
                            jQuery.UbizOIWidgetPrd.w_render_data_to_ouput_page(response);
                            jQuery.UbizOIWidgetPrd.w_go_back_to_output_page();
                        }
                    });
                } else {
                    jQuery.UbizOIWidgetPrd.w_render_data_to_ouput_page(response);
                    jQuery.UbizOIWidgetPrd.w_go_back_to_output_page();
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
            var products = response.data.product;
            initProduct(products, response.data.paging.page);
            jQuery.UbizOIWidgetPrd.page = response.data.paging.page;
            jQuery.UbizOIWidgetPrd.w_paging(response.data.paging.page, response.data.paging.rows_num, response.data.paging.rows_per_page);
        },
        w_render_data_to_input_page: function(response) {
            if (response == undefined || response.data == undefined || response.data.product.length <= 0) {
                return;
            }
            var data = response.data.product[0];
            $("#i-put-2 .GtF .delete").attr("onclick","jQuery.UbizOIWidgetPrd.w_delete("+data.id+")");
            $("#i-put-2 .GtF .save").attr("onclick", "jQuery.UbizOIWidgetPrd.w_save("+data.id+")");
            $("#i-put-2 .GtF .refresh").attr("onclick","getSeries()");
            $("#i-put-2 #nicescroll-iput-2 #txt_brand_name").val(data.brd_name);
            $("#i-put-2 #nicescroll-iput-2 #txt_brd_id").val(data.brd_id);
            $("#i-put-2 #nicescroll-iput-2 #txt_prd_id").val(data.id);
            $("#i-put-2 #nicescroll-iput-2 #txt_name").val(data.name).change(function() {inputChange(this, data.name)});
            $("#i-put-2 #nicescroll-iput-2 #txt_unit").val(data.prd_unit).change(function() {inputChange(this, data.prd_unit)});
            $("#i-put-2 #nicescroll-iput-2 #txt_model").val(data.model).change(function() {inputChange(this, data.model)});
            $("#i-put-2 #nicescroll-iput-2 #txt_name_type").val(data.prd_type_id).change(function() {inputChange(this, data.prd_type_id)}); // THY  fix thành combobox
            $("#i-put-2 #nicescroll-iput-2 #txt_prd_note").val(data.prd_note).change(function() {inputChange(this, data.prd_note)}); // THY fix thành Textarea
            $("#i-put-2 #nicescroll-iput-2 .img-show").attr("src","../images/avatar.png").setName("");
            if (data.images != undefined && data.images.length > 0) {
                var controlImages = $("#i-put-2 .img-show");
                for(var i = 0; i < data.images.length; i++) {
                    $(controlImages[i]).attr("src",data.images[i].src).setName(data.images[i].name);
                }
            }
            // if (isEmpty(data.images)) {
            //     data.src = jQuery.UbizOIWidgetPrd.defaultImage;  // THY Fix image
            // }
            // var addrLength = addresses.length >= 3 ? addresses.length : 3;
            // for(let i = 0; i < addrLength; i++) {
            //     if (i <= 2) {
            //         $($("#i-put #nicescroll-iput #txt_adr" + (i+1)).val(addresses[i] != undefined ? addresses[i].address : "" )).change(function() {
            //             inputChange(this, addresses[i] != undefined ? addresses[i].address : "" );
            //         }).attr("sad_id",addresses[i] != undefined ? addresses[i].id : "");
            //     } else {
            //         var address = $("#i-put #nicescroll-iput .txt_adr1_container").clone();
            //         $(address).removeClass("txt_adr1_container").addClass("txt_adr"+(i+1)+"_container").addClass("clone-address");
            //         $($(address).find("input").attr("id","txt_adr"+(i+1)).val(addresses[i].address)).change(function() {inputChange(this, addresses[i].address)}).attr("sad_id",addresses[i].id);
            //         $(address).find("label.lbl-primary").html(i18next.t("Address") + " " + (i+1));
            //         $(address).insertAfter("#i-put #nicescroll-iput .txt_adr"+i+"_container");
            //     }
            // }
            // $("#i-put #nicescroll-iput .image-upload .img-show").attr("src", data.src);
            // $("#i-put #nicescroll-iput .image-upload .img-show").attr("img-name", data.sup_avatar);

            jQuery.UbizOIWidgetPrd.w_set_paging_for_detail_page(response.data.paging.page, response.data.paging.rows_num);
            getSeries();
        },
        w_is_input_changed: function() {
            var txt_input = $("#i-put-2 .jAQ input, #i-put-2 .jAQ textarea,  #i-put-2 .jAQ select");
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
            var txt_input = $("#i-put-2 .jAQ input.input_field, #i-put-2 .jAQ textarea#txt_detail");
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
                    case "txt_name":

                        break;
                    case "txt_branch":

                        break;
                    case "txt_model":

                        break;
                    case "txt_detail":

                        break;
                }
            }
            return isValid;
        },
        w_clear_input_page: function() {
            $("#i-put-2 #nicescroll-iput-2 #txt_name").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 #txt_model").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 #txt_name_type").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 #txt_prd_note").val("").isChange("false");
            $("#i-put-2 #nicescroll-iput-2 #txt_unit").val("").isChange("false");
            jQuery.UbizOIWidgetPrd.sort = {'sort_name': 'prd_name', 'order_by': 'asc'};
            jQuery.UbizOIWidgetPrd.w_set_paging_for_detail_page(0,0,true);
            removeErrorInput();
            lst_image_delete = [];
            $("#i-put-2 #nicescroll-iput-2 .img-show").attr("src","../images/avatar.png").setName("");
            $("#i-put-2 #nicescroll-iput-2 .file-upload").val("").isChange("false");
            $("#i-put #nicescroll-iput .os-content-glue").css({
                "margin": "-10px 0px",
                "width": "1647px",
                "max-width": "100%",
                "height": "224px"
            });
            jQuery.UbizOIWidgetPrd.i_page_2.find(".tb-series").find("tbody").empty();
        },
        w_clear_search_form:function(){
            jQuery('#search-form  #prd_name').val("");
            jQuery('#search-form  #prd_model').val("");
            jQuery('#search-form  #type_id').val("");
            jQuery('#search-form  #prd_note').val("");
            jQuery('#search-form  #sup_contain').val("");
            jQuery('#search-form  #sup_notcontain').val("");
            jQuery('#search-form  #sup_fuzzy').val("");
        },
        w_get_specific_product_by_id(id, index) {
            changeCreateFunction(_ADD_PRODUCT);
            jQuery.UbizOIWidgetPrd.i_page_2.find(".tb-series").css("display",'');
            jQuery.UbizOIWidgetPrd.i_page_2.find(".tb-series").find("tbody").empty();
            var params = jQuery.UbizOIWidgetPrd.w_get_param_search_sort();
            params.page = index;
            params.search['brd_id'] = current_brd_id;
            ubizapis('v1','/products/detail', 'get', null, params,jQuery.UbizOIWidgetPrd.w_render_data_to_input_page);
        },
        w_make_row_html: function (id, cols, index) {
            var row_html = '';
            if (cols.length > 0) {
                row_html = '<div class="jvD" ondblclick="jQuery.UbizOIWidgetPrd.w_go_to_input_page(' + id + ','+index+')">';
                row_html += cols.join("");
                row_html += '</div>';
            }
            return row_html;
        },
        w_make_col_html: function (col_id, col_val, col_idx, isImage = null) {
            var col_html = "";
            col_html += '<div class="tcB col-' + col_idx + '">';
            col_html += '<div class="cbo">';
            if (col_idx == 1) {
                col_html += '<div class="jgQ" onclick="jQuery.UbizOIWidgetPrd.w_c_checkbox_click(this)">';
                col_html += '<input type="checkbox" class="ckb-i" value="' + col_id + '" style="display: none"/>';
                col_html += '<div class="asU ckb-c"></div>';
                col_html += '</div>';
            }
            if (isImage) {
                col_html += '<div class="nCji" title="' + isImage + '">';
                if (isEmpty(col_val)) {
                    col_html += "<img  />";
                } else {
                    col_html += "<img src='"+ col_val +"' class='img-thumbnail prd-image' />";
                }
            } else {
                var classDiv = "nCj";
                if (col_idx == 1) classDiv = "nCT";
                col_html += '<div class="'+classDiv+'" title="' + col_val + '">';
                col_html += '<span>' + col_val + '</span>';
            }

            col_html += '</div>';
            col_html += '</div>';
            col_html += '</div>';
            return col_html;
        },
        w_callback_remove_image: function(self) {
            var imageId = $(self).closest(".image-upload").find(".img-show").getImageId();
            if (!isEmpty(imageId)) {
                lst_image_delete.push(imageId);
            }
        },
        w_f_checkbox_click: function (self) {
            if (jQuery(self).find('div.ckb-f').hasClass('asU')) {
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').removeClass('asU');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').removeClass('asP');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').addClass('asC');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-c').removeClass('asU');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-c').addClass('asC');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-i').prop('checked', true);
            } else {
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').removeClass('asC');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').removeClass('asP');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').addClass('asU');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-c').removeClass('asC');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-c').addClass('asU');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-i').prop('checked', false);
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
            jQuery.UbizOIWidgetPrd.w_reset_f_checkbox_status();
        },
        w_reset_f_checkbox_status: function () {
            var row_length = jQuery.UbizOIWidgetPrd.i_page.find('.jvD').length;
            var checked_row_length = jQuery.UbizOIWidgetPrd.i_page.find('.ckb-i:checked').length;
            if (row_length == checked_row_length) {
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').removeClass('asU');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').removeClass('asP');
                jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').addClass('asC');
            } else {
                if (checked_row_length == 0) {
                    jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').removeClass('asC');
                    jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').removeClass('asP');
                    jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').addClass('asU');
                } else {
                    jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').removeClass('asC');
                    jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').removeClass('asU');
                    jQuery.UbizOIWidgetPrd.i_page.find('.ckb-f').addClass('asP');
                }
            }
        },
        w_get_checked_rows: function () {
            var ids = [];
            var checked_rows = jQuery.UbizOIWidgetPrd.i_page.find('.ckb-i:checked');
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
                get_older_data_func = 'onclick="jQuery.UbizOIWidgetPrd.w_get_older_data(' + older_page + ')"';
            }

            var newer_css = 'adS';
            if (newer_page < max_page) {
                newer_css = 'aaT';
                get_newer_data_func = 'onclick="jQuery.UbizOIWidgetPrd.w_get_newer_data(' + newer_page + ')"';
            }

            var paging_label = '<div id="paging-label" class="amH" style="user-select: none"><span class="Dj"><span><span class="ts">' + f_num + '</span>–<span class="ts">' + m_num + '</span></span> / <span class="ts">' + rows_num + '</span></span></div>';
            var paging_older = '<div id="paging-older" ' + get_older_data_func + ' class="amD utooltip" title="Cũ hơn"><span class="amF">&nbsp;</span><img class="amI ' + older_css + '" src="/images/cleardot.gif" alt=""></div>';
            var paging_newer = '<div id="paging-newer" ' + get_newer_data_func + ' class="amD utooltip" title="Mới hơn"><span class="amF">&nbsp;</span><img class="amJ ' + newer_css + '" src="/images/cleardot.gif" alt=""></div>';

            jQuery("#paging-label").replaceWith(paging_label);
            jQuery("#paging-older").replaceWith(paging_older);
            jQuery("#paging-newer").replaceWith(paging_newer);
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

function isEmpty(str) {
    if (str == null || str == undefined || str == "") {
        return true;
    }
    return false;
}

jQuery(document).ready(function () {
    jQuery.UbizOIWidgetPrd.w_init();
    jQuery.UbizOIWidget.w_init();
    $('#addSeriesModal').on('hide.bs.modal', function (e) {
        clearSeriesModal();
    })
    $('#addSeriesModal #txt_keep_person').change(function() {
        if ($(this).val() == "") $("#addSeriesModal .txt_expired_date_container").css("display","none").find("#txt_expired_date").addClass("input-hidden");
        else $("#addSeriesModal .txt_expired_date_container").css("display","").find("#txt_expired_date").removeClass("input-hidden");
    })
});

function initModal() {
    if ($('#addSeriesModal #txt_keep_person').val() == "")
        $("#addSeriesModal .txt_expired_date_container").css("display","none").find("#txt_expired_date").addClass("input-hidden");
    else
        $("#addSeriesModal .txt_expired_date_container").css("display","").find("#txt_expired_date").removeClass("input-hidden");
}

function initProduct(data, page) {
    var html = "";
    var index = page * 10 -1;
    if (index < 0) index = 0;
    $(".product-content .product-content-detail").html("");
    html+='<div class="yTP">';
    html+='<div id="table-content" class="jFr">\n';
    for(var i = 0; i < data.length; i++)  {
        var prd = data[i];
        var src_image = isEmpty(prd.image) ? "" : "src=" + prd.image;
        var class_image = isEmpty(prd.image) ? "" : "img-thumbnail ";
        html+= '                                        <div class="jvD" ondblclick="jQuery.UbizOIWidgetPrd.w_go_to_input_page('+prd.id+','+index+')">';
        html+= '                                            <div class="tcB col-1">';
        html+= '                                                <div class="cbo">';
        html+= '                                                    <div class="jgQ" onclick="jQuery.UbizOIWidgetPrd.w_c_checkbox_click(this)">';
        html+= '                                                        <input type="checkbox" class="ckb-i" value="'+prd.id+'" style="display: none"/>';
        html+= '                                                        <div class="asU ckb-c"></div>';
        html+= '                                                    </div>';
        html+= '                                                    <div class="nCT" title="'+prd.id+'">';
        html+= '                                                        <span>'+prd.id+'</span>';
        html+= '                                                    </div>';
        html+= '                                                </div>';
        html+= '                                            </div>';
        html+= '                                            <div class="tcB col-2">';
        html+= '                                                <div class="cbo">';
        if(prd.prd_img_id) {
            html += '                                                    <div class="nCji" title="' + prd.prd_img_id + '">';
            html += '                                                        <img ' + src_image + '  class="' + class_image + 'prd-image"/>';
            html += '                                                    </div>';
        }
        html+= '                                                </div>';
        html+= '                                            </div>';
        html+= '                                            <div class="tcB col-3">';
        html+= '                                                <div class="cbo">';
        html+= '                                                    <div class="nCj" title="'+prd.name+'">';
        html+= '                                                        <span>'+prd.name+'</span>';
        html+= '                                                    </div>';
        html+= '                                                </div>';
        html+= '                                            </div>';
        html+= '                                            <div class="tcB col-4">';
        html+= '                                                <div class="cbo">';
        html+= '                                                    <div class="nCj" title="'+prd.brd_name+'">';
        html+= '                                                        <span>'+prd.brd_name+'</span>';
        html+= '                                                    </div>';
        html+= '                                                </div>';
        html+= '                                            </div>';
        html+= '                                            <div class="tcB col-5">';
        html+= '                                                <div class="cbo">';
        html+= '                                                    <div class="nCj" title="'+(isEmpty(prd.model) ? "" : prd.model) +'">';
        html+= '                                                        <span>'+ (isEmpty(prd.model) ? "" : prd.model) +'</span>';
        html+= '                                                    </div>';
        html+= '                                                </div>';
        html+= '                                            </div>';
        html+= '                                            <div class="tcB col-6">';
        html+= '                                                <div class="cbo">';
        html+= '                                                    <div class="nCj" title="'+prd.name_type+'">';
        html+= '                                                        <span>'+prd.name_type+'</span>';
        html+= '                                                    </div>';
        html+= '                                                </div>';
        html+= '                                            </div>';
        html+= '                                        </div>';
        index++;
    }
    html +='                                </div>';
    html +='                            </div>';
    $(".product-content .product-content-detail").append(html);
}

function getSeries() {
    jQuery.UbizOIWidgetPrd.i_page_2.find(".tb-series").find("tbody").empty();
    var prd_id = $("#txt_prd_id").val();
    var params = {};
    params.page = 0;
    params.search = {};
    params.sort = "";
    params.prd_id = prd_id;
    ubizapis('v1','/series', 'get',null, params,function(response) {
        var series = response.data.series;
        writeSeriesToTable(series);
    });
}

function createNew(screen) {
    var obj = jQuery.UbizOIWidgetPrd;
    jQuery.UbizOIWidgetPrd.i_page_2.find(".tb-series").find("tbody").empty();
    current_screen = screen;
    if (screen == _ADD_BRANDS) {
        obj = jQuery.UbizOIWidget;
        setTimeout(function() {
            obj.i_page.find(".bkK").css("display","none");
            obj.i_page.find(".product-content").css("display","none");
            obj.i_page.find(".onsite").css("display","");
            obj.i_page.find(".onsite .delete").css("display","");
        }, 100);

    } else {
        var brd_name = $("#nicescroll-iput #txt_brd_name").val();
        var brd_id = $("#nicescroll-iput #txt_brd_id").val();
        $("#nicescroll-iput-2 #txt_brand_name").val(brd_name);
        $("#nicescroll-iput-2 #txt_brd_id").val(brd_id);
        $("#nicescroll-iput-2 #txt_prd_id").val("");
    }
    obj.w_clear_input_page();
    obj.w_go_to_input_page(0);
}

function changeCreateFunction(screen) {
    jQuery.UbizOIWidget.i_page.find(".product-content").css("display","");
    jQuery.UbizOIWidget.i_page.find(".bkK").css("display","");
    jQuery.UbizOIWidget.i_page.find(".onsite").css("display","none");
    $(".l-content .zY .yP").attr("onclick", "createNew("+screen+")");
}

function writeSeriesToTable(series) {

    var copyButton = '<i class="fa fa-files-o" onclick="copySeries(this)"></i>';
    var deleteButton = '<i class="fa fa-trash-o" onclick="deleteSeries(this)"></i>';
    var html = '';
    for(var i = 0; i < series.length; i++) {
        var seri = series[i];
        html += "<tr ondblclick='openSeriesModal(this)'>";
        html += "<td class='txt-stt'>" + (i + 1) +"</td>";
        html += "<td class='series_no'>" + seri.serial_no +"</td>";
        html += "<td class='series_inp_date'>" + seri.inp_date +"</td>";
        html += "<td class='series_keep_date'>" + (isEmpty(seri.serial_keep_date) ? "" : seri.serial_keep_date)  +"</td>";
        html += "<td class='series_expired_date'>" + (isEmpty(seri.serial_expired_date) ? "" : seri.serial_expired_date) +"</td>";
        html += "<td > <input type='hidden' class='series_kepper' value='"+ seri.serial_keeper+"'><span>" + seri.name +"</span></td>";
        html += "<td class='series_note'>" + seri.serial_note +"</td>";
        html += "<td class='text-center'><input type='hidden' value='"+seri.prd_series_id+"' class='prd_series_id'>"+copyButton+ " " +deleteButton+"</td>";
        html+= "</tr>";
    }

    $(".tb-series").find("tbody").append(html);
    $("#nicescroll-iput-2 #txt_quantity").val(series.length);
}

var series_row_selected;

function openSeriesModal(row) {
    series_row_selected = undefined;
    $("#addSeriesModal .btn-save").attr("onclick","seriesSave(0)");
    if (!isEmpty(row)) {
        series_row_selected = row;
        var series_no =$(row).find(".series_no").html();
        var keeper =$(row).find(".series_kepper").val();
        var series_note=$(row).find(".series_note").html();
        var expired_date =$(row).find(".series_expired_date").html();
        $("#addSeriesModal #txt_series_no").val(series_no);
        $("#addSeriesModal #txt_keep_person").val(keeper);
        $("#addSeriesModal #txt_series_note").val(series_note);
        $("#addSeriesModal #txt_expired_date").val(expired_date);
        $("#addSeriesModal .btn-save").attr("onclick","seriesSave(1)");
    }
    $("#addSeriesModal").modal();
    setTimeout(function() {
        initModal();
    }, 100);
}

function getSeriesDataForCreatePrd() {
    var rows = $(".tb-series-container .tb-series tbody tr");
    var lstSeries = [];
    for(var i = 0; i < rows.length; i++) {
        var row = rows[i];
        lstSeries.push({
            serial_no: $(row).find(".series_no").html(),
            serial_keeper: $(row).find(".series_kepper").val(),
            serial_note: $(row).find(".series_note").html(),
            serial_sts: isEmpty($(row).find(".series_kepper").val()) ? "0" : "1",
        });
    }
    return lstSeries;
}

function clearSeriesModal() {
    $("#addSeriesModal #txt_series_no").val("");
    $("#addSeriesModal #txt_keep_person").val("");
    $("#addSeriesModal #txt_series_note").val("");
    $("#addSeriesModal #txt_expired_date").val("");
    series_row_selected = null;
}

function seriesSave(flg) {
    if (!validateSeries(series_row_selected)) return;
    var series_no = $("#addSeriesModal #txt_series_no").val();
    var keeper  = $("#addSeriesModal #txt_keep_person").val();
    var series_note = $("#addSeriesModal #txt_series_note").val();
    var expired_date = $("#addSeriesModal #txt_expired_date").val();
    var params = {
        prd_series_id: getProductSeriID(),
        prd_id: getProductId(),
        serial_no : series_no,
        serial_sts: isEmpty(keeper) ? "0" : "1",
        serial_keeper: keeper,
        serial_note: series_note,
        serial_expired_date: !isEmpty(keeper) ? expired_date : "",
        serial_keep_date: !isEmpty(keeper) ? getCurrentDate() : ""
    };
    if (!isEmpty($("#nicescroll-iput-2 #txt_prd_id").val())) {
        if (flg == 0) {
            createNewSeries(params);
        } else {
            updateSeries(params);
        }
    }
    updateTableSeries(series_row_selected);
    $("#addSeriesModal").modal('hide');
    reOrderStt();
}

function createNewSeries(param) {
    if (!checkDuplicateSeries()) {
        // show notification
        return false;
    }
    // var formData = new FormData();
    // formData.append('series',JSON.stringify(param));
    var params = {
        series:JSON.stringify(param)
    };
    ubizapis('v1', '/series/insert', 'post', null, params, function(response) {
        setTimeout(function() {
            var prd_series_id = response.data.prd_series_id;
            var listTr = $(".tb-series tbody tr");
            var lastTr = listTr[listTr.length - 1];
            $(lastTr).find(".prd_series_id").val(prd_series_id);
        }, 1000);
    });
}

function updateSeries(param) {
    if (!checkDuplicateSeries()) {
        // show notification
        return false;
    }
    var params = {
        series:JSON.stringify(param),
        _method: "put"
    };
    ubizapis('v1', '/series/'+ param.prd_series_id +'/update', 'post', null, params, function() {});
}

function checkDuplicateSeries() {
    // Check duplicate in same product
    return true;
}

function updateTableSeries(row) {
    var today = getCurrentDate();
    var series_no = $("#addSeriesModal #txt_series_no").val();
    var keeper  = $("#addSeriesModal #txt_keep_person").val();
    var keeper_txt = $("#addSeriesModal #txt_keep_person option:selected").text();
    var series_note = $("#addSeriesModal #txt_series_note").val();
    var txt_expired_date = $("#addSeriesModal #txt_expired_date").val();
    var prd_series_id = getProductId();
    var seri = {
        prd_series_id: getProductSeriID(),
        prd_id:getProductId(),
        serial_no : series_no,
        serial_sts: isEmpty(keeper) ? "0" : "1",
        serial_keeper: keeper,
        name: keeper_txt,
        serial_note: series_note,
        inp_date: today,
        serial_expired_date: isEmpty(keeper) ? txt_expired_date : "",
        serial_keep_date: !isEmpty(keeper) ? getCurrentDate() : ""
    };
    if (!isEmpty(row)) {
        $(row).find(".series_no").html(series_no);
        $(row).find(".series_kepper").val(keeper);
        $(row).find(".series_kepper").parent().find("span").html(keeper_txt);
        $(row).find(".series_note").html(series_note);
        $(row).find(".series_expired_date").html(txt_expired_date);
        $(row).find(".series_keep_date").html(today);
        $(row).find(".prd_series_id").val(prd_series_id);
    } else {
        var series = [];
        series.push(seri);
        writeSeriesToTable(series);
    }
}

function copySeries(row) {
    var cloneNewRow = $(row).closest("tr").clone();
    var today = getCurrentDate();
    $(cloneNewRow).find(".series_inp_date").html(today);
    $(".tb-series").find("tbody").append(cloneNewRow);
    reOrderStt();
    var series_no =$(cloneNewRow).find(".series_no").html();
    var keeper =$(cloneNewRow).find(".series_kepper").val();
    var series_note=$(cloneNewRow).find(".series_note").html();
    var expired_date=$(cloneNewRow).find(".series_expired_date").html();
    var params = {
        prd_series_id: getProductSeriID(),
        prd_id:getProductId(),
        serial_no : series_no,
        serial_sts: isEmpty(keeper) ? "0" : "1",
        serial_keeper: keeper,
        serial_note: series_note,
        serial_expired_date: !isEmpty(keeper) ? expired_date : "",
        serial_keep_date: !isEmpty(keeper) ? getCurrentDate() : ""
    };
    if (isEmpty($("#nicescroll-iput-2 #txt_prd_id").val())) return;
    createNewSeries(params);
}

function deleteSeries(row) {
    if (!isEmpty($("#nicescroll-iput-2 #txt_prd_id").val())) {
        ubizapis('v1', '/series/' + $(row).closest("tr").find(".prd_series_id").val() + '/delete', 'delete', null, null);
    }
    $(row).closest("tr").remove();
    reOrderStt();
}

function getCurrentDate() {
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    if (month < 10) month = "0" + month;
    var today = day + "/" + month + "/" + year;
    return today;
}

function reOrderStt() {
    var stt = $(".txt-stt");
    var sttLength = $(".txt-stt").length + 1;
    for(i = 0; i < sttLength; i++) {
        $(stt[i]).html(i + 1);
    }
    $("#nicescroll-iput-2 #txt_quantity").val(sttLength - 1);
}

function getProductId() {
    return $("#nicescroll-iput-2 #txt_prd_id").val();
}

function getProductSeriID() {
    return  $(series_row_selected).find(".prd_series_id").val();
}

function validateSeries(row) {
    removeErrorInput();
    var isValid = true;
    var txt_input = $("#addSeriesModal .modal-body input");
    for(var i = 0; i < txt_input.length; i++) {
        if ($(txt_input[i]).prop("required") == true && $(txt_input[i]).hasClass("input-hidden") == false) {
            if ($(txt_input[i]).val() == "") {
                isValid = false;
                showErrorInput(txt_input[i], i18next.t("This input is required"));
            }
        }
        var control_id = $(txt_input[i]).attr("id");
        var control_value = $(txt_input[i]).val().trim();
        var message = "";
        switch(control_id) {
            case "txt_expired_date":
                if ($("#" + control_id).hasClass("input-hidden")) break;
                // First check for the pattern
                if(!/^\d{1,2}[\-\/]\d{1,2}[\-\/]\d{4}$/.test(control_value)){
                    message = "Not correct format date";
                    isValid = false;
                }

                // Parse the date parts to integers
                var parts = control_value.split(/[\-\/]/);
                var day = parseInt(parts[0], 10);
                var month = parseInt(parts[1], 10);
                var year = parseInt(parts[2], 10);

                // Check the ranges of month and year
                if(year < 1000 || year > 3000 || month == 0 || month > 12) {
                    message = "Not correct format date";
                    isValid = false;
                }

                var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

                // Adjust for leap years
                if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
                    monthLength[1] = 29;


                if ((day > 0 && day <= monthLength[month - 1]) == false) {
                    message = "Not correct format date";
                    isValid = false;
                } else {
                    isGreaterDate = compareDate($(row).find(".series_keep_date").html(), control_value);
                    if(isGreaterDate == -1){
                        isValid = false;
                        message = "Expired date have to greater than or equals to keep date";
                    }

                }
                if (!isValid) {
                    showErrorInput(txt_input[i], i18next.t(message));
                }

                break;
        }
    }
    return isValid;
}

function compareDate(date1, date2) {
    if (date1 == null || date1 == undefined || date1 == "") {
        date1 = getCurrentDate();
    }
    var datePart1 = date1.split(/[\/-]/);
    var datePart2 = date2.split(/[\/-]/);
    if (parseInt(datePart2[2]) > parseInt(datePart1[2])) {
        return 1;
    } else if (parseInt(datePart2[2]) == parseInt(datePart1[2])) {
        if (parseInt(datePart2[1]) > parseInt(datePart1[1]) ) {
            return 1;
        } else if (parseInt(datePart2[1]) == parseInt(datePart1[1]) ) {
            if (parseInt(datePart2[0]) > parseInt(datePart1[0]) ) {
                return 1;
            } else if (parseInt(datePart2[0]) == parseInt(datePart1[0]) ) {
                return 0;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    } else {
        return -1;
    }
}