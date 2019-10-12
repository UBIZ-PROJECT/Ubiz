var prod_spec_no = 1;
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
    var qp_tax = numeral($("input[name=qp_tax]").val()).value();
    var dt_amount_tax_total = dt_amount_total + (dt_amount_total * qp_tax / 100);
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
            add_row.find('input[name=dt_unit]').focus();
            qp_set_total(dt_amount_total, dt_amount_tax_total);
            w_update_scrollbars(input_scrollbars);
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

            add_row.find('input[name=dt_unit]').focus();

            prod_row_set_no();
            w_update_scrollbars(input_scrollbars);
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
    var qp_tax = numeral($("input[name=qp_tax]").val()).value();
    var dt_amount_tax_total = dt_amount_total + (dt_amount_total * qp_tax / 100);
    qp_set_total(dt_amount_total, dt_amount_tax_total);

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
    row.find("textarea[name=dt_prod_specs_mce]").val(data.dt_prod_specs_mce);
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
        && data.dt_note == ""
        && data.dt_unit == ""
        && (data.dt_quantity == "" || data.dt_quantity == null || data.dt_quantity == "0")
        && data.dt_delivery_time == ""
        && (data.dt_status == "1" || data.dt_status == "")
        && (data.dt_price == "" || data.dt_price == null || data.dt_price == "0")
        && (data.dt_amount == "" || data.dt_amount == null || data.dt_amount == "0")
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
    var qp_tax = numeral($("input[name=qp_tax]").val()).value();
    var dt_amount_tax_total = dt_amount_total + (dt_amount_total * qp_tax / 100);
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
    var qp_tax = numeral($("input[name=qp_tax]").val()).value();
    var dt_amount_tax_total = dt_amount_total + (dt_amount_total * qp_tax / 100);
    qp_set_total(dt_amount_total, dt_amount_tax_total);
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
    var qp_tax = numeral($("input[name=qp_tax]").val()).value();
    var dt_amount_tax_total = dt_amount_total + (dt_amount_total * qp_tax / 100);
    qp_set_total(dt_amount_total, dt_amount_tax_total);
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
        && (data.dt_quantity == "" || data.dt_quantity == null || data.dt_quantity == "0")
        && data.dt_delivery_time == ""
        && (data.dt_status == "1" || data.dt_status == "")
        && (data.dt_price == "" || data.dt_price == null || data.dt_price == "0")
        && (data.dt_amount == "" || data.dt_amount == null || data.dt_amount == "0")
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

    var qp_tax = numeral($("input[name=qp_tax]").val()).value();
    var dt_amount_tax_total = dt_amount_total + (dt_amount_total * qp_tax / 100);
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
    qp_set_total(dt_amount_total, dt_amount_tax_total);

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

    var qp_tax = numeral($("input[name=qp_tax]").val()).value();
    var dt_amount_tax_total = dt_amount_total + (dt_amount_total * qp_tax / 100);
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
    qp_set_total(dt_amount_total, dt_amount_tax_total);
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

    var qp_tax = numeral($("input[name=qp_tax]").val()).value();
    var dt_amount_tax_total = dt_amount_total + (dt_amount_total * qp_tax / 100);
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
    qp_set_total(dt_amount_total, dt_amount_tax_total);
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

function qp_set_total(qp_amount, qp_amount_tax) {

    $('input[name=qp_amount]').val(numeral(qp_amount).format('0,0'));
    $('input[name=qp_amount_tax]').val(numeral(qp_amount_tax).format('0,0'));

    $('input[name=qp_amount_old]').val(numeral(qp_amount).format('0,0'));
    $('input[name=qp_amount_tax_old]').val(numeral(qp_amount_tax).format('0,0'));
}

