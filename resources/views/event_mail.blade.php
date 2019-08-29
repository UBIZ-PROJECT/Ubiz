<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<table style="width:100%; margin-bottom: 20px" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td style="height: 60px; width: 70px;;color: #fff; background-color: #4184f3; text-align: center">
            {{--{{ $data['event_date_day'] }}<br>--}}
            {{--{{ $data['event_date_month'] }}--}}
        </td>
        <td style="width: auto;background-color: #ddd;color: #666;padding-left: 20px">
            {{--{{ $data['event_title_1'] }}--}}
        </td>
    </tr>
    </tbody>
</table>
<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td style="height: 40px; vertical-align: top; width: 70px;text-align: center;color: #666">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#666">
                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
            </svg>
        </td>
        <td style="width: auto;padding-left: 20px;color: #666;vertical-align: top">
            {{--{{ $data['event_time'] }}--}}
        </td>
    </tr>
    <tr>
        <td style="height: 40px; vertical-align: top; width: 70px;text-align: center;color: #666">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#666">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
            </svg>
        </td>
        <td style="width: auto;padding-left: 20px;color: #666;vertical-align: top">
            <ul style="margin: 0;padding: 0; list-style: none">
{{--                @foreach($data['event_pic'] as $pic)--}}
{{--                    <li><span>{{$pic['name']}}</span><span><</span>{{ $pic['email'] }}<span>></span>{{ $pic['organizer'] }}</li>--}}
                {{--@endforeach--}}
            </ul>
        </td>
    </tr>
    <tr>
        <td style="height: 40px; vertical-align: top; width: 70px;text-align: center;color: #666">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#666">
                <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                <path d="M0 0h24v24H0z" fill="none"/>
            </svg>
        </td>
        <td style="width: auto;padding-left: 20px;color: #666;vertical-align: top; font-weight: bold">
            {{--{{ $data['event_title_2'] }}--}}
        </td>
    </tr>
    <tr>
        <td style="height: 40px; vertical-align: top; width: 70px;text-align: center;color: #666">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#666">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                <path d="M0 0h24v24H0z" fill="none"/>
            </svg>
        </td>
        <td style="width: auto;padding-left: 20px;color: #666;vertical-align: top; font-weight: bold">
            {{--{{ $data['event_location'] }}--}}
        </td>
    </tr>
    <tr>
        <td style="height: 50px; vertical-align: middle; width: auto">
{{--            <a href="{{ $data['event_link'] }}"--}}
               {{--style="line-height: 16px;color: #ffffff;font-weight: 400;text-decoration: none;font-size: 14px;padding: 10px 24px;background-color: #4184f3;border-radius: 5px;min-width: 90px;">--}}
                {{--Chi tiết--}}
            {{--</a>--}}
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>