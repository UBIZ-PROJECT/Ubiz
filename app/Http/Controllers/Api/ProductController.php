<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/30/2018
 * Time: 10:42 PM
 */

namespace App\Http\Controllers\Api;

use App\Helper;
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
            $paging = $product->getPagingInfo();
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['product' => $data, 'paging' => $paging,'success' => true, 'message' => '', 'search'=>$search], 200);
    }

    public function getEachProductPaging(Request $req) {
        try {
            list($page, $sort,$search) = $this->getPageSortSearch($req);

            $product = new Product();
            $data = $product->getEachProductPaging($page, $sort,$search);
            $paging = $product->getPagingInfo();
            $paging['page'] = $page;
            $paging['rows_per_page'] = 1;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['product' => $data, 'paging' => $paging,'success' => true, 'message' => '', 'search'=>$search], 200);
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