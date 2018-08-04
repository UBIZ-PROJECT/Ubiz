<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Currency;

class CurrencyController extends Controller
{
    public function getAllCurrency(Request $request)
    {
        try {
            $currency = new Currency();
            $data = $currency->getAllCurrency();
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['currency' => $data, 'success' => true, 'message' => ''], 200);
    }

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

    public function getCurrencyById($id){
        try{
            $currency = new Currency();
            $data = $currency->getCurrencyById($id);
        }catch (\Throwable $e){
            throw $e;
        }
        return response()->json(['currency' => $data, 'success' => true, 'message' => ''],200);
    }

    public  function insertCurrency(Request $request){
        try{
            $param[] = '';
            $param['cur_name'] = $request->txt_name;
            $param['cur_code'] = $request->txt_code;
            $param['cur_symbol'] = $request->txt_symbol;
            $param['cur_state'] = $request->txt_state;
            $param['cur_avatar'] = $request->avatar;
            $currency = new Currency();
            $currency->insertCurrency($param);
        } catch (\Throwable $e){
            throw $e;
        }
        return response()->json(['success' => true, 'message' => 'Insert success'], 200);
    }

    public  function updatedCurrency($id, Request $request){
        try{
            $param = [];
            $param['cur_id'] = $id;
            $param['cur_name'] = $request->txt_name;
            $param['cur_code'] = $request->txt_code;
            $param['cur_symbol'] = $request->txt_symbol;
            $param['cur_state'] = $request->txt_state;
            if ($request->hasFile('avatar')) {
                $param['cur_avatar'] = $request->avatar;
            }
            $currency = new Currency();
            $currency->updateCurrency($param);
        } catch (\Throwable $e){
            throw $e;
        }
        return response()->json(['success' => true, 'message' => ''], 200);
    }

    public function deleteCurrency($ids, Request $request)
    {
        try {
            $currency = new Currency();
            $id = explode(',', $ids);
            $currency->deleteCurrency($id);
            $currencies = $currency->getCurrency();
            $paging = $currency->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['currency' => $currencies, 'paging' => $paging , 'success' => true, 'message' => __("Successfully processed.")], 200);
    }
}
