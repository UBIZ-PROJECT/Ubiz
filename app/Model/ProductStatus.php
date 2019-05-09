<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Helper;

class ProductStatus
{

    public function getAllStatus()
    {
        try {
            $data = DB::table('m_product_status')
                ->select('m_product_status.id', 'm_product_status.title')
                ->where('m_product_status.delete_flg', '0')->get();

            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
