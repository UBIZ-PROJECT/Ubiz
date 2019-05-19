<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Pricing;

class PricingController extends Controller
{
    public function getPricingList(Request $request)
    {
        try {
			list($page, $sort, $search) = $this->getRequestData($request);
            $pricing = new Pricing();
            $pricingList = $pricing->getPricingList($page, $sort, $search);
            $paging = $pricing->getPagingInfo();
            $paging['page'] = $page;
			foreach($pricingList as $key => $item){
				$pricingProducts = $pricing->getPricingProduct($item->cus_id);
				$pricingList[$key]->product = $pricingProducts;
			}
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['pricingList' => $pricingList, 'paging' => $paging, 'success' => true, 'message' => ''], 200);
    }
	
	public function getPricing(Request $request)
    {
        try {
			if ($request->has('page')) {
				$page = $request->page;
			}else{
				$page = 0;
			}

			if ($request->has('sort')) {
				$sort = $request->sort;
			}else{
				$sort = '';
			}
			
			if ($request->has('order')) {
				$order = $request->order;
			}else{
				$order = '';
			}
			
            $pricing = new Pricing();
			if($request->pri_id != 0){
				$pricings = $pricing->getPricing($request->pri_id);
			}else{
				$pricings = $pricing->getPricingPaging($request->index, $sort, $order);
			}
			$totalPricing = $pricing->countPricing();
			$pricingProducts = $pricing->getPricingProduct($pricings[0]->pri_id);
			$pricings[0]->product = $pricingProducts;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['pricings' => $pricings, 'totalPricing' => $totalPricing, 'success' => true, 'message' => ''], 200);
    }
	
	public function insertPricing(Request $request)
    {
        try {
            $pricing = new Pricing();
            $priCode = $pricing->insertPricing($request);
            list($page, $sort, $search) = $this->getRequestData($request);
            $pricingList = $pricing->getPricingList($page, $sort, $search);
            $paging = $pricing->getPagingInfo();
            $paging['page'] = $page;
            foreach($pricingList as $key => $item){
                $pricingProducts = $pricing->getPricingProduct($item->pri_id);
                $pricingList[$key]->product = $pricingProducts;
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['pricingList' => $pricingList, 'paging' => $paging, 'success' => true, 'message' => 'Tạo thành công báo giá với mã báo giá ['.$priCode.']'], 200);
    }
	
	public function updatePricing(Request $request)
    {
        try {
            $pricing = new Pricing();
            $pricing->updatePricing($request);
            unset($request['pri_code']);
            list($page, $sort, $search) = $this->getRequestData($request);
            $pricingList = $pricing->getPricingList($page, $sort, $search);
            $paging = $pricing->getPagingInfo();
            $paging['page'] = $page;
            foreach($pricingList as $key => $item){
                $pricingProducts = $pricing->getPricingProduct($item->pri_id);
                $pricingList[$key]->product = $pricingProducts;
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['pricingList' => $pricingList, 'paging' => $paging, 'success' => true, 'message' => 'Xử lý thành công'], 200);
    }

    public function deletePricing($ids, Request $request)
    {
        try {
            $pricing = new Pricing();
            $pricing->deletePricing($ids);
            list($page, $sort, $search) = $this->getRequestData($request);
            $pricingList = $pricing->getPricingList($page, $sort, $search);
            $paging = $pricing->getPagingInfo();
            $paging['page'] = $page;
            foreach($pricingList as $key => $item){
				$pricingProducts = $pricing->getPricingProduct($item->pri_id);
				$pricingList[$key]->product = $pricingProducts;
			}
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['pricingList' => $pricingList, 'paging' => $paging, 'success' => true, 'message' => 'Xử lý thành công'], 200);
    }
    
    public function getPricingCustomer(Request $request)
    {
        try {
            
            $pricing = new Pricing();
            $customer = $pricing->getPricingCustomer($request->cus_id);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['customer' => $customer, 'success' => true, 'message' => ''], 200);
    }
	
	public function getRequestData(Request $request)
    {
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
            $search['search'] = $request->search;
        }
        if ($request->has('pri_code')) {
            $search['pri_code'] = $request->pri_code;
        }
        if ($request->has('pri_date')) {
            $search['pri_date'] = $request->pri_date;
        }
		if ($request->has('exp_date')) {
		    $search['exp_date'] = substr($request->exp_date,6,4).'-'.substr($request->exp_date,3,2).'-'.substr($request->exp_date,0,2);
        }
        if ($request->has('contain')) {
            if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/",$request->contain)){
                $request->contain = substr($request->contain,6,4).'-'.substr($request->contain,3,2).'-'.substr($request->contain,0,2);
            }
            $search['contain'] = $request->contain;
        }
        if ($request->has('notcontain')) {
            if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/",$request->notcontain)){
                $request->notcontain = substr($request->notcontain,6,4).'-'.substr($request->notcontain,3,2).'-'.substr($request->notcontain,0,2);
            }
            $search['notcontain'] = $request->notcontain;
        }
        return [$page, $sort, $search];
    }
}
