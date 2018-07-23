function showProgress() {
    var progress = jQuery('.ubiz-progress');
    if (progress.length == 0) {
        var progress_dom = '<div class="ubiz-progress">' + i18next.t("Processing...") + '</div>';
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
    ubizapis('v1', '/logout', 'get', null, null, function (response) {
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
        options.data = api_data;
        if (api_data instanceof FormData) {
            options.headers['Content-Type'] = 'multipart/form-data';
        }
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
                if (error.response.status === 401) {
                    swal(i18next.t("Authentication failed.\nYou will be taken back to the login page for 5 seconds."), {
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        timer: 5000,
                    }).then((value) => {
                        window.location.href = '/login';
                    });
                }
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

function showErrorInput(control, error_message) {
    parentControl = $(control).closest(".root_textfield");
    $(parentControl).find(".error-message-text").html(error_message);
    $(parentControl).find('.error_message').removeClass('hidden-content');
    $(parentControl).find('.wrapper').addClass('invalid');
    $(parentControl).find('.fieldGroup').addClass('invalid');
}

function removeErrorInput() {
    $('.root_textfield').each(function() {
        $(this).find('.error-message-text').html('');
        $(this).find('.error_message').addClass('hidden-content');
        $(this).find('.wrapper').removeClass('invalid');
        $(this).find('.fieldGroup').removeClass('invalid');
    });
}

function openFileUpload(self) {
    $(self).closest('.image-upload').find(".file-upload").click();
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(input).closest('.image-upload').find(".img-show")
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
        $(input).attr("is-change", "true");
    }
}

function inputChange(self, oldVal) {
    if ($(self).val() == oldVal) {
        $(self).isChange("false");
    } else {
        $(self).isChange("true");
    }
}

jQuery.fn.extend({
    isChange: function(bool) {
        if (bool === undefined || bool === null || bool === "") {
            return this.attr("is-change");
        } else {
            this.attr("is-change", bool);
        }
    }
});

var I18n = function () {

    I18n.prototype.init = function init() {
        var _this2 = this;
        this.options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
    };

    I18n.prototype.t = function t() {
        var key = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
        var replace = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
        if (typeof key !== "string" || key == "")
            return "";

        if (typeof this.options.resources[this.options.lng] === "undefined")
            return key;

        if (typeof this.options.resources[this.options.lng].translation[key] === "undefined")
            return key;

        var value = this.options.resources[this.options.lng].translation[key];
        if (typeof replace == "object") {
            Object.keys(replace).map(function (objectKey, index) {
                var pattern = new RegExp(':' + objectKey, "g");
                value = value.replace(pattern, replace[objectKey]);
            });
        }
        return value;
    };
}
var i18next = new I18n();