function qp_no_change(self) {

    var qp_no = $(self).val();
    if (qp_no == '') {

        var qp_no_old = $('input[name=qp_no_old]').val();
        $(self).val(qp_no_old);

        var message = i18next.t("QP No is required.");
        swal({
            type: 'error',
            text: message
        });
        return false;
    }

    $('input[name=qp_no_old]').val(qp_no);
}

function qp_date_change(self) {

    var qp_date = $(self).val();
    if (qp_date == '') {

        var qp_date_old = $('input[name=qp_date_old]').val();
        $(self).val(qp_date_old);

        var message = i18next.t("QP Date is required.");
        swal({
            type: 'error',
            text: message
        });
        return false;
    }

    if (moment(qp_date).isValid() == false) {
        var qp_date_old = $('input[name=qp_date_old]').val();
        $(self).val(qp_date_old);

        var message = i18next.t("QP Date is wrong format YYYY/MM/DD");
        swal({
            type: 'error',
            text: message
        });
        return false;
    }

    qp_date = moment(qp_date).format('YYYY/MM/DD');
    $(self).val(qp_date);
    $('input[name=qp_date_old]').val(qp_date);
}

function qp_exp_date_change(self) {

    var qp_exp_date = $(self).val();
    if (qp_exp_date == '') {

        var qp_exp_date_old = $('input[name=qp_exp_date_old]').val();
        $(self).val(qp_exp_date_old);

        var message = i18next.t("QP Exp Date is required.");
        swal({
            type: 'error',
            text: message
        });
        return false;
    }

    if (moment(qp_exp_date).isValid() == false) {
        var qp_exp_date_old = $('input[name=qp_exp_date_old]').val();
        $(self).val(qp_exp_date_old);

        var message = i18next.t("QP Date is wrong format YYYY/MM/DD");
        swal({
            type: 'error',
            text: message
        });
        return false;
    }

    qp_exp_date = moment(qp_exp_date).format('YYYY/MM/DD');
    $(self).val(qp_exp_date);
    $('input[name=qp_exp_date_old]').val(qp_exp_date);
}

function qp_tax_change(self) {

    var qp_tax = numeral($(self).val()).value();
    if (max_validator(qp_tax, 100, 'integer') == false) {

        var qp_tax_old = numeral($('input[name=qp_tax_old]').val()).format('0,0');
        $(self).val(qp_tax_old);

        var message = i18next.t("System doesn't support tax bigger than :max.", {
            'max': 100
        });
        swal({
            type: 'error',
            text: message
        });
        return false;
    }

    var qp_amount = numeral($('input[name=qp_amount]').val()).value();
    var qp_amount_tax = qp_amount + (qp_amount * qp_tax / 100);
    if (max_validator(qp_amount_tax, max_double, 'double') == false) {

        var qp_tax_old = numeral($('input[name=qp_tax_old]').val()).format('0,0');
        $(self).val(qp_tax_old);

        var message = i18next.t("System doesn't support money bigger than :max.", {
            'max': numeral(max_double).format('0,0')
        });
        swal({
            type: 'error',
            text: message
        });
        return false;
    }
    $('input[name=qp_tax_old]').val(qp_tax);
    qp_set_total(qp_amount, qp_amount_tax);
}

function qp_colect_data() {
    var data = {};
    data.qp_id = $("input[name=qp_id]").val();
    data.qp_no = $("input[name=qp_no]").val();
    data.qp_date = $("input[name=qp_date]").val();
    data.qp_exp_date = $("input[name=qp_exp_date]").val();
    data.qp_note = $("textarea[name=qp_note]").val();
    data.cad_id = $("select[name=qp_cad_id]").val();
    data.sale_id = $("input[name=qp_sale_id]").val();
    data.contact_id = $("input[name=qp_contact_id]").val();
    data.contact_name = $("input[name=qp_contact_name]").val();
    data.contact_rank = $("input[name=qp_contact_rank]").val();
    data.contact_phone = $("input[name=qp_contact_phone]").val();
    data.contact_email = $("input[name=qp_contact_email]").val();
    data.qp_tax = numeral($("input[name=qp_tax]").val()).value();
    data.qp_amount = numeral($("input[name=qp_amount]").val()).value();
    data.qp_amount_tax = numeral($("input[name=qp_amount_tax]").val()).value();
    return data;
}

