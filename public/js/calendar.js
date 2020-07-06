document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['timeGrid', 'interaction'],
        locale: 'vi',
        editable: true,
        selectable: true,
        height: "auto",
        defaultView: 'timeGridWeek',
        firstDay: 1,
        allDaySlot: false,
        minTime: '06:00:00',
        maxTime: '23:00:00',
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'timeGridWeek, timeGridDay'
        },
        views: {
            timeGridWeek: {
                buttonText: 'Tuần này'
            },
            timeGridDay: {
                buttonText: 'Hôm nay'
            }
        },
        textColor: 'white',
        eventRender: function(info) {
            $('[aria-hidden="false"]').remove();
            var tooltip = new Tooltip(info.el, {
                title: info.event.extendedProps.description,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
        },
        eventResize: function(info) {
            // Sự kiện kéo thêm, rút ngắn giờ kết thúc ca quay
            var calendarID = info.event.id;
            var URL = info.event.extendedProps.quickUpdate;
            var endDate =  new Date(info.event.end);
            var days = endDate.getFullYear()+'-'+render_number(endDate.getMonth() + 1)+'-'+render_number(endDate.getDate());
            var end = render_number(endDate.getHours())+':'+render_number(endDate.getMinutes());

            if (confirm("Bạn thực sự muốn thay đổi thời gian kết thúc ca trực?")) {
                $('body').append(html_loading);
                $.post(URL, {id: calendarID, end_time: days + ' '+end}, function(data){
                    $('.card-load.uk-flex').remove();
                    var json = JSON.parse(data);
                    var type = 'success';
                    if(json.error == true){
                        info.revert();
                        type = 'danger'
                    }
                    notify(json.message, type);
                });
            }else{
                info.revert();
            }
        },
        eventOverlap: function(stillEvent, movingEvent) {
            notify('Ca trực bạn tùy chỉnh đang trùng lặp với ca trực khác. Vui lòng sửa lại!', 'danger');
            return false;
        },
        eventDrop: function(info) {
            // Sự kiện di chuyển ca quay
            var calendarID = info.event.id;
            var URL = info.event.extendedProps.quickUpdate;

            var startDate =  new Date(info.event.start);
            var endDate =  new Date(info.event.end);
            var days = startDate.getFullYear()+'-'+render_number(startDate.getMonth() + 1)+'-'+render_number(startDate.getDate());
            var start = render_number(startDate.getHours())+':'+render_number(startDate.getMinutes());
            var end = render_number(endDate.getHours())+':'+render_number(endDate.getMinutes());

            alert(info.event.title + " được thả vào " + (info.newResource ? 'phòng ' + info.newResource.title : '') + ' Từ ' + days + ' ' + start + ' đến ' + days + ' ' + end);
            if (confirm("Bạn thực sự muốn thay đổi thông tin ca trực?")) {
                $('body').append(html_loading);
                $.post(URL, {id: calendarID, date_record: days, start_time: start, end_time: end}, function(data){
                    $('.card-load.uk-flex').remove();
                    var json = JSON.parse(data);
                    var type = 'success';
                    if(json.error == true){
                        info.revert();
                        type = 'danger'
                    }
                    notify(json.message, type);
                });
            }else{
                info.revert();
            }
        },
        selectOverlap: function(event) {
            notify('Ca trực bạn chọn đang trùng lặp với ca quay khác. Vui lòng chọn lại!', 'danger');
            return false;
        },
        select: function(info) {
            // Sự kiện kéo khung giờ ca quay.
            var nowDate =  new Date();
            var startDate =  new Date(info.start);
            var endDate =  new Date(info.end);
            if (startDate < nowDate) {
                notify('Ca trực bạn chọn đang có thời gian bắt đầu ghi hình nhỏ hơn giờ hiện tại. Vui lòng chọn lại!', 'danger');
                return false;
            }
            var days = startDate.getFullYear()+'-'+render_number(startDate.getMonth() + 1)+'-'+render_number(startDate.getDate());
            var start = render_number(startDate.getHours())+':'+render_number(startDate.getMinutes());
            var end = render_number(endDate.getHours())+':'+render_number(endDate.getMinutes());

            // $('#EventModal input[name="date_record"]').val(days);
            // $('#EventModal input[name="start_time"]').val(start);
            // $('#EventModal input[name="end_time"]').val(end);
            // $('#EventModal input[name="room_code"]').val(roomId);
            // $('#EventModal').modal({backdrop: 'static'});

            notify('Ca trực bạn chọn hợp lý. Vui lòng viết thêm code!', 'success');
        },
        eventClick: function(info) {
            var eventObj = info.event;
            var modal = eventObj.extendedProps.action;
            if (eventObj.url && eventObj.id && modal != '') {
                $('body').append(html_loading);
                $.post(eventObj.url, {id: eventObj.id}, function(data){
                    $('.card-load.uk-flex').remove();
                    if (modal == '#EventModal2') {
                        $(modal).find('.modal-body').html(data);
                        load_attribute_hidden_form();
                    }else{
                        var json = JSON.parse(data);
                        if(json.error == false){
                            $(modal).find('input[name="date_record"]').val(json.result.date_record);
                            $(modal).find('input[name="start_time"]').val(json.result.start_time);
                            $(modal).find('input[name="end_time"]').val(json.result.end_time);
                            if (json.result.teacher) {
                                $(modal).find('select[name="teacher"]').html('<option value="'+json.result.teacher+'">'+json.result.teacher_name+'<option>');
                            }
                            if (json.result.technician) {
                                $(modal).find('select[name="technician"]').html('<option value="'+json.result.technician+'">'+json.result.technician_name+'<option>');
                            }
                            if (json.result.plan_id > 0) {
                                $(modal).find('select[name="plan_id"]').html('<option value="'+json.result.plan_id+'">'+json.result.plan_name+' - '+json.result.teacher_name+'<option>');
                            }
                            $(modal).find('select[name="status"]').val(json.result.status).next().find('.select2-selection__rendered')
                            .html($(modal).find('select[name="status"] option:selected').text());
                            $(modal).find('textarea[name="content"]').text(json.result.content);
                            $(modal).find('form').attr('action', json.result.url);
                        }
                    }
                    $(modal).modal({backdrop: 'static'});disabled_form_input();
                });
            }
            info.jsEvent.preventDefault();
        },
        events: function(fetchInfo, successCallback, failureCallback ) {
            var queryForm = $('.calendar_filter').serializeArray();
            var query = {
                start: fetchInfo.startStr,
                end: fetchInfo.endStr
            };

            queryForm.forEach( function(element, index) {
                var param = '';
                if (element.value != '') {
                    param = '{"'+element.name+'":"'+element.value+'"}';
                }
                if (param != '') {Object.assign(query, JSON.parse(param));}
            });

            $.ajax({
                url: calendarEl.getAttribute('data-event'),
                dataType: 'json',
                data: query,
                success: function(doc) {
                    successCallback(doc);
                }
            });
        }
    });

    calendar.render();
    $('.calendar_filter input, .calendar_filter select').change(function(){
        $('body').append(html_loading);
        calendar.refetchResources();
        calendar.refetchEvents();
    });

});
function render_number(number){
    return ((number < 10) ? '0'+number : number);
}

// npm install --save fullcalendar/core fullcalendar/resource-timegrid  fullcalendar/interaction

function notify(message, type){
    $.growl({
        message: message
    },{
        type: type,
        allow_dismiss: false,
        label: 'Cancel',
        className: 'btn-xs btn-inverse',
        placement: {
            from: 'top',
            align: 'right'
        },
        delay: 4500,
        animate: {
                enter: 'animated fadeInRight',
                exit: 'animated fadeOutRight'
        },
        offset: {
            x: 30,
            y: 30
        }
    });
};