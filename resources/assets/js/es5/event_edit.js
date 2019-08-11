var calendar = null;
var time_zone = 'local';

function event_get_filter_tag() {
    var filter_tag = new Array();
    $("input[name=event-tag]:checked").each(function (idx, tag) {
        filter_tag.push($(tag).val());
    });
    return filter_tag;
}

function event_edit(event) {
    console.log(event);
    $("#event-id").val(event.id);
    $("#event-title").val(event.title);
    $("#event-location").val(event.location);

    var startDatepicker = $('.start-date').datepicker().data('datepicker');
    var endDatepicker = $('.end-date').datepicker().data('datepicker');

    $("#event-all-day").prop("checked", event.allDay);
    if (event.allDay == true) {
        $("#event-start-time").hide();
        $("#event-end-time").hide();
        $("#event-start-date").val(moment(event.start).format('MMM DD ,YYYY'));
        $("#event-end-date").val(moment(event.end).subtract(1, 'days').format('MMM DD ,YYYY'));
        $("#event-start-time").val('8:00am');
        $("#event-end-time").val('5:00pm');
    } else {
        $("#event-start-time").show();
        $("#event-end-time").show();
        $("#event-start-date").val(moment(event.start).format('MMM DD ,YYYY'));
        $("#event-end-date").val(moment(event.end).format('MMM DD ,YYYY'));
        $("#event-start-time").val(moment(event.start).format('h:mma'));
        $("#event-end-time").val(moment(event.end).format('h:mma'));
    }

    startDatepicker.selectDate(new Date($("#event-start-date").val()));
    endDatepicker.selectDate(new Date($("#event-end-date").val()));

    $("#event-email").text(event.owner_email);

    epic_clean_tag_class();
    $("#event-tag").attr('tag_id', event.tag_id);
    $("#event-tag").attr('title', event.tag_title);
    $("#event-tag").addClass(event.tag_color);
    $("#event-tag-dropdown").find("div.dropdown-menu").find("a.dropdown-item").removeClass('active');
    $("#event-tag-dropdown").find("div.dropdown-menu").find("a[tag_id=" + event.tag_id + "].dropdown-item").addClass('active');

    $('#event_fee').val(numeral(event.fee).format('0,0'));

    if (event.pic_edit == '1') {
        $("#event_pic_edit").prop("checked", true);
    } else {
        $("#event_pic_edit").prop("checked", false);
    }

    if (event.pic_assign == '1') {
        $("#btn-assign").show();
        $("#event_pic_assign").prop("checked", true);
    } else {
        $("#btn-assign").hide();
        $("#event_pic_assign").prop("checked", false);
    }

    if (event.pic_see_list == '1') {
        $(".assigned-list").show();
        $("#event_pic_see_list").prop("checked", true);
    } else {
        $(".assigned-list").show();
        $("#event_pic_see_list").prop("checked", false);
    }

    if (event.pic_assign == '1' || event.is_owner == true) {
        $("#btn-assign").show();
    } else {
        $("#btn-assign").hide();
    }

    if (event.pic_see_list == '1' || event.is_owner == true) {
        $(".assigned-list").show();
    } else {
        $(".assigned-list").hide();
    }

    tinyMCE.get('event_desc').setContent(event.desc);
    tinyMCE.get('event_result').setContent(event.result);

    var assigned_list = new Array();
    $.map(event.pic, function (user, idx) {

        var pic = _.find(pic_list, {id: user.id});
        if (typeof pic !== "undefined") {
            assigned_list.push(pic);
        }
    });
    event_render_assigned_dropdown_list(assigned_list);

    $("#btn-delete").show();
    $('#event-modal').modal();
}

function epic_clean_tag_class() {
    $("#event-tag").attr('class', '');
    $("#event-tag").addClass('fas fa-circle');
}

