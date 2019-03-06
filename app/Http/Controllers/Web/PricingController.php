<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Pricing;

class PricingController extends Controller
{
    public function pricing(Request $request)
    {
		try {
			$pricing = new Pricing();
			$pricingList = $pricing->getAllPricing();
			$paging = $pricing->getPagingInfo();
			$paging['page'] = 0;
	
			return view('pricing', ['pricingList' => $pricingList, 'paging' => $paging]);
		} catch (\Throwable $e) {
            throw $e;
        }
    }

}
