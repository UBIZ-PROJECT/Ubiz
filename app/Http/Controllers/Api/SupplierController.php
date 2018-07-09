<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/8/2018
 * Time: 8:39 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function getSuppliers(Request $request)
    {
        $page = 0;
        if ($request->has('page')) {
            $page = $request->page;
        }

        $supplier = new Supplier();
        $data = $supplier->getSupplierPaging($page);
        echo json_encode($data);
    }

    public function getSupplierById($id) {
        $supplier = new Supplier();
        $data = $supplier->getSupplierById($id);
        echo json_encode($data);
    }

    public function insertSupplier(Request $request) {
        $supplier = new Supplier();
        $id = $supplier->insertSupplier($request->data);
        if (empty($id)) {
            echo json_encode(array('insert'=>'fail'));
        } else {
            echo json_encode(array('insert'=>'true'));
        }
    }
}