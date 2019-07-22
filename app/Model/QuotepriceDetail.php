<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuotepriceDetail
{

    public function getQuotepriceDetailsByQpId($qp_id)
    {
        try {
            $data = DB::table('quoteprice_detail')
                ->select('quoteprice_detail.*')
                ->where([
                    ['qp_id', '=', $qp_id],
                    ['owner_id', '=', Auth::user()->id]
                ])
                ->where('quoteprice_detail.delete_flg', '0')
                ->orderBy('quoteprice_detail.sort_no')
                ->get();
            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteQuotepriceDetailsByIds($qpdt_ids = [])
    {
        try {
            DB::table('quoteprice_detail')
                ->where('owner_id', Auth::user()->id)
                ->whereIn('qpdt_id', $qpdt_ids)
                ->update([
                    'delete_flg' => '1',
                    'upd_user' => Auth::user()->id
                ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteQuotepriceDetailsByQpIds($qp_ids = '')
    {
        try {
            DB::table('quoteprice_detail')
                ->where('owner_id', Auth::user()->id)
                ->whereIn('qp_id', explode(',', $qp_ids))
                ->update([
                    'delete_flg' => '1',
                    'upd_user' => Auth::user()->id
                ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function insertQuotepriceDetail($quoteprice_details)
    {
        try {
            DB::table('quoteprice_detail')->insert($quoteprice_details);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateQuotepriceDetail($quoteprice_detail)
    {
        try {
            $qpdt_id = $quoteprice_detail['qpdt_id'];
            unset($quoteprice_detail['qpdt_id']);
            DB::table('quoteprice_detail')
                ->where([
                    ['owner_id', '=', Auth::user()->id],
                    ['qpdt_id', '=', $qpdt_id]
                ])
                ->update($quoteprice_detail);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
