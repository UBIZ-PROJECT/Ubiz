<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Helper;

class OrderDetail
{

    public function getOrderDetails($ord_id)
    {
        try {
            $data = DB::table('order_detail')
                ->select('order_detail.*')
                ->where('ord_id', $ord_id)
                ->where('order_detail.delete_flg', '0')
                ->orderBy('order_detail.ordt_id')
                ->get();
            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function insertOrderDetail($ord_id, $order_detail)
    {
        try {
            DB::table('order_detail')->insert(
                [
                    'ord_id' => $ord_id,
                    'pro_id' => $order_detail['pro_id'],
                    'detail' => $order_detail['detail'],
                    'amount' => $order_detail['amount'],
                    'inp_date' => now(),
                    'upd_date' => now(),
                    'inp_user' => '1',
                    'upd_user' => '1'
                ]
            );
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
