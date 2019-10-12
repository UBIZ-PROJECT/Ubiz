<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Model\Product;
use App\Model\QuotepriceHistory;
use App\Model\OrderDetailHistory;

class OrderHistory
{
    public function getOrders($ord_id, $page = 0, $sort = '', $search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($ord_id, $search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);

            $orderList = DB::table('his_order')
                ->leftJoin('customer', 'customer.cus_id', '=', 'his_order.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'his_order.cad_id')
                ->leftJoin('users', 'users.id', '=', 'his_order.sale_id')
                ->select(
                    'his_order.*',
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

    public function getOrder($ord_id, $his_ord_id)
    {
        try {
            $order = DB::table('his_order')
                ->leftJoin('customer', 'customer.cus_id', '=', 'his_order.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'his_order.cad_id')
                ->leftJoin('users', 'users.id', '=', 'his_order.sale_id')
                ->select(
                    'his_order.*',
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
                    ['his_order.ord_id', '=', $ord_id],
                    ['his_order.his_ord_id', '=', $his_ord_id],
                    ['his_order.owner_id', '=', Auth::user()->id]
                ])
                ->first();
            return $order;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countOrders($ord_id, $search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($ord_id, $search);
            return DB::table('his_order')
                ->leftJoin('customer', 'customer.cus_id', '=', 'his_order.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'his_order.cad_id')
                ->leftJoin('users', 'users.id', '=', 'his_order.sale_id')
                ->select(
                    'his_order.*',
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

    public function getPagingInfo($ord_id, $search = '')
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countOrders($ord_id, $search);
            return [
                'rows_num' => $rows_num,
                'rows_per_page' => $rows_per_page
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function makeWhereRaw($ord_id, $search = '')
    {
        $params = [0];
        $where_raw = 'his_order.delete_flg = ?';
        $params[] = $ord_id;
        $where_raw .= ' AND his_order.ord_id = ?';
        $params[] = Auth::user()->id;
        $where_raw .= ' AND his_order.owner_id = ? ';

        if ($search != '') {
            $search_val = "%" . $search . "%";
            $where_raw .= " AND ( ";
            $where_raw .= " his_order.ord_no like ? ";
            $params[] = $search_val;
            if (dateValidator($search) == true) {
                $where_raw .= " OR his_order.ord_date = ? ";
                $params[] = $search;
            } else {
                if (is_numeric(str_replace(',', '', $search)) == false) {

                    $where_raw .= " OR users.name like ? ";
                    $params[] = $search_val;

                    $where_raw .= " OR customer.cus_name like ? ";
                    $params[] = $search_val;
                } else {
                    $where_raw .= " OR his_order.ord_amount = ? ";
                    $params[] = $search;

                    $where_raw .= " OR his_order.ord_amount_tax = ? ";
                    $params[] = str_replace(',', '', $search);

                    $where_raw .= " OR his_order.ord_paid = ? ";
                    $params[] = str_replace(',', '', $search);

                    $where_raw .= " OR his_order.ord_debt = ? ";
                    $params[] = str_replace(',', '', $search);
                }
            }
            $where_raw .= " ) ";

        }
        return [$where_raw, $params];
    }

    public function makeOrderBy($sort = '')
    {
        $field_name = 'his_ord_id';
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