function qp_rollback_total() {
    var qp_amount_old = numeral($('input[name=qp_amount_old]').val()).format('0,0');
    var qp_amount_tax_old = numeral($('input[name=qp_amount_tax_old]').val()).format('0,0');
    $('input[name=qp_amount]').val(qp_amount_old);
    $('input[name=qp_amount_tax]').val(qp_amount_tax_old);
}

function qp_back_to_output() {
    window.location.href = "/quoteprices";
}

function qp_save() {
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
            data.quoteprice = qp_colect_data();
            data.quoteprice_detail = dt_row_colect_data();
            ubizapis('v1', '/quoteprices/' + data.quoteprice.qp_id + '/update', 'post', {'data': data}, null, qp_save_callback);
        }
    })
}

function qp_save_callback(response) {
    if (response.data.success == true) {
        swal.fire({
            type: 'success',
            title: response.data.message,
            onClose: () => {
                qp_back_to_output();
            }
        })

    } else {
        swal.fire({
            type: 'error',
            title: response.data.message
        })
    }
}

function qp_delete() {
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
            var qp_id = $("input[name=qp_id]").val();
            ubizapis('v1', '/quoteprices/' + qp_id + '/delete', 'delete', null, null, qp_delete_callback);
        }
    })
}

function qp_delete_callback(response) {
    if (response.data.success == true) {
        swal.fire({
            type: 'success',
            title: response.data.message,
            onClose: () => {
                qp_back_to_output();
            }
        })

    } else {
        swal.fire({
            type: 'error',
            title: response.data.message
        })
    }
}