function epic_select_tag(self) {

    $(self).closest('div.dropdown-menu').find('a.dropdown-item').removeClass('active');

    $(self).addClass('active');
    var tag_id = $(self).attr('tag_id');
    var tag_title = $(self).attr('tag_title');
    var tag_color = $(self).attr('tag_color');

    epic_clean_tag_class();

    $("#event-tag").attr('tag_id', tag_id);
    $("#event-tag").attr('title', tag_title);
    $("#event-tag").addClass(tag_color);
}

function event_pic_select(self, event) {
    event.stopPropagation();
    var fa_check = $(self).find('div:first');
    if (fa_check.hasClass('assigned')) {
        fa_check.removeClass('assigned');
    } else {
        fa_check.addClass('assigned');
    }
}

function event_load_pic() {
    if (pic_list.length == 0) {
        ubizapis('v1', 'events/pic', 'get', null, null, function (response) {
            if (response.data.success == true) {
                pic_list = response.data.users;
                event_load_pic_callback(response.data.users);
            } else {
                swal.fire({
                    type: 'error',
                    title: response.data.message
                });
            }
        });
    } else {
        event_load_pic_callback(pic_list);
    }
}

function event_get_first_tag_info() {

    var tag = {
        'tag_id': '0',
        'tag_title': '',
        'tag_color': '',
    };

    var tag_obj = $("#event-tag-dropdown").find('div.dropdown-menu').find('a:first');
    if (tag_obj.length == 0) {
        return tag;
    }

    var tag = {};
    tag.tag_id = tag_obj.attr('tag_id');
    tag.tag_title = tag_obj.attr('tag_title');
    tag.tag_color = tag_obj.attr('tag_color');
    return tag;
}

function event_load_pic_callback(users) {
    var assigned_list = event_get_list_of_assigned_pic();
    event_render_pic_dropdown_list(users, assigned_list);
}

function event_render_pic_dropdown_list(users, checked_list) {
    var html = "";
    $.map(users, function (user, idx) {

        var assigned_class = 'assigned';
        if (typeof checked_list[user.id] === "undefined") {
            assigned_class = '';
        }

        html += '<a pic="' + user.id + '" class="dropdown-item media pdl-5" href="#" onclick="event_pic_select(this, event)">';
        html += '<div class="' + assigned_class + '" style="height: 30px; width: 20px; line-height: 30px">';
        html += '<i class="fas fa-check pdr-5"></i>';
        html += '</div>';
        html += '<div style="width: 30px; height: 30px" class="mr-3">';
        html += '<img src="' + user.avatar + '" class="img-fluid img-thumbnail" alt="">';
        html += '</div>';
        html += '<div class="media-body" style="height: 30px; line-height: 5px">';
        html += '<h6 class="mt-0 mb-1">' + user.name + '</h6>';
        html += '<small>' + user.dep_name + '</small>';
        html += '</div>';
        html += '</a>';
        if (idx < (users.length - 1)) {
            html += '<div class="dropdown-divider z-mgt z-mgb"></div>';
        }
    });
    $(".event-pic").find('.dropdown-menu').empty();
    $(".event-pic").find('.dropdown-menu').html(html);
}

function event_get_list_of_assigned_pic() {

    var assigned_list = {};
    $(".assigned-list").find('li.list-group-item').each(function (idx, ele) {
        var pic = $(ele).attr('pic');
        assigned_list[pic] = pic;
    });
    return assigned_list;
}

function event_get_list_of_checked_dropdown_pic() {
    var checked_list = {};
    $(".event-pic").find('div.dropdown-menu').find('a').each(function (idx, ele) {
        if ($(ele).find('div:first').hasClass('assigned')) {
            var pic = $(ele).attr('pic');
            checked_list[pic] = pic;
        }
    });
    return checked_list;
}

function event_get_list_of_selected_pic() {

    var selected_list = new Array();
    var checked_list = event_get_list_of_checked_dropdown_pic();
    $.map(pic_list, function (user, idx) {

        if (typeof checked_list[user.id] !== "undefined") {
            selected_list.push(user);
        }
    });
    return selected_list;
}

