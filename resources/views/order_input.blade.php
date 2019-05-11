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
                <input type="hidden" name="ord_id" value="{{ $order->ord_id }}">
                <div class="bkK">
                    <div class="rwq">
                        <div class="row z-mgr z-mgl">
                            <div class="col-3 text-left pdt-7">
                                <div class="GNi" onclick="ord_back_to_output()">
                                    <div class="ax7 poK utooltip" title="{{ __("Back to the list page") }}">
                                        <div class="asA">
                                            <div class="arB"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="GNi" onclick="ord_save()">
                                    <div class="ax7 poK utooltip" title="{{ __("Save") }}">
                                        <div class="asA">
                                            <div class="arS"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="GNi" onclick="ord_refresh()">
                                    <div class="ax7 poK utooltip" title="{{ __("Refresh") }}">
                                        <div class="asA">
                                            <div class="arR"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="btn-delete" class="GNi" onclick="ord_delete()">
                                    <div class="ax7 poK utooltip" title="{{ __("Delete") }}">
                                        <div class="asA">
                                            <div class="asX"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7 text-left pdt-5">
                                <ul class="nav nav-wizard">
                                    <li class="done"><a href="#">{{ __('Pricing') }}</a></li>
                                    <li class="active"><a href="#">{{ __('Order') }}</a></li>
                                    <li class="undone"><a href="#">{{ __('Import') }}</a></li>
                                    <li class="undone"><a href="#">{{ __('Contract') }}</a></li>
                                    <li class="undone"><a href="#">{{ __('Delivery') }}</a></li>
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
                                        @include('components.input',['control_id'=>'ord_no', 'value'=> $order->ord_no, 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Order No'), 'i_focus'=>'', 'i_blur'=>'', 'onchange'=>"ord_no_change(this)"])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'ord_date', 'value'=> date('Y/m/d', strtotime($order->ord_date)), 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Order Date'), 'class'=>'datepicker', 'i_focus'=>'', 'i_blur'=>'', 'onchange'=>"ord_date_change(this)"])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'sale_name', 'value'=> $order->sale_name, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Sale person'), 'i_focus'=>'', 'i_blur'=>''])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'sale_rank', 'value'=> $order->sale_rank, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Duty'), 'i_focus'=>'', 'i_blur'=>''])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'sale_phone', 'value'=> $order->sale_phone, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Mobile'), 'i_focus'=>'', 'i_blur'=>''])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'sale_email', 'value'=> $order->sale_email, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Email'), 'i_focus'=>'', 'i_blur'=>''])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-auto">
                                <div class="row">
                                    <div class="col-md-auto">
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'cus_name', 'value'=> $order->cus_name, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Customer'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'cus_type', 'value'=> $order->cus_type, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Type'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-auto">
                                        @include('components.textarea',['value'=>$order->ord_note, 'control_id'=>'ord_note', 'width'=>'300', 'height'=>'70', 'resize'=>'none', 'label'=>__('Note'), 'lable_class'=>'hidden-content'])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'cus_addr', 'value'=> $order->cus_addr, 'type'=>'disabled', 'width'=> '630', 'lbl_width'=>'90', 'label'=>__('Address'), 'i_focus'=>'', 'i_blur'=>''])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'contact_name', 'value'=> '', 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Contact person'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'contact_duty', 'value'=> '', 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Duty'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'contact_mobile', 'value'=> '', 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Mobile'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'contact_email', 'value'=> '', 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Email'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'cus_fax', 'value'=> $order->cus_fax, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Fax'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                            <div class="col-md-auto">
                                                @include('components.number',['value'=>$order->ord_tax, 'onchange'=>'ord_tax_change(this)', 'control_id'=>'ord_tax', 'min'=>'0', 'max'=>'100', 'suffix'=>'%', 'length'=>'3', 'width'=> '130', 'lbl_width'=>'70', 'label'=>__('Tax'), 'class'=> 'text-right pdr-5'])
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
                            <button type="button" onclick="dt_row_add()" class="btn btn-info add-btn"
                                    title="{{ __("Add new") }}">
                                <i class="fas fa-plus"></i>
                            </button>
                        </ul>
                        <div class="tab-content" id="tab-ord-inp-content">
                            <div class="tab-pane fade show active" id="dt-prod" role="tabpanel"
                                 aria-labelledby="dt-prod-tab">
                                @php $idx = 0; @endphp
                                @foreach($orderDetail as $item)
                                    @if($item->type == '1')
                                        <div class="dt-row" dt_id="{{ $item->ordt_id }}">
                                            <div class="row dt-row-head zero-mgl zero-mgr" onclick="my_collapse(this)">
                                                <div class="col text-left">
                                                    <label class="lbl-primary z-mgb">No.{{ ++$idx }}</label>
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
                                                    @include('components.input',['value'=>$item->prod_model, 'control_id'=>'dt_prod_model','width'=> '250', 'lbl_width'=>'70', 'label'=>__('Model'), 'i_focus'=>'', 'i_blur'=>''])
                                                    @include('components.textarea',['value'=>$item->prod_series, 'width'=>'250', 'height'=>'100', 'control_id'=>'dt_prod_series', 'resize'=>'none', 'label'=>__('Series')])
                                                    @include('components.textarea',['value'=>$item->note, 'width'=>'250', 'height'=>'100', 'control_id'=>'dt_note', 'resize'=>'none', 'label'=>__('Note')])
                                                </div>
                                                <div class="col-md-auto">
                                                    @include('components.input',['value'=>$item->unit, 'control_id'=>'dt_unit', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Unit'), 'class'=> 'text-right', 'i_focus'=>'', 'i_blur'=>''])
                                                    @include('components.number',['value'=>number_format($item->quantity), 'onchange'=>'dt_quantity_change(this)', 'control_id'=>'dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Quantity'), 'class'=> 'text-right'])
                                                    @include('components.textarea',['value'=>$item->delivery_time, 'control_id'=>'dt_delivery_time', 'width'=>'250', 'height'=>'50', 'resize'=>'none', 'class'=> 'margin-bottom-15', 'label'=>__('Delivery time')])
                                                    @include('components.dropdown',['value'=>$item->status, 'control_id'=>'dt_status', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Status') ,'data'=> $statusList])
                                                    @include('components.money',['value'=> number_format($item->price), 'onchange'=>'dt_price_change(this)', 'control_id'=>'dt_price', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Price'), 'class'=> 'text-right'])
                                                    @include('components.money',['value'=>number_format($item->amount), 'onchange'=>'dt_amount_change(this)', 'control_id'=>'dt_amount', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Amount'), 'class'=> 'text-right'])
                                                </div>
                                                <div class="col-md-auto z-pdr text-center">
                                                    <i onclick="prod_row_copy(this)"
                                                       class="material-icons text-primary i-btn"
                                                       title="{{ __("Copy") }}">
                                                        copyright
                                                    </i>
                                                    <br>
                                                    <i onclick="prod_row_del(this)"
                                                       class="material-icons text-danger i-btn"
                                                       title="{{ __("Delete") }}">
                                                        delete
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="dt-acce" role="tabpanel" aria-labelledby="dt-acce-tab">
                                @php $idx = 0; @endphp
                                @foreach($orderDetail as $item)
                                    @if($item->type == '2')
                                        <div class="dt-row" dt_id="{{ $item->ordt_id }}">
                                            <div class="row dt-row-head zero-mgl zero-mgr" onclick="my_collapse(this)">
                                                <div class="col text-left">
                                                    <label class="lbl-primary z-mgb">No.{{ ++$idx }}</label>
                                                </div>
                                                <div class="col text-right">
                                                    <i class="fas fa-caret-down"></i>
                                                </div>
                                            </div>
                                            <div class="row dt-row-body zero-mgl zero-mgr collapse hide">
                                                <div class="col-md-auto">
                                                    @include('components.input',['value'=>$item->acce_code, 'control_id'=>'dt_acce_code','width'=> '250', 'lbl_width'=>'70', 'label'=>__('Code'), 'i_focus'=>'', 'i_blur'=>''])
                                                    @include('components.input',['value'=>$item->acce_name, 'control_id'=>'dt_acce_name','width'=> '250', 'lbl_width'=>'70', 'label'=>__('Name'), 'i_focus'=>'', 'i_blur'=>''])
                                                    @include('components.textarea',['value'=>$item->note, 'control_id'=>'dt_note', 'width'=>'300', 'height'=>'73', 'resize'=>'none', 'label'=>__('Note'), 'lable_class'=>'hidden-content'])
                                                </div>
                                                <div class="col-md-auto">
                                                    @include('components.input',['value'=>$item->unit, 'control_id'=>'dt_unit', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Unit'), 'class'=> 'text-right', 'i_focus'=>'', 'i_blur'=>''])
                                                    @include('components.number',['value'=>number_format($item->quantity), 'onchange'=>'dt_quantity_change(this)', 'control_id'=>'dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Quantity'), 'class'=> 'text-right'])
                                                    @include('components.textarea',['value'=>$item->delivery_time, 'control_id'=>'dt_delivery_time', 'width'=>'250', 'height'=>'50', 'resize'=>'none', 'class'=> 'margin-bottom-15', 'label'=>__('Delivery time')])
                                                </div>
                                                <div class="col-md-auto">
                                                    @include('components.dropdown',['value'=>$item->status, 'control_id'=>'dt_status', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Status') ,'data'=> $statusList])
                                                    @include('components.money',['value'=> number_format($item->price), 'onchange'=>'dt_price_change(this)', 'control_id'=>'dt_price', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Price'), 'class'=> 'text-right'])
                                                    @include('components.money',['value'=>number_format($item->amount), 'onchange'=>'dt_amount_change(this)', 'control_id'=>'dt_amount', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Amount'), 'class'=> 'text-right'])
                                                </div>
                                                <div class="col-md-auto z-pdr text-center">
                                                    <i onclick="acce_row_copy(this)"
                                                       class="material-icons text-primary i-btn"
                                                       title="{{ __("Copy") }}">
                                                        copyright
                                                    </i>
                                                    <br>
                                                    <i onclick="acce_row_del(this)"
                                                       class="material-icons text-danger i-btn"
                                                       title="{{ __("Delete") }}">
                                                        delete
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
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
                                            <input type="text" name="ord_amount" readonly class="w-100 text-right"
                                                   value="{{ number_format($order->ord_amount) }}">
                                            <input type="hidden" value="{{ number_format($order->ord_amount) }}"
                                                   name="ord_amount_old">
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
                                            <input type="text" name="ord_amount_tax" readonly class="w-100 text-right"
                                                   value="{{ number_format($order->ord_amount_tax) }}">
                                            <input type="hidden" value="{{ number_format($order->ord_amount_tax) }}" name="ord_amount_tax_old">
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
                                            <input onchange="ord_paid_change(this)" onfocus="num_focus(this)" onblur="num_blur(this)" onkeydown="num_keydown(event)" spellcheck="false" type="text" maxlength="19" name="ord_paid" value="{{ number_format($order->ord_paid) }}" class="w-100 text-right">
                                            <input type="hidden" value="{{ number_format($order->ord_paid) }}" name="ord_paid_old">
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
                                            <input type="text" name="ord_debt" readonly class="w-100 text-right" value="{{ number_format($order->ord_debt) }}">
                                            <input type="hidden" value="{{ number_format($order->ord_debt) }}" name="ord_debt_old">
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
        var max_integer = 2147483647;
        var max_double = 9223372036854775807;

        function my_collapse(self) {
            var next_ele = $(self).next('div');
            next_ele.on('hidden.bs.collapse', function () {
                nicescroll_resize("#nicescroll-iput");
            })
            next_ele.on('shown.bs.collapse', function () {
                nicescroll_resize("#nicescroll-iput");
            });
            next_ele.collapse('toggle');
        }

        function prod_row_copy(self) {

            prod_spec_no++;
            var dt_prod_specs_mce_id = "dt_prod_specs_mce_" + prod_spec_no;
            var tinymce_selector = "#" + dt_prod_specs_mce_id;

            var copy_row = $(self).closest('div.dt-row');

            var copy_dt_amount = numeral(copy_row.find('input[name=dt_amount]').val()).value();
            var dt_amount_total = dt_get_amount_total();
            dt_amount_total = dt_amount_total + copy_dt_amount;
            if (max_validator(dt_amount_total, max_double, 'double') == false) {

                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }
            var ord_tax = numeral($("input[name=ord_tax]").val()).value();
            var dt_amount_tax_total = dt_amount_total + (dt_amount_total * ord_tax / 100);
            if (max_validator(dt_amount_tax_total, max_double, 'double') == false) {

                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            var copy_tinymce_selector = copy_row.find('textarea[name=dt_prod_specs_mce]').attr('id');
            var clone_row = copy_row.clone(false)


            clone_row.find('div.tox-tinymce').remove();
            clone_row.find('textarea[name=dt_prod_specs_mce]').attr('id', dt_prod_specs_mce_id);
            clone_row.find('textarea[name=dt_prod_specs_mce]').removeAttr('style');
            clone_row.find('textarea[name=dt_prod_specs_mce]').removeAttr('aria-hidden');
            $(self).closest('div.dt-row').after(clone_row.wrap('<p/>').parent().html());

            var add_row = copy_row.next('div.dt-row');
            var copy_row_data = prod_row_get_data(copy_row);

            prod_row_set_data(add_row, copy_row_data);
            add_row.find('div.dt-row-body').removeClass('hide');
            add_row.find('div.dt-row-body').addClass('show');
            add_row.find("div.dt-row-head").find('label').text('');
            add_row.attr('dt_id', '0');

            tinymce.init({
                width: 350,
                min_height: 246,
                max_height: 246,
                menubar: false,
                toolbar_drawer: 'floating',
                selector: tinymce_selector,
                init_instance_callback: function (inst) {
                    prod_row_set_no();
                    var copy_tinymce_content = tinyMCE.get(copy_tinymce_selector).getContent();
                    tinyMCE.get(dt_prod_specs_mce_id).setContent(copy_tinymce_content);
                    add_row.find('input[name=dt_prod_model]').focus();
                    ord_set_total(dt_amount_total, dt_amount_tax_total);
                    nicescroll_resize("#nicescroll-iput");
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

            var copy_row = $("#dt-prod").find('div.dt-row:first');
            var copy_tinymce_selector = copy_row.find('textarea[name=dt_prod_specs_mce]').attr('id');

            var clone_row = copy_row.clone(false)
            clone_row.find('div.tox-tinymce').remove();
            clone_row.find('textarea[name=dt_prod_specs_mce]').attr('id', dt_prod_specs_mce_id);
            clone_row.find('textarea[name=dt_prod_specs_mce]').text('');
            clone_row.find('textarea[name=dt_prod_specs_mce]').removeAttr('style');
            clone_row.find('textarea[name=dt_prod_specs_mce]').removeAttr('aria-hidden');

            $("#dt-prod").append(clone_row.wrap('<p/>').parent().html());
            var add_row = $("#dt-prod").find('div.dt-row:last');
            prod_row_clean(add_row);
            add_row.find('div.dt-row-body').removeClass('hide');
            add_row.find('div.dt-row-body').addClass('show');
            add_row.find("div.dt-row-head").find('label').text('');
            add_row.removeClass('hidden-content deleted');

            tinymce.init({
                width: 350,
                min_height: 246,
                max_height: 246,
                menubar: false,
                toolbar_drawer: 'floating',
                selector: tinymce_selector,
                init_instance_callback: function (inst) {

                    add_row.find('input[name=dt_prod_model]').focus();

                    prod_row_set_no();
                    nicescroll_resize("#nicescroll-iput");
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

            var del_row = $(self).closest('div.dt-row');
            var visible_rows_length = $("#dt-prod").find('div.dt-row').not('div.deleted').length;

            if (del_row.attr('dt_id') == '0') {
                if (visible_rows_length == 1) {
                    prod_row_clean(del_row);
                } else {
                    var del_tinymce_selector = del_row.find('textarea[name=dt_prod_specs_mce]').attr('id');
                    tinyMCE.get(del_tinymce_selector).remove();
                    del_row.remove();
                }
            } else {
                del_row.addClass('hidden-content deleted');
                if (visible_rows_length == 1) {
                    prod_row_add();
                }
            }

            var dt_amount_total = dt_get_amount_total();
            var ord_tax = numeral($("input[name=ord_tax]").val()).value();
            var dt_amount_tax_total = dt_amount_total + (dt_amount_total * ord_tax / 100);
            ord_set_total(dt_amount_total, dt_amount_tax_total);

            prod_row_set_no();
            nicescroll_resize("#nicescroll-iput");
        }

        function prod_row_clean(row) {
            row.attr('dt_id', '0');
            var tinymce_selector = row.find('textarea[name=dt_prod_specs_mce]').attr('id');
            if (tinyMCE.get(tinymce_selector) != null) {
                tinyMCE.get(tinymce_selector).setContent('');
            }
            row.find('textarea[name=dt_prod_specs_mce]').val("")
            row.find("input[name=dt_prod_model]").val('');
            row.find("textarea[name=dt_prod_series]").val('');
            row.find("textarea[name=dt_note]").val('');
            row.find("input[name=dt_unit]").val('');
            row.find("input[name=dt_quantity]").val('');
            row.find("textarea[name=dt_delivery_time]").val('');
            row.find("select[name=dt_status]").val('');
            row.find("input[name=dt_price]").val('');
            row.find("input[name=dt_amount]").val('');
        }

        function prod_row_get_data(row) {

            var data = {};
            var tinymce_selector = row.find('textarea[name=dt_prod_specs_mce]').attr('id');

            data.dt_id = row.attr('dt_id');
            data.dt_prod_specs_mce = tinyMCE.get(tinymce_selector).getContent();
            data.dt_prod_specs = tinyMCE.get(tinymce_selector).getContent({'format': 'text'});
            data.dt_prod_model = row.find("input[name=dt_prod_model]").val();
            data.dt_prod_series = row.find("textarea[name=dt_prod_series]").val();
            data.dt_note = row.find("textarea[name=dt_note]").val();
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
            if (tinyMCE.get(tinymce_selector) != null) {
                tinyMCE.get(tinymce_selector).setContent(data.dt_prod_specs_mce);
            }
            row.find("input[name=dt_prod_model]").val(data.dt_prod_model);
            row.find("textarea[name=dt_prod_specs_mce]").val(data.dt_prod_specs_mce);
            row.find("textarea[name=dt_prod_series]").val(data.dt_prod_series);
            row.find("textarea[name=dt_note]").val(data.dt_note);
            row.find("input[name=dt_unit]").val(data.dt_unit);
            row.find("input[name=dt_quantity]").val(data.dt_quantity);
            row.find("textarea[name=dt_delivery_time]").val(data.dt_delivery_time);
            row.find("select[name=dt_status]").val(data.dt_status);
            row.find("input[name=dt_price]").val(data.dt_price);
            row.find("input[name=dt_amount]").val(data.dt_amount);
        }

        function prod_row_set_no() {
            var cur_rows = $("#dt-prod").find('div.dt-row').not('div.deleted');
            $.each(cur_rows, function (idx, row) {
                var row_no = idx + 1;
                $(row).find("div.dt-row-head").find('label').text('No.' + row_no);
            });
        }

        function prod_row_validate_data(data) {

            if (numeral(data.dt_id).value() > 0)
                return true;

            if (data.dt_prod_specs_mce == ""
                && data.dt_prod_specs == ""
                && data.dt_prod_model == ""
                && data.dt_prod_series == ""
                && data.dt_note == ""
                && data.dt_unit == ""
                && data.dt_quantity == ""
                && data.dt_delivery_time == ""
                && (data.dt_status == "1" || data.dt_status == "")
                && data.dt_price == ""
                && data.dt_amount == ""
            ) return false;
            return true;
        }

        function acce_row_copy(self) {

            var copy_row = $(self).closest('div.dt-row');
            var copy_dt_amount = numeral(copy_row.find('input[name=dt_amount]').val()).value();
            var dt_amount_total = dt_get_amount_total();
            dt_amount_total = dt_amount_total + copy_dt_amount;
            if (max_validator(dt_amount_total, max_double, 'double') == false) {

                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }
            var ord_tax = numeral($("input[name=ord_tax]").val()).value();
            var dt_amount_tax_total = dt_amount_total + (dt_amount_total * ord_tax / 100);
            if (max_validator(dt_amount_tax_total, max_double, 'double') == false) {

                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            var clone_row = copy_row.clone(false)

            clone_row.find('div.dt-row-body').removeClass('hide');
            clone_row.find('div.dt-row-body').addClass('show');
            clone_row.find("div.dt-row-head").find('label').text('');
            $(self).closest('div.dt-row').after(clone_row.wrap('<p/>').parent().html());

            var copy_row_data = acce_row_get_data(copy_row);
            acce_row_set_data(copy_row.next('div.dt-row'), copy_row_data);

            acce_row_set_no();
            nicescroll_resize("#nicescroll-iput");
            copy_row.next('div.dt-row').find('input[name=dt_acce_code]').focus();
            copy_row.next('div.dt-row').attr('dt_id', '0');
        }

        function acce_row_add() {

            var copy_row = $("#dt-acce").find('div.dt-row:first');
            var clone_row = copy_row.clone(false)

            clone_row.find('div.dt-row-body').removeClass('hide');
            clone_row.find('div.dt-row-body').addClass('show');
            clone_row.find("div.dt-row-head").find('label').text('');
            clone_row.removeClass('hidden-content deleted')

            $("#dt-acce").append(clone_row.wrap('<p/>').parent().html());
            var add_row = $("#dt-acce").find('div.dt-row:last')

            acce_row_set_no();
            acce_row_clean(add_row);
            nicescroll_resize("#nicescroll-iput");
            add_row.find('input[name=dt_acce_code]').focus();
        }

        function acce_row_del(self) {

            var del_row = $(self).closest('div.dt-row');
            var visible_rows_length = $("#dt-acce").find('div.dt-row').not('div.deleted').length;

            if (del_row.attr('dt_id') == '0') {
                if (visible_rows_length == 1) {
                    acce_row_clean(del_row);
                } else {
                    del_row.remove();
                }
            } else {
                del_row.addClass('hidden-content deleted');
                if (visible_rows_length == 1) {
                    acce_row_add();
                }
            }
            acce_row_set_no();
            nicescroll_resize("#nicescroll-iput");

            var dt_amount_total = dt_get_amount_total();
            var ord_tax = numeral($("input[name=ord_tax]").val()).value();
            var dt_amount_tax_total = dt_amount_total + (dt_amount_total * ord_tax / 100);
            ord_set_total(dt_amount_total, dt_amount_tax_total);
        }

        function acce_row_clean(row) {
            row.attr('dt_id', '0');
            row.find("input[name=dt_acce_code]").val('');
            row.find("input[name=dt_acce_name]").val('');
            row.find("textarea[name=dt_note]").val('');
            row.find("input[name=dt_unit]").val('');
            row.find("input[name=dt_quantity]").val('');
            row.find("textarea[name=dt_delivery_time]").val('');
            row.find("select[name=dt_status]").val('');
            row.find("input[name=dt_price]").val('');
            row.find("input[name=dt_amount]").val('');
        }

        function acce_row_get_data(row) {

            var data = {};

            data.dt_id = row.attr('dt_id');
            data.dt_acce_code = row.find("input[name=dt_acce_code]").val();
            data.dt_acce_name = row.find("input[name=dt_acce_name]").val();
            data.dt_note = row.find("textarea[name=dt_note]").val();
            data.dt_unit = row.find("input[name=dt_unit]").val();
            data.dt_quantity = row.find("input[name=dt_quantity]").val();
            data.dt_delivery_time = row.find("textarea[name=dt_delivery_time]").val();
            data.dt_status = row.find("select[name=dt_status]").val();
            data.dt_price = row.find("input[name=dt_price]").val();
            data.dt_amount = row.find("input[name=dt_amount]").val();
            data.dt_type = '2';

            return data;

        }

        function acce_row_set_data(row, data) {
            row.attr('dt_id', data.dt_id);
            row.find("input[name=dt_acce_code]").val(data.dt_acce_code);
            row.find("input[name=dt_acce_name]").val(data.dt_acce_code);
            row.find("textarea[name=dt_note]").val(data.dt_note);
            row.find("input[name=dt_unit]").val(data.dt_unit);
            row.find("input[name=dt_quantity]").val(data.dt_quantity);
            row.find("textarea[name=dt_delivery_time]").val(data.dt_delivery_time);
            row.find("select[name=dt_status]").val(data.dt_status);
            row.find("input[name=dt_price]").val(data.dt_price);
            row.find("input[name=dt_amount]").val(data.dt_amount);
        }

        function acce_row_set_no() {
            var cur_rows = $("#dt-acce").find('div.dt-row').not('div.deleted');
            $.each(cur_rows, function (idx, row) {
                var row_no = idx + 1;
                $(row).find("div.dt-row-head").find('label').text('No.' + row_no);
            });
        }

        function acce_row_validate_data(data) {

            if (numeral(data.dt_id).value() > 0)
                return true;

            if (data.dt_acce_code == ""
                && data.dt_acce_name == ""
                && data.dt_note == ""
                && data.dt_unit == ""
                && data.dt_quantity == ""
                && data.dt_delivery_time == ""
                && (data.dt_status == "1" || data.dt_status == "")
                && data.dt_price == ""
                && data.dt_amount == ""
            ) return false;
            return true;
        }

        function dt_row_add() {
            var active_tab = $('a[data-toggle="tab"].active');
            if (active_tab.length == 0) {
                return false;
                console.log("Can not find active tab.!!");
            }
            var aria_controls = active_tab.attr('aria-controls');
            switch (aria_controls) {
                case 'dt-prod':
                    prod_row_add();
                    break;
                case 'dt-acce':
                    acce_row_add();
                    break;
                default:
                    console.log("Tab [" + aria_controls + "] is not supported.!!");
                    break;
            }
        }

        function dt_quantity_change(self) {

            var dt_row = $(self).closest('div.dt-row');

            var dt_quantity = numeral($(self).val()).value();
            if (max_validator(dt_quantity, max_integer, 'integer') == false) {

                dt_row_rollback(dt_row);
                var message = i18next.t("System doesn't support quantity bigger than :max.", {
                    'max': numeral(max_integer).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            var dt_price = numeral(dt_row.find('input[name=dt_price]').val()).value();
            var dt_amount = dt_quantity * dt_price;
            if (max_validator(dt_amount, max_double, 'double') == false) {

                dt_row_rollback(dt_row);
                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }
            dt_row.find('input[name=dt_amount]').val(numeral(dt_amount).format('0,0'));

            var dt_amount_total = dt_get_amount_total();
            if (max_validator(dt_amount_total, max_double, 'double') == false) {

                dt_row_rollback(dt_row);
                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            var ord_tax = numeral($("input[name=ord_tax]").val()).value();
            var dt_amount_tax_total = dt_amount_total + (dt_amount_total * ord_tax / 100);
            if (max_validator(dt_amount_tax_total, max_double, 'double') == false) {

                dt_row_rollback(dt_row);
                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            dt_row_set_old_data(dt_row);
            ord_set_total(dt_amount_total, dt_amount_tax_total);

        }

        function dt_price_change(self) {
            var dt_row = $(self).closest('div.dt-row');

            var dt_price = numeral($(self).val()).value();
            if (max_validator(dt_price, max_double, 'double') == false) {

                dt_row_rollback(dt_row);
                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            var dt_quantity = numeral(dt_row.find('input[name=dt_quantity]').val()).value();
            var dt_amount = dt_quantity * dt_price;
            if (max_validator(dt_amount, max_double, 'double') == false) {

                dt_row_rollback(dt_row);
                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }
            dt_row.find('input[name=dt_amount]').val(numeral(dt_amount).format('0,0'));

            var dt_amount_total = dt_get_amount_total();
            if (max_validator(dt_amount_total, max_double, 'double') == false) {

                dt_row_rollback(dt_row);
                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            var ord_tax = numeral($("input[name=ord_tax]").val()).value();
            var dt_amount_tax_total = dt_amount_total + (dt_amount_total * ord_tax / 100);
            if (max_validator(dt_amount_tax_total, max_double, 'double') == false) {

                dt_row_rollback(dt_row);
                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            dt_row_set_old_data(dt_row);
            ord_set_total(dt_amount_total, dt_amount_tax_total);
        }

        function dt_amount_change(self) {

            var dt_row = $(self).closest('div.dt-row');
            var dt_amount = numeral($(self).val()).value();
            if (max_validator(dt_amount, max_double, 'double') == false) {

                dt_row_rollback(dt_row);
                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            var dt_amount_total = dt_get_amount_total();
            if (max_validator(dt_amount_total, max_double, 'double') == false) {

                dt_row_rollback(dt_row);
                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            var ord_tax = numeral($("input[name=ord_tax]").val()).value();
            var dt_amount_tax_total = dt_amount_total + (dt_amount_total * ord_tax / 100);
            if (max_validator(dt_amount_tax_total, max_double, 'double') == false) {

                dt_row_rollback(dt_row);
                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            dt_row_set_old_data(dt_row);
            ord_set_total(dt_amount_total, dt_amount_tax_total);
        }

        function dt_get_amount_total() {
            var prod_amount_total = dt_get_prod_amount_total();
            var acce_amount_total = dt_get_acce_amount_total();
            return prod_amount_total + acce_amount_total;
        }

        function dt_get_prod_amount_total() {
            var dt_amount_total = 0;
            var cur_rows = $("#dt-prod").find('div.dt-row').not('div.deleted');
            $.each(cur_rows, function (idx, row) {
                var dt_amount = $(row).find('input[name=dt_amount]').val();
                dt_amount = numeral(dt_amount).value();
                if (dt_amount != null && isNaN(dt_amount) == false) {
                    dt_amount_total += dt_amount;
                }
            });
            return dt_amount_total;
        }

        function dt_get_acce_amount_total() {
            var dt_amount_total = 0;
            var cur_rows = $("#dt-acce").find('div.dt-row').not('div.deleted');
            $.each(cur_rows, function (idx, row) {
                var dt_amount = $(row).find('input[name=dt_amount]').val();
                dt_amount = numeral(dt_amount).value();
                if (dt_amount != null && isNaN(dt_amount) == false) {
                    dt_amount_total += dt_amount;
                }
            });
            return dt_amount_total;
        }

        function dt_row_rollback(row) {
            var dt_quantity_old = numeral(row.find('input[name=dt_quantity_old]').val()).format('0,0');
            var dt_price_old = numeral(row.find('input[name=dt_price_old]').val()).format('0,0');
            var dt_amount_old = numeral(row.find('input[name=dt_amount_old]').val()).format('0,0');

            row.find('input[name=dt_quantity]').val(dt_quantity_old);
            row.find('input[name=dt_price]').val(dt_price_old);
            row.find('input[name=dt_amount]').val(dt_amount_old);
        }

        function dt_row_set_old_data(row) {

            var dt_quantity = row.find('input[name=dt_quantity]').val();
            var dt_price = row.find('input[name=dt_price]').val();
            var dt_amount = row.find('input[name=dt_amount]').val();

            row.find('input[name=dt_quantity_old]').val(dt_quantity);
            row.find('input[name=dt_price_old]').val(dt_price);
            row.find('input[name=dt_amount_old]').val(dt_amount);
        }

        function dt_row_colect_data(){

            var dt_rows = new Array();

            var dt_prod_rows = $("#dt-prod").find('div.dt-row');
            $.each(dt_prod_rows, function (idx, row) {

                var dt_prod_row_data = prod_row_get_data($(row));
                var is_pass = prod_row_validate_data(dt_prod_row_data);
                if (is_pass == false)
                    return;

                var is_deleted = $(row).hasClass('deleted');
                dt_prod_row_data.action = 'insert';
                if (numeral(dt_prod_row_data.dt_id).value() > 0 && is_deleted == true) {
                    dt_prod_row_data.action = 'delete';
                }
                if (numeral(dt_prod_row_data.dt_id).value() > 0 && is_deleted == false) {
                    dt_prod_row_data.action = 'update';
                }
                dt_rows.push(dt_prod_row_data);
            });

            var dt_acce_rows = $("#dt-acce").find('div.dt-row');
            $.each(dt_acce_rows, function (idx, row) {

                var dt_acce_row_data = acce_row_get_data($(row));
                var is_pass = acce_row_validate_data(dt_acce_row_data);
                if (is_pass == false)
                    return;

                var is_deleted = $(row).hasClass('deleted');
                dt_acce_row_data.action = 'insert';
                if (numeral(dt_acce_row_data.dt_id).value() > 0 && is_deleted == true) {
                    dt_acce_row_data.action = 'delete';
                }
                if (numeral(dt_acce_row_data.dt_id).value() > 0 && is_deleted == false) {
                    dt_acce_row_data.action = 'update';
                }
                dt_rows.push(dt_acce_row_data);
            });

            return dt_rows;
        }

        function ord_set_total(ord_amount, ord_amount_tax) {

            var ord_paid = numeral($('input[name=ord_paid]').val()).value();
            var ord_debt = ord_amount_tax - ord_paid;

            $('input[name=ord_amount]').val(numeral(ord_amount).format('0,0'));
            $('input[name=ord_amount_tax]').val(numeral(ord_amount_tax).format('0,0'));
            $('input[name=ord_debt]').val(numeral(ord_debt).format('0,0'));

            $('input[name=ord_amount_old]').val(numeral(ord_amount).format('0,0'));
            $('input[name=ord_amount_tax_old]').val(numeral(ord_amount_tax).format('0,0'));
            $('input[name=ord_debt_old]').val(numeral(ord_debt).format('0,0'));
        }

        function ord_no_change(self) {

            var ord_no = $(self).val();
            if (ord_no == '') {

                var ord_no_old = $('input[name=ord_no_old]').val();
                $(self).val(ord_no_old);

                var message = i18next.t("Order No is required.");
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            $('input[name=ord_no_old]').val(ord_no);
        }

        function ord_date_change(self) {

            var ord_date = $(self).val();
            if (ord_date == '') {

                var ord_date_old = $('input[name=ord_date_old]').val();
                $(self).val(ord_date_old);

                var message = i18next.t("Order Date is required.");
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            if (moment(ord_date).isValid() == false) {
                var ord_date_old = $('input[name=ord_date_old]').val();
                $(self).val(ord_date_old);

                var message = i18next.t("Order Date is wrong format YYYY/MM/DD");
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            ord_date = moment(ord_date).format('YYYY/MM/DD');
            $(self).val(ord_date);
            $('input[name=ord_date_old]').val(ord_date);
        }

        function ord_tax_change(self) {

            var ord_tax = numeral($(self).val()).value();
            if (max_validator(ord_tax, 100, 'integer') == false) {

                var ord_tax_old = numeral($('input[name=ord_tax_old]').val()).format('0,0');
                $(self).val(ord_tax_old);

                var message = i18next.t("System doesn't support tax bigger than :max.", {
                    'max': 100
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }

            var ord_amount = numeral($('input[name=ord_amount]').val()).value();
            var ord_amount_tax = ord_amount + (ord_amount * ord_tax / 100);
            if (max_validator(ord_amount_tax, max_double, 'double') == false) {

                var ord_tax_old = numeral($('input[name=ord_tax_old]').val()).format('0,0');
                $(self).val(ord_tax_old);

                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }
            $('input[name=ord_tax_old]').val(ord_tax);
            ord_set_total(ord_amount, ord_amount_tax);
        }

        function ord_paid_change(self) {

            var ord_paid = numeral($(self).val()).value();
            if (max_validator(ord_paid, max_double, 'double') == false) {

                ord_rollback_total();
                var message = i18next.t("System doesn't support money bigger than :max.", {
                    'max': numeral(max_double).format('0,0')
                });
                swal({
                    type: 'error',
                    text: message
                });
                return false;
            }
            $('input[name=ord_paid_old]').val(ord_paid);
            var ord_amount = numeral($('input[name=ord_amount]').val()).value();
            var ord_amount_tax = numeral($('input[name=ord_amount_tax]').val()).value();
            ord_set_total(ord_amount, ord_amount_tax);
        }

        function ord_colect_data(){
            var data = {};
            data.ord_id = $("input[name=ord_id]").val();
            data.ord_no = $("input[name=ord_no]").val();
            data.ord_date = $("input[name=ord_date]").val();
            data.ord_note = $("textarea[name=ord_note]").val();
            data.ord_tax = numeral($("input[name=ord_tax]").val()).value();
            data.ord_amount = numeral($("input[name=ord_amount]").val()).value();
            data.ord_amount_tax = numeral($("input[name=ord_amount_tax]").val()).value();
            data.ord_paid = numeral($("input[name=ord_paid]").val()).value();
            data.ord_debt = numeral($("input[name=ord_debt]").val()).value();
            return data;
        }

        function ord_rollback_total() {
            var ord_amount_old = numeral($('input[name=ord_amount_old]').val()).format('0,0');
            var ord_amount_tax_old = numeral($('input[name=ord_amount_tax_old]').val()).format('0,0');
            var ord_paid_old = numeral($('input[name=ord_paid_old]').val()).format('0,0');
            var ord_debt_old = numeral($('input[name=ord_debt_old]').val()).format('0,0');

            $('input[name=ord_amount]').val(ord_amount_old);
            $('input[name=ord_amount_tax]').val(ord_amount_tax_old);
            $('input[name=ord_paid]').val(ord_paid_old);
            $('input[name=ord_debt]').val(ord_debt_old);
        }

        function ord_back_to_output(){
            window.location.href = "/orders";
        }

        function ord_save(){
            swal({
                title: i18next.t('Do you want to save the data.?'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var data = {};
                    data.order = ord_colect_data();
                    data.order_detail = dt_row_colect_data();
                    ubizapis('v1', '/orders/' + data.order.ord_id + '/update', 'post', data, null, ord_save_callback);
                }
            })
        }

        function ord_save_callback(response){
            if (response.data.success == true) {
                ord_back_to_output();
            } else {
                swal({
                    type: 'error',
                    text: response.data.message
                });
            }
        }

        function ord_delete(){
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
                    var ord_id = $("input[name=ord_id]").val();
                    ubizapis('v1', '/orders/' + ord_id + '/delete', 'delete', null, null, ord_delete_callback);
                }
            })
        }

        function ord_delete_callback(response){
            if (response.data.success == true) {
                ord_back_to_output();
            } else {
                swal({
                    type: 'error',
                    text: response.data.message
                });
            }
        }

        function ord_refresh(){
            swal({
                title: i18next.t('Do you want to refresh the data.?'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: i18next.t('No'),
                confirmButtonText: i18next.t('Yes'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    window.location.reload();
                }
            })

        }

        $(document).ready(function () {

            prod_spec_no = $("#dt-prod").find('div.dt-row').length;

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                nicescroll_resize("#nicescroll-iput");
            })

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
            $('#nicescroll-iput').niceScroll({
                cursorcolor: "#9fa8b0",
                cursorwidth: "5px",
                cursorborder: "none",
                cursorborderradius: 5,
                cursoropacitymin: 0.4,
                scrollbarid: 'nc-oput',
                autohidemode: false,
                horizrailenabled: false
            });
            fnc_datepicker('.datepicker');
        });
    </script>
@endsection