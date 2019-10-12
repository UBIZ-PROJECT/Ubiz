<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/10/2019
 * Time: 11:43 PM
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Model\Accessory;
use App\User;
use App\Model\Brand;

class AccessoryController extends Controller
{
    public function accessories() {
        try {
            $brand = new Brand();
            $acs = new Accessory();
            $user = new User();
            $allUser = $user->getAllUsers();
            $data = $brand->getBrandPaging(0,'', array("type"=>"1"));
            $paging = $brand->getPagingInfo();
            $paging['page'] = '0';
            $productType = $acs->getAllAccessoryType();
            return view('product',['data'=>$data,'paging' => $paging,'product_type'=>$productType,'users'=>$allUser]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}