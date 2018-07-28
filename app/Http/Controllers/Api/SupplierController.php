<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/8/2018
 * Time: 8:39 PM
 */

namespace App\Http\Controllers\Api;


use App\Helper;
use App\Http\Controllers\Controller;
use App\Model\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function getSuppliers(Request $request)
    {
        try {
            list($page, $sort,$search) = $this->getPageSortSearch($request);

            $supplier = new Supplier();
            $data = $supplier->getSupplierPaging($page, $sort,$search);
            $paging = $supplier->getPagingInfo();
            $paging['page'] = $page;
        } catch(\Throwable $e) {
            throw $e;
        }
        
        return response()->json(['supplier' => $data, 'paging' => $paging,'success' => true, 'message' => ''], 200);
    }

    public function getSupplierById($id, Request $request) {
        try {
            $supplier = new Supplier();
            list($page, $sort,$search) = $this->getPageSortSearch($request);
            $data = $supplier->getEachSupplierByPaging($page, $sort,$search);

            $image = Helper::readImage($data[0]->sup_avatar,'sup');
            $data[0]->src = $image;
            $paging = $supplier->getPagingInfo();
            $paging['page'] = $page;
            $paging['rows_per_page'] = 1;
        } catch (\Throwable $e) {
            throw $e;
        }
        
        return response()->json(['supplier' => $data, 'paging' => $paging, 'success' => true, 'message' => ''], 200);
    }

    public function insertSupplier(Request $request) {
        try {
            $params = json_decode($request['supplier'], true);
            list($page, $sort, $search) = $this->getPageSortSearch($request);
            if (!empty($request->file('image-upload'))) {
                $params['extension'] = $request->file('image-upload')->getClientOriginalExtension();
                $params['tmp_name'] = $request->file('image-upload')->getRealPath();
            }

            $supplier = new Supplier();
            $supplier->insertSupplier($params);

            $data = $supplier->getSupplierPaging($page, $sort,$search);
            $paging = $supplier->getPagingInfo();
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }

        return response()->json(['supplier' => $data,'paging' => $paging, 'success' => true, 'message' => __("Successfully processed."),'method'=>'insert'], 200);
    }

    public function deleteSuppliersById($ids, Request $request) {
        try {
            list($page, $sort, $search) = $this->getPageSortSearch($request);
            $supplier = new Supplier();
            $ids = json_decode($ids,true);
            $supplier->deleteSuppliersById($ids);
            $data = $supplier->getSupplierPaging($page,$sort,$search);
            $paging = $supplier->getPagingInfo();
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['supplier' => $data, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed."),'method'=>'delete'], 200);
    }

    public function updateSupplierById($id, Request $request) {
        try {
            $params = json_decode($request->input('supplier'), true);
            $params['sup_id'] = $id;

            list($page, $sort, $search) = $this->getPageSortSearch($request);

            if (!empty($request->file('image-upload'))) {
                $params['extension'] = $request->file('image-upload')->getClientOriginalExtension();
                $params['tmp_name'] = $request->file('image-upload')->getRealPath();
            }
            $supplier = new Supplier();
            $supplier->updateSupplierById($params);

            $data = $supplier->getSupplierPaging($page, $sort, $search);
            $paging = $supplier->getPagingInfo();
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['supplier' => $data,'paging' => $paging, 'success' => true, 'message' => __("Successfully processed."),'method'=>'update'], 200);
    }

    private function getPageSortSearch($request) {
        $page = 0;
        if ($request->has('page')) {
            $page = $request->page;
        }

        $sort = '';
        if ($request->has('sort')) {
            $sort = $request->sort;
        }
        $search = '';
        if ($request->has('search')) {
            $search = json_decode($request->search, true);
        }
        return array($page, $sort, $search);
    }
}