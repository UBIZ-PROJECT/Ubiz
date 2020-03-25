<?php
/**
 * Created by PhpStorm.
 * User: hoait
 * Date: 9/23/2019
 * Time: 9:27 PM
 */

namespace App\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContractDetail
{
    public function getContractDetailsByCtrId($ctr_id)
    {
        try {
            $data = DB::table('contract_detail')
                ->select('contract_detail.*')
                ->where([
                    ['ctr_id', '=', $ctr_id],
                    ['owner_id', '=', Auth::user()->id]
                ])
                ->where('contract_detail.delete_flg', '0')
                ->orderBy('contract_detail.sort_no')
                ->get();
            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteContractDetailsByIds($ordt_ids = [])
    {
        try {
            DB::table('contract_detail')
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

    public function deleteContractDetailsByCtrIds($ctr_ids = '')
    {
        try {
            DB::table('contract_detail')
                ->where('owner_id', Auth::user()->id)
                ->whereIn('ctr_id', explode(',', $ctr_ids))
                ->update([
                    'delete_flg' => '1',
                    'upd_user' => Auth::user()->id
                ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function insertContractDetail($contract_details)
    {
        try {
            DB::table('contract_detail')->insert($contract_details);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateContractDetail($contract_detail)
    {
        try {
            $ordt_id = $contract_detail['ordt_id'];
            unset($contract_detail['ordt_id']);
            DB::table('contract_detail')
                ->where([
                    ['owner_id', '=', Auth::user()->id],
                    ['ordt_id', '=', $ordt_id]
                ])
                ->update($contract_detail);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}