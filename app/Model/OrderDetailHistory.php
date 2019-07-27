<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderDetailHistory
{

    public function getOrderDetailsByOrdId($ord_id, $his_ord_id)
    {
        try {
            $data = DB::table('his_order_detail')
                ->select('his_order_detail.*')
                ->where([
                    ['ord_id', '=', $ord_id],
                    ['his_ord_id', '=', $his_ord_id],
                    ['owner_id', '=', Auth::user()->id]
                ])
                ->where('his_order_detail.delete_flg', '0')
                ->orderBy('his_order_detail.sort_no')
                ->get();
            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
