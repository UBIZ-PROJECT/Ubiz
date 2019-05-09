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
}
