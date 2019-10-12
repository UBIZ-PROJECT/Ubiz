<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/7/2019
 * Time: 2:36 AM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Accessory;
use App\Model\Product;
use Illuminate\Http\Request;
class AccessoryController extends Controller
{
    public function getAccessory(Request $req) {
        try {
            list($page, $sort,$search) = $this->getPageSortSearch($req);
            $acs = new Accessory();
            $data = $acs->getAccessoryPaging($page, $sort,$search);
            $paging = $acs->getPagingInfo($sort,$search);
            $productType = $acs->getAllAccessoryType();
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['product' => $data, "product_type" => $productType ,'paging' => $paging,'success' => true, 'message' => '', 'search'=>$search], 200);
    }

    public function getEachAccessoryPaging(Request $req) {
        try {
            list($page, $sort,$search) = $this->getPageSortSearch($req);
            $acs = new Accessory();
            $data = $acs->getEachAccessoryPaging($page, $sort,$search);
            $paging = $acs->getPagingInfoDetailAccessoryWithConditionSearch($sort,$search);
            $productType = $acs->getAllAccessoryType();
            $paging['page'] = $page;
            $paging['rows_per_page'] = 1;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['product' => $data, "product_type" => $productType ,'paging' => $paging,'success' => true, 'message' => '', 'search'=>$search], 200);
    }

    public function getAccessoryType() {
        try {
            $acs = new Accessory();
            $productType = $acs->getAllAccessoryType();
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(["product_type" => $productType, 'success' => true, 'message' => ''], 200);
    }

    public function insertAccessory(Request $request) {
        try {
            $message = __("Successfully processed.");
            if ($request->has("accessory")) { //accessory
                list($page, $sort, $search) = $this->getPageSortSearch($request);
                $params = json_decode($request->input('accessory'), true);
                if ($request->has("keeper")) {
                    $params['keeper'] = json_decode($request->input("keeper"), true);
                }
                if (!empty($request->file('image-upload'))) {
                    foreach ($request->file('image-upload') as $index=>$imageUpload) {
                        $params['images'][$index]['extension'] = $imageUpload->getClientOriginalExtension();
                        $params['images'][$index]['temp_name'] = $imageUpload->getRealPath();
                    }
                }
                $acs = new Accessory();
                $acs->insertAccessory($params);
                $data = $acs->getAccessoryPaging($page, $sort,$search);
                $paging = $acs->getPagingInfo($sort,$search);
                $productType = $acs->getAllAccessoryType();
                $paging['page'] = $page;
            } else {
                $message = '';
            }
        } catch(\Throwable $e) {
            throw $e;
        }
        return response()->json(['product' => $data, "product_type" => $productType ,'paging' => $paging,'success' => true, 'message' => $message, 'search'=>$search,'method'=>'insert'], 200);
    }

    public function updateAccessory($id, Request $request) {
        try {
            $message = __("Successfully processed.");
            if ($request->has("accessory")) {
                list($page, $sort, $search) = $this->getPageSortSearch($request);
                $params = json_decode($request->input('accessory'), true);
                $params['id'] = $id;
                if (!empty($request->file('image-upload'))) {
                    foreach ($request->file('image-upload') as $index=>$imageUpload) {
                        $params['images']['insert'][$index]['extension'] = $imageUpload->getClientOriginalExtension();
                        $params['images']['insert'][$index]['temp_name'] = $imageUpload->getRealPath();
                    }
                }
                $acs = new Accessory();
                $acs->updateAccessory($params);
                $data = $acs->getAccessoryPaging($page, $sort,$search);
                $paging = $acs->getPagingInfo($sort,$search);
                $productType = $acs->getAllAccessoryType();
                $paging['page'] = $page;
            } else {
                $message = '';
            }
        } catch(\Throwable $e) {
            throw $e;
        }
        return response()->json(['product' => $data, "product_type" => $productType ,'paging' => $paging,'success' => true, 'message' => $message, 'search'=>$search,'method'=>'update'], 200);
    }

    public function updateAccessoryPaging($id, Request $request) {
        try {
            $message = __("Successfully processed.");
            if ($request->has("accessory")) {
                list($page, $sort, $search) = $this->getPageSortSearch($request);
                $params = json_decode($request->input('accessory'), true);
                $params['id'] = $id;
                if (!empty($request->file('image-upload'))) {
                    foreach ($request->file('image-upload') as $index=>$imageUpload) {
                        $params['images']['insert'][$index]['extension'] = $imageUpload->getClientOriginalExtension();
                        $params['images']['insert'][$index]['temp_name'] = $imageUpload->getRealPath();
                    }
                }
                $acs = new Accessory();
                $acs->updateAccessory($params);
            } else {
                $message = '';
            }
        } catch(\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => $message, 'search'=>$search], 200);
    }

    public function deleteAccessory($ids, Request $request) {
        try {
            $message = __("Successfully processed.");
            list($page, $sort, $search) = $this->getPageSortSearch($request);
            $acs = new Accessory();
            $ids = json_decode($ids,true);
            $acs->deleteAccessory($ids);
            $data = $acs->getAccessoryPaging($page,$sort,$search);
            $paging = $acs->getPagingInfo($sort,$search);
            $productType = $acs->getAllAccessoryType();
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['product' => $data, "product_type" => $productType ,'paging' => $paging,'success' => true, 'message' => $message, 'search'=>$search,'method'=>'delete'], 200);
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
        $search = [];
        if ($request->has('search')) {
            $search = json_decode($request->search, true);
        }
        return array($page, $sort, $search);
    }
}