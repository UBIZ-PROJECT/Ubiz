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
    <div id="search-form" class="search-container" onclick="search_container_click(event)">
        <div class="eyo">
            <div class="hvo">
                <div id="search-content" class="row z-mgr z-mgl pdt-20">
                    <div class="col-12">
                        <div class="row justify-content-start mgb-10">
                            <div class="col-auto">
                                <label style="min-width: 80px" class="text-primary">Mã báo giá</label>
                            </div>
                            <div class="col-auto">
                                @include('components.search_operators_1',['name'=>'so-qp-code'])
                            </div>
                            <div class="col-auto">
                                <textarea style="resize: none" class="input-textarea"
                                          is-change="false" placeholder="" id="sv-qp-code">
                                </textarea>
                            </div>
                        </div>
                        <div class="row justify-content-start mgb-10">
                            <div class="col-auto">
                                <label style="min-width: 80px" class="text-primary">Ngày tạo</label>
                            </div>
                            <div class="col-auto">
                                @include('components.search_operators_2',['name'=>'so-qp-date'])
                            </div>
                            <div class="col-auto">
                                <input type="text" style="width: 100px"
                                       value="" name="sv-f-qp-date" autocomplete="off"
                                       class="date-picker form-control light-color custom-form-control">
                            </div>
                            <div class="col-auto z-pdl z-pdr">
                                <label>~</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" style="width: 100px"
                                       value="" name="sv-t-qp-date" autocomplete="off"
                                       class="date-picker form-control light-color custom-form-control">
                            </div>
                        </div>
                        <div class="row justify-content-start mgb-10">
                            <div class="col-auto">
                                <label style="min-width: 80px" class="text-primary">Hết hạn</label>
                            </div>
                            <div class="col-auto">
                                @include('components.search_operators_2',['name'=>'so-qp-exp-date'])
                            </div>
                            <div class="col-auto">
                                <input type="text" style="width: 100px"
                                       value="" name="sv-f-qp-exp-date" autocomplete="off"
                                       class="date-picker form-control light-color custom-form-control">
                            </div>
                            <div class="col-auto z-pdl z-pdr">
                                <label>~</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" style="width: 100px"
                                       value="" name="sv-t-qp-exp-date" autocomplete="off"
                                       class="date-picker form-control light-color custom-form-control">
                            </div>
                        </div>
                        @if(sizeof($users) > 0)
                            <div class="row justify-content-start mgb-10">
                                <div class="col-auto">
                                    <label style="min-width: 80px" class="text-primary">Nhân viên</label>
                                </div>
                                <div class="col-auto">
                                    @include('components.search_operators_3',['name'=>'so-sale-id'])
                                </div>
                                <div id="drd-menu-user" class="col-auto dropdown">
                                    <select id="drd-user" name="sv-sale-id" style="display: none" multiple>
                                        @foreach($users as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <ul class="cst-select multiple-select"
                                        id="drd-menu-tags-user"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                    </ul>
                                    <div id="drd-menu-items-user"
                                         class="dropdown-menu multiple-select-menu"
                                         onclick="stop_propagation(event)"
                                         aria-labelledby="drd-menu-tags-user">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row justify-content-start mgb-10">
                            <div class="col-auto">
                                <label style="min-width: 80px" class="text-primary">Khách hàng</label>
                            </div>
                            <div class="col-auto">
                                @include('components.search_operators_3',['name'=>'so-cus-id'])
                            </div>
                            <div id="drd-menu-cus" class="col-auto dropdown">
                                <select id="drd-cus" name="sv-cus-id" style="display: none" multiple>
                                    @foreach($customers as $item)
                                        <option value="{{ $item->cus_id }}">{{ $item->cus_name }}</option>
                                    @endforeach
                                </select>
                                <ul class="cst-select multiple-select"
                                    id="drd-menu-tags-cus"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                </ul>
                                <div id="drd-menu-items-cus"
                                     class="dropdown-menu multiple-select-menu"
                                     onclick="stop_propagation(event)"
                                     aria-labelledby="drd-menu-tags-cus">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-start mgb-10">
                            <div class="col-auto">
                                <label style="min-width: 80px" class="text-primary">Tổng tiền</label>
                            </div>
                            <div class="col-auto">
                                @include('components.search_operators_4',['name'=>'so-qp-amount-tax'])
                            </div>
                            <div class="col-auto">
                                <input type="text" style="width: 240px" value="" name="sv-qp-amount-tax"
                                       onfocus="num_focus(this, '')" onblur="num_blur(this, '')"
                                       onkeydown="num_keydown(event)" min="0" max="9999999999"
                                       class="form-control light-color custom-form-control text-right">
                            </div>
                        </div>
                        <div class="row justify-content-start mgb-10">
                            <div class="col-auto">
                                <label style="min-width: 80px" class="text-primary">Ghi chú</label>
                            </div>
                            <div class="col-auto">
                                @include('components.search_operators_5',['name'=>'so-qp-note'])
                            </div>
                            <div class="col-auto">
                                <textarea style="width: 240px" value="" name="sv-qp-note"
                                          class="form-control light-color custom-form-control"></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-start mgb-10">
                            <div class="col-auto">
                                <label style="min-width: 80px" class="text-primary">Trạng thái</label>
                            </div>
                            <div class="col-auto">
                                @include('components.search_operators_3',['name'=>'so-sale-step'])
                            </div>
                            <div id="drd-menu-sale-step" class="col-auto dropdown">
                                <select id="drd-sale-step" name="sv-sale-step" style="display: none" multiple>
                                    <option value="1">Báo giá</option>
                                    <option value="2">Đơn hàng</option>
                                    <option value="3">Hợp đồng</option>
                                    <option value="4">Giao hàng</option>
                                </select>
                                <ul class="cst-select multiple-select"
                                    id="drd-menu-tags-sale-step"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                </ul>
                                <div id="drd-menu-items-sale-step"
                                     class="dropdown-menu multiple-select-menu"
                                     onclick="stop_propagation(event)"
                                     aria-labelledby="drd-menu-tags-sale-step">
                                </div>
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
</div>
<script>

    function stop_propagation(e) {
        e.stopPropagation();
    }

    function search_container_click(e) {
        if (event.target.id == 'search-form') {
            hide_advance_searh_form();
        }
    }

    function show_advance_searh_form() {
        $("#search-form").addClass('show');
    }

    function hide_advance_searh_form() {
        $("#search-form").removeClass('show');
    }

    function clear_advance_searh_form() {
        var tags = $('#sv-qp-code').tagEditor('getTags')[0].tags;
        for (i = 0; i < tags.length; i++) {
            $('#sv-qp-code').tagEditor('removeTag', tags[i]);
        }
        $(".so-drd").val("");
        $("input[name=sv-f-qp-date]").val("");
        $("input[name=sv-t-qp-date]").val("");
        $("input[name=sv-f-qp-exp-date]").val("");
        $("input[name=sv-t-qp-exp-date]").val("");

        $("#drd-menu-tags-user").empty();
        $("#drd-menu-items-user").empty();
        var drd_user = $("#drd-user");
        set_multiple_drd_val(drd_user, new Array());

        $("#drd-menu-tags-cus").empty();
        $("#drd-menu-items-cus").empty();
        var drd_cus = $("#drd-cus");
        set_multiple_drd_val(drd_cus, new Array());

        $("input[name=sv-qp-amount-tax]").val("");
        $("textarea[name=sv-qp-note]").val("");

        $("#drd-menu-tags-sale-step").empty();
        $("#drd-menu-items-sale-step").empty();
        var drd_sale_step = $("#drd-sale-step");
        set_multiple_drd_val(drd_sale_step, new Array());
    }

    function get_multiple_drd_items(drd) {
        var items = new Array();
        var options = drd.find('option');
        options.each(function (idx) {
            var item = {};
            item.opt_id = $(this).attr('value');
            item.opt_nm = $(this).text();
            item.opt_sl = $(this).is(':selected');
            items.push(item);
        });
        return items;
    }

    function set_multiple_drd_val(drd, items) {
        drd.find('option').attr('selected', false);
        _.forEach(items, function (item) {
            var option = drd.find('option[value=' + item.opt_id + "]");
            if (option.length == 0)
                return;
            option.attr('selected', true);
        });
    }

    function get_multiple_drd_val(drd) {
        var selected_items = new Array();
        var options = drd.find('option');
        options.each(function (idx) {

            if ($(this).is(':selected') == false)
                return;

            var item = {};
            item.opt_id = $(this).attr('value');
            item.opt_nm = $(this).text();
            selected_items.push(item);
        });
        return selected_items;
    }

    function get_drd_menu_tag_list(ele) {

        var tag_list = new Array();

        var tags = ele.find('li');
        if (tags.length == 0)
            return tag_list;

        tags.each(function (idx) {
            var tag = {};
            tag.opt_id = $(this).attr('opt-id');
            tag.opt_nm = $(this).attr('opt-nm');
            tag_list.push(tag);
        });

        return tag_list;
    }

    function get_drd_menu_checked_list(ele) {

        var checked_list = new Array();

        var dropdown_items = ele.find('a.dropdown-item');
        if (dropdown_items.length == 0)
            return checked_list;

        dropdown_items.each(function (idx) {
            if ($(this).find('input[type=checkbox]').is(':checked') == false)
                return;
            var item = {};
            item.opt_id = $(this).attr('opt-id');
            item.opt_nm = $(this).attr('opt-nm');
            checked_list.push(item);
        });

        return checked_list;
    }

    //--begin [sale-step]--
    function set_drd_menu_tags_sale_step(checked_list) {

        var tags_html = "";
        _.forEach(checked_list, function (item) {
            tags_html += '<li opt-id="' + item.opt_id + '" opt-nm="' + item.opt_nm + '">';
            tags_html += '<div class="multiple-select-spacer">&nbsp;,</div>';
            tags_html += '<div class="multiple-select-tag">' + item.opt_nm + '</div>';
            tags_html += '<div class="multiple-select-delete" onclick="tag_sale_step_remove(this, event)"><i></i></div>';
            tags_html += '</li>';
        });

        $("#drd-menu-tags-sale-step").empty();
        $("#drd-menu-tags-sale-step").html(tags_html);
    }

    function set_drd_menu_items_sale_step(items) {

        var items_html = "";
        _.forEach(items, function (item) {

            var checked = '';
            if (item.opt_sl == true) {
                checked = ' checked';
            }

            items_html += '<a opt-id="' + item.opt_id + '" opt-nm="' + item.opt_nm + '" class="dropdown-item" href="#">';
            items_html += '<div class="row justify-content-start">';
            items_html += '<div class="col-auto z-pdr">';
            items_html += '<input' + checked + ' type="checkbox">';
            items_html += '</div>';
            items_html += '<div class="col-auto">' + item.opt_nm + '</div>';
            items_html += '</div>';
            items_html += '</a>';
        });

        $("#drd-menu-items-sale-step").empty();
        $("#drd-menu-items-sale-step").html(items_html);
    }

    function tag_sale_step_remove(self, e) {
        e.stopPropagation();
        $(self).closest('li').remove();
        var drd_menu_tags = $("#drd-menu-tags-sale-step");
        var tag_list = get_drd_menu_tag_list(drd_menu_tags);

        var drd = $("#drd-sale-step");
        set_multiple_drd_val(drd, tag_list);
    }

    //--end [sale-step]--

    //--begin [cus]--
    function set_drd_menu_tags_cus(checked_list) {

        var tags_html = "";
        _.forEach(checked_list, function (item) {
            tags_html += '<li opt-id="' + item.opt_id + '" opt-nm="' + item.opt_nm + '">';
            tags_html += '<div class="multiple-select-spacer">&nbsp;,</div>';
            tags_html += '<div class="multiple-select-tag">' + item.opt_nm + '</div>';
            tags_html += '<div class="multiple-select-delete" onclick="tag_cus_remove(this, event)"><i></i></div>';
            tags_html += '</li>';
        });

        $("#drd-menu-tags-cus").empty();
        $("#drd-menu-tags-cus").html(tags_html);
    }

    function set_drd_menu_items_cus(items) {

        var items_html = "";
        _.forEach(items, function (item) {

            var checked = '';
            if (item.opt_sl == true) {
                checked = ' checked';
            }

            items_html += '<a opt-id="' + item.opt_id + '" opt-nm="' + item.opt_nm + '" class="dropdown-item" href="#">';
            items_html += '<div class="row justify-content-start">';
            items_html += '<div class="col-auto z-pdr">';
            items_html += '<input' + checked + ' type="checkbox">';
            items_html += '</div>';
            items_html += '<div class="col-auto">' + item.opt_nm + '</div>';
            items_html += '</div>';
            items_html += '</a>';
        });

        $("#drd-menu-items-cus").empty();
        $("#drd-menu-items-cus").html(items_html);
    }

    function tag_cus_remove(self, e) {
        e.stopPropagation();
        $(self).closest('li').remove();
        var drd_menu_tags = $("#drd-menu-tags-cus");
        var tag_list = get_drd_menu_tag_list(drd_menu_tags);

        var drd = $("#drd-cus");
        set_multiple_drd_val(drd, tag_list);
    }

    //--end [cus]--

    //--begin [user]--
    function set_drd_menu_tags_user(checked_list) {

        var tags_html = "";
        _.forEach(checked_list, function (item) {
            tags_html += '<li opt-id="' + item.opt_id + '" opt-nm="' + item.opt_nm + '">';
            tags_html += '<div class="multiple-select-spacer">&nbsp;,</div>';
            tags_html += '<div class="multiple-select-tag">' + item.opt_nm + '</div>';
            tags_html += '<div class="multiple-select-delete" onclick="tag_user_remove(this, event)"><i></i></div>';
            tags_html += '</li>';
        });

        $("#drd-menu-tags-user").empty();
        $("#drd-menu-tags-user").html(tags_html);
    }

    function set_drd_menu_items_user(items) {

        var items_html = "";
        _.forEach(items, function (item) {

            var checked = '';
            if (item.opt_sl == true) {
                checked = ' checked';
            }

            items_html += '<a opt-id="' + item.opt_id + '" opt-nm="' + item.opt_nm + '" class="dropdown-item" href="#">';
            items_html += '<div class="row justify-content-start">';
            items_html += '<div class="col-auto z-pdr">';
            items_html += '<input' + checked + ' type="checkbox">';
            items_html += '</div>';
            items_html += '<div class="col-auto">' + item.opt_nm + '</div>';
            items_html += '</div>';
            items_html += '</a>';
        });

        $("#drd-menu-items-user").empty();
        $("#drd-menu-items-user").html(items_html);
    }

    function tag_user_remove(self, e) {
        e.stopPropagation();
        $(self).closest('li').remove();
        var drd_menu_tags = $("#drd-menu-tags-user");
        var tag_list = get_drd_menu_tag_list(drd_menu_tags);

        var drd = $("#drd-user");
        set_multiple_drd_val(drd, tag_list);
    }

    //--end [user]--

    function get_search_cond() {

        var cond = {};
        var search_cond = new Array();

        //get qp-code search cond
        cond.search_name = 'qp-code';
        cond.search_value = $('#sv-qp-code').tagEditor('getTags')[0].tags;
        cond.search_operator = $('select[name=so-qp-code]').val();
        if (cond.search_operator != '' && cond.search_value.length > 0) {
            search_cond.push(cond);
        }

        //get qp-date search cond
        cond = {};
        cond.search_name = 'qp-date';
        cond.search_operator = $('select[name=so-qp-date]').val();
        cond.search_value = {};
        cond.search_value.from = $("input[name=sv-f-qp-date]").val();
        cond.search_value.to = $("input[name=sv-t-qp-date]").val();
        if (cond.search_operator != ''
            && (cond.search_value.from != '' || cond.search_value.to != '')
        ) {
            search_cond.push(cond);
        }

        //get qp-exp-date search cond
        cond = {};
        cond.search_name = 'qp-exp-date';
        cond.search_operator = $('select[name=so-qp-exp-date]').val();
        cond.search_value = {};
        cond.search_value.from = $("input[name=sv-f-qp-exp-date]").val();
        cond.search_value.to = $("input[name=sv-t-qp-exp-date]").val();
        if (cond.search_operator != ''
            && (cond.search_value.from != '' || cond.search_value.to != '')
        ) {
            search_cond.push(cond);
        }

        //get sale-id search cond
        cond = {};
        cond.search_name = 'sale-id';
        cond.search_value = $('select[name=sv-sale-id]').val();
        cond.search_operator = $('select[name=so-sale-id]').val();
        if (cond.search_operator != '' && cond.search_value.length > 0) {
            search_cond.push(cond);
        }

        //get cus-id search cond
        cond = {};
        cond.search_name = 'cus-id';
        cond.search_value = $('select[name=sv-cus-id]').val();
        cond.search_operator = $('select[name=so-cus-id]').val();
        if (cond.search_operator != '' && cond.search_value.length > 0) {
            search_cond.push(cond);
        }

        //get qp-amount-tax search cond
        cond = {};
        cond.search_name = 'qp-amount-tax';
        cond.search_value = numeral($('input[name=sv-qp-amount-tax]').val()).format('0');
        cond.search_operator = $('select[name=so-qp-amount-tax]').val();
        if (cond.search_operator != '' && cond.search_value != '') {
            search_cond.push(cond);
        }

        //get qp-note search cond
        cond = {};
        cond.search_name = 'qp-note';
        cond.search_value = $('textarea[name=sv-qp-note]').val();
        cond.search_operator = $('select[name=so-qp-note]').val();
        if (cond.search_operator != '') {
            search_cond.push(cond);
        }

        //get sale-step search cond
        cond = {};
        cond.search_name = 'sale-step';
        cond.search_value = $('select[name=sv-sale-step]').val();
        cond.search_operator = $('select[name=so-sale-step]').val();
        if (cond.search_operator != '' && cond.search_value.length > 0) {
            search_cond.push(cond);
        }

        return search_cond;
    }

    jQuery(document).ready(function () {

        $("#sv-qp-code").tagEditor({forceLowercase: false});

        //--begin [sale-step]--
        $('#drd-menu-sale-step').on('hide.bs.dropdown', function () {

            var drd_menu_items = $("#drd-menu-items-sale-step");
            var checked_list = get_drd_menu_checked_list(drd_menu_items);
            set_drd_menu_tags_sale_step(checked_list);

            var drd_sale_step = $("#drd-sale-step");
            set_multiple_drd_val(drd_sale_step, checked_list);
        })
        $('#drd-menu-sale-step').on('show.bs.dropdown', function () {

            var drd_sale_step = $("#drd-sale-step");
            var drd_items = get_multiple_drd_items(drd_sale_step);
            set_drd_menu_items_sale_step(drd_items);
        })
        //--end [sale-step]--

        //--begin [cus]--
        $('#drd-menu-cus').on('hide.bs.dropdown', function () {

            var drd_menu_items = $("#drd-menu-items-cus");
            var checked_list = get_drd_menu_checked_list(drd_menu_items);
            set_drd_menu_tags_cus(checked_list);

            var drd_cus = $("#drd-cus");
            set_multiple_drd_val(drd_cus, checked_list);
        })
        $('#drd-menu-cus').on('show.bs.dropdown', function () {

            var drd_cus = $("#drd-cus");
            var drd_items = get_multiple_drd_items(drd_cus);
            set_drd_menu_items_cus(drd_items);
        })
        //--end [cus]--

        //--begin [user]--
        $('#drd-menu-user').on('hide.bs.dropdown', function () {

            var drd_menu_items = $("#drd-menu-items-user");
            var checked_list = get_drd_menu_checked_list(drd_menu_items);
            set_drd_menu_tags_user(checked_list);

            var drd_user = $("#drd-user");
            set_multiple_drd_val(drd_user, checked_list);
        })
        $('#drd-menu-user').on('show.bs.dropdown', function () {

            var drd_user = $("#drd-user");
            var drd_items = get_multiple_drd_items(drd_user);
            set_drd_menu_items_user(drd_items);
        })
        //--end [user]--

        $.fn.datepicker.language['vi'] = {
            days: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
            daysShort: ['CN', 'Th 2', 'Th 3', 'Th 4', 'Th 5', 'Th 6', 'Th 7'],
            daysMin: ['CN', 'Th 2', 'Th 3', 'Th 4', 'Th 5', 'Th 6', 'Th 7'],
            months: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            monthsShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            today: 'Hôm nay',
            clear: 'Xóa'
        };

        $('.date-picker').datepicker({
            language: 'vi',
            autoClose: true,
            dateFormat: 'yyyy/mm/dd',
            firstDay: 1
        });
    });
</script>