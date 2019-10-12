<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
Chào {{$data['cus_name']}},
<br><br>
Em là {{$data['sale_name']}} bên {{$data['com_name']}}.<br>
Lời đầu tiên gửi tới {{$data['cus_name']}} lời chúc sức khỏe và thành công.<br>
Theo như thông tin trao đổi trong buổi nói chuyện em xin gửi tới {{$data['cus_name']}} bản báo giá.<br>
Thông tin chi tiết trong tệp đính kèm.<br>
<br><br>
Trân trọng,<br>
{{$data['sale_name']}}
</body>
</html>