function event_set_assigned_list() {
    var assigned_list = event_get_list_of_selected_pic();
    event_render_assigned_dropdown_list(assigned_list);
}

function event_render_assigned_dropdown_list(assigned_list) {
    var html = "";
    $.map(assigned_list, function (user, idx) {
        html += '<li pic="' + user.id + '" class="border-top-0  border-bottom-0 list-group-item z-pdl z-pdr z-pdb" style="display: flex; align-items: flex-start;">';
        html += '<div style="width: 30px; height: 30px" class="mr-3">';
        html += '<img src="' + user.avatar + '" class="img-fluid img-thumbnail" alt="">';
        html += '</div>';
        html += '<div class="media-body" style="height: 30px; line-height: 5px">';
        html += '<h6 class="mt-0 mb-1">' + user.name + '</h6>';
        html += '<small>' + user.dep_name + '</small>';
        html += '</div>';
        html += '<div style="height: 30px; line-height: 30px">';
        html += '<i class="fas fa-times pdr-5" onclick="event_delete_selected_pic(this)"></i>';
        html += '</div>';
        html += '</li>';
    });
    $(".assigned-list").empty();
    $(".assigned-list").html(html);
}

function event_delete_selected_pic(self) {
    $(self).closest('li.list-group-item').remove();
}

function event_all_day_change(self) {
    if ($(self).is(":checked") == true) {
        $("#event-start-time").addClass('txt-hidden');
        $("#event-end-time").addClass('txt-hidden');
    } else {
        $("#event-start-time").removeClass('txt-hidden');
        $("#event-end-time").removeClass('txt-hidden');
    }
}

function event_colect_data() {
    var data = {};
    data.event_title = $("#event-title").val();

    var event_start_time = '00:00:00';
    var event_end_time = '00:00:00';

    data.event_all_day = '1';
    if ($("#event-all-day").is(":checked") == false) {
        data.event_all_day = '0';
        event_start_time = moment($("#event-start-time").val(), ["h:mma"]).format("HH:mm:ss");
        event_end_time = moment($("#event-end-time").val(), ["h:mma"]).format("HH:mm:ss");
        data.event_start = moment($("#event-start-date").val(), ["MMM DD ,YYYY"]).format("YYYY-MM-DD") + " " + event_start_time;
        data.event_end = moment($("#event-end-date").val(), ["MMM DD ,YYYY"]).format("YYYY-MM-DD") + " " + event_end_time;
    } else {
        data.event_start = moment($("#event-start-date").val(), ["MMM DD ,YYYY"]).format("YYYY-MM-DD") + " " + event_start_time;
        data.event_end = moment($("#event-end-date").val(), ["MMM DD ,YYYY"]).add(1, 'days').format("YYYY-MM-DD") + " " + event_end_time;
    }

    data.event_tag = $("#event-tag").attr('tag_id');
    data.event_location = $("#event-location").val();

    var desc_selector = $('textarea[name=txt_desc]').attr('id');
    data.event_desc = tinyMCE.get(desc_selector).getContent();
    data.event_desc_origin = tinyMCE.get(desc_selector).getContent({'format': 'text'});

    data.event_fee = numeral($("#event_fee").val()).value();

    data.event_pic_edit = '0';
    if ($("#event_pic_edit").is(":checked") == true) {
        data.event_pic_edit = '1';
    }

    data.event_pic_assign = '0';
    if ($("#event_pic_assign").is(":checked") == true) {
        data.event_pic_assign = '1';
    }

    data.event_pic_see_list = '0';
    if ($("#event_pic_see_list").is(":checked") == true) {
        data.event_pic_see_list = '1';
    }

    data.event_pic_list = new Array();
    $(".assigned-list").find('li.list-group-item').each(function (idx, ele) {
        var pic = $(ele).attr('pic');
        data.event_pic_list.push(pic);
    });

    var result_selector = $('textarea[name=txt_result]').attr('id');
    data.event_result = tinyMCE.get(result_selector).getContent();
    data.event_result_origin = tinyMCE.get(result_selector).getContent({'format': 'text'});

    return data;
}

