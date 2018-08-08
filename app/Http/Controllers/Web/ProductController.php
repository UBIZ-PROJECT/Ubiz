<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/4/2018
 * Time: 1:03 PM
 */

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Model\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products() {
        try {
            $product = new Product();
            $data = $product->getProductPaging(0);
            $paging = $product->getPagingInfo();
            $productType = $product->getAllProductType();
            $paging['page'] = '0';
            return view('product',['data'=>$data,'paging' => $paging,'product_type'=>$productType]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}