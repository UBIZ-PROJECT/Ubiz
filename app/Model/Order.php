<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helper;

class Order
{
    public function getOrders($page = 0, $sort = '', $search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);

            $orderList = DB::table('order')
                ->leftJoin('customer', 'customer.cus_id', '=', 'order.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'order.cad_id')
                ->leftJoin('users', 'users.id', '=', 'order.sale_id')
                ->select(
                    'order.*',
                    'customer.cus_code',
                    'customer.cus_name',
                    'customer.cus_phone',
                    'customer.cus_fax',
                    'customer.cus_mail',
                    'customer.cus_avatar',
                    'customer_address.cad_address as cus_addr',
                    'm_customer_type.title as cus_type',
                    'users.name as sale_name',
                    'users.rank as sale_rank',
                    'users.email as sale_email',
                    'users.phone as sale_phone'
                )
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();
            return $orderList;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countOrders($search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            return DB::table('order')
                ->leftJoin('customer', 'customer.cus_id', '=', 'order.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'order.cad_id')
                ->leftJoin('users', 'users.id', '=', 'order.sale_id')
                ->select(
                    'order.*',
                    'customer.cus_code',
                    'customer.cus_name',
                    'customer.cus_phone',
                    'customer.cus_fax',
                    'customer.cus_mail',
                    'customer.cus_avatar',
                    'customer_address.cad_address as cus_addr',
                    'm_customer_type.title as cus_type',
                    'users.name as sale_name',
                    'users.rank as sale_rank',
                    'users.email as sale_email',
                    'users.phone as sale_phone'
                )
                ->whereRaw($where_raw, $params)
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getOrder($ord_id)
    {
        try {
            $order = DB::table('order')
                ->leftJoin('customer', 'customer.cus_id', '=', 'order.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'order.cad_id')
                ->leftJoin('users', 'users.id', '=', 'order.sale_id')
                ->select(
                    'order.*',
                    'customer.cus_code',
                    'customer.cus_name',
                    'customer.cus_phone',
                    'customer.cus_fax',
                    'customer.cus_mail',
                    'customer.cus_avatar',
                    'customer_address.cad_address as cus_addr',
                    'm_customer_type.title as cus_type',
                    'users.name as sale_name',
                    'users.rank as sale_rank',
                    'users.email as sale_email',
                    'users.phone as sale_phone'
                )
                ->where([
                    ['order.ord_id', '=', $ord_id],
                    ['order.owner_id', '=', Auth::user()->id]
                ])
                ->first();
            return $order;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getPagingInfo($search = '')
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countOrders($search);
            return [
                'rows_num' => $rows_num,
                'rows_per_page' => $rows_per_page
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteOrders($ids = '')
    {
        DB::beginTransaction();
        try {

            DB::table('order')
                ->whereIn('ord_id', explode(',', $ids))
                ->update(['delete_flg' => '1']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insertOrder()
    {
        try {

        } catch (\Throwable $e) {
            throw $e;
        }
        return $id;
    }

    public function updateOrder()
    {
        try {

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function makeWhereRaw($search = '')
    {
        $params = [0];
        $where_raw = 'order.delete_flg = ?';

        if ($search != '') {
            $search_val = "%" . $search . "%";
            $where_raw .= " AND order.ord_no like ? ";
            $params[] = $search_val;
        }
        return [$where_raw, $params];
    }

    public function makeOrderBy($sort = '')
    {
        $field_name = 'ord_no';
        $order_by = 'asc';
        if ($sort != '') {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $field_name = implode('_', $sort_info);
        }
        return [$field_name, $order_by];
    }
}
