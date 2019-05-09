@extends('layouts.main')
@section('title',__("Order"))
@section('headbar-title', __("Order"))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/order_input.css') }}">
@endsection
@section('headbar')
    @include('layouts/headbar')
@endsection
@section('content')
    <div class="main-content order-input">
        <div class="l-content">
            <div id="nicescroll-sidebar" class="zX nicescroll">
                <nav role="navigation">
                    <div class="kL"></div>
                    <div class="sP">
                        <div class="aW aT" id="li">
                            <div class="mR">
                                <div class="eT">
                                    <div class="Vf"></div>
                                    <div class="Vg">
                                        <svg x="0px" y="0px" width="20px" height="20px"
                                             viewBox="0 0 20 20" focusable="false">
                                            <polygon points="5,8 10,13 15,8"></polygon>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="iU">
                                <div class="wQ">
                                    <div class="tA">
                                        <div class="vD">
                                            <div class="xT">
                                                <div class="oQ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24">
                                                        <path d="M4 14h4v-4H4v4zm0 5h4v-4H4v4zM4 9h4V5H4v4zm5 5h12v-4H9v4zm0 5h12v-4H9v4zM9 5v4h12V5H9z"/>
                                                        <path d="M0 0h24v24H0z" fill="none"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="xV">
                                                <div class="oQ">
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24">
                                                        <path fill="none" d="M0 0h24v24H0V0zm0 0h24v24H0z"></path>
                                                        <path d="M3 20.01c0 1.1.89 1.99 2 1.99h14c1.1 0 2-.9 2-1.99V18H3v2.01zM18 19c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm1-17H5c-1.1 0-2 .9-2 1.99V17h18V3.99C21 2.89 20.11 2 19 2zm-8.62 3h3.24l3.25 5.68h-3.24L10.38 5zm-3.52 6.16l3.11-5.44s1.62 2.85 1.62 2.84L8.49 14l-1.63-2.84zM15.51 14H9.3l1.62-2.84h6.21L15.51 14z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="dG">{{ __("List") }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="m-content"></div>
        <div class="r-content">
            <div class="jAQ" id="i-put">
                <div class="bkK">
                    <div class="rwq">
                        <div class="row z-mgr z-mgl">
                            <div class="col-3 text-left pdt-7">
                                <div class="GNi" onclick="jQuery.UbizOIWidget.w_go_back_to_output_page()">
                                    <div class="ax7 poK utooltip" title="{{ __("Back to the list page") }}">
                                        <div class="asA">
                                            <div class="arB"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="GNi" onclick="jQuery.UbizOIWidget.w_save()">
                                    <div class="ax7 poK utooltip" title="{{ __("Save") }}">
                                        <div class="asA">
                                            <div class="arS"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="GNi" onclick="jQuery.UbizOIWidget.w_refresh()">
                                    <div class="ax7 poK utooltip" title="{{ __("Refresh") }}">
                                        <div class="asA">
                                            <div class="arR"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="btn-delete" class="GNi" onclick="jQuery.UbizOIWidget.w_i_delete()">
                                    <div class="ax7 poK utooltip" title="{{ __("Delete") }}">
                                        <div class="asA">
                                            <div class="asX"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7 text-left pdt-5">
                                <ul class="nav nav-wizard">
                                    <li class="done"><a href="#">Báo giá</a></li>
                                    <li class="active"><a href="#">Đơn hàng</a></li>
                                    <li class="undone"><a href="#">Đặt hàng</a></li>
                                    <li class="undone"><a href="#">Hợp đồng</a></li>
                                    <li class="undone"><a href="#">Giao hàng</a></li>
                                </ul>
                            </div>
                            <div class="col-2 text-right">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="jAQ">
                    <div class="aqI" id="nicescroll-iput">
                        <div class="row z-pdl z-pdr z-mgr z-mgl">
                            <div class="col-md-auto">
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'ord_no', 'value'=> $order->ord_no, 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Order No')])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'ord_date', 'value'=> date('Y/m/d', strtotime($order->ord_date)), 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Order Date'), 'class'=>'datepicker'])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'sale_name', 'value'=> $order->sale_name, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Sale person')])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'sale_rank', 'value'=> $order->sale_rank, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Duty')])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'sale_phone', 'value'=> $order->sale_phone, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Mobile')])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'sale_email', 'value'=> $order->sale_email, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Email')])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-auto">
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'cus_name', 'value'=> $order->cus_name, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Customer')])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'cus_type', 'value'=> $order->cus_type, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Type')])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'cus_addr', 'value'=> '', 'type'=>'disabled', 'width'=> '630', 'lbl_width'=>'90', 'label'=>__('Address')])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'contact_name', 'value'=> '', 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Contact person')])
                                            </div>
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'contact_duty', 'value'=> '', 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Duty')])
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'contact_mobile', 'value'=> '', 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Mobile')])
                                            </div>
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'contact_email', 'value'=> '', 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Email')])
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'cus_fax', 'value'=> $order->cus_fax, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Fax')])
                                            </div>
                                            <div class="col-md-auto">
                                                @include('components.number',['value'=>$order->ord_tax, 'onchange'=>'ord_tax_change(this)', 'control_id'=>'ord_tax', 'width'=> '120', 'lbl_width'=>'70', 'label'=>__('Tax'), 'class'=> 'text-right'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-tabs" id="ord-inp-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="dt-prod-tab" data-toggle="tab" href="#dt-prod" role="tab"
                                   aria-controls="dt-prod" aria-selected="true">{{ __('Pump') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="dt-acce-tab" data-toggle="tab" href="#dt-acce" role="tab"
                                   aria-controls="dt-acce" aria-selected="false">{{ __('Accessories') }}</a>
                            </li>
                            <li class="nav-item add-btn">
                                <i onclick="prod_row_add()" class="material-icons md-33" title="{{ __("Add new") }}">
                                    add_box
                                </i>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-ord-inp-content">
                            <div class="tab-pane fade show active" id="dt-prod" role="tabpanel"
                                 aria-labelledby="dt-prod-tab">
                                @foreach($orderDetail as $idx => $item)
                                    <div class="dt-row" dt_id="{{ $item->ordt_id }}">
                                        <div class="row dt-row-head zero-mgl zero-mgr" onclick="my_collapse(this)">
                                            <div class="col text-left">
                                                <label class="lbl-primary z-mgb">No.{{ $idx + 1 }}</label>
                                            </div>
                                            <div class="col text-right">
                                                <i class="fas fa-caret-down"></i>
                                            </div>
                                        </div>
                                        <div class="row dt-row-body zero-mgl zero-mgr collapse hide">
                                            <div class="col-md-auto">
                                                <label class="lbl-primary">{{ __('Specification') }}:</label>
                                                <textarea name="dt_prod_specs_mce"
                                                          id="dt_prod_specs_mce_1">{{ $item->prod_specs_mce }}</textarea>
                                            </div>
                                            <div class="col-md-auto">
                                                @include('components.input',['value'=>$item->prod_model, 'control_id'=>'dt_prod_model','width'=> '250', 'lbl_width'=>'70', 'label'=>__('Model')])
                                                @include('components.textarea',['value'=>$item->prod_series, 'width'=>'250', 'height'=>'100', 'control_id'=>'dt_prod_series', 'resize'=>'none', 'label'=>__('Series')])
                                                @include('components.textarea',['value'=>$item->memo, 'width'=>'250', 'height'=>'100', 'control_id'=>'dt_memo', 'resize'=>'none', 'label'=>__('Memo')])
                                            </div>
                                            <div class="col-md-auto">
                                                @include('components.input',['value'=>$item->unit, 'control_id'=>'dt_unit', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Unit'), 'class'=> 'text-right'])
                                                @include('components.number',['value'=>number_format($item->quantity), 'onchange'=>'dt_quantity_change(this)', 'control_id'=>'dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Quantity'), 'class'=> 'text-right'])
                                                @include('components.textarea',['value'=>$item->delivery_time, 'control_id'=>'dt_delivery_time', 'width'=>'250', 'height'=>'50', 'resize'=>'none', 'class'=> 'margin-bottom-15', 'label'=>__('Delivery time')])
                                                @include('components.dropdown',['value'=>$item->status, 'control_id'=>'dt_status', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Status') ,'data'=> $statusList])
                                                @include('components.money',['value'=> number_format($item->price), 'onchange'=>'dt_price_change(this)', 'control_id'=>'dt_price', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Price'), 'class'=> 'text-right'])
                                                @include('components.money',['value'=>number_format($item->amount), 'onchange'=>'dt_amount_change(this)', 'control_id'=>'dt_amount', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Amount'), 'class'=> 'text-right'])
                                            </div>
                                            <div class="col-md-auto z-pdr text-center">
                                                <i onclick="prod_row_copy(this)"
                                                   class="material-icons text-primary i-btn" title="{{ __("Copy") }}">
                                                    copyright
                                                </i>
                                                <br>
                                                <i onclick="prod_row_del(this)" class="material-icons text-danger i-btn"
                                                   title="{{ __("Delete") }}">
                                                    delete
                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="dt-acce" role="tabpanel" aria-labelledby="dt-acce-tab"></div>
                        </div>
                        <hr>
                        <div class="total-info margin-bottom-30">
                            <div class="row z-pdl z-pdr z-mgr z-mgl">
                                <div class="col-4 text-left z-pdl z-pdr">
                                    <label style="width: 70px">{{ __('Input Date') }}</label><label>: {{ date("Y/m/d H:i:s", strtotime($order->inp_date)) }}</label>
                                    <br>
                                    <label style="width: 70px">{{ __('Update Date') }}</label><label>: {{ date("Y/m/d H:i:s", strtotime($order->upd_date)) }}</label>
                                </div>
                                <div class="col-8 text-right">
                                    <div class="row justify-content-end z-pdl z-pdr z-mgr z-mgl">
                                        <div class="col-md-auto text-right z-mgr z-mgl pdt-5">
                                            <span>{{ __('Total value of orders (before VAT)') }}</span>
                                        </div>
                                        <div class="col-md-auto z-pdr z-pdl" style="width: 150px">
                                            <input type="text" id="ord_amount" readonly class="w-100 text-right" value="{{ number_format($order->ord_amount) }}">
                                        </div>
                                        <div class="col-md-auto z-mgr z-mgl">
                                            <span>VND</span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end z-pdl z-pdr z-mgr z-mgl">
                                        <div class="col-md-auto text-right z-mgr z-mgl pdt-5">
                                            <span>{{ __('Total value of orders (VAT included)') }}</span>
                                        </div>
                                        <div class="col-md-auto z-pdr z-pdl" style="width: 150px">
                                            <input type="text" id="ord_amount_tax" readonly class="w-100 text-right" value="{{ number_format($order->ord_amount_tax) }}">
                                        </div>
                                        <div class="col-md-auto z-mgr z-mgl">
                                            <span>VND</span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end z-pdl z-pdr z-mgr z-mgl">
                                        <div class="col-md-auto text-right z-mgr z-mgl pdt-5">
                                            <span>{{ __('Paid') }}</span>
                                        </div>
                                        <div class="col-md-auto z-pdr z-pdl" style="width: 150px">
                                            <input type="text" id="ord_paid" readonly class="w-100 text-right" value="{{ number_format($order->ord_paid) }}">
                                        </div>
                                        <div class="col-md-auto z-mgr z-mgl">
                                            <span>VND</span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end z-pdl z-pdr z-mgr z-mgl">
                                        <div class="col-md-auto text-right z-mgr z-mgl pdt-5">
                                            <span>{{ __('Debt') }}</span>
                                        </div>
                                        <div class="col-md-auto z-pdr z-pdl" style="width: 150px">
                                            <input type="text" id="ord_debt" readonly class="w-100 text-right" value="{{ number_format($order->ord_debt) }}">
                                        </div>
                                        <div class="col-md-auto z-mgr z-mgl">
                                            <span>VND</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript">

        var prod_spec_no = 1;
        var acce_spec_no = 1;

        function my_collapse(self) {
            var next_ele = jQuery(self).next('div');
            next_ele.on('hidden.bs.collapse', function () {
                jQuery('#nicescroll-iput').getNiceScroll().resize();
            })
            next_ele.on('shown.bs.collapse', function () {
                jQuery('#nicescroll-iput').getNiceScroll().resize();
            });
            next_ele.collapse('toggle');
        }

        function prod_row_copy(self) {

            prod_spec_no++;
            var dt_prod_specs_mce_id = "dt_prod_specs_mce_" + prod_spec_no;
            var tinymce_selector = "#" + dt_prod_specs_mce_id;

            var copy_row = jQuery(self).closest('div.dt-row');
            var copy_tinymce_selector = copy_row.find('textarea[name=dt_prod_specs_mce]').attr('id');

            var clone_row = copy_row.clone(false)
            clone_row.find('div.tox-tinymce').remove();
            clone_row.find('textarea[name=dt_prod_specs_mce]').attr('id', dt_prod_specs_mce_id);
            clone_row.find('textarea[name=dt_prod_specs_mce]').removeAttr('style');
            clone_row.find('textarea[name=dt_prod_specs_mce]').removeAttr('aria-hidden');
            jQuery(self).closest('div.dt-row').after(clone_row.wrap('<p/>').parent().html());

            tinymce.init({
                width: 350,
                min_height: 246,
                max_height: 246,
                menubar: false,
                toolbar_drawer: 'floating',
                selector: tinymce_selector,
                init_instance_callback: function (inst) {
                    var copy_tinymce_content = tinyMCE.get(copy_tinymce_selector).getContent();
                    tinyMCE.get(dt_prod_specs_mce_id).setContent(copy_tinymce_content);
                    jQuery('#nicescroll-iput').getNiceScroll().resize();

                    prod_row_set_no();
                    var copy_row_data = prod_row_get_data(copy_row);
                    prod_row_set_data(copy_row.next('div.dt-row'), copy_row_data);

                },
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor searchreplace visualblocks code fullscreen insertdatetime media table paste code wordcount autoresize'
                ],
                toolbar: 'undo redo | bold italic forecolor backcolor | formatselect | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
                content_css: [
                    '{{ asset('fonts/roboto/v18/roboto.css') }}'
                ]
            });
        }

        function prod_row_add() {

            prod_spec_no++;
            var dt_prod_specs_mce_id = "dt_prod_specs_mce_" + prod_spec_no;
            var tinymce_selector = "#" + dt_prod_specs_mce_id;

            var copy_row = jQuery("#dt-prod").find('div.dt-row:first');
            var copy_tinymce_selector = copy_row.find('textarea[name=dt_prod_specs_mce]').attr('id');

            var clone_row = copy_row.clone(false)
            clone_row.find('div.tox-tinymce').remove();
            clone_row.find('textarea[name=dt_prod_specs_mce]').attr('id', dt_prod_specs_mce_id);
            clone_row.find('textarea[name=dt_prod_specs_mce]').removeAttr('style');
            clone_row.find('textarea[name=dt_prod_specs_mce]').removeAttr('aria-hidden');
            jQuery("#dt-prod").append(clone_row.wrap('<p/>').parent().html());

            tinymce.init({
                width: 350,
                min_height: 246,
                max_height: 246,
                menubar: false,
                toolbar_drawer: 'floating',
                selector: tinymce_selector,
                init_instance_callback: function (inst) {
                    prod_row_set_no();
                    prod_row_clean(jQuery("#dt-prod").find('div.dt-row:last'));
                    jQuery('#nicescroll-iput').getNiceScroll().resize();
                },
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor searchreplace visualblocks code fullscreen insertdatetime media table paste code wordcount autoresize'
                ],
                toolbar: 'undo redo | bold italic forecolor backcolor | formatselect | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
                content_css: [
                    '{{ asset('fonts/roboto/v18/roboto.css') }}'
                ]
            });
        }

        function prod_row_del(self) {

            var del_row = jQuery(self).closest('div.dt-row');
            var cur_rows_length = jQuery("#dt-prod").find('div.dt-row').not('div.deleted').length;

            if (del_row.attr('dt_id') == '0') {
                if (cur_rows_length == 1) {
                    prod_row_clean(del_row);
                } else {
                    var del_tinymce_selector = del_row.find('textarea[name=dt_prod_specs_mce]').attr('id');
                    tinyMCE.get(del_tinymce_selector).remove();
                    del_row.remove();
                }
            } else {
                del_row.addClass('hidden-content deleted');
            }
        }

        function prod_row_clean(row) {
            row.attr('dt_id', '0');
            var tinymce_selector = row.find('textarea[name=dt_prod_specs_mce]').attr('id');
            tinyMCE.get(tinymce_selector).setContent('');
            row.find("input[name=dt_prod_model]").val('');
            row.find("textarea[name=dt_prod_series]").val('');
            row.find("textarea[name=dt_memo]").val('');
            row.find("input[name=dt_unit]").val('');
            row.find("input[name=dt_quantity]").val('');
            row.find("textarea[name=dt_delivery_time]").val('');
            row.find("select[name=dt_status]").val('');
            row.find("input[name=dt_price]").val('');
            row.find("input[name=dt_amount]").val('');
        }

        function dt_quantity_change(self) {
            alert('changed');
        }

        function dt_price_change(self) {
            alert('changed');
        }

        function dt_amount_change(self) {
            alert('changed');
        }

        function ord_tax_change(self) {
            alert('changed');
        }

        function prod_row_get_data(row) {
            var data = {};
            data.dt_id = row.attr('dt_id');

            var tinymce_selector = row.find('textarea[name=dt_prod_specs_mce]').attr('id');
            data.dt_prod_specs_mce = tinyMCE.get(tinymce_selector).getContent();
            data.dt_prod_specs = tinyMCE.get(tinymce_selector).getContent({'format': 'text'});
            data.dt_prod_model = row.find("input[name=dt_prod_model]").val();
            data.dt_prod_series = row.find("textarea[name=dt_prod_series]").val();
            data.dt_memo = row.find("textarea[name=dt_memo]").val();
            data.dt_unit = row.find("input[name=dt_unit]").val();
            data.dt_quantity = row.find("input[name=dt_quantity]").val();
            data.dt_delivery_time = row.find("textarea[name=dt_delivery_time]").val();
            data.dt_status = row.find("select[name=dt_status]").val();
            data.dt_price = row.find("input[name=dt_price]").val();
            data.dt_amount = row.find("input[name=dt_amount]").val();
            data.dt_type = '1';
            return data;

        }

        function prod_row_set_data(row, data) {
            row.attr('dt_id', data.dt_id);
            var tinymce_selector = row.find('textarea[name=dt_prod_specs_mce]').attr('id');
            tinyMCE.get(tinymce_selector).setContent(data.dt_prod_specs_mce);
            row.find("input[name=dt_prod_model]").val(data.dt_prod_model);
            row.find("textarea[name=dt_prod_series]").val(data.dt_prod_series);
            row.find("textarea[name=dt_memo]").val(data.dt_memo);
            row.find("input[name=dt_unit]").val(data.dt_unit);
            row.find("input[name=dt_quantity]").val(data.dt_quantity);
            row.find("textarea[name=dt_delivery_time]").val(data.dt_delivery_time);
            row.find("select[name=dt_status]").val(data.dt_status);
            row.find("input[name=dt_price]").val(data.dt_price);
            row.find("input[name=dt_amount]").val(data.dt_amount);
        }

        function prod_row_set_no() {
            var cur_rows = jQuery("#dt-prod").find('div.dt-row').not('div.deleted');
            $.each(cur_rows, function (idx, row) {
                var row_no = idx + 1;
                $(row).find("div.dt-row-head").find('label').text('No.' + row_no);
            });
        }

        jQuery(document).ready(function () {

            prod_spec_no = jQuery("#dt-prod").find('div.dt-row').length;
            acce_spec_no = jQuery("#dt-acce").find('div.dt-row').length;

            tinymce.init({
                width: 350,
                min_height: 246,
                max_height: 246,
                menubar: false,
                toolbar_drawer: 'floating',
                selector: 'textarea[name=dt_prod_specs_mce]',
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor searchreplace visualblocks code fullscreen insertdatetime media table paste code wordcount autoresize'
                ],
                toolbar: 'undo redo | bold italic forecolor backcolor | formatselect | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
                content_css: [
                    '{{ asset('fonts/roboto/v18/roboto.css') }}'
                ]
            });
            jQuery('#nicescroll-iput').niceScroll({
                cursorcolor: "#9fa8b0",
                cursorwidth: "5px",
                cursorborder: "none",
                cursorborderradius: 5,
                cursoropacitymin: 0.4,
                scrollbarid: 'nc-oput',
                autohidemode: false,
                horizrailenabled: false
            });

            TinyDatePicker('.datepicker', {mode: 'dp-below'});
        });
    </script>
@endsection