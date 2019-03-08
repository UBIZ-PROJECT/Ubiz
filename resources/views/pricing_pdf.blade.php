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

#product-info{
    width: 100%;
}

#product-info td{
	padding: 5px;
}

#comfirm_table{
    width: 100%;
}

#comfirm_table td{
	padding: 5px;
}

ul#rule {list-style-type: none;}

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
    	<td colspan="2"><b>Số báo giá:</b> {{ $data['pri_code'] }}</td>
    	<td colspan="2"><b>Ngày báo giá:</b> {{ $data['pri_export_date'] }}</td>
	</tr>
	<tr>
		<td><b>Khách hàng (công ty):</b></td>
		<td colspan="3">{{ $data['customer']->cus_name }}</td>
	</tr>
	<tr>
		<td><b>Địa chỉ công ty:</b></td>
		<td colspan="3">{{ $data['customer']->cad_address }}</td>
	</tr>
	<tr>
		<td><b>Điện thoại công ty:</b></td>
		<td>{{ $data['customer']->cus_phone }}</td>
		<td><b>Fax:</b></td>
		<td>{{ $data['customer']->cus_fax }}</td>
	</tr>
	<tr>
		<td><b>Người liên hệ:</b></td>
		<td>{{ $data['customer']->cus_name }}</td>
		<td><b>NV kinh doanh:</b></td>
		<td>{{ $data['sale']->name }}</td>
	</tr>
	<tr>
		<td><b>Chức vụ:</b></td>
		<td>Trưởng phòng</td>
		<td><b>Chức vụ:</b></td>
		<td>Nhóm trưởng</td>
	</tr>
	<tr>
		<td><b>Di động:</b></td>
		<td>{{ $data['customer']->cus_phone }}</td>
		<td><b>Di động:</b></td>
		<td>{{ $data['sale']->phone }}</td>
	</tr>
	<tr>
		<td><b>Email:</b></td>
		<td>{{ $data['customer']->cus_mail }}</td>
		<td><b>Email:</b></td>
		<td>{{ $data['sale']->email }}</td>
	</tr>
</table>
<img src="{{ asset('images/partner.png') }}" style="width:100%;margin-top:50px"/>
<br><br>
<div style="margin-top:150px">
<span style="font-size: 14px; font-weight: bold">Rất cảm ơn Quý Công Ty đã quan tâm đến sản phẩm và dịch vụ của Công ty Thái Khương.
Theo như yêu cầu, Thái Khương xin hân hạnh gửi đến Quý Công ty bảng chào giá như sau:</span>
</div>
<br><br>


<table border="1" cellpadding="0" cellspacing="0" id="product-info">
		<tr>
			<td style="background-color: #FFFF00; font-weight: bold">STT</td>
			<td style="background-color: #FFFF00; font-weight: bold">Thông số kỹ thuật chi tiết</td>
			<td style="background-color: #FFFF00; font-weight: bold">Đơn vị</td>
			<td style="background-color: #FFFF00; font-weight: bold">Số lượng</td>
			<td style="background-color: #FFFF00; font-weight: bold">Thời gian giao hàng</td>
			<td style="background-color: #FFFF00; font-weight: bold">Đơn giá (VNĐ)</td>
			<td style="background-color: #FFFF00; font-weight: bold">Thành tiền (VNĐ)</td>
		</tr>
		<?php $i=0;?>
		<?php $total=0;?>
	@foreach($data['pro_id'] as $key => $pro_id)
		<?php $i++;?>
		<tr>
			<td>{{ ($i) }}</td>
			<td><?=isset($data['specs'][$key])?$data['specs'][$key]:$data['name'][$key]?></td>
			<td>{{ $data['unit'][$key] }}</td>
			<td>{{ $data['amount'][$key] }}</td>
			<td>{{ $data['delivery_date'][$key] }}</td>
			<td>{{ $data['price'][$key] }}</td>
			<td>{{ number_format($data['amount'][$key]*str_replace('.','',$data['price'][$key]), 0, '', '.') }}</td>
		</tr>
		<?php $total+=($data['amount'][$key]*str_replace('.','',$data['price'][$key]));?>
	 @endforeach
	 <tr>
	 	<td colspan="6"><b>Tổng giá trị đơn hàng (trước thuế VAT)</b></td>
	 	<td>{{ number_format($total, 0, '', '.') }}</td>
	 </tr>
	 <tr>
	 	<td colspan="6"><b>Thuế VAT 10%</td>
	 	<td>{{ number_format(($total*10)/100, 0, '', '.') }}</b></td>
	 </tr>
	 <tr>
	 	<td colspan="6"><b>Tổng giá trị đơn hàng (đã bao gồm thuế VAT)</b></td>
	 	<td>{{ number_format($total+(($total*10)/100), 0, '', '.') }}</td>
	 </tr>
</table>
<p style="font-size:13px; font-weight:bold">ĐIỀU KHOẢN THƯƠNG MẠI</p>
<ul id="rule">
	<li><b>1.</b> Giá trị bảng chào giá : 30 ngày tính từ ngày báo giá</li>
	<li><b>2.</b> Thời gian bảo hành : 12 tháng tính từ ngày giao hàng (không bảo hành phụ tùng)</li>
	<li><b>3.</b> Điều kiện thanh toán : 100% trước khi giao hàng</li>
	<li><b>4.</b> Địa điểm giao hàng : tại nội thành TP. Hồ Chí Minh</li>
	<li><b>5.</b> Thông tin tài khoản : <b>249 88 789 tại Ngân hàng ACB – Hội sở Thành phố Hồ Chí Minh</b></li>
</ul>
<p><i>Chúng tôi hi vọng chào hàng này đáp ứng được nhu cầu của Quý khách hàng và sớm nhận được đơn hàng.</i></p>
<p><i>Nếu có vấn đề gì chưa rõ, vui lòng liên hệ chúng tôi để được hỗ trợ kịp thời.</i></p>
<br>
<table border="1" cellpadding="0" cellspacing="0" id="comfirm_table">
	<tr>
		<td style="font-weight: bold">Nhân viên kinh doanh</td>
		<td style="font-weight: bold">Xác nhận đặt hàng của quý công ty</td>
	</tr>
	<tr>
		<td style="padding:30px"></td>
		<td style="padding:30px"></td>
	</tr>
</table>

</body>

</html>