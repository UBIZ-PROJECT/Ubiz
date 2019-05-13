<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Helper;

class CustomerAddress
{

    public function getAddressByCusId($cus_id)
    {
        try {
            $data = DB::table('customer_address')
                ->select('cad_id', 'cad_address')
                ->where([
                    ['cus_id', '=', $cus_id],
                    ['delete_flg','=', '0']
                ])->get();

            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
