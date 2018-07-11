<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/5/2018
 * Time: 12:02 AM
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function suppliers(Request $request) {
        $supplier = new Supplier();
        $data = $supplier->getAllSupplier();
        return view('supplier',['data'=>$data]);
    }
}