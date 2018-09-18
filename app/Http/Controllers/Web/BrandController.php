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

class BrandController extends Controller
{
    public function brands() {
        try {
            $brand = new Brand();
            $data = $brand->getBrandPaging(0);
            $paging = $brand->getPagingInfo();
            $paging['page'] = '0';
            return view('brand',['data'=>$data,'paging' => $paging]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}