function qp_refresh() {
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

function qp_send() {
    $("#confirm-btn").text('Gửi báo giá');
    $("#confirm-btn").unbind('click');
    $("#confirm-btn").bind('click', function () {

        var md_company = $("#md_company").val();
        var md_language = $("#md_language").val();
        if (md_company == "" || md_language == "") {
            swal.fire({
                type: 'error',
                title: "Xin vui lòng chọn [Công ty] và [Ngôn ngữ].",
                onClose: () => {
                    return false;
                }
            })
            return false;
        }

        var data = qp_get_bussiness_conditions(md_company, md_language);
        data.md_company = md_company;
        data.md_language = md_language;

        var qp_id = $("input[name=qp_id]").val();
        ubizapis('v1', '/quoteprices/' + qp_id + '/send', 'post', {'data': data}, null, qp_send_callback);
    });
    $("#preview-btn").unbind('click');
    $("#preview-btn").bind('click', function () {
        qp_preview();
    });
    $("#confirm-modal").modal('show');
}

function qp_send_callback(response) {
    if (response.data.success == true) {
        swal.fire({
            type: 'success',
            title: response.data.message,
            onClose: () => {
                $("#confirm-modal").modal('hide');
            }
        })

    } else {
        swal.fire({
            type: 'error',
            title: response.data.message
        })
    }
}

function qp_download() {
    $("#confirm-btn").text('Tải xuống');
    $("#confirm-btn").unbind('click');
    $("#confirm-btn").bind('click', function () {

        var md_company = $("#md_company").val();
        var md_language = $("#md_language").val();
        if (md_company == "" || md_language == "") {
            swal.fire({
                type: 'error',
                title: "Xin vui lòng chọn [Công ty] và [Ngôn ngữ].",
                onClose: () => {
                    return false;
                }
            })
            return false;
        }

        var data = qp_get_bussiness_conditions(md_company, md_language);
        data.md_company = md_company;
        data.md_language = md_language;

        var qp_id = $("input[name=qp_id]").val();
        ubizapis('v1', '/quoteprices/' + qp_id + '/download', 'post', {'data': data}, null, qp_download_callback);
    });
    $("#preview-btn").unbind('click');
    $("#preview-btn").bind('click', function () {
        qp_preview();
    });
    $("#confirm-modal").modal('show');
}

function qp_get_bussiness_conditions(company, language) {
    var data = {};

    var company_nm = company == '1' ? 'tk' : 'ht';

    data.md_project = $("#md_project_" + language).val();
    data.md_value = $("#md_value_" + language).val();
    data.md_warranty = $("#md_warranty_" + language).val();
    data.md_payment = $("#md_payment_" + language).val();
    data.md_delivery = $("#md_delivery_" + language).val();
    data.md_account = $("#md_account_" + company_nm + "_" + language).val();
    return data;
}

function qp_download_callback(response) {
    if (response.data.success == true) {
        $("#confirm-modal").modal('hide');
        var qp_id = $("input[name=qp_id]").val();
        window.open('/quoteprices/' + qp_id + '/download/' + response.data.uniqid + '/' + response.data.file_name);
    } else {
        swal.fire({
            type: 'error',
            title: response.data.message
        })
    }
}

function qp_preview() {
    var md_company = $("#md_company").val();
    var md_language = $("#md_language").val();
    if (md_company == "" || md_language == "") {
        swal.fire({
            type: 'error',
            title: "Xin vui lòng chọn [Công ty] và [Ngôn ngữ].",
            onClose: () => {
                return false;
            }
        })
        return false;
    }

    var data = qp_get_bussiness_conditions(md_company, md_language);
    data.md_company = md_company;
    data.md_language = md_language;

    var qp_id = $("input[name=qp_id]").val();
    var iframe_url = "http://tkp.local/quoteprices/" + qp_id + "/preview?" + qs.stringify({'params': data});

    var iframe = $("#preview-modal").find('iframe');
    iframe.attr('src', iframe_url);
    iframe.on('load', function() {
        $(".iframe-spinner").addClass('hide');
        iframe.show();
    });
    iframe.hide();
    $(".iframe-spinner").removeClass('hide');
    $("#preview-modal").modal('show');
}

function qp_create_order() {
    swal({
        title: i18next.t('Do you want to create order the data.?'),
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: i18next.t('No'),
        confirmButtonText: i18next.t('Yes'),
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            var qp_id = $("input[name=qp_id]").val();
            ubizapis('v1', '/orders/' + qp_id + '/create', 'post', null, null, qp_create_order_callback);
        }
    })
}

function qp_create_order_callback(response) {
    if (response.data.success == true) {
        var ord_id = response.data.ord_id;
        swal.fire({
            type: 'success',
            title: response.data.message,
            onClose: () => {
                window.location.href = "/orders/" + ord_id;
            }
        })

    } else {
        swal.fire({
            type: 'error',
            title: response.data.message
        })
    }
}

function qp_render_drd_contact() {
    var drd_html = "";
    if (con_list.length > 0) {

        var qp_contact_id = $("input[name=qp_contact_id]").val();

        $.map(con_list, function (contact, idx) {

            var itm_active = "";
            if (qp_contact_id == contact.con_id) {
                itm_active = "active";
            }

            drd_html += '<a con_id="' + contact.con_id + '" class="dropdown-item ' + itm_active + ' media pdl-5" href="#" onClick="qp_drd_contact_select(this, event)">';
            drd_html += '<div style="width: 30px; height: 30px" class="mr-3">';

            if (contact.con_avatar_base64 == '') {
                drd_html += '<img src="' + deafult_profile + '" class="img-fluid img-thumbnail" alt="">';
            } else {
                drd_html += '<img src="' + contact.con_avatar_base64 + '" class="img-fluid img-thumbnail" alt="">';
            }

            drd_html += '</div>';
            drd_html += '<div class="media-body" style="height: 30px; line-height: 5px">';
            drd_html += '<h6 class="mt-0 mb-1">' + html_escape(contact.con_name) + '</h6>';
            drd_html += '<small>' + html_escape(contact.con_rank) + '</small>';
            drd_html += '</div>';
            drd_html += '</a>';
        });
    } else {
        drd_html = '<div style="margin: 10px 15px"><h5>Không có người liên hệ.</h5></div>';
    }
    drd_html += '<div class="dropdown-divider"></div>';
    drd_html += '<div class="w-100 text-right">';
    drd_html += '<button type="button" class="btn btn-link btn-sm text-primary text-right" onclick="qp_drd_contact_clear(event)">Xóa</button>';
    drd_html += '</div>';

    $("#qp_contact_name_drd_menu").empty();
    $("#qp_contact_name_drd_menu").html(drd_html);
}

