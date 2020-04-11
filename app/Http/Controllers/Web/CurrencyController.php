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
            checkUserRight(4,1);
            $currency = new Currency();
            $currencies = $currency->search();
            $paging = $currency->getPagingInfo();
            $paging['page'] = 0;
            return view('currency', ['currencies' => $currencies, 'paging' => $paging]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

}
