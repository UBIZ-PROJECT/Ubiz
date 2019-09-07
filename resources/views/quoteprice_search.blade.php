<div class="search">
    <div class="tyo" role="search">
        <div class="cyo">
            <input id="fuzzy" spellcheck="false"
                   autocomplete="off"
                   placeholder="Tìm kiếm báo giá"
                   value="" type="text"
                   onkeypress="jQuery.UbizOIWidget.w_fuzzy_search_handle_enter(event)">
        </div>
        <button class="dyo" onclick="show_advance_searh_form()">
            <svg focusable="false" height="24px" viewBox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 10l5 5 5-5z"></path>
                <path d="M0 0h24v24H0z" fill="none"></path>
            </svg>
        </button>
        <button class="jyo">
            <svg focusable="false" height="24px" viewBox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                <path d="M0 0h24v24H0z" fill="none"></path>
            </svg>
        </button>
        <button class="xyo" onclick="jQuery.UbizOIWidget.w_fuzzy_search()">
            <svg focusable="false" height="24px" viewBox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                <path d="M0 0h24v24H0z" fill="none"></path>
            </svg>
        </button>
    </div>
    <div id="search-form" class="eyo">
        <div class="hvo">
            <div class="row z-mgr z-mgl pdt-20">
                <div class="col-12">
                    <div class="row justify-content-start mgb-10">
                        <div class="col-auto">
                            <label style="min-width: 80px" class="text-primary">Mã báo giá</label>
                        </div>
                        <div class="col-auto">
                                        <textarea style="resize: none"
                                                  is-change="false" placeholder="" id="s-qp-code"
                                                  class="input-textarea "></textarea>
                        </div>
                        <div class="col-auto">
                            <select class="s-drd">
                                <option value="1">Bằng</option>
                                <option value="1">Không bằng</option>
                                <option value="1">Chứa</option>
                                <option value="1">Không chứa</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-start mgb-10">
                        <div class="col-auto">
                            <label style="min-width: 80px" class="text-primary">Ngày tạo</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" style="width: 100px"
                                   class="form-control light-color custom-form-control" value="2019/08/10">
                        </div>
                        <div class="col-auto z-pdl z-pdr">
                            <label>~</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" style="width: 100px"
                                   class="form-control light-color custom-form-control" value="2019/08/10">
                        </div>
                    </div>
                    <div class="row justify-content-start mgb-10">
                        <div class="col-auto">
                            <label style="min-width: 80px" class="text-primary">Hết hạn</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" style="width: 100px"
                                   class="form-control light-color custom-form-control" value="2019/08/10">
                        </div>
                        <div class="col-auto z-pdl z-pdr">
                            <label>~</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" style="width: 100px"
                                   class="form-control light-color custom-form-control" value="2019/08/10">
                        </div>
                    </div>
                    <div class="row justify-content-start mgb-10">
                        <div class="col-auto">
                            <label style="min-width: 80px" class="text-primary">Nhân viên</label>
                        </div>
                        <div class="col-auto dropdown">
                            <ul class="sale-step multiple-select"
                                id="dropdownMenuButton"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Báo giá</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Đơn hàng</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Hợp đồng</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Giao hàng</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                            </ul>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <select class="s-drd">
                                <option value="1">Chứa</option>
                                <option value="1">Không chứa</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-start mgb-10">
                        <div class="col-auto">
                            <label style="min-width: 80px" class="text-primary">Khách hàng</label>
                        </div>
                        <div class="col-auto dropdown">
                            <ul class="sale-step multiple-select"
                                id="dropdownMenuButton"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Báo giá</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Đơn hàng</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Hợp đồng</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Giao hàng</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                            </ul>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <select class="s-drd">
                                <option value="1">Chứa</option>
                                <option value="1">Không chứa</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-start mgb-10">
                        <div class="col-auto">
                            <label style="min-width: 80px" class="text-primary">Tổng tiền</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" style="width: 200px" value=""
                                   class="form-control light-color custom-form-control">
                        </div>
                        <div class="col-auto">
                            <select class="s-drd">
                                <option value="1">Bằng</option>
                                <option value="1">Không bằng</option>
                                <option value="1">Nhỏ hơn</option>
                                <option value="1">Lớn hơn</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-start mgb-10">
                        <div class="col-auto">
                            <label style="min-width: 80px" class="text-primary">Trạng thái</label>
                        </div>
                        <div class="col-auto dropdown">
                            <ul class="sale-step multiple-select"
                                id="dropdownMenuButton"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Báo giá</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Đơn hàng</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Hợp đồng</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                                <li>
                                    <div class="multiple-select-spacer">&nbsp;,</div>
                                    <div class="multiple-select-tag">Giao hàng</div>
                                    <div class="multiple-select-delete"><i></i></div>
                                </li>
                            </ul>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <select class="s-drd">
                                <option value="1">Chứa</option>
                                <option value="1">Không chứa</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row z-mgr z-mgl pdb-20">
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-link btn-sm text-secondary"
                            onclick="clear_advance_searh_form()">{{ __("Clear filter") }}</button>
                    <button type="button" class="btn btn-primary btn-sm"
                            onclick="jQuery.UbizOIWidget.w_search()">{{ __("Search") }}</button>
                    <button type="button" class="btn btn-danger btn-sm"
                            onclick="hide_advance_searh_form()">{{ __("Close") }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function show_advance_searh_form() {
        jQuery("#search-form").fadeIn('fast', function () {
            document.body.addEventListener('click', hide_advance_searh_form, false);
        });
    }

    function hide_advance_searh_form(e) {
        var search_form = jQuery(e.target).closest("#search-form");
        if (search_form.length == 0) {
            document.body.removeEventListener('click', hide_advance_searh_form, false);
            jQuery("#search-form").hide('fast');
        }
    }

    function clear_advance_searh_form() {
        jQuery("#search-form").hide('fast');
    }
</script>