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

function back_to_contract() {
    window.location.href = "/contracts/";
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

function delete_contract() {
    var ctr_id = _s("input[name='ctr_id']");
    var uri = '/contracts/' + ctr_id + '/delete';
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
            ubizapis('v1', uri, 'delete', null, null, function(response) {
                if (response.data.success == true) {
                    swal.fire({
                        type: 'success',
                        title: response.data.message,
                        onClose: () => {
                            window.location = "/contracts";
                        }
                    })
                } else {
                    swal.fire({
                        type: 'error',
                        title: response.data.message
                    })
                }

            });
        }
    });

}

function update_contract() {
    var obj = new ObjectCreator();
    obj.add("#ctr_date");
    obj.add("#ctr_tax");
    obj.add("#ctr_note");
    // obj.add("#sale_name");
    // obj.add("#sale_rank");
    // obj.add("#sale_phone");
    // obj.add("#sale_email");
    // obj.add("#cus_name");
    // obj.add("#cus_type");
    // obj.add("#cus_addr");
    // obj.add("#cus_fax");
    obj.add("#ctr_contact_name", 5);
    obj.add("#ctr_contact_rank", 5);
    obj.add("#ctr_contact_phone", 5);
    obj.add("#ctr_contact_email", 5);
    var ctr_id = _s("input[name='ctr_id']");

    var data = obj.getAll();
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
            ubizapis('v1', "contracts/" + ctr_id + "/update", 'post', null, {data: JSON.stringify(data)}, function(response) {
                if (response.data.success == true) {
                    swal.fire({
                        type: 'success',
                        title: response.data.message
                    })
                } else {
                    swal.fire({
                        type: 'error',
                        title: response.data.message
                    })
                }
            });
        }
    });

}

function ObjectCreator() {
    var obj = {};
    this.add = function(selector, cutPosition) {
        if (cutPosition == undefined) {
            cutPosition = 1;
        }
        var name = selector.substr(cutPosition, selector.length);
        obj[name] = _s(selector);
    }

    this.getAll = function() {
        return obj;
    }

}

function _s(selector) {
    return $(selector).val();
}

function show_contract_type() {
    $("#dropDownList").toggle("show");
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
    fnc_datepicker('.datepicker');
    $("textarea[name=dt_prod_series]").tagEditor();
    jQuery('.utooltip').tooltipster({
        side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
    });

    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn') && !event.target.matches(".dropdown") && !event.target.matches(".dropdown .dropbtn .asA")) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
});