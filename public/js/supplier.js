function goToInputPage(id, self) {
    getSpecificSupplierDetail(id);
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
        autohidemode: 'leave',
        horizrailenabled: false
    });
}

function goBackToOutputPage(self) {
    jQuery("#o-put").fadeIn("slow");
    jQuery("#i-put").hide();
    jQuery('#nicescroll-iput').getNiceScroll().remove();
    jQuery('#nicescroll-oput').getNiceScroll().remove();
    jQuery('#nicescroll-oput').niceScroll({
        cursorcolor: "#9fa8b0",
        cursorwidth: "5px",
        cursorborder: "none",
        cursorborderradius: 5,
        cursoropacitymin: 0.4,
        autohidemode: 'leave',
        horizrailenabled: false
    });
}

function chkFClick(self) {
    var o_put = jQuery("#o-put");
    if (jQuery(self).find('div.ckb-f').hasClass('asU')) {
        o_put.find('.ckb-f').removeClass('asU');
        o_put.find('.ckb-f').removeClass('asP');
        o_put.find('.ckb-f').addClass('asC');
        o_put.find('.ckb-c').removeClass('asU');
        o_put.find('.ckb-c').addClass('asC');
        o_put.find('.ckb-i').prop('checked', true);
    } else {
        o_put.find('.ckb-f').removeClass('asC');
        o_put.find('.ckb-f').removeClass('asP');
        o_put.find('.ckb-f').addClass('asU');
        o_put.find('.ckb-c').removeClass('asC');
        o_put.find('.ckb-c').addClass('asU');
        o_put.find('.ckb-i').prop('checked', false);
    }
}

function chkCClick(self) {
    if (jQuery(self).find('.ckb-c').hasClass('asU')) {
        jQuery(self).find('.ckb-c').removeClass('asU');
        jQuery(self).find('.ckb-c').addClass('asC');
        jQuery(self).find('.ckb-i').prop('checked', true);
    } else {
        jQuery(self).find('.ckb-c').removeClass('asC');
        jQuery(self).find('.ckb-c').addClass('asU');
        jQuery(self).find('.ckb-i').prop('checked', false);
    }
    chkFReCheckStatus();
}

function chkFReCheckStatus(){
    var o_put = jQuery("#o-put");
    var row_length = o_put.find('.jvD').length;
    var checked_row_length = o_put.find('.ckb-i:checked').length;
    if(row_length == checked_row_length){
        o_put.find('.ckb-f').removeClass('asU');
        o_put.find('.ckb-f').removeClass('asP');
        o_put.find('.ckb-f').addClass('asC');
    }else{
        if(checked_row_length == 0){
            o_put.find('.ckb-f').removeClass('asC');
            o_put.find('.ckb-f').removeClass('asP');
            o_put.find('.ckb-f').addClass('asU');
        }else{
            o_put.find('.ckb-f').removeClass('asC');
            o_put.find('.ckb-f').removeClass('asU');
            o_put.find('.ckb-f').addClass('asP');
        }
    }
}

function refreshOutputPage(self) {
    ubizapis('v1', '/suppliers', 'get', null, {'page': 0}, renderDataToOutPut);
}

function getOlderData(){
    ubizapis('v1', '/suppliers', 'get', null, {'page': 0}, renderDataToOutPut);
}

function getNewerData(){
    ubizapis('v1', '/suppliers', 'get', null, {'page': 0}, renderDataToOutPut);
}

function getSpecificSupplierDetail(id) {
    ubizapis('v1','/suppliers/' + id, 'get', null, {'page': 0},renderDataToInput);
}

function renderDataToInput(response) {
    data = response.data[0];
    $("#nicescroll-iput .sup_id .control").html(data.sup_id);
    $("#nicescroll-iput .sup_name .control").html(data.sup_name);
    $("#nicescroll-iput .sup_website .control").html(data.sup_website);
    $("#nicescroll-iput .sup_phone .control").html(data.sup_phone);
    $("#nicescroll-iput .sup_fax .control").html(data.sup_fax);
    $("#nicescroll-iput .sup_mail .control").html(data.sup_mail);
}

function renderDataToOutPut(response) {
    var table_html = "";
    var data = response.data;
    if (data.length > 0) {
        var rows = [];
        for (let i = 0; i < data.length; i++) {
            var cols = [];
            cols.push(renderColHtml(data[i].id, data[i].sup_id, 1));
            cols.push(renderColHtml(data[i].id, data[i].sup_name, 2));
            cols.push(renderColHtml(data[i].id, data[i].sup_website, 3));
            cols.push(renderColHtml(data[i].id, data[i].sup_phone, 4));
            cols.push(renderColHtml(data[i].id, data[i].sup_fax, 5));
            cols.push(renderColHtml(data[i].id, data[i].sup_mail, 6));
            rows.push(renderRowHtml(data[i].id, cols));
        }
        table_html += rows.join("");
    }
    jQuery("#table-content").empty();
    jQuery("#table-content").append(table_html);
    chkFReCheckStatus();
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
        autohidemode: 'leave',
        horizrailenabled: false
    });
    jQuery('#nicescroll-oput').niceScroll({
        cursorcolor: "#9fa8b0",
        cursorwidth: "5px",
        cursorborder: "none",
        cursorborderradius: 5,
        cursoropacitymin: 0.4,
        autohidemode: 'leave',
        horizrailenabled: false
    });
    jQuery('.utooltip').tooltipster({
        side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
    });
});