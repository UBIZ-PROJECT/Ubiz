var pic_list = new Array();
var time_zone = 'local';
function event_edit(info) {
    console.log(info);
    moment.locale('vi');
    $("#event-title").val(info.event.title);
    $("#event-start-date").val(moment(info.event.start).format('MMM DD, YYYY'));
    $("#event-end-date").val(moment(info.event.end).format('MMM DD, YYYY'));
    $("#event-start-time").val(moment(info.event.start).format('h:mma'));
    $("#event-end-time").val(moment(info.event.end).format('h:mma'));
    if (info.event.allDay == '0') {
        $("#event-all-day").prop("checked", false);
    } else {
        $("#event-all-day").prop("checked", true);
    }
    $("#event-email").text(info.event.extendedProps.owner_email);
    $("#event_tag").attr('tag_id', info.event.extendedProps.tag_id);
    $("#event_tag").attr('title', info.event.extendedProps.tag_title);
    $("#event_tag").addClass(info.event.extendedProps.tag_color);
    $("#event-tag-dropdown").find("div.dropdown-menu").find("a.dropdown-item").removeClass('active');
    $("#event-tag-dropdown").find("div.dropdown-menu").find("a[tag_id=" + info.event.extendedProps.tag_id + "].dropdown-item").addClass('active');

    if (info.event.extendedProps.pic_edit == '0') {
        $("#event_pic_edit").prop("checked", false);
    } else {
        $("#event_pic_edit").prop("checked", true);
    }

    if (info.event.extendedProps.pic_assign == '0') {
        $("#event_pic_assign").prop("checked", false);
    } else {
        $("#event_pic_assign").prop("checked", true);
    }

    if (info.event.extendedProps.pic_see_list == '0') {
        $("#event_pic_see_list").prop("checked", false);
    } else {
        $("#event_pic_see_list").prop("checked", true);
    }

    tinyMCE.get('event_desc').setContent(info.event.extendedProps.desc);

    $('#event-modal').modal();
}

function epic_clean_tag_class() {
    $("#event_tag").attr('class', '');
    $("#event_tag").addClass('fas fa-circle');
}

function epic_select_tag(self) {

    $(self).closest('div.dropdown-menu').find('a.dropdown-item').removeClass('active');

    $(self).addClass('active');
    var tag_id = $(self).attr('tag_id');
    var tag_title = $(self).attr('tag_title');
    var tag_color = $(self).attr('tag_color');

    epic_clean_tag_class();

    $("#event_tag").attr('tag_id', tag_id);
    $("#event_tag").attr('title', tag_title);
    $("#event_tag").addClass(tag_color);
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

function event_add() {
    $("#event-title").val('');
    $("#event-start-date").val(moment().format('MMM DD, YYYY'));
    $("#event-end-date").val(moment().format('MMM DD, YYYY'));
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

moment.locale('vi', {
    months: 'Tháng 1_Tháng 2_Tháng 3_Tháng 4_Tháng 5_Tháng 6_Tháng 7_Tháng 8_Tháng 9_Tháng 10_Tháng 11_Tháng 12'.split('_'),
    monthsShort: 'Th1_Th2_Th3_Th4_Th5_Th6_Th7_Th8_Th9_Th1_Th11_Th12'.split('_'),
    monthsParseExact: true,
    weekdays: 'Chủ nhật_Thứ hai_Thứ ba_Thứ tư_Thứ năm_Thứ sáu_Thứ bảy'.split('_'),
    weekdaysShort: 'CN_T2_T3_T4_T5_T6_T7'.split('_'),
    weekdaysMin: 'CN_T2_T3_T4_T5_T6_T7'.split('_'),
});

document.addEventListener('DOMContentLoaded', function () {
    var initialLocaleCode = 'vi';
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: time_zone,
        plugins: ['interaction', 'bootstrap', 'dayGrid', 'timeGrid', 'list', 'momentTimezone', 'rrule'],
        height: 'parent',
        header: {
            left: 'prev,next today',
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
        select: function (arg) {
            event_add();
            // if (title) {
            //     calendar.addEvent({
            //         title: title,
            //         start: arg.start,
            //         end: arg.end,
            //         allDay: arg.allDay
            //     })
            // }
            calendar.unselect()
        },
        editable: true,
        eventSources: [
            {
                events: function (fetchInfo, successCallback, failureCallback) {
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

    $.fn.datepicker.language['vi'] = {
        days: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
        daysShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        daysMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        months: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
        monthsShort: ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'],
        today: 'Hôm nay',
        clear: 'Xóa'
    };

    $('.my-datepicker').datepicker({
        language: 'vi',
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:ss',
        firstDay: 0,
        onSelect: function (fd, d, picker) {

        }
    });

    $('.start-date').datepicker({
        language: 'vi',
        autoClose: true,
        dateFormat: 'M dd ,yyyy',
        onSelect: function (fd, d, picker) {

        }
    });

    $('.end-date').datepicker({
        language: 'vi',
        autoClose: true,
        dateFormat: 'M dd ,yyyy',
        onSelect: function (fd, d, picker) {

        }
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

    $('#event-modal').on('hidden.bs.modal', function (e) {
        $("#event-start-date").val("");
        $("#event-end-date").val("");
    })

    $('.event-pic').on('show.bs.dropdown', function () {
        event_load_pic();
    })

    $('.event-pic').on('hide.bs.dropdown', function () {
        event_set_assigned_list();
    })

    tinymce.init({
        width: '100%',
        min_height: 246,
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
        ]
    });
});