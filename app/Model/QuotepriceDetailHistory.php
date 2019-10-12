<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuotepriceDetailHistory
{
    public function getQuotepriceDetailsByQpId($qp_id, $his_qp_id)
    {
        try {
            $data = DB::table('his_quoteprice_detail')
                ->select('his_quoteprice_detail.*')
                ->where([
                    ['qp_id', '=', $qp_id],
                    ['his_qp_id', '=', $his_qp_id],
                    ['owner_id', '=', Auth::user()->id]
                ])
                ->where('his_quoteprice_detail.delete_flg', '0')
                ->orderBy('his_quoteprice_detail.sort_no')
                ->get();
            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
