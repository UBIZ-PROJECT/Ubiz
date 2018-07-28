<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Currency;

class CurrencyController extends Controller
{
    public function getCurrency(Request $request)
    {
        try {

            $page = 0;
            if ($request->has('page')) {
                $page = $request->page;
            }

            $sort = '';
            if ($request->has('sort')) {
                $sort = $request->sort;
            }

            $currency = new Currency();
            $currencies = $currency->getCurrency($page, $sort);
            $paging = $currency->getPagingInfo();
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['currency' => $currencies, 'paging' => $paging, 'success' => true, 'message' => ''], 200);
    }

    public function deleteCurrency($ids, Request $request)
    {
        try {
            $customer = new Currency();
            $customer->deleteCurrency($ids);
            $customers = $customer->getCurrency(0);
            $paging = $customer->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['currency' => $customers, 'paging' => $paging, 'success' => true, 'message' => 'Xử lý thành công'], 200);
    }
}
