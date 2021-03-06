<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Currency;
use App\User;

class CurrencyController extends Controller
{
    public function search(Request $request)
    {
        try {
            checkUserRight(4,1);
            list($page, $sort, $search) = $this->getRequestData($request);

            $currency = new Currency();
            $currencies = $currency->search($page, $sort, $search);
            $paging = $currency->getPagingInfo($search);
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['currency' => $currencies, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function detail($id, Request $request)
    {
        try {
            checkUserRight(4,1);
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
        return response()->json(['currency' => $data, 'success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function insert(Request $request)
    {
        try {
            checkUserRight(4,2);
            list($page, $sort, $search, $insert_data) = $this->getRequestData($request);
            $currency = new Currency();
            $currency->insert($insert_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => 'Insert success'], 200);
    }

    public function update($id, Request $request)
    {
        try {
            checkUserRight(4,4);
            list($page, $sort, $search, $update_data) = $this->getRequestData($request);
            $currency = new Currency();
            $currency->update($update_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function delete($ids, Request $request)
    {
        try {
            checkUserRight(4,3);
            $currency = new Currency();
            $id = explode(',', $ids);
            $currency->delete($id);
            $currencies = $currency->search();
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

        $search = $request->get('search', '');

        $currency = [];
        if ($request->has('txt_cur_id')) {
            $currency['cur_id'] = $request->txt_cur_id;
        }
        if ($request->has('txt_cur_ctr_nm')) {
            $currency['cur_ctr_nm'] = $request->txt_cur_ctr_nm;
        }
        if ($request->has('txt_cur_ctr_cd_alpha_2')) {
            $currency['cur_ctr_cd_alpha_2'] = $request->txt_cur_ctr_cd_alpha_2;
        }
        if ($request->has('txt_cur_ctr_cd_alpha_3')) {
            $currency['cur_ctr_cd_alpha_3'] = $request->txt_cur_ctr_cd_alpha_3;
        }
        if ($request->has('txt_cur_ctr_cd_numeric')) {
            $currency['cur_ctr_cd_numeric'] = $request->txt_cur_ctr_cd_numeric;
        }
        if ($request->has('txt_cur_nm')) {
            $currency['cur_nm'] = $request->txt_cur_nm;
        }
        if ($request->has('txt_cur_cd_numeric_default')) {
            $currency['cur_cd_numeric_default'] = $request->txt_cur_cd_numeric_default;
        }
        if ($request->has('txt_cur_cd_alpha')) {
            $currency['cur_cd_alpha'] = $request->txt_cur_cd_alpha;
        }
        if ($request->has('txt_cur_cd_numeric')) {
            $currency['cur_cd_numeric'] = $request->txt_cur_cd_numeric;
        }
        if ($request->has('txt_cur_minor_units')) {
            $currency['cur_minor_units'] = $request->txt_cur_minor_units;
        }
        if ($request->has('txt_cur_symbol')) {
            $currency['cur_symbol'] = $request->txt_cur_symbol;
        }
        if ($request->has('txt_active_flg')) {
            $currency['active_flg'] = $request->txt_active_flg;
        }

        return [$page, $sort, $search, $currency];
    }
}
