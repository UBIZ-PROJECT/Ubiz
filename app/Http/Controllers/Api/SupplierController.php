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
            $page = 0;
            if ($request->has('page')) {
                $page = $request->page;
            }

            $sort = '';
            if ($request->has('sort')) {
                $sort = $request->sort;
            }

            $supplier = new Supplier();
            $data = $supplier->getSupplierPaging($page, $sort);
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
            $page = 0;
            if ($request->has('page')) {
                $page = $request->page;
            }

            $sort = '';
            if ($request->has('sort')) {
                $sort = $request->sort;
            }
            $data = $supplier->getEachSupplierByPaging($page, $sort);

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

    public function insertSupplier() {
        try {
            $params = json_decode($_POST['supplier'], true);

            if (!empty($_FILES)) {
                $path_parts = pathinfo($_FILES['image-upload']["name"]);
                $extension = $path_parts['extension'];
                $params['extension'] = $extension;
                $params['tmp_name'] = $_FILES['image-upload']['tmp_name'];
            }

            $supplier = new Supplier();
            $supplier->insertSupplier($params);

            $data = $supplier->getSupplierPaging(0, '');
            $paging = $supplier->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }

        return response()->json(['supplier' => $data,'paging' => $paging, 'success' => true, 'message' => 'Thêm dữ liệu thành công!'], 200);
    }

    public function deleteSuppliersById(Request $request) {
        try {
            $supplier = new Supplier();
            $listId = $request->listId;
            $supplier->deleteSuppliersById($listId);
            $data = $supplier->getSupplierPaging(0);
            $paging = $supplier->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['supplier' => $data, 'paging' => $paging, 'success' => true, 'message' => 'Xóa dữ liệu thành công!'], 200);
    }

    public function updateSupplierById($id) {
        try {
            $data = $_POST['supplier'];
            $data = json_decode($data, true);
            $data['sup_id'] = $id;

            if (!empty($_FILES)) {
                $path_parts = pathinfo($_FILES['image-upload']["name"]);
                $extension = $path_parts['extension'];
                $data['extension'] = $extension;
                $data['tmp_name'] = $_FILES['image-upload']['tmp_name'];
            }

            $supplier = new Supplier();
            $supplier->updateSupplierById($data);

            $data = $supplier->getSupplierPaging(0, '');
            $paging = $supplier->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['supplier' => $data,'paging' => $paging, 'success' => true, 'message' => 'Sửa dữ liệu thành công!'], 200);
    }
}