function goToInputPage(id, self) {
    jQuery("#o-put").hide();
    jQuery("#i-put").fadeIn("slow");
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
}

function goBackToOutputPage(self) {

    jQuery("#o-put").fadeIn("slow");
    jQuery("#i-put").hide();
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
}

function refreshOutputPage(self) {
    ubizapis('v1', '/users', 'get', null, {'page': 0}, renderDataToOutPut);
}

function sort(self){

    var sort_name = jQuery(self).attr('sort-name');
    var order_by = jQuery(self).attr('order-by') == 'asc' ? 'desc' : 'asc';
    var sort = sort_name + "_" + order_by;

    jQuery("#o-put").find('div.dWT').removeClass('dWT');
    jQuery(self).attr('order-by', order_by);
    jQuery(self).addClass('dWT');

    ubizapis('v1', '/users', 'get', null, {'page': 0, 'sort': sort}, renderDataToOutPut);
}

function getSortInfo(){
    var sort_obj = jQuery("#o-put").find('div.dWT');
    var sort_name = sort_obj.attr('sort-name');
    var order_by = sort_obj.attr('order-by') == 'asc' ? 'desc' : 'asc';
    return {'sort_name': sort_name, 'order_by': order_by};
}

function getOlderData(page) {
    ubizapis('v1', '/users', 'get', null, {'page': page}, renderDataToOutPut);
}

function getNewerData(page) {
    ubizapis('v1', '/users', 'get', null, {'page': page}, renderDataToOutPut);
}

function delCheckedData() {
    var ids = getCheckedRows();
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
                ubizapis('v1', '/users/' + ids.join(','), 'delete', null, null, delCheckedDataCallback);
                break;
        }
    });
}

function delCheckedDataCallback(response) {
    if (response.data.success == true) {
        renderDataToOutPut(response);
        swal(response.data.message, {
            icon: "success",
        });
    } else {
        swal(response.data.message, {
            icon: "error",
        });
    }
}

function renderDataToOutPut(response) {
    var table_html = "";
    var users = response.data.users;
    if (users.length > 0) {
        var rows = [];
        for (let i = 0; i < users.length; i++) {
            var cols = [];
            cols.push(renderColHtml(users[i].id, users[i].code, 1));
            cols.push(renderColHtml(users[i].id, users[i].name, 2));
            cols.push(renderColHtml(users[i].id, users[i].email, 3));
            cols.push(renderColHtml(users[i].id, users[i].phone, 4));
            cols.push(renderColHtml(users[i].id, users[i].dep_name, 5));
            cols.push(renderColHtml(users[i].id, users[i].address, 6));
            rows.push(renderRowHtml(users[i].id, cols));
        }
        table_html += rows.join("");
    }
    jQuery("#table-content").empty();
    jQuery("#table-content").append(table_html);
    chkFReCheckStatus();
    paging(response.data.paging.page, response.data.paging.rows_num, response.data.paging.rows_per_page);
}

function renderRowHtml(id, cols) {
    var row_html = '';
    if (cols.length > 0) {
        row_html = '<div class="jvD" ondblclick="goToInputPage(' + id + ',this)">';
        row_html += cols.join("");
        row_html += '</div>';
    }
    return row_html;
}

function renderColHtml(col_id, col_val, col_idx) {
    var col_html = "";
    col_html += '<div class="tcB col-' + col_idx + '">';
    col_html += '<div class="cbo">';
    if (col_idx == 1) {
        col_html += '<div class="jgQ" onclick="chkCClick(this)">';
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
}

jQuery(document).ready(function () {
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
});