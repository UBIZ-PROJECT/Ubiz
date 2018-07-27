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

function logout() {
    ubizapis('v1', '/logout', 'get', null, null, function (response) {
        if (response.data.success == true) {
            window.location.href = '/login';
        } else {
            swal({
                type: 'error',
                text: response.data.message
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
        method: api_method,
        headers:[]
    };

    if (typeof api_data === 'object') {
        options.data = api_data;
        if (api_data instanceof FormData) {
            options.headers = {};
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
                    let timerInterval
                    swal({
                        title: i18next.t("Authentication failed.\nYou will be taken back to the login page for 5 seconds."),
                        html: '<strong></strong> ' + i18next.t('seconds') + '.',
                        timer: 5000,
                        onOpen: () => {
                            swal.showLoading()
                            timerInterval = setInterval(() => {
                                swal.getContent().querySelector('strong').textContent = swal.getTimerLeft()
                            }, 100)
                        },
                        onClose: () => {
                            clearInterval(timerInterval)
                            window.location.href = '/login';
                        }
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
    $('.root_textfield').each(function () {
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

function checkbox_click(self) {
    if (jQuery(self).closest('div.fieldGroup').find('input').prop('disabled') === true)
        return false;

    var id = jQuery(self).closest('div.fieldGroup').find('input').attr('id');
    if (jQuery(self).hasClass('suc')) {
        jQuery(self).removeClass('suc');
        jQuery(self).addClass('sck');
        jQuery("#" + id).prop("checked", true);
    } else {
        jQuery(self).removeClass('sck');
        jQuery(self).addClass('suc');
        jQuery("#" + id).prop("checked", false);
    }
}

function format_date(val, format){
    val = val.replace(/\s/g, "");
    if(val == "")
        return "";

    var f_date = moment(val).format(format);
    if(f_date == "Invalid date")
        return "";
    return f_date;
}

jQuery.fn.forceNumeric = function () {
    return this.each(function () {
        $(this).keydown(function (e) {
            var key = e.which || e.keyCode;

            if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
                // numbers
                key >= 48 && key <= 57 ||
                // Numeric keypad
                key >= 96 && key <= 105 ||
                // comma, period and minus, . on keypad
                key == 190 || key == 188 || key == 109 || key == 110 ||
                // Backspace and Tab and Enter
                key == 8 || key == 9 || key == 13 ||
                // Home and End
                key == 35 || key == 36 ||
                // left and right arrows
                key == 37 || key == 39 ||
                // Del and Ins
                key == 46 || key == 45)
                return true;

            return false;
        });

        $(this).focus(function () {
            var _this2 = this;
            setTimeout(function () {
                var f_value = $(_this2).val();
                var uf_value = numeral(f_value).format('0');
                $(_this2).val(uf_value).select();
            }, 10);
        });

        $(this).blur(function () {
            var _this2 = this;
            setTimeout(function () {
                var f_value = $(_this2).val();
                var uf_value = numeral(f_value).format('0,0');
                $(_this2).val(uf_value);
            }, 10);

        });
    });
}

jQuery.fn.extend({
    isChange: function (bool) {
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