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

class AccessoryController extends Controller
{
    public function accessories() {
        try {
            $acs = new Accessory();
            $data = $acs->getAccessoryPaging(0, '','');
            $paging = $acs->getPagingInfo();
            $productType = $acs->getAllAccessoryType();
            $paging['page'] = '0';
            return view('product',['data'=>$data,'paging' => $paging,'product_type'=>$productType]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}