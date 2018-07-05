function showProgress(){
    var progress = jQuery('.ubiz-progress');
    if(progress.length == 0){
        var progress_dom = '<div class="ubiz-progress">Loading...</div>';
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

    // Add a response interceptor
    axios.interceptors.response.use(function (response) {
        // Do something with response data
        setTimeout(function () {
            hideProgress();
        }, 1000);
        if (typeof api_callback == 'function') {
            api_callback(response);
        }
    }, function (error) {
        console.log(error);
        hideProgress();
    });

    axios(options);
}