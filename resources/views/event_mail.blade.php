<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<table style="width:100%; margin-bottom: 20px" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td style="height: 60px; width: 70px;color: #fff; background-color: #4184f3; text-align: center">
            {{ $data['event_date_day'] }}<br>
            {{ $data['event_date_month'] }}
        </td>
        <td style="width: auto;background-color: #ddd;color: #666;padding-left: 20px">
            {{ $data['event_title_1'] }}
        </td>
    </tr>
    </tbody>
</table>
<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td style="padding-top: 5px;padding-bottom: 5px; vertical-align: top; width: 70px;text-align: center;color: #666">
            <img style="width: 18px; height: 18px" src="{{ $message->embed(public_path() . "/images/time.png") }}">
        </td>
        <td style="padding-top: 5px;padding-bottom: 5px; width: auto;padding-left: 20px;color: #666;vertical-align: top; font-weight: bold">
            @if($data['event_time'] == '')
                {{ $data['event_day'] }}<br>
                {{ $data['event_time'] }}
            @else
                {{ $data['event_day'] }}
            @endif
        </td>
    </tr>
    @if($data['event_pic_see_list'] == '1')
        <tr>
            <td style="padding-top: 5px;padding-bottom: 5px; vertical-align: top; width: 70px;text-align: center;color: #666">
                <img style="width: 18px; height: 18px" src="{{ $message->embed(public_path() . "/images/pic.png") }}">
            </td>
            <td style="padding-top: 5px;padding-bottom: 5px;width: auto;padding-left: 20px;color: #666;vertical-align: top">
                <ul style="margin: 0;padding: 0; list-style: none">
                    @foreach($data['event_pic'] as $pic)
                        <li style="margin: 0;padding: 0;">
                        <span>
                            <b>{{$pic['name']}}</b>
                        </span>
                            <span>
                            <
                        </span>
                            {{ $pic['email'] }}
                            <span>
                            >
                        </span>
                            {{ $pic['organizer'] }}
                        </li>
                    @endforeach
                </ul>
            </td>
        </tr>
    @endif
    <tr>
        <td style="padding-top: 5px;padding-bottom: 5px; vertical-align: top; width: 70px;text-align: center;color: #666">
            <img style="width: 18px; height: 18px" src="{{ $message->embed(public_path() . "/images/money.png") }}">
        </td>
        <td style="padding-top: 5px;padding-bottom: 5px;width: auto;padding-left: 20px;color: #666;vertical-align: top">
            <b>{{$data['event_fee']}}</b>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 5px;padding-bottom: 5px; vertical-align: top; width: 70px;text-align: center;color: #666">
            <img style="width: 18px; height: 18px" src="{{ $message->embed(public_path() . "/images/event.png") }}">
        </td>
        <td style="padding-top: 5px;padding-bottom: 5px; width: auto;padding-left: 20px;color: #666;vertical-align: top; font-weight: bold">
            {{ $data['event_title_2'] }}
        </td>
    </tr>
    <tr>
        <td style="padding-top: 5px;padding-bottom: 5px; vertical-align: top; width: 70px;text-align: center;color: #666">
            <img style="width: 18px; height: 18px" src="{{ $message->embed(public_path() . "/images/location.png") }}">
        </td>
        <td style="padding-top: 5px;padding-bottom: 5px; width: auto;padding-left: 20px;color: #666;vertical-align: top; font-weight: bold">
            {{ $data['event_location'] }}
        </td>
    </tr>
    </tbody>
</table>
<div style="margin-top: 5px;">&nbsp;</div>
<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td style="padding-top: 5px;padding-bottom: 5px; vertical-align: top; min-height: 50px; width: 70px;text-align: center;color: #666">
            <img style="width: 18px; height: 18px" src="{{ $message->embed(public_path() . "/images/note.png") }}">
        </td>
        <td style="padding-top: 5px;padding-bottom: 5px; width: auto;padding-left: 20px;background-color: #ddd;color: #666;vertical-align: top;">
            <pre>{{ $data['event_desc'] }}</pre>
        </td>
    </tr>
    </tbody>
</table>
<div style="margin-top: 5px;">&nbsp;</div>
<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td style="padding-top: 5px;padding-bottom: 5px; vertical-align: top; min-height: 50px; width: 70px;text-align: center;color: #666">
            <img style="width: 18px; height: 18px" src="{{ $message->embed(public_path() . "/images/result.png") }}">
        </td>
        <td style="padding-top: 5px;padding-bottom: 5px; width: auto; padding-left: 20px;background-color: #ddd;color: #666;vertical-align: top;">
            <pre>{{ $data['event_result'] }}</pre>
        </td>
    </tr>
    </tbody>
</table>
<div style="margin-top: 5px;">&nbsp;</div>
<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td style="vertical-align: middle; width: auto">
            <a href="{{ $data['event_link'] }}" style="line-height: 16px;color: #ffffff;font-weight: 400;text-decoration: none;font-size: 14px;padding: 10px 24px;background-color: #4184f3;border-radius: 5px;min-width: 90px;">
                Chi tiết
            </a>
        </td>
    </tr>
    </tbody>
</table>
<div style="margin-top: 5px">&nbsp;</div>
</body>
</html>