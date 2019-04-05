<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;

class Currency
{
    public function getAllCurrency()
    {
        $currency = DB::table('m_currency')
            ->where([
                ['cur_active_flg', '=', '1'],
                ['delete_flg', '=', '0']
            ])
            ->orderBy('cur_id', 'asc')
            ->get();
        return $currency;
    }

    public function getCurrency($page = 0, $sort = '', $search = [])
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $currency = DB::table('m_currency')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $currency;
    }

    public function getCurrencyById($id)
    {
        try {
            $currency = DB::table('m_currency')
                ->where('cur_id', $id)
                ->first();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $currency;
    }

    public function getCurrencyByPos($pos = 0, $sort = '', $search = [])
    {
        try {

            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $currency = DB::table('m_currency')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($pos - 1)
                ->limit(1)
                ->first();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $currency;
    }

    public function countAllCurrency()
    {
        try {
            $count = DB::table('m_currency')
                ->where([['active_flg', '=', '1'],['delete_flg', '=', '0']])
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    public function countCurrency($search = [])
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            $count = DB::table('m_currency')
                ->whereRaw($where_raw, $params)
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    public function getPagingInfo($search=[])
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countCurrency($search);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function makeWhereRaw($search = [])
    {
        $params = ['1','0'];
        $where_raw = 'm_currency.active_flg = ? AND m_currency.delete_flg = ?';
        if (sizeof($search) > 0) {
            if (isset($search['contain']) || isset($search['notcontain'])) {
                if (isset($search['contain'])) {
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "m_currency.cur_ctr_nm like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_currency.cur_nm like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_currency.cur_cd_alpha like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_currency.cur_symbol like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if (isset($search['notcontain'])) {
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= " AND m_currency.cur_ctr_nm not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_currency.cur_nm not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_currency.cur_cd_alpha not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_currency.cur_symbol not like ?";
                    $params[] = $search_val;
                }

            } else {

                $where_raw_tmp = [];
                if (isset($search['cur_ctr_nm'])) {
                    $where_raw_tmp[] = "m_currency.cur_ctr_nm = ?";
                    $params[] = $search['cur_ctr_nm'];
                }
                if (isset($search['cur_nm'])) {
                    $where_raw_tmp[] = "m_currency.cur_nm = ?";
                    $params[] = $search['cur_nm'];
                }
                if (isset($search['cur_cd_alpha'])) {
                    $where_raw_tmp[] = "m_currency.cur_cd_alpha = ?";
                    $params[] = $search['cur_cd_alpha'];
                }
                if (isset($search['cur_symbol'])) {
                    $where_raw_tmp[] = "m_currency.cur_symbol = ?";
                    $params[] = $search['cur_symbol'];
                }
                if (sizeof($where_raw_tmp) > 0) {
                    $where_raw .= " AND ( " . implode(" OR ", $where_raw_tmp) . " )";
                }
            }
        }
        return [$where_raw, $params];
    }

    public function makeOrderBy($sort)
    {
        $field_name = 'cur_id';
        $order_by = 'asc';
        if ($sort != '') {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $field_name = implode('_', $sort_info);
        }
        return [$field_name, $order_by];
    }

    public function insertCurrency($param)
    {
        DB::beginTransaction();
        try {
            DB::table('m_currency')->insert($param);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateCurrency($param)
    {
        DB::beginTransaction();
        try {
            DB::table('m_currency')
                ->where('cur_id', $param['cur_id'])
                ->update($param);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteCurrency($ids)
    {
        DB::beginTransaction();
        try {
            DB::table('m_currency')
                ->whereIn('cur_id', $ids)
                ->update([
                    'delete_flg' => '1',
                    'upd_date' => date('Y-m-d H:i:s')
                ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return response()->json(['success']);
    }

}