function qp_drd_contact_select(self, event) {
    var con_id = $(self).attr('con_id');
    var contact = qp_get_selected_contact(con_id);
    if (contact == null)
        return false;
    qp_set_contact_form(contact);
}

function qp_drd_contact_clear(event) {
    event.stopPropagation();
    $("input[name=qp_contact_id]").val('');
    $("input[name=qp_contact_name]").val('');
    $("input[name=qp_contact_rank]").val('');
    $("input[name=qp_contact_phone]").val('');
    $("input[name=qp_contact_email]").val('');
    $('#qp_contact_name_drd').dropdown('hide');
}

function qp_get_selected_contact(con_id) {
    var contact = _.find(con_list, function (o) {
        return o.con_id == con_id;
    });
    if (typeof contact === 'undefined')
        return null;
    return contact;
}

function qp_set_contact_form(contact) {
    $("input[name=qp_contact_id]").val(contact.con_id);
    $("input[name=qp_contact_name]").val(contact.con_name);
    $("input[name=qp_contact_rank]").val(contact.con_rank);
    $("input[name=qp_contact_phone]").val(contact.con_phone);
    $("input[name=qp_contact_email]").val(contact.con_mail);
}

function qp_render_drd_sale() {
    var drd_html = "";
    if (sale_list.length > 0) {

        var qp_sale_id = $("input[name=qp_sale_id]").val();

        $.map(sale_list, function (sale, idx) {

            var itm_active = "";
            if (qp_sale_id == sale.id) {
                itm_active = "active";
            }

            drd_html += '<a sale_id="' + sale.id + '" class="dropdown-item ' + itm_active + ' media pdl-5" href="#" onClick="qp_drd_sale_select(this, event)">';
            drd_html += '<div style="width: 30px; height: 30px" class="mr-3">';

            if (sale.avatar_base64 == '') {
                drd_html += '<img src="' + deafult_profile + '" class="img-fluid img-thumbnail" alt="">';
            } else {
                drd_html += '<img src="' + sale.avatar_base64 + '" class="img-fluid img-thumbnail" alt="">';
            }

            drd_html += '</div>';
            drd_html += '<div class="media-body" style="height: 30px; line-height: 5px">';
            drd_html += '<h6 class="mt-0 mb-1">' + html_escape(sale.name) + '</h6>';
            drd_html += '<small>' + html_escape(sale.rank) + '</small>';
            drd_html += '</div>';
            drd_html += '</a>';
        });
    } else {
        drd_html = '<div style="margin: 10px 15px"><h5>Không có nhân viên phụ trách.</h5></div>';
    }
    drd_html += '<div class="dropdown-divider"></div>';
    drd_html += '<div class="w-100 text-right">';
    drd_html += '<button type="button" class="btn btn-link btn-sm text-primary text-right" onclick="qp_drd_sale_clear(event)">Xóa</button>';
    drd_html += '</div>';

    $("#qp_sale_name_drd_menu").empty();
    $("#qp_sale_name_drd_menu").html(drd_html);
}

