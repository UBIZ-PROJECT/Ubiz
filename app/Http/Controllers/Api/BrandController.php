<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/26/2018
 * Time: 1:40 PM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Brand;
use Illuminate\Http\Request;
class BrandController extends Controller
{
    public function getBrand(Request $req) {
        try {
            list($page, $sort,$search) = $this->getPageSortSearch($req);
            $brand = new Brand();
            $data = $brand->getBrandPaging($page, $sort,$search);
            $paging = $brand->getPagingInfo($sort,$search);
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['brand' => $data,'paging' => $paging,'success' => true, 'message' => '', 'search'=>$search], 200);
    }

    public function getEachBrandPaging(Request $req) {
        try {
            list($page, $sort,$search) = $this->getPageSortSearch($req);

            $brand = new Brand();
            $data = $brand->getEachBrandPaging($page, $sort,$search);
            $paging = $brand->getPagingInfoDetailBrandWithConditionSearch($sort,$search);
            $paging['page'] = $page;
            $paging['rows_per_page'] = 1;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['brand' => $data, 'paging' => $paging,'success' => true, 'message' => '', 'search'=>$search], 200);
    }

    public function insertBrand(Request $request) {
        try {
            $message = __("Successfully processed.");
            if ($request->has("brand")) {
                list($page, $sort, $search) = $this->getPageSortSearch($request);
                $params = json_decode($request->input('brand'), true);
                $this->getReqImages($params, $request);
                $brand = new Brand();
                $brand->insertBrand($params);
                $data = $brand->getBrandPaging($page, $sort,$search);
                $paging = $brand->getPagingInfo($sort,$search);
                $paging['page'] = $page;
            } else {
                $message = '';
            }
        } catch(\Throwable $e) {
            throw $e;
        }
        return response()->json(['brand' => $data, 'paging' => $paging,'success' => true, 'message' => $message, 'search'=>$search,'method'=>'insert'], 200);
    }

    public function updateBrand($id, Request $request) {
        try {
            $message = __("Successfully processed.");
            if ($request->has("brand")) {
                list($page, $sort, $search) = $this->getPageSortSearch($request);
                $params = json_decode($request->input('brand'), true);
                $params['id'] = $id;
                $this->getReqImages($params, $request);
                $brand = new Brand();
                $brand->updateBrand($params);
                $data = $brand->getBrandPaging($page, $sort,$search);
                $paging = $brand->getPagingInfo($sort,$search);
                $paging['page'] = $page;
            } else {
                $message = '';
            }
        } catch(\Throwable $e) {
            throw $e;
        }
        return response()->json(['brand' => $data, 'paging' => $paging,'success' => true, 'message' => $message, 'search'=>$search,'method'=>'update'], 200);
    }

    public function updateBrandPaging($id, Request $request) {
        try {
            $message = __("Successfully processed.");
            if ($request->has("brand")) {
                list($page, $sort, $search) = $this->getPageSortSearch($request);
                $params = json_decode($request->input('brand'), true);
                $params['id'] = $id;
                $this->getReqImages($params, $request);
                $brand = new Brand();
                $brand->updateBrand($params);
            } else {
                $message = '';
            }
        } catch(\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => $message, 'search'=>$search], 200);
    }

    public function deleteBrand($ids, Request $request) {
        try {
            $message = __("Successfully processed.");
            list($page, $sort, $search) = $this->getPageSortSearch($request);
            $brand = new Brand();
            $ids = json_decode($ids,true);
            $brand->deleteBrand($ids);
            $data = $brand->getBrandPaging($page,$sort,$search);
            $paging = $brand->getPagingInfo($sort,$search);
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['brand' => $data ,'paging' => $paging,'success' => true, 'message' => $message, 'search'=>$search,'method'=>'delete'], 200);
    }

    private function getReqImages(&$params, $request) {
        if (!empty($request->file('image-upload'))) {
            foreach ($request->file('image-upload') as $index=>$imageUpload) {
                $params['images']['insert'][$index]['extension'] = $imageUpload->getClientOriginalExtension();
                $params['images']['insert'][$index]['temp_name'] = $imageUpload->getRealPath();
            }
        }
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