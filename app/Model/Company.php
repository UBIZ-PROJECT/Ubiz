<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;

class Company
{

    public function getPagingInfo()
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countAllCompany();
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function countAllCompany()
    {
        try {
            $count = DB::table('m_company')
                ->where('delete_flg', '0')
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    public function getAllCompany()
    {
        $companies = DB::table('m_company')->get();
        return $companies;
    }

    public  function getCompanyById($id){
        try{
            $company = DB::table('m_company')
                ->where('com_id', $id)
                ->first();
        }catch (\Throwable $e){
            throw $e;
        }
        return $company;
    }

    public function getCurrencyByPos($pos = 0)
    {
        try {

            $currency = DB::table('m_company')
                ->where('delete_flg', '0')
                ->orderBy('com_id', 'asc')
                ->offset($pos - 1)
                ->limit(1)
                ->first();

        } catch (\Throwable $e) {
            throw $e;
        }
        return $currency;
    }

}
