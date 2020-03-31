var prod_row_no = 1;
var max_integer = 2147483647;
var max_double = 9223372036854775807;
var sidebar_scrollbars = null;
var input_scrollbars = null;

function my_collapse(self) {
    var next_ele = $(self).next('div');
    next_ele.on('hidden.bs.collapse', function () {
        w_update_scrollbars(input_scrollbars);
    })
    next_ele.on('shown.bs.collapse', function () {
        w_update_scrollbars(input_scrollbars);
    });
    next_ele.collapse('toggle');
}

function prod_row_copy(self) {

    prod_row_no++;
    var dt_prod_specs_mce_id = "dt_prod_specs_mce_" + prod_row_no;
    var tinymce_selector = "#" + dt_prod_specs_mce_id;
    var dt_prod_series_id = "dt_prod_series_" + prod_row_no;
    var tagEditor_selector = "#" + dt_prod_series_id;

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

    clone_row.find('ul.tag-editor').remove();
    clone_row.find('textarea[name=dt_prod_series]').attr('id', dt_prod_series_id);
    clone_row.find('textarea[name=dt_prod_series]').text('');
    clone_row.find('textarea[name=dt_prod_series]').removeClass('tag-editor-hidden-src');

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
            w_update_scrollbars(input_scrollbars);
            $(tagEditor_selector).tagEditor();
        },
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor searchreplace visualblocks code fullscreen insertdatetime media table paste code wordcount autoresize'
        ],
        toolbar: 'undo redo | bold italic forecolor backcolor | formatselect | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
        content_css: [
            '/fonts/roboto/v18/roboto.css'
        ]
    });
}

function prod_row_add() {

    prod_row_no++;
    var dt_prod_specs_mce_id = "dt_prod_specs_mce_" + prod_row_no;
    var tinymce_selector = "#" + dt_prod_specs_mce_id;
    var dt_prod_series_id = "dt_prod_series_" + prod_row_no;
    var tagEditor_selector = "#" + dt_prod_series_id;
    var copy_row = $("#dt-prod").find('div.dt-row:first');
    var clone_row = copy_row.clone(true)

    clone_row.find('div.tox-tinymce').remove();
    clone_row.find('textarea[name=dt_prod_specs_mce]').attr('id', dt_prod_specs_mce_id);
    clone_row.find('textarea[name=dt_prod_specs_mce]').text('');
    clone_row.find('textarea[name=dt_prod_specs_mce]').removeAttr('style');
    clone_row.find('textarea[name=dt_prod_specs_mce]').removeAttr('aria-hidden');

    clone_row.find('ul.tag-editor').remove();
    clone_row.find('textarea[name=dt_prod_series]').attr('id', dt_prod_series_id);
    clone_row.find('textarea[name=dt_prod_series]').text('');
    clone_row.find('textarea[name=dt_prod_series]').removeClass('tag-editor-hidden-src');

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
            w_update_scrollbars(input_scrollbars);
            $(tagEditor_selector).tagEditor();
            prod_row_set_no();
        },
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor searchreplace visualblocks code fullscreen insertdatetime media table paste code wordcount autoresize'
        ],
        toolbar: 'undo redo | bold italic forecolor backcolor | formatselect | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
        content_css: [
            '/fonts/roboto/v18/roboto.css'
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
    w_update_scrollbars(input_scrollbars);
}

function prod_row_clean(row) {

    row.attr('dt_id', '0');
    var tinymce_selector = row.find('textarea[name=dt_prod_specs_mce]').attr('id');
    if (tinyMCE.get(tinymce_selector) != null) {
        tinyMCE.get(tinymce_selector).setContent('');
    }
    row.find('textarea[name=dt_prod_specs_mce]').val("")
    row.find("input[name=dt_prod_model]").val('');

    var dt_prod_series_id = row.find('textarea[name=dt_prod_series]').attr('id');
    var tagEditor_selector = "#" + dt_prod_series_id;

    var tagEditor = $(tagEditor_selector).tagEditor('getTags');
    if (tagEditor.length == 1) {
        var tags = typeof tagEditor[0].tags == "undefined" ? new Array() : tagEditor[0].tags;
        for (i = 0; i < tags.length; i++) {
            $(tagEditor_selector).tagEditor('removeTag', tags[i]);
        }
    }
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
    data.dt_quantity = numeral(row.find("input[name=dt_quantity]").val()).value();
    data.dt_delivery_time = row.find("textarea[name=dt_delivery_time]").val();
    data.dt_status = row.find("select[name=dt_status]").val();
    data.dt_price = numeral(row.find("input[name=dt_price]").val()).value();
    data.dt_amount = numeral(row.find("input[name=dt_amount]").val()).value();
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
    w_update_scrollbars(input_scrollbars);
    copy_row.next('div.dt-row').find('input[name=dt_acce_code]').focus();
    copy_row.next('div.dt-row').attr('dt_id', '0');

    var dt_amount_total = dt_get_amount_total();
    var ord_tax = numeral($("input[name=ord_tax]").val()).value();
    var dt_amount_tax_total = dt_amount_total + (dt_amount_total * ord_tax / 100);
    ord_set_total(dt_amount_total, dt_amount_tax_total);
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
    w_update_scrollbars(input_scrollbars);
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
    w_update_scrollbars(input_scrollbars);

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
    data.dt_quantity = numeral(row.find("input[name=dt_quantity]").val()).value();
    data.dt_delivery_time = row.find("textarea[name=dt_delivery_time]").val();
    data.dt_status = row.find("select[name=dt_status]").val();
    data.dt_price = numeral(row.find("input[name=dt_price]").val()).value();
    data.dt_amount = numeral(row.find("input[name=dt_amount]").val()).value();
    data.dt_type = '2';

    return data;

}

