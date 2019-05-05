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
        eventSources: [
            {
                events: function (fetchInfo, successCallback, failureCallback) {
                    console.log(fetchInfo);
                    ubizapis('v1', '/events', 'get', null, fetchInfo, function (response) {
                        if (response.data.success == true) {
                            successCallback(response.data.events);
                        } else {
                            console.log('fail');
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
        }
    });
    calendar.render();

    $.fn.datepicker.language['vi'] = {
        days: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
        daysShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        daysMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        months: ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6', 'Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'],
        monthsShort: ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'],
        today: 'Hôm nay',
        clear: 'Xóa',
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:ss',
        firstDay: 0
    };

    $('.my-datepicker').datepicker({
        language: 'vi',
        onSelect: function (fd, d, picker) {

        }
    })
});