<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \PDF;

class PdfController extends Controller
{
    public function exportPdf(Request $request)
    {
        $data = $request;	
        $data['pri_export_date'] = date("d/m/Y");
    	$pdf = PDF::loadView('pricing_pdf',  compact('data'));
    	$pdf->save(storage_path().'/baogia.pdf');
    	
    	return $pdf->download('baogia.pdf');
    }
	
}