function qp_drd_sale_select(self, event) {
    var sale_id = $(self).attr('sale_id');
    var sale = qp_get_selected_sale(sale_id);
    if (sale == null)
        return false;
    qp_set_sale_form(sale);
}

function qp_drd_sale_clear(event) {
    event.stopPropagation();
    $("input[name=qp_sale_id]").val('');
    $("input[name=qp_sale_name]").val('');
    $("input[name=qp_sale_rank]").val('');
    $("input[name=qp_sale_phone]").val('');
    $("input[name=qp_sale_email]").val('');
    $('#qp_sale_name_drd').dropdown('hide');
}

function qp_get_selected_sale(sale_id) {
    var sale = _.find(sale_list, function (o) {
        return o.id == sale_id;
    });
    if (typeof sale === 'undefined')
        return null;
    return sale;
}

function qp_set_sale_form(sale) {
    $("input[name=qp_sale_id]").val(sale.id);
    $("input[name=qp_sale_name]").val(sale.name);
    $("input[name=qp_sale_rank]").val(sale.rank);
    $("input[name=qp_sale_phone]").val(sale.phone);
    $("input[name=qp_sale_email]").val(sale.email);
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

$(document).ready(function () {

    prod_spec_no = $("#dt-prod").find('div.dt-row').length;

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
    fnc_datepicker('#qp_date');
    fnc_datepicker('#qp_exp_date');
    jQuery('.utooltip').tooltipster({
        side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
    });
    $("a[name=order_step]").on("click", function () {
        var ord_id = numeral($("input[name=ord_id]").val()).value();
        if (ord_id > 0) {
            window.location.href = "/orders/" + ord_id;
        } else {
            qp_create_order();
        }
    });
    $("#md_company").on("change", function () {
        var company = $(this).val() == '1' ? 'tk' : 'ht';
        var lang = $("#md_language").val();
        if (lang == 'vn') {
            $("#md_content_vn").show();
            $("#md_content_en").hide();
            if (company == 'tk') {
                $("#div_md_account_tk_vn").show();
                $("#div_md_account_ht_vn").hide();
            } else {
                $("#div_md_account_tk_vn").hide();
                $("#div_md_account_ht_vn").show();
            }
        } else {
            $("#md_content_vn").hide();
            $("#md_content_en").show();
            if (company == 'tk') {
                $("#div_md_account_tk_en").show();
                $("#div_md_account_ht_en").hide();
            } else {
                $("#div_md_account_tk_en").hide();
                $("#div_md_account_ht_en").show();
            }
        }
    });
    $("#md_language").on("change", function () {
        var company = $("#md_company").val() == '1' ? 'tk' : 'ht';
        var lang = $(this).val();
        if (lang == 'vn') {
            $("#md_content_vn").show();
            $("#md_content_en").hide();
            if (company == 'tk') {
                $("#div_md_account_tk_vn").show();
                $("#div_md_account_ht_vn").hide();
            } else {
                $("#div_md_account_tk_vn").hide();
                $("#div_md_account_ht_vn").show();
            }
        } else {
            $("#md_content_vn").hide();
            $("#md_content_en").show();
            if (company == 'tk') {
                $("#div_md_account_tk_en").show();
                $("#div_md_account_ht_en").hide();
            } else {
                $("#div_md_account_tk_en").hide();
                $("#div_md_account_ht_en").show();
            }
        }
    });
    $('#qp_contact_name_drd').on('show.bs.dropdown', function () {
        qp_render_drd_contact();
    });
    if ($("#qp_sale_name").attr('select') == true) {
        $('#qp_sale_name_drd').on('show.bs.dropdown', function () {
            qp_render_drd_sale();
        });
    }
    $('#preview-modal').on('hidden.bs.modal', function (e) {
        var iframe = $("#preview-modal").find('iframe');
        iframe.attr('src', '');
    })
});