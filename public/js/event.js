var calendar = null;
var time_zone = 'local';
var detail_scroll_1 = null;
var detail_scroll_2 = null;

function event_get_filter_tag() {
    var filter_tag = new Array();
    $("input[name=event-tag]:checked").each(function (idx, tag) {
        filter_tag.push($(tag).val());
    });
    return filter_tag;
}

function event_tag_change(self) {
    calendar.refetchEvents();
}

function event_edit(info) {
    console.log(info);
    $("#event-id").val(info.event.id);
    $("#event-title").val(info.event.title);
    $("#event-location").val(info.event.extendedProps.location);

    var startDatepicker = $('.start-date').datepicker().data('datepicker');
    var endDatepicker = $('.end-date').datepicker().data('datepicker');

    $("#event-all-day").prop("checked", info.event.allDay);
    if (info.event.allDay == true) {
        $("#event-start-time").hide();
        $("#event-end-time").hide();
        $("#event-start-date").val(moment(info.event.start).format('MMM DD ,YYYY'));
        $("#event-end-date").val(moment(info.event.end).subtract(1, 'days').format('MMM DD ,YYYY'));
        $("#event-start-time").val('8:00am');
        $("#event-end-time").val('5:00pm');
    } else {
        $("#event-start-time").show();
        $("#event-end-time").show();
        $("#event-start-date").val(moment(info.event.start).format('MMM DD ,YYYY'));
        $("#event-end-date").val(moment(info.event.end).format('MMM DD ,YYYY'));
        $("#event-start-time").val(moment(info.event.start).format('h:mma'));
        $("#event-end-time").val(moment(info.event.end).format('h:mma'));
    }

    startDatepicker.selectDate(new Date($("#event-start-date").val()));
    endDatepicker.selectDate(new Date($("#event-end-date").val()));

    $("#event-email").text(info.event.extendedProps.owner_email);

    epic_clean_tag_class();
    $("#event-tag").attr('tag_id', info.event.extendedProps.tag_id);
    $("#event-tag").attr('title', info.event.extendedProps.tag_title);
    $("#event-tag").addClass(info.event.extendedProps.tag_color);
    $("#event-tag-dropdown").find("div.dropdown-menu").find("a.dropdown-item").removeClass('active');
    $("#event-tag-dropdown").find("div.dropdown-menu").find("a[tag_id=" + info.event.extendedProps.tag_id + "].dropdown-item").addClass('active');

    $('#event_fee').val(numeral(info.event.extendedProps.fee).format('0,0'));

    if (info.event.extendedProps.pic_edit == '1') {
        $("#event_pic_edit").prop("checked", true);
    } else {
        $("#event_pic_edit").prop("checked", false);
    }

    if (info.event.extendedProps.pic_assign == '1') {
        $("#btn-assign").show();
        $("#event_pic_assign").prop("checked", true);
    } else {
        $("#btn-assign").hide();
        $("#event_pic_assign").prop("checked", false);
    }

    if (info.event.extendedProps.pic_see_list == '1') {
        $(".assigned-list").show();
        $("#event_pic_see_list").prop("checked", true);
    } else {
        $(".assigned-list").show();
        $("#event_pic_see_list").prop("checked", false);
    }

    if (info.event.extendedProps.pic_assign == '1' || info.event.extendedProps.is_owner == true) {
        $("#btn-assign").show();
    } else {
        $("#btn-assign").hide();
    }

    if (info.event.extendedProps.pic_see_list == '1' || info.event.extendedProps.is_owner == true) {
        $(".assigned-list").show();
    } else {
        $(".assigned-list").hide();
    }

    $("#event_desc").val(info.event.extendedProps.desc);
    $("#event_result").val(info.event.extendedProps.result);

    var assigned_list = new Array();
    $.map(info.event.extendedProps.pic, function (user, idx) {

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

function main_pic_select(self, event) {
    event.stopPropagation();
    var fa_check = $(self).find('div:first');
    if (fa_check.hasClass('assigned')) {
        fa_check.removeClass('assigned');
    } else {
        fa_check.addClass('assigned');
    }
}

function event_add(arg) {

    if (arg == null && calendar != null) {
        arg = {};
        arg.startStr = calendar.getDate();
    }

    $("#event-id").val('0');
    $("#event-title").val('');
    $("#event-location").val('');
    $("#event-start-date").val(moment(arg.startStr).format('MMM DD ,YYYY'));
    $("#event-end-date").val(moment(arg.startStr).format('MMM DD ,YYYY'));
    $("#event-start-time").val('8:00am');
    $("#event-end-time").val('5:00pm');
    $("#event-all-day").prop("checked", false);
    $("#event-email").text($("#user_email").text());
    $("#event-start-time").show();
    $("#event-start-end").show();

    var startDatepicker = $('.start-date').datepicker().data('datepicker');
    var endDatepicker = $('.end-date').datepicker().data('datepicker');
    startDatepicker.selectDate(new Date(arg.startStr));
    endDatepicker.selectDate(new Date(arg.startStr));

    epic_clean_tag_class();
    var event_tag = event_get_first_tag_info();
    $("#event-tag").attr('tag_id', event_tag.tag_id);
    $("#event-tag").attr('title', event_tag.tag_title);
    $("#event-tag").addClass(event_tag.tag_color);
    $("#event-tag-dropdown").find("div.dropdown-menu").find("a.dropdown-item").removeClass('active');
    $("#event-tag-dropdown").find("div.dropdown-menu").find("a[tag_id=" + event_tag.tag_id + "].dropdown-item").addClass('active');

    $('#event_fee').val('0');
    $("#btn-assign").show();
    $(".assigned-list").show();
    $("#event_pic_edit").prop("checked", false);
    $("#event_pic_assign").prop("checked", false);
    $("#event_pic_see_list").prop("checked", false);
    $("#event_desc").val('');
    $("#event_result").val('');
    $(".assigned-list").empty();

    $("#btn-delete").hide();
    $('#event-modal').modal();
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

function main_load_pic() {
    if (pic_list.length == 0) {
        ubizapis('v1', 'events/pic', 'get', null, null, function (response) {
            if (response.data.success == true) {
                pic_list = response.data.users;
                main_load_pic_callback(response.data.users);
            } else {
                swal.fire({
                    type: 'error',
                    title: response.data.message
                });
            }
        });
    } else {
        main_load_pic_callback(pic_list);
    }
}

function main_load_pic_callback(users) {
    var assigned_list = main_get_list_of_assigned_pic();
    main_render_pic_dropdown_list(users, assigned_list);
}

function main_render_pic_dropdown_list(users, checked_list) {
    var html = "";
    $.map(users, function (user, idx) {

        var assigned_class = 'assigned';
        if (typeof checked_list[user.id] === "undefined") {
            assigned_class = '';
        }

        html += '<a pic="' + user.id + '" class="dropdown-item media pdl-5" href="#" onclick="main_pic_select(this, event)">';
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
    $(".main-pic").find('.dropdown-menu').empty();
    $(".main-pic").find('.dropdown-menu').html(html);
}

function main_get_list_of_assigned_pic() {

    var assigned_list = {};
    $(".main-pic-sel").find('li.list-group-item').each(function (idx, ele) {
        var pic = $(ele).attr('pic');
        assigned_list[pic] = pic;
    });
    return assigned_list;
}

function event_get_list_of_assigned_pic() {

    var assigned_list = new Array();
    $(".main-pic-sel").find('li.list-group-item').each(function (idx, ele) {
        var pic = $(ele).attr('pic');
        assigned_list.push(pic);
    });
    return assigned_list;
}


function main_get_list_of_checked_dropdown_pic() {
    var checked_list = {};
    $(".main-pic").find('div.dropdown-menu').find('a').each(function (idx, ele) {
        if ($(ele).find('div:first').hasClass('assigned')) {
            var pic = $(ele).attr('pic');
            checked_list[pic] = pic;
        }
    });
    return checked_list;
}

function main_get_list_of_selected_pic() {

    var selected_list = new Array();
    var checked_list = main_get_list_of_checked_dropdown_pic();
    $.map(pic_list, function (user, idx) {

        if (typeof checked_list[user.id] !== "undefined") {
            selected_list.push(user);
        }
    });
    return selected_list;
}

function main_set_assigned_list() {
    var assigned_list = main_get_list_of_selected_pic();
    main_render_assigned_dropdown_list(assigned_list);
}

function main_render_assigned_dropdown_list(assigned_list) {
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
    $(".main-pic-sel").empty();
    $(".main-pic-sel").html(html);
}

function main_delete_selected_pic(self) {
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

    data.event_desc = $("#event_desc").val();

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

    data.event_result = $("#event_result").val();
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
                calendar.refetchEvents();
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
                calendar.refetchEvents();
            }
        });
    } else {
        swal.fire({
            type: 'error',
            title: res.data.message
        });
    }
}

function event_cancel() {
    $('#event-modal').modal('hide');
}

function update_scrollbars(instance) {
    if (typeof instance == "undefined")
        return false;
    instance.update();
    instance.scroll({y: "0"}, 1000);
}

function downloadCallback(response) {
    window.open('events/download/' + response.data.uniqid + '/' + response.data.file_name);
}

document.addEventListener('DOMContentLoaded', function () {
    var initialLocaleCode = 'vi';
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        customButtons: {
            next: {
                click: function () {
                    calendar.next();
                    var myDatepicker = $('.my-datepicker').datepicker().data('datepicker');
                    myDatepicker.selectDate(new Date(calendar.getDate()));
                }
            },
            prev: {
                click: function () {
                    calendar.prev();
                    var myDatepicker = $('.my-datepicker').datepicker().data('datepicker');
                    myDatepicker.selectDate(new Date(calendar.getDate()));
                }
            },
            today: {
                text: 'Hôm nay',
                click: function () {
                    calendar.today();
                    var myDatepicker = $('.my-datepicker').datepicker().data('datepicker');
                    myDatepicker.selectDate(new Date(calendar.getDate()));
                }
            },
            refresh: {
                text: 'Làm mới',
                click: function () {
                    calendar.refetchEvents();
                }
            },
            download: {
                text: 'Tải lịch làm việc',
                click: function () {

                    var fetchInfo = {};
                    fetchInfo.view = calendar.view.type;

                    if (fetchInfo.view == 'dayGridMonth') {
                        var year = calendar.getDate().getFullYear();
                        var month = calendar.getDate().getMonth();

                        fetchInfo.start = moment(year + '-' + month)
                            .endOf('month')
                            .format('YYYY-MM-DD');

                        fetchInfo.end = moment(year + '-' + month)
                            .add(2, 'months')
                            .startOf('month')
                            .format('YYYY-MM-DD');

                    } else {
                        fetchInfo.start = calendar.view.activeStart;
                        fetchInfo.end = calendar.view.activeEnd;
                    }
                    fetchInfo.tag = event_get_filter_tag();
                    fetchInfo.user = new Array();
                    ubizapis('v1', '/events/export', 'get', null, fetchInfo, function (response) {
                        if (response.data.success == true) {
                            downloadCallback(response);
                        } else {
                            swal.fire({
                                type: 'error',
                                title: response.data.message
                            });
                        }
                    });
                }
            }
        },
        timeZone: time_zone,
        plugins: ['interaction', 'bootstrap', 'dayGrid', 'timeGrid', 'list', 'momentTimezone', 'rrule'],
        height: 'parent',
        header: {
            left: 'prev,next today refresh download',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        themeSystem: 'bootstrap',
        defaultView: 'dayGridMonth',
        locale: initialLocaleCode,
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        buttonIcons: false, // show the prev/next text
        weekNumbers: true,
        selectable: true,
        selectMirror: true,
        fixedWeekCount: false,
        select: function (arg) {
            event_add(arg);
            calendar.unselect();
        },
        editable: true,
        eventSources: [
            {
                events: function (fetchInfo, successCallback, failureCallback) {

                    fetchInfo.tag = event_get_filter_tag();
                    fetchInfo.user = event_get_list_of_assigned_pic();
                    if (calendar != null) {
                        fetchInfo.view = calendar.view.type;
                    }

                    ubizapis('v1', '/events', 'get', null, fetchInfo, function (response) {
                        if (response.data.success == true) {
                            successCallback(response.data.events);
                        } else {
                            swal.fire({
                                type: 'error',
                                title: response.data.message
                            });
                        }
                    });
                },
                className: 'my-event',
            }
        ],
        eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: false,
            hour12: true
        },
        eventRender: function (info) {
            var tag_color = info.event.extendedProps.tag_color;
            jQuery(info.el).find('div.fc-content').prepend('<i class="fas fa-circle ' + tag_color + '"></i>');
        },
        eventClick: function (info) {
            info.jsEvent.preventDefault(); // don't let the browser navigate

            if (info.event.url) {
                window.open(info.event.url);
            }

            event_edit(info);
        }
    });
    calendar.render();

    detail_scroll_1 = fnc_set_scrollbars("detail-scroll-1");
    detail_scroll_2 = fnc_set_scrollbars("detail-scroll-2");
    fnc_set_scrollbars("nicescroll-sidebar");

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
        firstDay: 1,
        onSelect: function (fd, d, picker) {
            if (calendar.state.loadingLevel == 0) {
                calendar.gotoDate(fd);
            }
        }
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

    $('#event-tag-head').on('click', function () {
        $('#event-tag-body').collapse('toggle');
    });

    $('#event-tag-body').on('shown.bs.collapse', function () {
        $('#event-tag-head').addClass('tag-show');
        $('#event-tag-head').removeClass('tag-hide');
    });

    $('#event-tag-body').on('hidden.bs.collapse', function () {
        $('#event-tag-head').addClass('tag-hide');
        $('#event-tag-head').removeClass('tag-show');
    });

    $('#event-modal').on('shown.bs.modal', function (e) {
        update_scrollbars(detail_scroll_1);
        update_scrollbars(detail_scroll_2);
    })

    $('.event-pic').on('show.bs.dropdown', function () {
        event_load_pic();
    })

    $('.event-pic').on('hide.bs.dropdown', function () {
        event_set_assigned_list();
    })

    $('.main-pic').on('show.bs.dropdown', function () {
        main_load_pic();
    })

    $('.main-pic').on('hide.bs.dropdown', function () {
        main_set_assigned_list();
    })
});