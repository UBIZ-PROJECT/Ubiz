(function ($) {
    UbizOIWidget = function () {
        this.page = 0;
        this.sort = {};
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

            ubizapis('v1', '/customers', 'get', null, {'page': jQuery.UbizOIWidget.page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_delete: function (ids) {
			if(ids == 0){
				var ids = jQuery.UbizOIWidget.w_get_checked_rows();
			}
            if (ids.length == 0)
                return false;

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
                        ubizapis('v1', '/customers/' + ids.join(',') + '/delete', 'delete', null, null, jQuery.UbizOIWidget.w_delete_callback);
                        break;
                }
            });
        },
        w_create:function(){
            jQuery.UbizOIWidget.w_go_to_input_page(0);
        },
        w_search:function(){
            var params = {};
            params.page = '0';

            if (jQuery('#cus_code').val().replace(/\s/g, '') != '') {
                params.code = jQuery('#cus_code').val();
            }
			
			
            if (jQuery('#cus_type').val().replace(/\s/g, '') != '') {
                params.name = jQuery('#cus_type').val();
            }

            if (jQuery('#cus_name').val().replace(/\s/g, '') != '') {
                params.name = jQuery('#cus_name').val();
            }

            if (jQuery('#cus_phone').val().replace(/\s/g, '') != '') {
                params.email = jQuery('#cus_phone').val();
            }

            if (jQuery('#cus_fax').val().replace(/\s/g, '') != '') {
                params.phone = jQuery('#cus_fax').val();
            }

            if (jQuery('#cus_mail').val().replace(/\s/g, '') != '') {
                params.dep_name = jQuery('#cus_mail').val();
            }

            if (jQuery('#cus_address').val().replace(/\s/g, '') != '') {
                params.address = jQuery('#cus_address').val();
            }

            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            params.sort = sort_info.sort_name + "_" + sort_info.order_by;

            ubizapis('v1', '/users', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_clear_search_form:function(){
            jQuery('#cus_code').val("");
			jQuery('#cus_type').val("");
            jQuery('#cus_name').val("");
            jQuery('#cus_phone').val("");
            jQuery('#cus_fax').val("");
            jQuery('#cus_mail').val("");
            jQuery('#cus_address').val("");
            jQuery.UbizOIWidget.page = '0';
            jQuery.UbizOIWidget.w_search();
        },
        w_fuzzy_search: function () {
            var params = {};
            params.page = '0';
            jQuery.UbizOIWidget.page = '0';

            var fuzzy_val = jQuery('#fuzzy').val();
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            var sort = sort_info.sort_name + "_" + sort_info.order_by;

            params.search = fuzzy_val;
            params.sort = sort;

            ubizapis('v1', '/customers', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_fuzzy_search_handle_enter(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                jQuery.UbizOIWidget.w_fuzzy_search();
            }
        },
        w_go_to_input_page: function (id, ele) {
			var index = jQuery('input[name="pageno"]').val()*10 + (jQuery(ele).index()+1);
	
			if(id != 0){
				var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
				ubizapis('v1','/customer-edit', 'get', null, {'cus_id': id, 'index': index, 'sort': sort_info.sort_name, 'order': sort_info.order_by}, jQuery.UbizOIWidget.w_render_data_to_input_page);
			}else{
				$('#f-input input').val('');
				$('#avt_img').attr('src','../images/avatar.png');
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
			
			$(".save").click(function(){
				jQuery.UbizOIWidget.w_save();
			});
			
			$(".delete").click(function(){
				var id = $('input[name="cus_id"]').val();
				var ids = [];
				ids.push(id);
				jQuery.UbizOIWidget.w_delete(ids);
			});
			
			$("#change_avt").click(function(){
				$("#avatar").click();
			});
			
			$("#avatar").change(function(){
				jQuery.UbizOIWidget.w_preview_avatar(this);
			});
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
        },
        w_refresh_output_page: function () {
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/customers', 'get', null, {'page': jQuery.UbizOIWidget.page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
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
            ubizapis('v1', '/customers', 'get', null, {'page': page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_get_newer_data: function (page) {
            jQuery.UbizOIWidget.page = page;
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            jQuery.UbizOIWidget.sort = sort_info;
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/customers', 'get', null, {'page': page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_delete_callback: function (response) {
            if (response.data.success == true) {
                jQuery.UbizOIWidget.w_render_data_to_ouput_page(response);
				jQuery.UbizOIWidget.w_go_back_to_output_page(this);
                swal(response.data.message, {
                    icon: "success",
                });
            } else {
                swal(response.data.message, {
                    icon: "error",
                });
            }
        },
        w_render_data_to_ouput_page: function (response) {
            var table_html = "";
            var customer = response.data.customers;
            if (customer.length > 0) {
                var rows = [];
                for (let i = 0; i < customer.length; i++) {
                    var cols = [];
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_code, 1));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_name, 3));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_type, 3));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_phone, 3));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_fax, 3));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].cus_mail, 3));
					if(customer[i].address[0] != undefined){
						cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, customer[i].address[0].cad_address, 3));
					}else{
						cols.push(jQuery.UbizOIWidget.w_make_col_html(customer[i].cus_id, '', 3));
					}
                    rows.push(jQuery.UbizOIWidget.w_make_row_html(customer[i].cus_id, cols));
                }
                table_html += rows.join("");
            }
            jQuery.UbizOIWidget.o_page.find("#table-content").empty();
            jQuery.UbizOIWidget.o_page.find("#table-content").append(table_html);
            jQuery.UbizOIWidget.w_reset_f_checkbox_status();
            jQuery.UbizOIWidget.page = response.data.paging.page;
            jQuery.UbizOIWidget.w_paging(response.data.paging.page, response.data.paging.rows_num, response.data.paging.rows_per_page);
        },
		w_render_data_to_input_page: function (response) {
			var customer = response.data.customers[0];
		
			$('input[name="cus_id"]').val(customer.cus_id);
			$('input[name="cus_code"]').val(customer.cus_code);
			$('input[name="cus_name"]').val(customer.cus_name);
			if(customer.avt_src != ''){
				$('#avt_img').attr("src", customer.avt_src);
			}else{
				$('#avt_img').attr('src','../images/avatar.png');
			}
			$('input[name="cus_type"]').val(customer.cus_type);
			$('input[name="cus_phone"]').val(customer.cus_phone);
			$('input[name="cus_fax"]').val(customer.cus_fax);
			$('input[name="cus_mail"]').val(customer.cus_mail);
			$('input[name="user_id"]').val(customer.user_id);
			
			if(customer.address.length > 0){
				$(".cus_address\\[\\]_container").remove();
				for(var i = 0; i < customer.address.length; i++){
					var html = '<div class="textfield  root_textfield rootIsUnderlined cus_address[]_container"><div class="wrapper"><label for="cus_address[]" class="ms-Label root-56">Địa chỉ '+ (i+1) +' :</label><div class="fieldGroup"><input type="text" name="cus_address[]" id="cus_address[]" value="'+ customer.address[i].cad_address +'" class="input_field"></div></div><span class="error_message hidden-content"><div class="message-container"><p class="label_errorMessage css-57 errorMessage"><span class="error-message-text"></span></p></div></span></div>';
					$('.cus-part-2').append(html);
				}
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
			jQuery('input[name="pageno"]').val(page);
        },
		w_get_data_input_form: function () {
			//var data = $('form').getForm2obj();
			var data = new FormData($('#f-input')[0]);
			return data;
		},
		w_save: function () {
			var data = jQuery.UbizOIWidget.w_get_data_input_form();
			var cus_id = jQuery('input[name="cus_id"]').val();
			
			swal({
                title: "Bạn có chắc chắn muốn lưu dữ liệu?",
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
                        if(cus_id != 0){
							ubizapis('v1', '/customer-update', 'post', data, null, jQuery.UbizOIWidget.w_save_callback);
						}else{
							ubizapis('v1', '/customer-create', 'post', data, null, jQuery.UbizOIWidget.w_save_callback);
						}
                        break;
                }
            });
			
			// jQuery.UbizOIWidget.w_go_back_to_output_page();
		},
		w_save_callback: function (response) {
			if (response.data.success == true) {
                jQuery.UbizOIWidget.w_render_data_to_ouput_page(response);
				jQuery.UbizOIWidget.w_go_back_to_output_page(this);
                swal(response.data.message, {
                    icon: "success",
                });
            } else {
                swal(response.data.message, {
                    icon: "error",
                });
            }
		},
		w_preview_avatar: function (input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#avt_img').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}
    });
})(jQuery);
jQuery(document).ready(function () {
    jQuery.UbizOIWidget.w_init();
});

(function($){
    $.fn.getForm2obj = function(){
        var _ = {},_t=this;
        this.c = function(k,v){ eval("c = typeof "+k+";"); if(c == 'undefined') _t.b(k,v);}
        this.b = function(k,v,a = 0){ if(a) eval(k+".push("+v+");"); else eval(k+"="+v+";"); };
        $.map(this.serializeArray(),function(n){
            if(n.name.indexOf('[') > -1 ){
                var keys = n.name.match(/[a-zA-Z0-9_]+|(?=\[\])/g),le = Object.keys(keys).length,tmp = '_';
                $.map(keys,function(key,i){
                    if(key == ''){
                        eval("ale = Object.keys("+tmp+").length;");
                        if(!ale) _t.b(tmp,'[]');
                        if(le == (i+1)) _t.b(tmp,"'"+n['value']+"'",1);
                        else _t.b(tmp += "["+ale+"]",'{}');
                    }else{
                        _t.c(tmp += "['"+key+"']",'{}');
                        if(le == (i+1)) _t.b(tmp,"'"+n['value']+"'");
                    }
                });
            }else _t.b("_['"+n['name']+"']","'"+n['value']+"'");
        });
        return _;
    }
})(jQuery);