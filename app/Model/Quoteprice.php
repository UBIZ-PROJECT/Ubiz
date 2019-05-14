<?php

namespace App\Model;

use App\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Model\QuotepriceDetail;

class Quoteprice
{
    public function getQuoteprices($page = 0, $sort = '', $search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);

            $quoteprices = DB::table('quoteprice')
                ->leftJoin('customer', 'customer.cus_id', '=', 'quoteprice.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'quoteprice.cad_id')
                ->leftJoin('users', 'users.id', '=', 'quoteprice.sale_id')
                ->select(
                    'quoteprice.*',
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

    public function getQuoteprice($qp_id)
    {
        try {
            $quoteprice = DB::table('quoteprice')
                ->leftJoin('customer', 'customer.cus_id', '=', 'quoteprice.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'quoteprice.cad_id')
                ->leftJoin('users', 'users.id', '=', 'quoteprice.sale_id')
                ->select(
                    'quoteprice.*',
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
                    ['quoteprice.qp_id', '=', $qp_id],
                    ['quoteprice.owner_id', '=', Auth::user()->id]
                ])
                ->first();
            return $quoteprice;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countQuoteprices($search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            return DB::table('quoteprice')
                ->leftJoin('customer', 'customer.cus_id', '=', 'quoteprice.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'quoteprice.cad_id')
                ->leftJoin('users', 'users.id', '=', 'quoteprice.sale_id')
                ->select(
                    'quoteprice.*',
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

    public function getPagingInfo($search = '')
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countQuoteprices($search);
            return [
                'rows_num' => $rows_num,
                'rows_per_page' => $rows_per_page
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function transactionDeleteQuotepricesByIds($qp_ids = '')
    {
        DB::beginTransaction();
        try {

            //delete quoteprices
            $this->deleteQuotepricesByIds($qp_ids);

            //delete quoteprices detail
            $quotepriceDetail = new QuotepriceDetail();
            $quotepriceDetail->deleteQuotepriceDetailsByOrdIds($qp_ids);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function transactionUpdateQuoteprice($qp_id, $data)
    {
        DB::beginTransaction();
        try {

            $insert_quoteprice_detail_data = [];
            $delete_quoteprice_detail_data = [];
            $update_quoteprice_detail_data = [];

            foreach ($data['quoteprice_detail'] as $item) {


                $quoteprice_detail_data = [
                    "note" => $item['dt_note'],
                    "unit" => $item['dt_unit'],
                    "quantity" => $item['dt_quantity'],
                    "status" => $item['dt_status'],
                    "delivery_time" => $item['dt_delivery_time'],
                    "price" => $item['dt_price'],
                    "amount" => $item['dt_amount'],
                    "type" => $item['dt_type'],
                    "sort_no" => $item['dt_sort_no'],
                    "owner_id" => Auth::user()->id,
                    "upd_user" => Auth::user()->id
                ];

                if ($item['dt_type'] == '1') {
                    $quoteprice_detail_data["prod_specs"] = $item['dt_prod_specs'];
                    $quoteprice_detail_data["prod_specs_mce"] = $item['dt_prod_specs_mce'];
                    $quoteprice_detail_data["acce_code"] = null;
                    $quoteprice_detail_data["acce_name"] = null;
                }

                if ($item['dt_type'] == '2') {
                    $quoteprice_detail_data["prod_specs"] = null;
                    $quoteprice_detail_data["prod_specs_mce"] = null;
                    $quoteprice_detail_data["acce_code"] = $item['dt_acce_code'];
                    $quoteprice_detail_data["acce_name"] = $item['dt_acce_name'];
                }

                $action = $item['action'];
                switch ($action) {
                    case'insert':
                        $quoteprice_detail_data["qp_id"] = $qp_id;
                        $quoteprice_detail_data["inp_user"] = Auth::user()->id;
                        $insert_quoteprice_detail_data[] = $quoteprice_detail_data;
                        break;
                    case'update':
                        $quoteprice_detail_data["qpdt_id"] = $item['dt_id'];
                        $update_quoteprice_detail_data[] = $quoteprice_detail_data;
                        break;
                    case'delete':
                        $delete_quoteprice_detail_data[] = $item['dt_id'];
                        break;
                }
            }

            //update quoteprices
            $this->updateQuoteprice($data['quoteprice']);

            $quotepriceDetail = new QuotepriceDetail();
            //insert quoteprice detail
            if (!empty($insert_quoteprice_detail_data)) {
                $quotepriceDetail->insertQuotepriceDetail($insert_quoteprice_detail_data);
            }

            //delete quoteprice detail
            if (!empty($delete_quoteprice_detail_data)) {
                $quotepriceDetail->deleteQuotepriceDetailsByIds($delete_quoteprice_detail_data);
            }

            //update quoteprice detail
            foreach ($update_quoteprice_detail_data as $quoteprice_detail) {
                $quotepriceDetail->updateQuotepriceDetail($quoteprice_detail);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function transactionCreateQuoteprice($cus_id, $data)
    {
        DB::beginTransaction();
        try {

            //insert quoteprice
            $data['quoteprice']['cus_id'] = $cus_id;
            $data['quoteprice']['sale_id'] = Auth::user()->id;
            $data['quoteprice']['owner_id'] = Auth::user()->id;
            $data['quoteprice']['inp_user'] = Auth::user()->id;
            $data['quoteprice']['upd_user'] = Auth::user()->id;
            $qp_id = $this->createQuoteprice($data['quoteprice']);

            $insert_quoteprice_detail_data = [];
            foreach ($data['quoteprice_detail'] as $item) {


                $quoteprice_detail_data = [
                    "qp_id" => $qp_id,
                    "note" => $item['dt_note'],
                    "unit" => $item['dt_unit'],
                    "quantity" => $item['dt_quantity'],
                    "status" => $item['dt_status'],
                    "delivery_time" => $item['dt_delivery_time'],
                    "price" => $item['dt_price'],
                    "amount" => $item['dt_amount'],
                    "type" => $item['dt_type'],
                    "sort_no" => $item['dt_sort_no'],
                    "owner_id" => Auth::user()->id,
                    "upd_user" => Auth::user()->id,
                    "inp_user" => Auth::user()->id
                ];

                if ($item['dt_type'] == '1') {
                    $quoteprice_detail_data["prod_specs"] = $item['dt_prod_specs'];
                    $quoteprice_detail_data["prod_specs_mce"] = $item['dt_prod_specs_mce'];
                    $quoteprice_detail_data["acce_code"] = null;
                    $quoteprice_detail_data["acce_name"] = null;
                }

                if ($item['dt_type'] == '2') {
                    $quoteprice_detail_data["prod_specs"] = null;
                    $quoteprice_detail_data["prod_specs_mce"] = null;
                    $quoteprice_detail_data["acce_code"] = $item['dt_acce_code'];
                    $quoteprice_detail_data["acce_name"] = $item['dt_acce_name'];
                }
                $insert_quoteprice_detail_data[] = $quoteprice_detail_data;
            }

            //insert quoteprice detail
            $quotepriceDetail = new QuotepriceDetail();
            if (!empty($insert_quoteprice_detail_data)) {
                $quotepriceDetail->insertQuotepriceDetail($insert_quoteprice_detail_data);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function validateData($data)
    {
        try {

            $res = ['success' => true, 'message' => ''];
            $message = [];

            if (!array_key_exists('quoteprice', $data)) {
                $res['success'] = false;
                $message[] = __('Data is wrong.!');
                return $res;
            }

            $quoteprice = $data['quoteprice'];
            if (!array_key_exists('qp_no', $quoteprice) || $quoteprice['qp_no'] == '' || $quoteprice['qp_no'] == null) {
                $res['success'] = false;
                $message[] = __('QP No is required.');
            }
            if (array_key_exists('qp_no', $quoteprice) && mb_strlen($quoteprice['qp_no'], "utf-8") > 10) {
                $res['success'] = false;
                $message[] = __('QP No is too long.');
            }
            if (!array_key_exists('qp_date', $quoteprice) || $quoteprice['qp_date'] == '' || $quoteprice['qp_date'] == null) {
                $res['success'] = false;
                $message[] = __('QP Date is required.');
            }
            if (array_key_exists('qp_date', $quoteprice) && Carbon::createFromFormat('Y/m/d', $quoteprice['qp_date']) == false) {
                $res['success'] = false;
                $message[] = __('QP Date is wrong format YYYY/MM/DD.');
            }
            if (!array_key_exists('qp_exp_date', $quoteprice) || $quoteprice['qp_exp_date'] == '' || $quoteprice['qp_exp_date'] == null) {
                $res['success'] = false;
                $message[] = __('QP Exp Date is required.');
            }
            if (array_key_exists('qp_exp_date', $quoteprice) && Carbon::createFromFormat('Y/m/d', $quoteprice['qp_exp_date']) == false) {
                $res['success'] = false;
                $message[] = __('QP Exp Date is wrong format YYYY/MM/DD.');
            }

            $amount_check = true;
            if (!array_key_exists('qp_tax', $quoteprice)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('QP Tax is required.');
            }
            if (!array_key_exists('qp_amount', $quoteprice)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of quoteprices (before VAT) is required.');
            }
            if (!array_key_exists('qp_amount_tax', $quoteprice)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of quoteprices (VAT included) is required.');
            }
            if (array_key_exists('qp_tax', $quoteprice) && (is_numeric($quoteprice['qp_tax']) == false || intval($quoteprice['qp_tax']) < 0 || intval($quoteprice['qp_tax']) > 2147483647)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('QP Tax is wrong data.');
            }
            if (array_key_exists('qp_amount', $quoteprice) && (is_numeric($quoteprice['qp_amount']) == false || floatval($quoteprice['qp_amount']) < 0 || floatval($quoteprice['qp_amount']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of quoteprices (before VAT) is wrong.');
            }
            if (array_key_exists('qp_amount_tax', $quoteprice) && (is_numeric($quoteprice['qp_amount_tax']) == false || floatval($quoteprice['qp_amount_tax']) < 0 || floatval($quoteprice['qp_amount']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of quoteprices (VAT included) is wrong.');
            }

            if ($amount_check == true) {

                $qp_tax = $quoteprice['qp_tax'] == null || $quoteprice['qp_tax'] == '' ? 0 : intval($quoteprice['qp_tax']);
                $qp_amount = $quoteprice['qp_amount'] == null || $quoteprice['qp_amount'] == '' ? 0 : doubleval($quoteprice['qp_amount']);
                $qp_amount_tax = $quoteprice['qp_amount_tax'] == null || $quoteprice['qp_amount_tax'] == '' ? 0 : doubleval($quoteprice['qp_amount_tax']);

                $chk_qp_amount_tax = $qp_amount + $qp_amount * $qp_tax / 100;
                if ($qp_amount_tax != $chk_qp_amount_tax) {
                    $amount_check = false;
                    $res['success'] = false;
                    $message[] = __('Amount total is wrong.');
                }
            }

            $dt_total_amount = 0;
            $quoteprice_details = array_key_exists('quoteprice_detail', $data) ? $data['quoteprice_detail'] : [];
            foreach ($quoteprice_details as $line_no => $item) {

                if (!array_key_exists('dt_note', $item)
                    || !array_key_exists('dt_unit', $item)
                    || !array_key_exists('dt_quantity', $item)
                    || !array_key_exists('dt_delivery_time', $item)
                    || !array_key_exists('dt_status', $item)
                    || !array_key_exists('dt_price', $item)
                    || !array_key_exists('dt_amount', $item)
                    || !array_key_exists('dt_type', $item)
                    || !array_key_exists('dt_sort_no', $item)
                    || !array_key_exists('action', $item)
                ) {
                    $res['success'] = false;
                    switch ($item['dt_type']) {
                        case '1':
                            $message[] = __('[Row : :line ] pump detail is wrong data.', ['line' => "No." + ($line_no + 1)]);
                            break;
                        case '2':
                            $message[] = __('[Row : :line ] accessory detail is wrong data.', ['line' => "No." + ($line_no + 1)]);
                            break;
                    }
                    continue;
                }
                switch ($item['dt_type']) {
                    case '1':
                        if (!array_key_exists('dt_prod_specs_mce', $item)
                            || !array_key_exists('dt_prod_specs', $item)
                        ) {
                            $res['success'] = false;
                            $message[] = __('[Row : :line ] pump detail is wrong data.', ['line' => "No." + ($line_no + 1)]);
                            continue;
                        }
                        break;
                    case '2':
                        if (!array_key_exists('dt_acce_code', $item)
                            || !array_key_exists('dt_acce_name', $item)
                        ) {
                            $res['success'] = false;
                            $message[] = __('[Row : :line ] accessory detail is wrong data.', ['line' => "No." + ($line_no + 1)]);
                            continue;
                        }
                        break;
                }

                if ($item['action'] == 'delete')
                    continue;
                $dt_total_amount += $item['dt_amount'] == null || $item['dt_amount'] == '' ? 0 : doubleval($item['dt_amount']);
            }

            if ($amount_check == true && $dt_total_amount != $qp_amount) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Amount total of quoteprice details is not equal amount total of quoteprice.');
            }

            $res['message'] = implode("\n", $message);
            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }

    }

    public function deleteQuotepricesByIds($qp_ids = '')
    {
        try {

            DB::table('quoteprice')
                ->where('owner_id', Auth::user()->id)
                ->whereIn('qp_id', explode(',', $qp_ids))
                ->update([
                    'upd_user' => Auth::user()->id,
                    'delete_flg' => '1'
                ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function createQuoteprice($data)
    {
        try {
            return DB::table('quoteprice')->insertGetId($data);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateQuoteprice($quoteprice)
    {
        try {
            $qp_id = $quoteprice['qp_id'];
            unset($quoteprice['qp_id']);
            DB::table('quoteprice')
                ->where([
                    ['owner_id', '=', Auth::user()->id],
                    ['qp_id', '=', $qp_id]
                ])
                ->update($quoteprice);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function makeWhereRaw($search = '')
    {
        $params = [0];
        $where_raw = 'quoteprice.delete_flg = ?';
        $params[] = Auth::user()->id;
        $where_raw .= ' AND quoteprice.owner_id = ? ';

        if ($search != '') {
            $search_val = "%" . $search . "%";
            $where_raw .= " AND ( ";
            $where_raw .= " quoteprice.qp_no like ? ";
            $params[] = $search_val;
            if (Carbon::createFromFormat('Y/m/d', $search) == true || Carbon::createFromFormat('Y-m-d', $search) == true) {
                $where_raw .= " OR quoteprice.qp_date = ? ";
                $params[] = $search;
                $where_raw .= " OR quoteprice.qp_exp_date = ? ";
                $params[] = $search;
            } else {
                if (is_numeric(str_replace(',', '', $search)) == false) {

                    $where_raw .= " OR users.name like ? ";
                    $params[] = $search_val;

                    $where_raw .= " OR customer.cus_name like ? ";
                    $params[] = $search_val;
                } else {
                    $where_raw .= " OR quoteprice.qp_amount = ? ";
                    $params[] = $search;

                    $where_raw .= " OR quoteprice.qp_amount_tax = ? ";
                    $params[] = str_replace(',', '', $search);
                }
            }
            $where_raw .= " ) ";

        }
        return [$where_raw, $params];
    }

    public function makeOrderBy($sort = '')
    {
        $field_name = 'qp_no';
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