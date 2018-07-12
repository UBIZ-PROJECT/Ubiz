<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/5/2018
 * Time: 12:02 AM
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Model\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function suppliers(Request $request) {
    	try {
			$supplier = new Supplier();
	        $data = $supplier->getSupplierPaging(0);
	        $paging = $supplier->getPagingInfo();
	        $paging['page'] = '0';
        return view('supplier',['data'=>$data,'paging' => $paging]);
    	} catch (\Throwable $e) {
    		throw $e;
    	}
    }
}