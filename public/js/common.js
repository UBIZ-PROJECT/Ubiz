function showProgress(){
    var progress = jQuery('.ubiz-progress');
    if(progress.length == 0){
        var progress_dom = '<div class="ubiz-progress">Đang xử lý...</div>';
        jQuery('body').append(progress_dom);
        progress = jQuery('.ubiz-progress');
    }
    progress.show();
}

function hideProgress(){
    var progress = jQuery('.ubiz-progress');
    if(progress.length == 1){
        progress.hide();
    }
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

function getCheckedRows(){
    var ids = [];
    var checked_rows = jQuery("#o-put").find('.ckb-i:checked');
    checked_rows.each(function (idx, ele) {
        var id = ele.value;
        ids.push(id);
    });
    return ids;
}

function paging(page, rows_num, rows_per_page) {

    var page = parseInt(page);
    var f_num = (page * rows_per_page) + 1;
    var m_num = (page + 1) * rows_per_page;
    if (m_num > rows_num) m_num = rows_num;

    var older_page = page - 1;
    var newer_page = page + 1;

    var max_page = Math.ceil(rows_num / rows_per_page);

    var get_older_data_func = '';
    var get_newer_data_func = '';

    var older_css = 'adS';
    if (older_page > -1) {
        older_css = 'aaT';
        get_older_data_func = 'onclick="getOlderData(' + older_page + ')"';
    }

    var newer_css = 'adS';
    if (newer_page < max_page) {
        newer_css = 'aaT';
        get_newer_data_func = 'onclick="getNewerData(' + newer_page + ')"';
    }

    var paging_label = '<div id="paging-label" class="amH" style="user-select: none"><span class="Dj"><span><span class="ts">' + f_num + '</span>–<span class="ts">' + m_num + '</span></span> / <span class="ts">' + rows_num + '</span></span></div>';
    var paging_older = '<div id="paging-older" ' + get_older_data_func + ' class="amD utooltip" title="Cũ hơn"><span class="amF">&nbsp;</span><img class="amI ' + older_css + '" src="http://ubiz.local/images/cleardot.gif" alt=""></div>';
    var paging_newer = '<div id="paging-newer" ' + get_newer_data_func + ' class="amD utooltip" title="Mới hơn"><span class="amF">&nbsp;</span><img class="amJ ' + newer_css + '" src="http://ubiz.local/images/cleardot.gif" alt=""></div>';

    jQuery("#paging-label").replaceWith(paging_label);
    jQuery("#paging-older").replaceWith(paging_older);
    jQuery("#paging-newer").replaceWith(paging_newer);
}

// Add a request interceptor
axios.interceptors.request.use(function (options) {
    // Do something before request is sent
    showProgress();
    return options;
}, function (error) {
    // Do something with request error
    hideProgress();
    console.log(error);
});
function ubizapis(api_version, api_url, api_method, api_data, api_params, api_callback) {

    var protocol = window.location.protocol;
    var hostname = window.location.hostname;
    var api_base_url = protocol + "//" + hostname + "/api/" + api_version + "/";

    var options = {
        baseURL: api_base_url,
        url: api_url,
        method: api_method
    };

    if(typeof api_data === 'object'){
        options.data = qs.stringify(api_data);
    }

    if(typeof api_params === 'object'){
        options.params = api_params;
    }

    axios(options)
        .then(function (response) {
            // Do something with response data
            setTimeout(function () {
                hideProgress();
            }, 500);
            if (typeof api_callback == 'function') {
                api_callback(response);
            }
        })
        .catch(function (error) {
            setTimeout(function () {
                hideProgress();
            }, 500);
            if (error.response) {
                // The request was made and the server responded with a status code
                // that falls out of the range of 2xx
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.headers);
            } else if (error.request) {
                // The request was made but no response was received
                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                // http.ClientRequest in node.js
                console.log(error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                console.log('Error', error.message);
            }
            console.log(error.config);
        });
}