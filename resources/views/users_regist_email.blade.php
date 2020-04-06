<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<h1>Chào mừng bạn đến với Công ty.</h1>
<span>Dưới đây là thông tin đăng nhập của bạn.</span>
<div style="margin-top: 5px;">&nbsp;</div>
<table style="width:100%; margin-bottom: 20px" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td style="height: 60px; width: 70px;color: #fff; background-color: #4184f3; text-align: center">
            Mã
        </td>
        <td style="width: auto;background-color: #ddd;color: #666;padding-left: 20px">
            {{ $data['user_code'] }}
        </td>
    </tr>
    <tr>
        <td style="height: 60px; width: 70px;color: #fff; background-color: #4184f3; text-align: center">
            Tên
        </td>
        <td style="width: auto;background-color: #ddd;color: #666;padding-left: 20px">
            {{ $data['user_name'] }}
        </td>
    </tr>
    <tr>
        <td style="height: 60px; width: 70px;color: #fff; background-color: #4184f3; text-align: center">
            E-Mail
        </td>
        <td style="width: auto;background-color: #ddd;color: #666;padding-left: 20px">
            {{ $data['user_email'] }}
        </td>
    </tr>
    <tr>
        <td style="height: 60px; width: 70px;color: #fff; background-color: #4184f3; text-align: center">
            Mật khẩu
        </td>
        <td style="width: auto;background-color: #ddd;color: #666;padding-left: 20px">
            {{ $data['user_passwd'] }}
        </td>
    </tr>
    </tbody>
</table>
<div style="margin-top: 5px;">&nbsp;</div>
</body>
</html>