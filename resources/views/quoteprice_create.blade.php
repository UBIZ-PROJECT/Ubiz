@extends('layouts.main')
@section('title',__("QP"))
@section('headbar-title', __("QP"))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/quoteprice_input.css') }}">
@endsection
@section('headbar')
    @include('layouts/headbar')
@endsection
@section('content')
    <div class="main-content quoteprice-input">
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
                <input type="hidden" name="qp_id" value="0">
                <input type="hidden" name="cus_id" value="{{ $customer->cus_id }}">
                <div class="bkK">
                    <div class="rwq">
                        <div class="row z-mgr z-mgl">
                            <div class="col-3 text-left pdt-7">
                                <div class="GNi" onclick="qp_back_to_output()">
                                    <div class="ax7 poK utooltip" title="{{ __("Back to the list page") }}">
                                        <div class="asA">
                                            <div class="arB"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="GNi" onclick="qp_save()">
                                    <div class="ax7 poK utooltip" title="{{ __("Save") }}">
                                        <div class="asA">
                                            <div class="arS"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="GNi" onclick="qp_refresh()">
                                    <div class="ax7 poK utooltip" title="{{ __("Refresh") }}">
                                        <div class="asA">
                                            <div class="arR"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7 text-left pdt-5">
                                @include('components.sale_step', ['sale_step'=>0])
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
                                        @include('components.input',['control_id'=>'qp_no', 'value'=> $qp_no, 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('QP No'), 'i_focus'=>'', 'i_blur'=>'', 'onchange'=>"qp_no_change(this)"])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto z-pdr">
                                        @include('components.input',['control_id'=>'qp_date', 'value'=> date('Y/m/d'), 'width'=> '150', 'lbl_width'=>'70', 'label'=>__('QP Date'), 'class'=>'datepicker z-pdl z-pdr', 'i_focus'=>'', 'i_blur'=>'', 'onchange'=>"qp_date_change(this)"])
                                    </div>
                                    <div class="col-md-auto z-pdl z-pdr">
                                        @include('components.input',['control_id'=>'qp_exp_date', 'value'=> date('Y/m/d'), 'width'=> '150', 'lbl_width'=>'70', 'label'=>__('QP Exp Date'), 'class'=>'datepicker z-pdl z-pdr', 'i_focus'=>'', 'i_blur'=>'', 'onchange'=>"qp_exp_date_change(this)"])
                                    </div>
                                </div>
                                @if($user->role == 2)
                                    <div class="row">
                                        <div class="col-md-auto">
                                            <input type="hidden" id="qp_sale_id" name="qp_sale_id" value="">
                                            @include('components.input',['control_id'=>'qp_sale_name', 'readonly'=>true, 'select'=>true, 'value'=> '', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Sale person'), 'i_focus'=>'', 'i_blur'=>''])
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-auto">
                                            <input type="hidden" id="qp_sale_id" name="qp_sale_id" value="{{ $user->id }}">
                                            @include('components.input',['control_id'=>'qp_sale_name', 'value'=> $user->name, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Sale person'), 'i_focus'=>'', 'i_blur'=>''])
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'qp_sale_rank', 'value'=> ( $user->role == 2 ? '' : $user->rank ), 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Duty'), 'i_focus'=>'', 'i_blur'=>''])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'qp_sale_phone', 'value'=>  ( $user->role == 2 ? '' : $user->phone ), 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Phone'), 'i_focus'=>'', 'i_blur'=>''])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.input',['control_id'=>'qp_sale_email', 'value'=>  ( $user->role == 2 ? '' : $user->email ), 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Email'), 'i_focus'=>'', 'i_blur'=>''])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-auto">
                                <div class="row">
                                    <div class="col-md-auto">
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'cus_name', 'value'=> $customer->cus_name, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Customer'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'cus_type', 'value'=> $customer->cus_type_name, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Type'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-auto">
                                        @include('components.textarea',['value'=>'', 'control_id'=>'qp_note', 'width'=>'300', 'height'=>'70', 'resize'=>'none', 'label'=>__('Note'), 'lable_class'=>'hidden-content'])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        @include('components.dropdown',['value'=>'', 'control_id'=>'qp_cad_id', 'width'=> '630', 'lbl_width'=>'50', 'label'=>__('Address') ,'data'=> $cusAddress])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-auto">
                                        <div class="row">
                                            <div class="col-md-auto">
                                                <input type="hidden" id="qp_contact_id" name="qp_contact_id" value="0">
                                                @include('components.input',['control_id'=>'qp_contact_name', 'readonly'=>true, 'select'=>true, 'value'=> '', 'width'=> '300', 'lbl_width'=>'90', 'label'=>__('Contact person'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'qp_contact_rank', 'value'=> '', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Duty'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'qp_contact_phone', 'value'=> '', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Phone'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'qp_contact_email', 'value'=> '', 'width'=> '300', 'lbl_width'=>'70', 'label'=>__('Email'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-auto">
                                                @include('components.input',['control_id'=>'cus_fax', 'value'=> $customer->cus_fax, 'type'=>'disabled', 'width'=> '300', 'lbl_width'=>'60', 'label'=>__('Fax'), 'i_focus'=>'', 'i_blur'=>''])
                                            </div>
                                            <div class="col-md-auto">
                                                @include('components.number',['value'=>'10', 'onchange'=>'qp_tax_change(this)', 'control_id'=>'qp_tax', 'min'=>'0', 'max'=>'100', 'suffix'=>'%', 'length'=>'3', 'width'=> '130', 'lbl_width'=>'70', 'label'=>__('Tax'), 'class'=> 'text-right pdr-5'])
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
                                <div class="dt-row" dt_id="0">
                                    <div class="row dt-row-head zero-mgl zero-mgr" onclick="my_collapse(this)">
                                        <div class="col text-left">
                                            <label class="lbl-primary z-mgb">No.1</label>
                                        </div>
                                        <div class="col text-right">
                                            <i class="fas fa-caret-down"></i>
                                        </div>
                                    </div>
                                    <div class="row dt-row-body zero-mgl zero-mgr collapse hide">
                                        <div class="col-md-auto">
                                            <label class="lbl-primary">{{ __('Specification') }}:</label>
                                            <textarea name="dt_prod_specs_mce" id="dt_prod_specs_mce_1"></textarea>
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.input',['value'=>'', 'control_id'=>'dt_unit', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Unit'), 'class'=> 'text-right', 'i_focus'=>'', 'i_blur'=>''])
                                            @include('components.number',['value'=>'', 'onchange'=>'dt_quantity_change(this)', 'control_id'=>'dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Quantity'), 'class'=> 'text-right'])
                                            @include('components.textarea',['value'=>'', 'control_id'=>'dt_delivery_time', 'width'=>'250', 'height'=>'50', 'resize'=>'none', 'class'=> 'margin-bottom-15', 'label'=>__('Delivery time')])
                                            @include('components.dropdown',['value'=>'', 'control_id'=>'dt_status', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Status') ,'data'=> $prdStatus])
                                            @include('components.money',['value'=> '', 'onchange'=>'dt_price_change(this)', 'control_id'=>'dt_price', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Price'), 'class'=> 'text-right'])
                                            @include('components.money',['value'=>'', 'onchange'=>'dt_amount_change(this)', 'control_id'=>'dt_amount', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Amount'), 'class'=> 'text-right'])
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.textarea',['value'=>'', 'width'=>'250', 'height'=>'100', 'control_id'=>'dt_note', 'resize'=>'none', 'label'=>__('Note')])
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
                            </div>
                            <div class="tab-pane fade" id="dt-acce" role="tabpanel" aria-labelledby="dt-acce-tab">
                                <div class="dt-row" dt_id="0">
                                    <div class="row dt-row-head zero-mgl zero-mgr" onclick="my_collapse(this)">
                                        <div class="col text-left">
                                            <label class="lbl-primary z-mgb">No.1</label>
                                        </div>
                                        <div class="col text-right">
                                            <i class="fas fa-caret-down"></i>
                                        </div>
                                    </div>
                                    <div class="row dt-row-body zero-mgl zero-mgr collapse show">
                                        <div class="col-md-auto">
                                            @include('components.input',['value'=>'', 'control_id'=>'dt_acce_code','width'=> '250', 'lbl_width'=>'70', 'label'=>__('Code'), 'i_focus'=>'', 'i_blur'=>''])
                                            @include('components.input',['value'=>'', 'control_id'=>'dt_acce_name','width'=> '250', 'lbl_width'=>'70', 'label'=>__('Name'), 'i_focus'=>'', 'i_blur'=>''])
                                            @include('components.textarea',['value'=>'', 'control_id'=>'dt_note', 'width'=>'300', 'height'=>'73', 'resize'=>'none', 'label'=>__('Note'), 'lable_class'=>'hidden-content'])
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.input',['value'=>'', 'control_id'=>'dt_unit', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Unit'), 'class'=> 'text-right', 'i_focus'=>'', 'i_blur'=>''])
                                            @include('components.number',['value'=>'', 'onchange'=>'dt_quantity_change(this)', 'control_id'=>'dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Quantity'), 'class'=> 'text-right'])
                                            @include('components.textarea',['value'=>'', 'control_id'=>'dt_delivery_time', 'width'=>'250', 'height'=>'50', 'resize'=>'none', 'class'=> 'margin-bottom-15', 'label'=>__('Delivery time')])
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.dropdown',['value'=>'', 'control_id'=>'dt_status', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Status') ,'data'=> $prdStatus])
                                            @include('components.money',['value'=> '', 'onchange'=>'dt_price_change(this)', 'control_id'=>'dt_price', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Price'), 'class'=> 'text-right'])
                                            @include('components.money',['value'=>'', 'onchange'=>'dt_amount_change(this)', 'control_id'=>'dt_amount', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Amount'), 'class'=> 'text-right'])
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
                            </div>
                        </div>
                        <hr>
                        <div class="total-info margin-bottom-30">
                            <div class="row z-pdl z-pdr z-mgr z-mgl">
                                <div class="col-4 text-left z-pdl z-pdr">
                                    <label style="width: 70px">{{ __('Input Date') }}</label><label>: {{ date("Y/m/d H:i:s") }}</label>
                                    <br>
                                    <label style="width: 70px">{{ __('Update Date') }}</label><label>: {{ date("Y/m/d H:i:s") }}</label>
                                </div>
                                <div class="col-8 text-right">
                                    <div class="row justify-content-end z-pdl z-pdr z-mgr z-mgl">
                                        <div class="col-md-auto text-right z-mgr z-mgl pdt-5">
                                            <span>{{ __('Total value of quoteprices (before VAT)') }}</span>
                                        </div>
                                        <div class="col-md-auto z-pdr z-pdl" style="width: 150px">
                                            <input type="text" name="qp_amount" readonly class="w-100 text-right"
                                                   value="0">
                                            <input type="hidden" value="0" name="qp_amount_old">
                                        </div>
                                        <div class="col-md-auto z-mgr z-mgl">
                                            <span>VND</span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end z-pdl z-pdr z-mgr z-mgl">
                                        <div class="col-md-auto text-right z-mgr z-mgl pdt-5">
                                            <span>{{ __('Total value of quoteprices (VAT included)') }}</span>
                                        </div>
                                        <div class="col-md-auto z-pdr z-pdl" style="width: 150px">
                                            <input type="text" name="qp_amount_tax" readonly class="w-100 text-right"
                                                   value="0">
                                            <input type="hidden" value="" name="qp_amount_tax_old">
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
    <script type="text/javascript" src="{{ asset('js/quoteprice_create.js') }}"></script>
    <script>
        var sale_list = {!! json_encode($sales) !!};
        var con_list = {!! json_encode($contacts) !!};
    </script>
@endsection