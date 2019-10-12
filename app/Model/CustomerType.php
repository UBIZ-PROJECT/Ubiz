<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;

class CustomerType
{

    public function getAllTypes()
    {
        try {
            $data = DB::table('m_customer_type')
                ->select('m_customer_type.id', 'm_customer_type.title')
                ->where('m_customer_type.delete_flg', '0')->get();

            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
