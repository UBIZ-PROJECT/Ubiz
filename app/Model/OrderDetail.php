<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helper;

class OrderDetail
{

    public function getOrderDetailsByOrdId($ord_id)
    {
        try {
            $data = DB::table('order_detail')
                ->select('order_detail.*')
                ->where([
                    ['ord_id', '=', $ord_id],
                    ['owner_id', '=', Auth::user()->id]
                ])
                ->where('order_detail.delete_flg', '0')
                ->orderBy('order_detail.sort_no')
                ->get();
            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteOrderDetailsByIds($ordt_ids = [])
    {
        try {
            DB::table('order_detail')
                ->where('owner_id', Auth::user()->id)
                ->whereIn('ordt_id', $ordt_ids)
                ->update([
                    'delete_flg' => '1',
                    'upd_user' => Auth::user()->id
                ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteOrderDetailsByOrdIds($ord_ids = '')
    {
        try {
            DB::table('order_detail')
                ->where('owner_id', Auth::user()->id)
                ->whereIn('ord_id', explode(',', $ord_ids))
                ->update([
                    'delete_flg' => '1',
                    'upd_user' => Auth::user()->id
                ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function insertOrderDetail($order_details)
    {
        try {
            DB::table('order_detail')->insert($order_details);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateOrderDetail($order_detail)
    {
        try {
            $ordt_id = $order_detail['ordt_id'];
            unset($order_detail['ordt_id']);
            DB::table('order_detail')
                ->where([
                    ['owner_id', '=', Auth::user()->id],
                    ['ordt_id', '=',$ordt_id]
                ])
                ->update($order_detail);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