function event_save() {
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
            var event_id = $("#event-id").val();
            var data = event_colect_data();
            if (event_id != 0) {
                ubizapis('v1', '/events/' + event_id + "/update", 'post', data, null, event_save_callback);
            } else {
                ubizapis('v1', '/events', 'post', data, null, event_save_callback);
            }
        }
    });
}

function event_delete() {
    swal({
        title: i18next.t('Do you want to delete the data.?'),
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: i18next.t('No'),
        confirmButtonText: i18next.t('Yes'),
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            var event_id = $("#event-id").val();
            ubizapis('v1', '/events/' + event_id + "/delete", 'delete', null, null, event_delete_callback);
        }
    });
}

function event_save_callback(res) {
    if (res.data.success == true) {
        $('#event-modal').modal('hide');
        swal.fire({
            type: 'success',
            title: res.data.message,
            onClose: () => {
                go_back_to_output();
            }
        });
    } else {
        swal.fire({
            type: 'error',
            title: res.data.message
        });
    }
}

function event_delete_callback(res) {
    if (res.data.success == true) {
        $('#event-modal').modal('hide');
        swal.fire({
            type: 'success',
            title: res.data.message,
            onClose: () => {
                go_back_to_output();
            }
        });
    } else {
        swal.fire({
            type: 'error',
            title: res.data.message
        });
    }
}

function event_refresh() {
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
    });
}

function go_back_to_output() {
    window.location.href = "/events";
}

document.addEventListener('DOMContentLoaded', function () {

    $('.utooltip').tooltipster({
        side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
    });

    fnc_set_scrollbars("nicescroll-iput");
    fnc_set_scrollbars("detail-scroll-1");
    fnc_set_scrollbars("detail-scroll-2");

    $.fn.datepicker.language['vi'] = {
        days: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
        daysShort: ['CN', 'Th 2', 'Th 3', 'Th 4', 'Th 5', 'Th 6', 'Th 7'],
        daysMin: ['CN', 'Th 2', 'Th 3', 'Th 4', 'Th 5', 'Th 6', 'Th 7'],
        months: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
        monthsShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
        today: 'Hôm nay',
        clear: 'Xóa'
    };

    $('.my-datepicker').datepicker({
        language: 'vi',
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:ss',
        firstDay: 1
    });

    $('.start-date').datepicker({
        language: 'vi',
        autoClose: true,
        dateFormat: 'M dd ,yyyy',
        firstDay: 1
    });

    $('.end-date').datepicker({
        language: 'vi',
        autoClose: true,
        dateFormat: 'M dd ,yyyy',
        firstDay: 1
    });

    $('.event-pic').on('show.bs.dropdown', function () {
        event_load_pic();
    })

    $('.event-pic').on('hide.bs.dropdown', function () {
        event_set_assigned_list();
    })

    tinymce.init({
        width: '100%',
        min_height: 250,
        max_height: 500,
        menubar: false,
        toolbar_drawer: 'floating',
        selector: '#event_desc',
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor searchreplace visualblocks code fullscreen insertdatetime media table paste code wordcount autoresize'
        ],
        toolbar: 'undo redo | bold italic forecolor backcolor | formatselect | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
        content_css: [
            '/fonts/roboto/v18/roboto.css'
        ],
        init_instance_callback: function (editor) {
            event_edit(event);
        }
    });

    tinymce.init({
        width: '100%',
        min_height: 250,
        max_height: 500,
        menubar: false,
        toolbar_drawer: 'floating',
        selector: '#event_result',
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor searchreplace visualblocks code fullscreen insertdatetime media table paste code wordcount autoresize'
        ],
        toolbar: 'undo redo | bold italic forecolor backcolor | formatselect | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
        content_css: [
            '/fonts/roboto/v18/roboto.css'
        ]
    });

});
