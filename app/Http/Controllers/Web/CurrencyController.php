<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Currency;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        try {
            $currency = new Currency();
            $currencies = $currency->getCurrency();
            $paging = $currency->getPagingInfo();
            $paging['page'] = 0;
            //return response()->json(['currency' => $currencies, 'paging' => $paging, 'success' => true, 'message' => ''], 200);
            return view('currency', ['currencies' => $currencies, 'paging' => $paging]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

}
