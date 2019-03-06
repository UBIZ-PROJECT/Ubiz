<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;

class Order
{
    public function getOrders($page = 0, $sort = '', $search = '')
    {
        try {

            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $orders = DB::table('order')
                ->select('*')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();
            return $orders;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countOrders($search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            $count = DB::table('order')
                ->whereRaw($where_raw, $params)
                ->count();

            return $count;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getPagingInfo($search = '')
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countOrders($search);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function makeWhereRaw($search = '')
    {
        $params = ['0'];
        $where_raw = 'order.delete_flg = ?';

        $params[] = $search;
        $where_raw .= " AND ( order.ord_no LIKE '%?%'";

        $params[] = $search;
        $where_raw .= " OR order.ord_date LIKE '%?%' )";

        return [$where_raw, $params];
    }

    public function makeOrderBy($sort)
    {
        $field_name = 'ord_no';
        $order_by = 'desc';
        if ($sort != '') {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $field_name = implode('_', $sort_info);
        }
        return [$field_name, $order_by];
    }
}
