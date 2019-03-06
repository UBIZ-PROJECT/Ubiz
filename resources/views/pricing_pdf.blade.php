<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<style>
body {
    font-family: DejaVu Sans;
	font-size: 12px;
}

#company-info{
    width: 100%;
}

#company-info td{
	padding: 5px;
}

#customer-info{
    width: 100%;
}

#customer-info td{
	padding: 5px;
}
</style>
</head>

<body>

<table border="1" cellpadding="0" cellspacing="0" id="company-info">
	<tr>
		<td rowspan="5"><center><img src="{{ asset('images/tkt_pumps_logo.jpg') }}" style="width: 150px; height: 150px"/></center></td>
		<td colspan="2"><b>CÔNG TY TNHH KỸ THUẬT THƯƠNG MẠI THÁI KHƯƠNG</b></td>
	</tr>
	
	<tr>
		<td colspan="2"><b>Địa chỉ:</b> 38A Phan Văn Sửu, Phường 13, Q. Tân Bình, TP. HCM, Việt Nam</td>
	</tr>
	
	<tr>
		<td><b>Điện thoại:</b> (+84) 28 3813 4728/ 29</td>
		<td><b>Fax:</b> (+84) 28 3813 4727</td>
	</tr>
		
	<tr>
		<td><b>Website:</b> www.thaikhuongpump.com</td>
		<td><b>Email:</b> info@thaikhuongpump.com</td>
	</tr>
	
	<tr>
		<td><b>Hotline:</b> (+84) 941 400 488</td>
		<td><b>MST:</b> 0304844502</td>
	</tr>
</table>
<center><h1>BÁO GIÁ</h1></center><br><br>
<table border="1" cellpadding="0" cellspacing="0" id="customer-info">
	<tr>
    	<td colspan="2">Số báo giá: {{ $data['pri_id'] }}</td>
    	<td colspan="2">Ngày báo giá: {{ $data['pri_export_date'] }}</td>
	</tr>
	<tr>
		<td>Khách hàng (công ty):</td>
		<td colspan="3"></td>
	</tr>
	<tr>
		<td>Địa chỉ công ty:</td>
		<td colspan="3"></td>
	</tr>
	<tr>
		<td>Điện thoại công ty:</td>
		<td></td>
		<td>Fax:</td>
		<td></td>
	</tr>
	<tr>
		<td>Người liên hệ:</td>
		<td></td>
		<td>NV kinh doanh:</td>
		<td></td>
	</tr>
	<tr>
		<td>Chức vụ:</td>
		<td></td>
		<td>Chức vụ:</td>
		<td></td>
	</tr>
	<tr>
		<td>Di động:</td>
		<td></td>
		<td>Di động:</td>
		<td></td>
	</tr>
	<tr>
		<td>Email:</td>
		<td></td>
		<td>Email:</td>
		<td></td>
	</tr>
</table>
<img src="{{ asset('images/partner.png') }}" style="width:100%"/>
<span>Rất cảm ơn Quý Công Ty đã quan tâm đến sản phẩm và dịch vụ của Công ty Thái Khương.
Theo như yêu cầu, Thái Khương xin hân hạnh gửi đến Quý Công ty bảng chào giá như sau:</span>
</body>

</html>