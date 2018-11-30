<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Currency;
use App\User;

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
            list($page, $sort, $search) = $this->getRequestData($request);

            $currency = new Currency();
            $currencies = $currency->getCurrency($page, $sort, $search);
            $paging = $currency->getPagingInfo();
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['currency' => $currencies, 'paging' => $paging, 'success' => true, 'message' => ''], 200);
    }

    public function getCurrencyById($id, Request $request)
    {
        try {
            $currency = new Currency();
            if ($request->has('pos')) {
                list ($page, $sort, $search) = $this->getRequestData($request);
                $data = $currency->getCurrencyByPos($request->pos, $sort, $search);
            } else {
                $data = $currency->getCurrencyById($id);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['currency' => $data, 'success' => true, 'message' => ''], 200);
    }

    public function insertCurrency(Request $request)
    {
        try {
            $param = [];
            $param['cur_name'] = $request->txt_name;
            $param['cur_code'] = $request->txt_code;
            $param['cur_symbol'] = $request->txt_symbol;
            $param['cur_state'] = $request->txt_state;
            $param['inp_date'] = date('Y-m-d H:i:s');
            $user = new User();
            $data = $user->getAuthUser();
            $param['inp_user'] = $data->id;
            $param['upd_user'] = $data->id;
            if ($request->hasFile('avatar')) {
                $param['cur_avatar'] = $request->avatar;
            }
            $currency = new Currency();
            $currency->insertCurrency($param);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => 'Insert success'], 200);
    }

    public function updatedCurrency($id, Request $request)
    {
        try {
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
        } catch (\Throwable $e) {
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
        return response()->json(['currency' => $currencies, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed.")], 200);
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
        if ($request->has('name')) {
            $search['name'] = $request->name;
        }
        if ($request->has('code')) {
            $search['code'] = $request->code;
        }
        if ($request->has('symbol')) {
            $search['symbol'] = $request->symbol;
        }
        if ($request->has('state')) {
            $search['state'] = $request->state;
        }
        if ($request->has('contain')) {
            $search['contain'] = $request->contain;
        }
        if ($request->has('notcontain')) {
            $search['notcontain'] = $request->notcontain;
        }

        $currency = [];
        if ($request->has('txt_name')) {
            $currency['name'] = $request->txt_name;
        }
        if ($request->has('txt_code')) {
            $currency['code'] = $request->txt_code;
        }
        if ($request->has('txt_symbol')) {
            $currency['symbol'] = $request->txt_symbol;
        }
        if ($request->has('txt_state')) {
            $currency['state'] = $request->txt_state;
        }
        if ($request->hasFile('avatar')) {
            $currency['avatar'] = $request->avatar;
        }

        return [$page, $sort, $search, $currency];
    }
}
