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

function qp_back_to_output() {
    var qp_id = $("input[name=qp_id]").val();
    window.location.href = "/quoteprices/" + qp_id + "/history";
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
    jQuery('.utooltip').tooltipster({
        side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
    });
});