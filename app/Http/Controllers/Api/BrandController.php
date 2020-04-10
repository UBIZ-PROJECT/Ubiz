<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/26/2018
 * Time: 1:40 PM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Common\ProductUpload;
use App\Http\Controllers\Controller;
use App\Model\Accessory;
use App\Model\Brand;
use App\Model\Product;
use Illuminate\Http\Request;
class BrandController extends Controller
{
    public function getBrand(Request $req) {
        try {
            checkUserRight(7, 1);
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
            checkUserRight(7, 1);
            $brd_id = '0';
            if ($req->has('brd_id')) {
                $brd_id = $req->brd_id;
            }

            $brand = new Brand();
            $data = $brand->getEachBrandPaging($brd_id);
            if ($data->type == "0") {
                list($data_prd, $paging_prd) = $this->productByBrand($brd_id);
            } else if ($data->type == "1") {
                list($data_prd, $paging_prd) = $this->accessoryByBrand($brd_id);
            }

            $paging['rows_per_page'] = 1;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['brand' => $data, 'paging' => $paging, 'product'=>$data_prd, 'paging_prd'=>$paging_prd ,'success' => true, 'message' => ''], 200);
    }

    private function productByBrand($brd_id) {
        try {
            checkUserRight(7, 1);
            $search['brd_id'] = $brd_id;
            $product = new Product();
            $data = $product->getProductPaging(0,'',$search);
            $paging = $product->getPagingInfo('',$search);
//            $productType = $product->getAllProductType();
            $paging['page'] = '0';
            return array($data, $paging);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    private function accessoryByBrand($brd_id) {
        try {
            checkUserRight(7, 1);
            $search['brd_id'] = $brd_id;
            $accessory = new Accessory();
            $data = $accessory->getAccessoryPaging(0,'',$search);
            $paging = $accessory->getPagingInfo('',$search);
//            $productType = $product->getAllProductType();
            $paging['page'] = '0';
            return array($data, $paging);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function insertBrand(Request $request) {
        try {
            checkUserRight(7, 2);
            $message = __("Successfully processed.");
            if ($request->has("brand")) {
                list($page, $sort, $search) = $this->getPageSortSearch($request);
                $params = json_decode($request->input('brand'), true);
                $search['type'] = $params['type'];
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
            checkUserRight(7, 4);
            $message = __("Successfully processed.");
            if ($request->has("brand")) {
                list($page, $sort, $search) = $this->getPageSortSearch($request);
                $params = json_decode($request->input('brand'), true);
                $params['id'] = $id;
                $search['type'] = $params['type'];
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
            checkUserRight(7, 4);
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
            checkUserRight(7, 3);
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

    public function uploadFile(Request $request) {
        checkUserRight(7, 2);
        $files = $request->file('file');
        $prdUpload = new ProductUpload($files->getClientOriginalExtension());
        $file = [];
        $file['file'] = ["name"=>$files->getClientOriginalName(),
            "tmp_name"=>$files->getRealPath(),
            "size"=>$files->getSize()];
        $message = $prdUpload->uploadFile($file, "file");
        if (empty($message)) {
            return response()->json(['message'=>$message, "success"=>false], 500);
        }
        $prdUpload->analyzeFile();
        $listPathFiles = $prdUpload->getAllFilePathAfterExtract();
        $prdUpload->saveToDatabase($listPathFiles, array("pump", "accessory"));
        return response()->json(['message'=>"Upload file successfully!", "success"=>true], 200);
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
            $search = $request->search;
        }
        return array($page, $sort, $search);
    }
}