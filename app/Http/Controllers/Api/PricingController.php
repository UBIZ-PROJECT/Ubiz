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
            $pricing->insertPricing($request);
            list($page, $sort, $search) = $this->getRequestData($request);
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
        return response()->json(['pricingList' => $pricingList, 'paging' => $paging, 'success' => true, 'message' => 'Xử lý thành công'], 200);
    }
	
	public function updatePricing(Request $request)
    {
        try {
            $pricing = new Pricing();
            $pricing->updatePricing($request);
            list($page, $sort, $search) = $this->getRequestData($request);
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
        return response()->json(['pricingList' => $pricingList, 'paging' => $paging, 'success' => true, 'message' => 'Xử lý thành công'], 200);
    }

    public function deletePricing($ids, Request $request)
    {
        try {
            $pricing = new Pricing();
            $pricing->deletePricing($ids);
            $pricings = $pricing->getPricing($request->pri_id);
            $paging = $pricing->getPagingInfo();
            $paging['page'] = 0;
			foreach($pricings as $key => $item){
				$pricingProducts = $pricing->getPricingProduct($item->cus_id);
				$pricings[$key]->product = $pricingProducts;
			}
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['pricings' => $pricings, 'paging' => $paging, 'success' => true, 'message' => 'Xử lý thành công'], 200);
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
            $search['exp_date'] = $request->exp_date;
        }
        if ($request->has('contain')) {
            $search['contain'] = $request->contain;
        }
        if ($request->has('notcontain')) {
            $search['notcontain'] = $request->notcontain;
        }
        return [$page, $sort, $search];
    }
}