function acce_row_set_data(row, data) {
    row.attr('dt_id', data.dt_id);
    row.find("input[name=dt_acce_code]").val(data.dt_acce_code);
    row.find("input[name=dt_acce_name]").val(data.dt_acce_name);
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

function dt_row_colect_data() {

    var dt_rows = new Array();

    var dt_prod_rows = $("#dt-prod").find('div.dt-row');
    $.each(dt_prod_rows, function (idx, row) {

        var dt_prod_row_data = prod_row_get_data($(row));
        dt_prod_row_data.dt_sort_no = idx + 1;
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
        dt_acce_row_data.dt_sort_no = idx + 1;
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

function ord_exp_date_change(self) {

    var ord_exp_date = $(self).val();
    if (ord_exp_date == '') {

        var ord_exp_date_old = $('input[name=ord_exp_date_old]').val();
        $(self).val(ord_exp_date_old);

        var message = i18next.t("QP Exp Date is required.");
        swal({
            type: 'error',
            text: message
        });
        return false;
    }

    if (moment(ord_exp_date).isValid() == false) {
        var ord_exp_date_old = $('input[name=ord_exp_date_old]').val();
        $(self).val(ord_exp_date_old);

        var message = i18next.t("QP Date is wrong format YYYY/MM/DD");
        swal({
            type: 'error',
            text: message
        });
        return false;
    }

    ord_exp_date = moment(ord_exp_date).format('YYYY/MM/DD');
    $(self).val(ord_exp_date);
    $('input[name=ord_exp_date_old]').val(ord_exp_date);
}

function ord_dlv_date_change(self) {

    var ord_dlv_date = $(self).val();
    if (ord_dlv_date == '') {

        var ord_dlv_date_old = $('input[name=ord_dlv_date_old]').val();
        $(self).val(ord_dlv_date_old);

        var message = i18next.t("QP Exp Date is required.");
        swal({
            type: 'error',
            text: message
        });
        return false;
    }

    if (moment(ord_dlv_date).isValid() == false) {
        var ord_dlv_date_old = $('input[name=ord_dlv_date_old]').val();
        $(self).val(ord_dlv_date_old);

        var message = i18next.t("QP Date is wrong format YYYY/MM/DD");
        swal({
            type: 'error',
            text: message
        });
        return false;
    }

    ord_dlv_date = moment(ord_dlv_date).format('YYYY/MM/DD');
    $(self).val(ord_dlv_date);
    $('input[name=ord_dlv_date_old]').val(ord_dlv_date);
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

function ord_colect_data() {
    var data = {};
    data.ord_id = $("input[name=ord_id]").val();
    data.ord_no = $("input[name=ord_no]").val();
    data.ord_date = $("input[name=ord_date]").val();
    data.ord_exp_date = $("input[name=ord_exp_date]").val();
    data.ord_dlv_date = $("input[name=ord_dlv_date]").val();
    data.ord_note = $("textarea[name=ord_note]").val();
    data.ord_tax = numeral($("input[name=ord_tax]").val()).value();
    data.ord_amount = numeral($("input[name=ord_amount]").val()).value();
    data.ord_amount_tax = numeral($("input[name=ord_amount_tax]").val()).value();
    data.ord_rel_fee = numeral($("input[name=ord_relate_fee]").val()).value();
    data.ord_debt = numeral($("input[name=ord_debt]").val()).value();
    data.ord_pay_met = $("textarea[name=ord_pay_met]").val();
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

function ord_back_to_output() {
    window.location.href = "/orders";
}

function ord_save() {
    swal({
        title: i18next.t('Do you want to save the data.?'),
        type: 'question',
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
            ubizapis('v1', '/orders/' + data.order.ord_id + '/update', 'post', {'data': data}, null, ord_save_callback);
        }
    })
}

function ord_save_callback(response) {
    if (response.data.success == true) {
        swal.fire({
            type: 'success',
            title: response.data.message,
            onClose: () => {
                ord_back_to_output();
            }
        })

    } else {
        swal.fire({
            type: 'error',
            title: response.data.message
        })
    }
}

function ord_delete() {
    swal({
        title: i18next.t('Do you want to delete the data?'),
        type: 'question',
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

function ord_delete_callback(response) {
    if (response.data.success == true) {
        swal.fire({
            type: 'success',
            title: response.data.message,
            onClose: () => {
                ord_back_to_output();
            }
        })

    } else {
        swal.fire({
            type: 'error',
            title: response.data.message
        })
    }
}

function ord_refresh() {
    swal({
        title: i18next.t('Do you want to refresh the data.?'),
        type: 'question',
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

function w_sleep_scrollbars(instance) {
    if (typeof instance == "undefined")
        return false;
    instance.sleep();
}

function w_update_scrollbars(instance) {

    if (typeof instance == "undefined")
        return false;
    instance.update();
}

function ord_contract_step(){
    swal({
        title: i18next.t('Do you want to confirm contract status.?'),
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: i18next.t('No'),
        confirmButtonText: i18next.t('Yes'),
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            var ord_id = $("input[name=ord_id]").val();
            var ordt_ids = getSelectedPump();
            ubizapis('v1', '/contracts/' + ord_id + '/create', 'post', {ordt_ids: ordt_ids}, null, ord_contract_step_callback);
        }
    })
}

function ord_contract_step_callback(response) {
    if (response.data.success == true) {
        swal.fire({
            type: 'success',
            title: response.data.message,
            onClose: () => {
                window.location.href = window.location.origin + "/contracts"
            }
        })

    } else {
        swal.fire({
            type: 'error',
            title: response.data.message
        })
    }
}

function ord_delivery_step(){
    swal({
        title: i18next.t('Do you want to confirm delivery status.?'),
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: i18next.t('No'),
        confirmButtonText: i18next.t('Yes'),
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            var ord_id = $("input[name=ord_id]").val();
            ubizapis('v1', '/orders/' + ord_id + '/salestep', 'post', {'sale_step': '4'}, null, ord_delivery_step_callback);
        }
    })
}

function ord_delivery_step_callback(response) {
    if (response.data.success == true) {
        swal.fire({
            type: 'success',
            title: response.data.message,
            onClose: () => {
                window.location.reload();
            }
        })

    } else {
        swal.fire({
            type: 'error',
            title: response.data.message
        })
    }
}

function getSelectedPump() {
    var lstIds = [];
    $(".sck").each(function(index, divContainer) {
        var checkbox = $(divContainer).parent().find(".checkbox_field");
        var container = null;

        if (checkbox.attr("id").indexOf("pump") > -1) {
            container = checkbox.closest(".row_container_pump");
            lstIds.push(container.find(".dt-row").attr("dt_id"));
        } else if (checkbox.attr("id").indexOf("acs") > -1) {
            container = checkbox.closest(".row_container_acs");
            lstIds.push(container.find(".dt-row").attr("dt_id"));
        }
    })
    return lstIds;
}

$(document).ready(function () {

    prod_row_no = $("#dt-prod").find('div.dt-row').length;

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        w_update_scrollbars(input_scrollbars);
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
            '/fonts/roboto/v18/roboto.css'
        ]
    });
    sidebar_scrollbars = fnc_set_scrollbars("nicescroll-sidebar");
    input_scrollbars = fnc_set_scrollbars("nicescroll-iput");
    fnc_datepicker('#ord_date');
    fnc_datepicker('#ord_exp_date');
    fnc_datepicker('#ord_dlv_date');
    $("textarea[name=dt_prod_series]").tagEditor();
    jQuery('.utooltip').tooltipster({
        side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
    });
    $("a[name=quoteprice_step]").on("click", function () {
        var qp_id = $('input[name=qp_id]').val();
        window.location.href = "/quoteprices/" + qp_id;
    });
    $("a[name=contract_step]").on("click", function () {
        ord_contract_step();
    });
    $("a[name=delivery_step]").on("click", function () {
        ord_delivery_step();
    });
});