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

            ubizapis('v1', '/pricing', 'get', null, {'page': jQuery.UbizOIWidget.page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
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
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Không',
				confirmButtonText: 'Có',
				reverseButtons: true
			}).then((result) => {
				if (result.value) {
					ubizapis('v1', '/pricing/' + ids.join(',') + '/delete', 'delete', null, null, jQuery.UbizOIWidget.w_delete_callback);
                }
			});
        },
        w_create:function(){
            jQuery.UbizOIWidget.w_go_to_input_page(0);
        },
        w_search:function(){
            var params = {};
            params.page = '0';

            if (jQuery('#pri_code').val().replace(/\s/g, '') != '') {
                params.pri_code = jQuery('#pri_code').val();
            }
			
			
            if (jQuery('#pri_date').val().replace(/\s/g, '') != '') {
                params.pri_date = jQuery('#pri_date').val();
            }

            if (jQuery('#exp_date').val().replace(/\s/g, '') != '') {
                params.exp_date = jQuery('#exp_date').val();
            }

            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            params.sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/pricing', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
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

            ubizapis('v1', '/pricing', 'get', null, params, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_fuzzy_search_handle_enter(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                jQuery.UbizOIWidget.w_fuzzy_search();
            }
        },
        w_go_to_input_page: function (id, ele) {
			if(id != 0){
				var index = jQuery('input[name="pageno"]').val()*10 + jQuery(ele).index();
				var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
				ubizapis('v1','/pricing-edit', 'get', null, {'pri_id': id}, jQuery.UbizOIWidget.w_render_data_to_input_page);
				jQuery('.curindex').text(index+1);
				jQuery('.prev').attr('onclick', 'jQuery.UbizOIWidget.w_go_to_input_page_paging('+ (index-1) +')');
				jQuery('.next').attr('onclick', 'jQuery.UbizOIWidget.w_go_to_input_page_paging('+ (index+1) +')');
				if(index == 0){
					jQuery('.prev').removeAttr('onclick');
					jQuery('.prev').addClass('adS');
				}else{
					jQuery('.prev').removeClass('adS');
				}
				
				if( (index+1) == parseInt($('.totalindex').text()) ){
					jQuery('.next').removeAttr('onclick');
					jQuery('.next').addClass('adS');
				}else{
					jQuery('.next').removeClass('adS');
				}
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
				var id = $('input[name="pri_id"]').val();
				var ids = [];
				ids.push(id);
				jQuery.UbizOIWidget.w_delete(ids);
			});
        },
		w_go_to_input_page_paging: function (index) {
			var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
			ubizapis('v1','/pricing-edit', 'get', null, {'pri_id': 0, 'index': index, 'sort': sort_info.sort_name, 'order': sort_info.order_by}, jQuery.UbizOIWidget.w_render_data_to_input_page);
			jQuery('.curindex').text(index+1);
			jQuery('.prev').attr('onclick', 'jQuery.UbizOIWidget.w_go_to_input_page_paging('+ (index-1) +')');
			jQuery('.next').attr('onclick', 'jQuery.UbizOIWidget.w_go_to_input_page_paging('+ (index+1) +')');
			if(index == 0){
				jQuery('.prev').removeAttr('onclick');
				jQuery('.prev').addClass('adS');
			}else{
				jQuery('.prev').removeClass('adS');
			}
			
			if( (index+1) == parseInt($('.totalindex').text()) ){
				jQuery('.next').removeAttr('onclick');
				jQuery('.next').addClass('adS');
			}else{
				jQuery('.next').removeClass('adS');
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
        },
        w_refresh_output_page: function () {
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/pricing', 'get', null, {'page': jQuery.UbizOIWidget.page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
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
            ubizapis('v1', '/pricing', 'get', null, {'page': page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
        },
        w_get_newer_data: function (page) {
            jQuery.UbizOIWidget.page = page;
            var sort_info = jQuery.UbizOIWidget.w_get_sort_info();
            jQuery.UbizOIWidget.sort = sort_info;
            var sort = sort_info.sort_name + "_" + sort_info.order_by;
            ubizapis('v1', '/pricing', 'get', null, {'page': page, 'sort': sort}, jQuery.UbizOIWidget.w_render_data_to_ouput_page);
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
            var pricing = response.data.pricings;
            if (pricing.length > 0) {
                var rows = [];
                for (let i = 0; i < pricing.length; i++) {
                    var cols = [];
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(pricing[i].pri_id, pricing[i].pri_code, 1));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(pricing[i].pri_id, pricing[i].pri_date, 3));
                    cols.push(jQuery.UbizOIWidget.w_make_col_html(pricing[i].pri_id, pricing[i].exp_date, 3));
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
			var pricing = response.data.pricings[0];
			$('.totalindex').text(response.data.totalPricing);
		
			$('input[name="cus_id"]').val(pricing.cus_id);
			$('input[name="cus_code"]').val(pricing.cus_code);
			$('input[name="cus_name"]').val(pricing.cus_name);
			$('input[name="cus_type"]').val(pricing.cus_type);
			$('input[name="cus_phone"]').val(pricing.cus_phone);
			$('input[name="cus_fax"]').val(pricing.cus_fax);
			$('input[name="cus_mail"]').val(pricing.cus_mail);
			if(pricing.avt_src != ''){
				$('#avt_img').attr("src", pricing.avt_src);
			}else{
				$('#avt_img').attr('src','../images/avatar.png');
			}
			$('input[name="cus_phone"]').val(pricing.cus_phone);
			$('input[name="cus_fax"]').val(pricing.cus_fax);
			$('input[name="cus_mail"]').val(pricing.cus_mail);
			
//			console.log(pricing.product)
			
			if(pricing.product.length > 0){
//				$(".pri_product\\[\\]_container").remove();
				$(".index_no").parent().remove();
				$(".index_f_no").parent().remove();
				
				var p_no = 0;
				var f_no = 0;
				for(var i = 0; i < pricing.product.length; i++){
					//to-do append html
					if(pricing.product[i].type == '1'){
						p_no++;
						$('#p_tab').append('<tr><td class="index_no">' + p_no + '</td><td><textarea size="5" name="specs" class="inp-specs" value="' + pricing.product[i].detail + '"></textarea></td><td><input type="text" name="unit" class="inp70" value="' + pricing.product[i].unit + '"/></td><td><input type="text" name="amount" class="inp70" value="' + pricing.product[i].amount + '"/></td><td><input type="text" name="delivery_date" class="inp100" value="' + pricing.product[i].delivery_date + '"/></td><td> <select name="status" class="inp100"><option selected>Sẵn có</option><option>Order</option> </select></td><td><input type="text" name="price" class="inp100" value="' + pricing.product[i].price + '"/></td><td><input type="text" name="total" class="inp130" value="' + (pricing.product[i].price * pricing.product[i].amount) + '"/></td><td><a href="#" class="delete_p_row"><i class="far fa-trash-alt" style="color:red"></i></a></td></tr>');
					}else{
						f_no++;
						$('#f_tab').append('<tr><td class="index_f_no">' + f_no + '</td><td><input type="text" name="as_id" class="inp70" value="' + pricing.product[i].code + '"/></td><td><input type="text" name="as_name" class="inp130" value="' + pricing.product[i].name + '"/></td><td><input type="text" name="as_unit" class="inp70" value="' + pricing.product[i].unit + '"/></td><td><input type="text" name="as_amount" class="inp70" value="' + pricing.product[i].amount + '"/></td><td><input type="text" name="as_delivery_date" class="inp100" value="' + pricing.product[i].delivery_date + '"/></td><td> <select name="status" class="inp100"><option selected>Sẵn có</option><option>Order</option> </select></td><td><input type="text" name="price" class="inp100" value="' + pricing.product[i].price + '"/></td><td><input type="text" name="total" class="inp110" value="' + (pricing.product[i].price * pricing.product[i].amount) + '"/></td><td><a href="#" class="delete_f_row"><i class="far fa-trash-alt" style="color:red"></i></a></td></tr>');					}
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
            var paging_older = '<div id="paging-older" ' + get_older_data_func + ' class="amD utooltip" title="Cũ hơn"><span class="amF">&nbsp;</span><img class="amI ' + older_css + '" src="./images/cleardot.gif" alt=""></div>';
            var paging_newer = '<div id="paging-newer" ' + get_newer_data_func + ' class="amD utooltip" title="Mới hơn"><span class="amF">&nbsp;</span><img class="amJ ' + newer_css + '" src="./images/cleardot.gif" alt=""></div>';

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
			var cus_id = jQuery('input[name="pri_id"]').val();
			
			
			
			swal({
				title: "Bạn có chắc chắn muốn lưu dữ liệu?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Không',
				confirmButtonText: 'Có',
				reverseButtons: true
			}).then((result) => {
				if (result.value) {
					if(cus_id != 0){
						ubizapis('v1', '/pricing-update', 'post', data, null, jQuery.UbizOIWidget.w_save_callback);
					}else{
						ubizapis('v1', '/pricing-create', 'post', data, null, jQuery.UbizOIWidget.w_save_callback);
					}
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
		},
		w_add_p_row: function () {
			$("#p_tab").append('<tr><td class="index_no">1</td><td><textarea size="5" name="specs" class="inp-specs"></textarea></td><td><input type="text" name="unit" class="inp70"/></td><td><input type="text" name="amount" class="inp70"/></td><td><input type="text" name="delivery_date" class="inp100"/></td><td> <select name="status" class="inp100"><option selected>Sẵn có</option><option>Order</option> </select></td><td><input type="text" name="price" class="inp100"/></td><td><input type="text" name="total" class="inp130"/></td><td><a href="#" class="delete_p_row"><i class="far fa-trash-alt" style="color:red"></i></a></td></tr>');
			$(".index_no").each(function(index) {
				$(this).text(index+1);
			});
			
			$(".delete_p_row").click(function(){
				$(this).parent().parent().remove();
				$(".index_no").each(function(index) {
					$(this).text(index+1);
				});
			});
		},
		w_add_f_row: function () {
			$("#f_tab").append('<tr><td class="index_f_no">1</td><td><input type="text" name="as_id" class="inp70"/></td><td><input type="text" name="as_name" class="inp130"/></td><td><input type="text" name="as_unit" class="inp70"/></td><td><input type="text" name="as_amount" class="inp70"/></td><td><input type="text" name="as_delivery_date" class="inp100"/></td><td> <select name="status" class="inp100"><option selected>Sẵn có</option><option>Order</option> </select></td><td><input type="text" name="price" class="inp100"/></td><td><input type="text" name="total" class="inp110"/></td><td><a href="#" class="delete_f_row"><i class="far fa-trash-alt" style="color:red"></i></a></td></tr>');
			$(".index_f_no").each(function(index) {
				$(this).text(index+1);
			});
			
			$(".delete_f_row").click(function(){
				$(this).parent().parent().remove();
				$(".index_f_no").each(function(index) {
					$(this).text(index+1);
				});
			});
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

$(".delete_p_row").click(function(){
	$(this).parent().parent().remove();
	$(".index_no").each(function(index) {
		$(this).text(index+1);
	});
});

$(".delete_f_row").click(function(){
	$(this).parent().parent().remove();
	$(".index_f_no").each(function(index) {
		$(this).text(index+1);
	});
});