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
                    <div class="aeH">
                        <div class="aqK">
                            <div class="aqL">
                                <div class="GtF">
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
                            </div>
                            <div class="aqJ">
                                <div class="ar5">
                                <span class="Di">
                                    <div id="i-paging-label"></div>
                                    <div id="i-paging-older"></div>
                                    <div id="i-paging-newer"></div>
                                    <div class="amD utooltip" title="{{ __("Setting") }}">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amG" src="{{ asset("images/cleardot.gif") }}" alt="">
                                    </div>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jAQ">
                    <div class="aqI" id="nicescroll-iput">
                        <ul class="nav nav-tabs" id="ord-inp-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="dt-prod-tab" data-toggle="tab" href="#dt-prod" role="tab" aria-controls="dt-prod" aria-selected="true">{{ __('Products') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="dt-acce-tab" data-toggle="tab" href="#dt-acce" role="tab" aria-controls="dt-acce" aria-selected="false">{{ __('Accessories') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-ord-inp-content">
                            <div class="tab-pane fade show active" id="dt-prod" role="tabpanel" aria-labelledby="dt-prod-tab">
                                <div class="dt-row">
                                    <div class="row dt-row-head zero-mgl zero-mgr">
                                        <div class="col text-left">
                                            <label class="lbl-primary z-mgb">Row: 1</label>
                                        </div>
                                        <div class="col text-right">
                                            <i class="fas fa-caret-down"></i>
                                        </div>
                                    </div>
                                    <div class="row dt-row-body zero-mgl zero-mgr">
                                        <div class="col-md-auto">
                                            <label class="lbl-primary">{{ __('Specification') }}:</label>
                                            <textarea name="txt_dt_spec"></textarea>
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.input',['control_id'=>'txt_dt_model', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Model')])
                                            @include('components.textarea',['width'=>'250', 'height'=>'100', 'control_id'=>'txt_dt_series', 'label'=>__('Series')])
                                            @include('components.textarea',['width'=>'250', 'height'=>'100', 'control_id'=>'txt_dt_memo', 'label'=>__('Memo')])
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.input',['control_id'=>'txt_dt_unit', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Unit')])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Quantity')])
                                            @include('components.dropdown',['control_id'=>'txt_dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Status'),'data'=>['a'=>'a','b'=>'b']])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Price')])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Total')])
                                        </div>
                                        <div class="col-md-auto text-right">
                                            <i class="fas fa-copy fa-2x"></i>
                                            <i class="fas fa-trash fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="dt-row">
                                    <div class="row dt-row-head zero-mgl zero-mgr">
                                        <div class="col text-left">
                                            <label class="lbl-primary z-mgb">Row: 1</label>
                                        </div>
                                        <div class="col text-right">
                                            <i class="fas fa-caret-down"></i>
                                        </div>
                                    </div>
                                    <div class="row dt-row-body zero-mgl zero-mgr">
                                        <div class="col-md-auto">
                                            <label class="lbl-primary">{{ __('Specification') }}:</label>
                                            <textarea name="txt_dt_spec"></textarea>
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.input',['control_id'=>'txt_dt_model', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Model')])
                                            @include('components.textarea',['width'=>'250', 'height'=>'100', 'control_id'=>'txt_dt_series', 'label'=>__('Series')])
                                            @include('components.textarea',['width'=>'250', 'height'=>'100', 'control_id'=>'txt_dt_memo', 'label'=>__('Memo')])
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.input',['control_id'=>'txt_dt_unit', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Unit')])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Quantity')])
                                            @include('components.dropdown',['control_id'=>'txt_dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Status'),'data'=>['a'=>'a','b'=>'b']])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Price')])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Total')])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="dt-acce" role="tabpanel" aria-labelledby="dt-acce-tab">
                                <div class="dt-row">
                                    <div class="row dt-row-head zero-mgl zero-mgr">
                                        <div class="col text-left">
                                            <label class="lbl-primary z-mgb">Row: 1</label>
                                        </div>
                                        <div class="col text-right">
                                            <i class="fas fa-caret-down"></i>
                                        </div>
                                    </div>
                                    <div class="row dt-row-body zero-mgl zero-mgr">
                                        <div class="col-md-auto">
                                            <label class="lbl-primary">{{ __('Specification') }}:</label>
                                            <textarea name="txt_dt_spec"></textarea>
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.input',['control_id'=>'txt_dt_model', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Model')])
                                            @include('components.textarea',['width'=>'250', 'height'=>'100', 'control_id'=>'txt_dt_series', 'label'=>__('Series')])
                                            @include('components.textarea',['width'=>'250', 'height'=>'100', 'control_id'=>'txt_dt_memo', 'label'=>__('Memo')])
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.input',['control_id'=>'txt_dt_unit', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Unit')])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Quantity')])
                                            @include('components.dropdown',['control_id'=>'txt_dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Status'),'data'=>['a'=>'a','b'=>'b']])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Price')])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Total')])
                                        </div>
                                        <div class="col-md-auto text-right">
                                            <i class="fas fa-copy fa-2x"></i>
                                            <i class="fas fa-trash fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="dt-row">
                                    <div class="row dt-row-head zero-mgl zero-mgr">
                                        <div class="col text-left">
                                            <label class="lbl-primary z-mgb">Row: 1</label>
                                        </div>
                                        <div class="col text-right">
                                            <i class="fas fa-caret-down"></i>
                                        </div>
                                    </div>
                                    <div class="row dt-row-body zero-mgl zero-mgr">
                                        <div class="col-md-auto">
                                            <label class="lbl-primary">{{ __('Specification') }}:</label>
                                            <textarea name="txt_dt_spec"></textarea>
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.input',['control_id'=>'txt_dt_model', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Model')])
                                            @include('components.textarea',['width'=>'250', 'height'=>'100', 'control_id'=>'txt_dt_series', 'label'=>__('Series')])
                                            @include('components.textarea',['width'=>'250', 'height'=>'100', 'control_id'=>'txt_dt_memo', 'label'=>__('Memo')])
                                        </div>
                                        <div class="col-md-auto">
                                            @include('components.input',['control_id'=>'txt_dt_unit', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Unit')])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Quantity')])
                                            @include('components.dropdown',['control_id'=>'txt_dt_quantity', 'width'=> '170', 'lbl_width'=>'70', 'label'=>__('Status'),'data'=>['a'=>'a','b'=>'b']])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Price')])
                                            @include('components.input',['control_id'=>'txt_dt_quantity', 'width'=> '250', 'lbl_width'=>'70', 'label'=>__('Total')])
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
        jQuery(document).ready(function () {
            tinymce.init({
                width: 350,
                min_height: 246,
                max_height: 500,
                menubar: false,
                toolbar_drawer: 'floating',
                selector: 'textarea[name=txt_dt_spec]',
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor searchreplace visualblocks code fullscreen insertdatetime media table paste code wordcount autoresize'
                ],
                toolbar: 'undo redo | bold italic forecolor backcolor | formatselect | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
                content_css: [
                    '{{ asset('fonts/roboto/v18/roboto.css') }}'
                ]
            });
        });
    </script>
@endsection