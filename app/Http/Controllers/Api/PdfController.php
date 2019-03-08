<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \PDF;
use App\Model\Pricing;

class PdfController extends Controller
{
    public function exportPdf(Request $request)
    {
//         print_r($request->request);exit;
        $pricing = new Pricing();
        $customer = $pricing->getPricingCustomer($request['cus_id']);
        $sale = $pricing->getPricingSale($request['user_id']);
        
        $data = $request;	
        $data['customer'] = $customer[0];
        $data['sale'] = $sale[0];
        $data['pri_export_date'] = date("d/m/Y");
    	$pdf = PDF::loadView('pricing_pdf',  compact('data'));
//     	$pdf->save(storage_path().'/baogia.pdf');
    	
    	return base64_encode($pdf->download('baogia.pdf'));
    }
	
}
