<?php

namespace App\Model;

use Mail;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Model\QuotepriceDetailHistory;

class QuotepriceHistory
{
    public function getQuoteprices($qp_id, $page = 0, $sort = '', $search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($qp_id, $search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);

            $quoteprices = DB::table('his_quoteprice')
                ->leftJoin('customer', 'customer.cus_id', '=', 'his_quoteprice.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'his_quoteprice.cad_id')
                ->leftJoin('users', 'users.id', '=', 'his_quoteprice.sale_id')
                ->select(
                    'his_quoteprice.*',
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
            return $quoteprices;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getQuoteprice($qp_id, $his_qp_id)
    {
        try {
            $quoteprice = DB::table('his_quoteprice')
                ->leftJoin('order', 'order.qp_id', '=', 'his_quoteprice.qp_id')
                ->leftJoin('customer', 'customer.cus_id', '=', 'his_quoteprice.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'his_quoteprice.cad_id')
                ->leftJoin('users', 'users.id', '=', 'his_quoteprice.sale_id')
                ->select(
                    'his_quoteprice.*',
                    'order.ord_id',
                    'customer.cus_code',
                    'customer.cus_name',
                    'customer.cus_phone',
                    'customer.cus_fax',
                    'customer.cus_mail',
                    'customer.cus_sex',
                    'customer.cus_avatar',
                    'customer_address.cad_address as cus_addr',
                    'm_customer_type.title as cus_type',
                    'users.name as sale_name',
                    'users.rank as sale_rank',
                    'users.email as sale_email',
                    'users.phone as sale_phone'
                )
                ->where([
                    ['his_quoteprice.qp_id', '=', $qp_id],
                    ['his_quoteprice.his_qp_id', '=', $his_qp_id],
                    ['his_quoteprice.owner_id', '=', Auth::user()->id]
                ])
                ->first();
            return $quoteprice;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countQuoteprices($qp_id, $search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($qp_id, $search);
            return DB::table('his_quoteprice')
                ->leftJoin('customer', 'customer.cus_id', '=', 'his_quoteprice.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'his_quoteprice.cad_id')
                ->leftJoin('users', 'users.id', '=', 'his_quoteprice.sale_id')
                ->select(
                    'his_quoteprice.*',
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

    public function getPagingInfo($qp_id, $search = '')
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countQuoteprices($qp_id, $search);
            return [
                'rows_num' => $rows_num,
                'rows_per_page' => $rows_per_page
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function makeWhereRaw($qp_id, $search = '')
    {
        $params = [0];
        $where_raw = 'his_quoteprice.delete_flg = ?';
        $params[] = $qp_id;
        $where_raw .= ' AND his_quoteprice.qp_id = ? ';
        $params[] = Auth::user()->id;
        $where_raw .= ' AND his_quoteprice.owner_id = ? ';

        if ($search != '') {
            $search_val = "%" . $search . "%";
            $where_raw .= " AND ( ";
            $where_raw .= " his_quoteprice.qp_no like ? ";
            $params[] = $search_val;
            if (dateValidator($search) == true) {
                $where_raw .= " OR his_quoteprice.qp_date = ? ";
                $params[] = $search;
                $where_raw .= " OR his_quoteprice.qp_exp_date = ? ";
                $params[] = $search;
            } else {
                if (is_numeric(str_replace(',', '', $search)) == false) {

                    $where_raw .= " OR users.name like ? ";
                    $params[] = $search_val;

                    $where_raw .= " OR customer.cus_name like ? ";
                    $params[] = $search_val;
                } else {
                    $where_raw .= " OR his_quoteprice.qp_amount = ? ";
                    $params[] = $search;

                    $where_raw .= " OR his_quoteprice.qp_amount_tax = ? ";
                    $params[] = str_replace(',', '', $search);
                }
            }
            $where_raw .= " ) ";

        }
        return [$where_raw, $params];
    }

    public function makeOrderBy($sort = '')
    {
        $field_name = 'his_qp_id';
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
