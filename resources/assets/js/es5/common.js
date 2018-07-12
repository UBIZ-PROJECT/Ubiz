function showProgress() {
    var progress = jQuery('.ubiz-progress');
    if (progress.length == 0) {
        var progress_dom = '<div class="ubiz-progress">Đang xử lý...</div>';
        jQuery('body').append(progress_dom);
        progress = jQuery('.ubiz-progress');
    }
    progress.show();
}

function hideProgress() {
    var progress = jQuery('.ubiz-progress');
    if (progress.length == 1) {
        progress.hide();
    }
}

function show_searh_form() {
    jQuery("#search-form").fadeIn('fast', function () {
        jQuery("search-form").find('#code').focus();
        document.body.addEventListener('click', hide_searh_form, false);
    });
}

function hide_searh_form(e) {
    var search_form = jQuery(e.target).closest("#search-form");
    if (search_form.length == 0) {
        document.body.removeEventListener('click', hide_searh_form, false);
        jQuery("#search-form").hide('fast');
    }
}

function show_account_form() {
    jQuery("#account-form").fadeIn('fast', function () {
        document.body.addEventListener('click', hide_account_form, false);
    });
}

function hide_account_form(e) {
    var account_form = jQuery(e.target).closest("#account-form");
    if (account_form.length == 0) {
        document.body.removeEventListener('click', hide_account_form, false);
        jQuery("#account-form").hide('fast');
    }
}

function show_notify_form() {
    jQuery("#notify-form").fadeIn('fast', function () {
        document.body.addEventListener('click', hide_notify_form, false);
    });
}

function hide_notify_form(e) {
    var notify_form = jQuery(e.target).closest("#notify-form");
    if (notify_form.length == 0) {
        document.body.removeEventListener('click', hide_notify_form, false);
        jQuery("#notify-form").hide('fast');
    }
}

function show_apps_form() {
    jQuery("#apps-form").fadeIn('fast', function () {
        document.body.addEventListener('click', hide_apps_form, false);
    });
}

function hide_apps_form(e) {
    var apps_form = jQuery(e.target).closest("#apps-form");
    if (apps_form.length == 0) {
        document.body.removeEventListener('click', hide_apps_form, false);
        jQuery("#apps-form").hide('fast');
    }
}

function logout(){
    ubizapis('v1', '/users', 'get', null, null, function (response) {
        if (response.data.success == true) {
            window.location.href = '/login';
        } else {
            swal(response.data.message, {
                icon: "error",
            });
        }

    });
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

    if (typeof api_data === 'object') {
        options.data = qs.stringify(api_data);
    }

    if (typeof api_params === 'object') {
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