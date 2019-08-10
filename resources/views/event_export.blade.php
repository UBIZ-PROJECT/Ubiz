<table>
    <thead>
    <tr>
        <th>Tiêu đề</th>
        <th>Bắt đầu</th>
        <th>Kết thúc</th>
        <th>Cả ngày</th>
        <th>Địa điểm</th>
        <th>Thẻ</th>
        <th>Nội dung</th>
        <th>Kết quả</th>
        <th>Chi phí</th>
        <th>Người phụ trách</th>
    </tr>
    </thead>
    <tbody>
    @foreach($events as $event)
        <tr>
            <td>{{ $event['title']}}</td>
            <td align="right">{{ $event['start']}}</td>
            <td align="right">{{ $event['end']}}</td>
            <td align="center">{{ $event['allDay']}}</td>
            <td>{{ $event['location']}}</td>
            <td>{{ $event['tag_title']}}</td>
            <td>{!! $event['desc'] !!}</td>
            <td>{!! $event['result'] !!}</td>
            <td>{{ $event['fee']}}</td>
            <td>{{ $event['pic']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>