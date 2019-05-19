<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/17/2018
 * Time: 9:13 PM
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Product;
use App\User;

class BrandController extends Controller
{
    public function brands() {
        try {
            $brand = new Brand();
            $user = new User();
            $product = new Product();
            $allUser = $user->getAllUsers();
            $product_type = $product->getAllProductType();
            $data = $brand->getBrandPaging(0);
            $paging = $brand->getPagingInfo();
            $paging['page'] = '0';
            return view('brand',['data'=>$data,'paging' => $paging, 'product_type'=>$product_type, 'users'=>$allUser]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}