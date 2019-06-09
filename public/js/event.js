function event_edit(info) {
    console.log(info);
    moment.locale('vi');
    $("#event-title").val(info.event.title);
    $("#event-start-date").val(moment().format('MMM DD, YYYY'));
    $("#event-end-date").val(moment().format('MMM DD, YYYY'));
    $('#event-modal').modal();
}

function event_add() {
    $("#event-title").val('');
    $("#event-start-date").val(moment().format('MMM DD, YYYY'));
    $("#event-end-date").val(moment().format('MMM DD, YYYY'));
    $('#event-modal').modal();
}

function event_load_pic() {
    ubizapis('v1', 'events/pic', 'get', null, null, function (response) {
        if (response.data.success == true) {
            event_load_pic_callback(response.data.users);
        } else {
            swal.fire({
                type: 'error',
                title: response.data.message
            });
        }
    });
}

function event_load_pic_callback(users) {


    var assigned_list = {};
    $(".assigned-list").find('li.list-group-item').each(function (idx, ele) {
        var pic = $(ele).attr('pic');
        assigned_list[pic] = pic;
    });

    var html = "";
    $.map(users, function (user, idx) {

        var assigned_class = 'assigned';
        if (typeof assigned_list[user.id] === "undefined") {
            assigned_class = '';
        }

        html += '<a pic="' + user.id + '" class="dropdown-item media pdl-5" href="#">';
        html += '<div class="' + assigned_class + '" style="height: 30px; line-height: 30px">';
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
        timeZone: 'UTC +7',
        plugins: ['interaction', 'bootstrap', 'dayGrid', 'timeGrid', 'list'],
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
                textColor: 'rgba(0, 0, 0, .7)',
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
});