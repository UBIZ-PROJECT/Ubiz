<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/30/2018
 * Time: 10:42 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Product;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    public function getProduct(Request $req) {
        try {
            list($page, $sort,$search) = $this->getPageSortSearch($req);
            $product = new Product();
            $data = $product->getProductPaging($page, $sort,$search);
            $paging = $product->getPagingInfo($sort,$search);
            $productType = $product->getAllProductType();
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['product' => $data, "product_type" => $productType ,'paging' => $paging,'success' => true, 'message' => '', 'search'=>$search], 200);
    }

    public function getEachProductPaging(Request $req) {
        try {
            list($page, $sort,$search) = $this->getPageSortSearch($req);
            $product = new Product();
            $data = $product->getEachProductPaging($page, $sort,$search);
            $paging = $product->getPagingInfoDetailProductWithConditionSearch($sort,$search);
            $productType = $product->getAllProductType();
            $paging['page'] = $page;
            $paging['rows_per_page'] = 1;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['product' => $data, "product_type" => $productType ,'paging' => $paging,'success' => true, 'message' => '', 'search'=>$search], 200);
    }

    public function getProductType() {
        try {
            $product = new Product();
            $productType = $product->getAllProductType();
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(["product_type" => $productType, 'success' => true, 'message' => ''], 200);
    }

    public function insertProduct(Request $request) {
        try {
            $message = __("Successfully processed.");
            if ($request->has("product")) {
                list($page, $sort, $search) = $this->getPageSortSearch($request);
                $params = json_decode($request->input('product'), true);
                if (!empty($request->file('image-upload'))) {
                    foreach ($request->file('image-upload') as $index=>$imageUpload) {
                        $params['images'][$index]['extension'] = $imageUpload->getClientOriginalExtension();
                        $params['images'][$index]['temp_name'] = $imageUpload->getRealPath();
                    }
                }
                $product = new Product();
                $product->insertProduct($params);
                $data = $product->getProductPaging($page, $sort,$search);
                $paging = $product->getPagingInfo($sort,$search);
                $productType = $product->getAllProductType();
                $paging['page'] = $page;
            } else {
                $message = '';
            }
        } catch(\Throwable $e) {
            throw $e;
        }
        return response()->json(['product' => $data, "product_type" => $productType ,'paging' => $paging,'success' => true, 'message' => $message, 'search'=>$search,'method'=>'insert'], 200);
    }

    public function updateProduct($id, Request $request) {
        try {
            $message = __("Successfully processed.");
            if ($request->has("product")) {
                list($page, $sort, $search) = $this->getPageSortSearch($request);
                $params = json_decode($request->input('product'), true);
                $params['id'] = $id;
                if (!empty($request->file('image-upload'))) {
                    foreach ($request->file('image-upload') as $index=>$imageUpload) {
                        $params['images']['insert'][$index]['extension'] = $imageUpload->getClientOriginalExtension();
                        $params['images']['insert'][$index]['temp_name'] = $imageUpload->getRealPath();
                    }
                }
                $product = new Product();
                $product->updateProduct($params);
                $data = $product->getProductPaging($page, $sort,$search);
                $paging = $product->getPagingInfo($sort,$search);
                $productType = $product->getAllProductType();
                $paging['page'] = $page;
            } else {
                $message = '';
            }
        } catch(\Throwable $e) {
            throw $e;
        }
        return response()->json(['product' => $data, "product_type" => $productType ,'paging' => $paging,'success' => true, 'message' => $message, 'search'=>$search,'method'=>'update'], 200);
    }

    public function updateProductPaging($id, Request $request) {
        try {
            $message = __("Successfully processed.");
            if ($request->has("product")) {
                list($page, $sort, $search) = $this->getPageSortSearch($request);
                $params = json_decode($request->input('product'), true);
                $params['id'] = $id;
                if (!empty($request->file('image-upload'))) {
                    foreach ($request->file('image-upload') as $index=>$imageUpload) {
                        $params['images']['insert'][$index]['extension'] = $imageUpload->getClientOriginalExtension();
                        $params['images']['insert'][$index]['temp_name'] = $imageUpload->getRealPath();
                    }
                }
                $product = new Product();
                $product->updateProduct($params);
            } else {
                $message = '';
            }
        } catch(\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => $message, 'search'=>$search], 200);
    }

    public function deleteProduct($ids, Request $request) {
        try {
            $message = __("Successfully processed.");
            list($page, $sort, $search) = $this->getPageSortSearch($request);
            $product = new Product();
            $ids = json_decode($ids,true);
            $product->deleteProduct($ids);
            $data = $product->getProductPaging($page,$sort,$search);
            $paging = $product->getPagingInfo($sort,$search);
            $productType = $product->getAllProductType();
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