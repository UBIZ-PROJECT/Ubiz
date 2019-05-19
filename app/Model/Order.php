<?php

namespace App\Model;

use App\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Model\Product;
use App\Model\Quoteprice;
use App\Model\OrderDetail;

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

    public function transactionDeleteOrdersByIds($ord_ids = '')
    {
        DB::beginTransaction();
        try {

            //delete orders
            $this->deleteOrdersByIds($ord_ids);

            //delete orders detail
            $orderDetail = new OrderDetail();
            $orderDetail->deleteOrderDetailsByOrdIds($ord_ids);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function transactionUpdateOrder($ord_id, $data)
    {
        DB::beginTransaction();
        try {

            $imp_step = 0;
            $insert_order_detail_data = [];
            $delete_order_detail_data = [];
            $update_order_detail_data = [];

            $order_detail = array_key_exists('order_detail', $data) ? $data['order_detail'] : [];
            foreach ($order_detail as $item) {

                $order_detail_data = [
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
                    $order_detail_data["prod_model"] = $item['dt_prod_model'];
                    $order_detail_data["prod_series"] = $item['dt_prod_series'];
                    $order_detail_data["prod_specs"] = $item['dt_prod_specs'];
                    $order_detail_data["prod_specs_mce"] = $item['dt_prod_specs_mce'];
                    $order_detail_data["acce_code"] = null;
                    $order_detail_data["acce_name"] = null;
                }

                if ($item['dt_type'] == '2') {
                    $order_detail_data["prod_model"] = null;
                    $order_detail_data["prod_series"] = null;
                    $order_detail_data["prod_specs"] = null;
                    $order_detail_data["prod_specs_mce"] = null;
                    $order_detail_data["acce_code"] = $item['dt_acce_code'];
                    $order_detail_data["acce_name"] = $item['dt_acce_name'];
                }

                $action = $item['action'];
                switch ($action) {
                    case'insert':
                        if ($item['dt_status'] == '2') {
                            $imp_step = '1';
                        }
                        $order_detail_data["ord_id"] = $ord_id;
                        $order_detail_data["inp_user"] = Auth::user()->id;
                        $insert_order_detail_data[] = $order_detail_data;
                        break;
                    case'update':
                        if ($item['dt_status'] == '2') {
                            $imp_step = '1';
                        }
                        $order_detail_data["ordt_id"] = $item['dt_id'];
                        $update_order_detail_data[] = $order_detail_data;
                        break;
                    case'delete':
                        $delete_order_detail_data[] = $item['dt_id'];
                        break;
                }
            }

            //update orders
            $order = $data['order'];
            $order['imp_step'] = $imp_step;
            $this->updateOrder($order);

            $orderDetail = new OrderDetail();
            //insert order detail
            if (!empty($insert_order_detail_data)) {
                $orderDetail->insertOrderDetail($insert_order_detail_data);
            }

            //delete order detail
            if (!empty($delete_order_detail_data)) {
                $orderDetail->deleteOrderDetailsByIds($delete_order_detail_data);
            }

            //update order detail
            foreach ($update_order_detail_data as $order_detail) {
                $orderDetail->updateOrderDetail($order_detail);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function transactionCreateOrder($quoteprice, $quoteprice_details)
    {
        DB::beginTransaction();
        try {

            //create orders
            $ord_no = $this->generateOrdNo();
            $order = [
                "ord_no" => $ord_no,
                "ord_date" => date('Y-m-d'),
                "ord_tax" => $quoteprice->qp_tax,
                "ord_amount" => $quoteprice->qp_amount,
                "ord_amount_tax" => $quoteprice->qp_amount_tax,
                "ord_paid" => '0',
                "ord_debt" => $quoteprice->qp_amount_tax,
                "ord_note" => $quoteprice->qp_note,
                "qp_id" => $quoteprice->qp_id,
                "cus_id" => $quoteprice->cus_id,
                "cad_id" => $quoteprice->cad_id,
                "sale_step" => '2',
                "sale_id" => Auth::user()->id,
                "contact_name" => $quoteprice->contact_name,
                "contact_rank" => $quoteprice->contact_rank,
                "contact_phone" => $quoteprice->contact_phone,
                "contact_email" => $quoteprice->contact_email,
                "owner_id" => Auth::user()->id,
                "inp_user" => Auth::user()->id,
                "upd_user" => Auth::user()->id
            ];
            $ord_id = $this->insertOrder($order);

            $imp_step = 0;
            $insert_order_detail_data = [];
            foreach ($quoteprice_details as $item) {

                if ($item->status == '2') {
                    $imp_step = '1';
                }

                $order_detail_data = [
                    "ord_id" => $ord_id,
                    "note" => $item->note,
                    "unit" => $item->unit,
                    "quantity" => $item->quantity,
                    "status" => $item->status,
                    "delivery_time" => $item->delivery_time,
                    "price" => $item->price,
                    "amount" => $item->amount,
                    "type" => $item->type,
                    "sort_no" => $item->sort_no,
                    "owner_id" => Auth::user()->id,
                    "inp_user" => Auth::user()->id,
                    "upd_user" => Auth::user()->id
                ];

                if ($item->type == '1') {
                    $order_detail_data["prod_specs"] = $item->prod_specs;
                    $order_detail_data["prod_specs_mce"] = $item->prod_specs_mce;
                    $order_detail_data["acce_code"] = null;
                    $order_detail_data["acce_name"] = null;
                }

                if ($item->type == '2') {
                    $order_detail_data["prod_specs"] = null;
                    $order_detail_data["prod_specs_mce"] = null;
                    $order_detail_data["acce_code"] = $item->acce_code;
                    $order_detail_data["acce_name"] = $item->acce_name;
                }

                $insert_order_detail_data[] = $order_detail_data;
            }
            $orderDetail = new OrderDetail();
            //insert order detail
            if (!empty($insert_order_detail_data)) {
                $orderDetail->insertOrderDetail($insert_order_detail_data);
            }

            $order = [];
            $order['ord_id'] = $ord_id;
            $order['imp_step'] = $imp_step;
            $order['upd_user'] = Auth::user()->id;
            $this->updateOrder($order);

            $qpModel = new Quoteprice();
            $qpUpdateData = [
                'qp_id' => $quoteprice->qp_id,
                'sale_step' => '2'
            ];
            $qpModel->updateQuoteprice($qpUpdateData);

            DB::commit();
            return $ord_id;
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

            if (!array_key_exists('order', $data)) {
                $res['success'] = false;
                $message[] = __('Data is wrong.!');
                return $res;
            }

            $order = $data['order'];
            if (!array_key_exists('ord_no', $order) || $order['ord_no'] == '' || $order['ord_no'] == null) {
                $res['success'] = false;
                $message[] = __('Order No is required.');
            }
            if (array_key_exists('ord_no', $order) && mb_strlen($order['ord_no'], "utf-8") > 30) {
                $res['success'] = false;
                $message[] = __('Order No is too long.');
            }
            if (!array_key_exists('ord_date', $order) || $order['ord_date'] == '' || $order['ord_date'] == null) {
                $res['success'] = false;
                $message[] = __('Order Date is required.');
            }
            if (array_key_exists('ord_date', $order) && $this->dateValidator($order['ord_date']) == false) {
                $res['success'] = false;
                $message[] = __('Order Date is wrong format YYYY/MM/DD.');
            }

            $amount_check = true;
            if (!array_key_exists('ord_tax', $order)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Order Tax is required.');
            }
            if (!array_key_exists('ord_amount', $order)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of orders (before VAT) is required.');
            }
            if (!array_key_exists('ord_amount_tax', $order)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of orders (VAT included) is required.');
            }
            if (!array_key_exists('ord_paid', $order)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Paid is required.');
            }
            if (!array_key_exists('ord_debt', $order)) {
                $res['success'] = false;
                $message[] = __('Debt is required.');
            }
            if (array_key_exists('ord_tax', $order) && (is_numeric($order['ord_tax']) == false || intval($order['ord_tax']) < 0 || intval($order['ord_tax']) > 2147483647)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Order Tax is wrong data.');
            }
            if (array_key_exists('ord_amount', $order) && (is_numeric($order['ord_amount']) == false || floatval($order['ord_amount']) < 0 || floatval($order['ord_amount']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of orders (before VAT) is wrong.');
            }
            if (array_key_exists('ord_amount_tax', $order) && (is_numeric($order['ord_amount_tax']) == false || floatval($order['ord_amount_tax']) < 0 || floatval($order['ord_amount']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of orders (VAT included) is wrong.');
            }
            if (array_key_exists('ord_paid', $order) && (is_numeric($order['ord_paid']) == false || floatval($order['ord_paid']) < 0 || floatval($order['ord_paid']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Paid is wrong.');
            }
            if (array_key_exists('ord_debt', $order) && (is_numeric($order['ord_debt']) == false || floatval($order['ord_debt']) < 0 || floatval($order['ord_debt']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Debt is wrong.');
            }

            if ($amount_check == true) {

                $ord_tax = $order['ord_tax'] == null || $order['ord_tax'] == '' ? 0 : intval($order['ord_tax']);
                $ord_amount = $order['ord_amount'] == null || $order['ord_amount'] == '' ? 0 : doubleval($order['ord_amount']);
                $ord_amount_tax = $order['ord_amount_tax'] == null || $order['ord_amount_tax'] == '' ? 0 : doubleval($order['ord_amount_tax']);
                $ord_paid = $order['ord_paid'] == null || $order['ord_paid'] == '' ? 0 : doubleval($order['ord_paid']);
                $ord_debt = $order['ord_debt'] == null || $order['ord_debt'] == '' ? 0 : doubleval($order['ord_debt']);

                $chk_ord_amount_tax = $ord_amount + $ord_amount * $ord_tax / 100;
                $chk_ord_debt = $ord_amount_tax - $ord_paid;
                if ($ord_amount_tax != $chk_ord_amount_tax || $chk_ord_debt != $ord_debt) {
                    $amount_check = false;
                    $res['success'] = false;
                    $message[] = __('Amount total is wrong.');
                }
            }

            $prdModel = new Product();
            $dt_total_amount = 0;
            $order_details = array_key_exists('order_detail', $data) ? $data['order_detail'] : [];
            foreach ($order_details as $line_no => $item) {

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
                            || !array_key_exists('dt_prod_model', $item)
                            || !array_key_exists('dt_prod_series', $item)
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

                if ($item['dt_type'] == 1 && $item['dt_prod_model'] != '') {
                    $is_exists = $prdModel->checkProductIsExistsByModel($item['dt_prod_model']);
                    if ($is_exists == false) {
                        $res['success'] = false;
                        $message[] = __('[Row : :line ] model [ :model ] is not exists.', ['line' => "No." + ($line_no + 1), 'model' => $item['dt_prod_model']]);
                    }
                }

                if ($item['dt_type'] == 1 && $item['dt_prod_model'] != '' && $item['dt_prod_series'] != '') {

                    $prdSeriesObjData = $prdModel->getProductSeriesByModel($item['dt_prod_model']);
                    $prdSeriesArrData = [];
                    foreach ($prdSeriesObjData as $seri) {
                        $prdSeriesArrData[] = $seri->serial_no;
                    }

                    $dt_prod_series = explode(",", $item['dt_prod_series']);
                    $not_exists_series = [];
                    foreach ($dt_prod_series as $seri) {
                        if (in_array($seri, $prdSeriesArrData) == false) {
                            $not_exists_series[] = $seri;
                        }
                    }

                    if (sizeof($not_exists_series) > 0) {
                        $res['success'] = false;
                        $message[] = __('[Row : :line ] series [ :series ] is not exists.', ['line' => "No." + ($line_no + 1), 'series' => implode(",", $not_exists_series)]);
                    }
                }

                $dt_total_amount += $item['dt_amount'] == null || $item['dt_amount'] == '' ? 0 : doubleval($item['dt_amount']);
            }

            if ($amount_check == true && $dt_total_amount != $ord_amount) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Amount total of order details is not equal amount total of order.');
            }

            $res['message'] = implode("\n", $message);
            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }

    }

    public function generateOrdNo()
    {
        try {
            $user = new User();
            $curUser = $user->getCurrentUser();
            $pre_reg = strtoupper(explode('@', $curUser->email)[0]) . 'DH' . date('y');
            $reg = '^' . $pre_reg . '[0-9]{5,}$';
            $order = DB::select("SELECT MAX(ord_no) AS ord_no FROM `order` WHERE ord_no REGEXP :reg;", ['reg' => $reg]);
            if ($order[0]->ord_no == null) {
                $ord_no_num = 1;
            } else {
                $ord_no_num = intval(str_replace($pre_reg, '', $order[0]->ord_no)) + 1;
            }
            $ord_no = $pre_reg . str_pad($ord_no_num, 5, '0', STR_PAD_LEFT);
            return $ord_no;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function checkOrderIsExistsByQpId($qp_id)
    {
        try {
            $cnt = DB::table('order')
                ->where([
                    ['order.qp_id', '=', $qp_id],
                    ['order.delete_flg', '=', '0'],
                    ['order.owner_id', '=', Auth::user()->id]
                ])
                ->count();
            if ($cnt > 0)
                return false;
            return true;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteOrdersByIds($ord_ids = '')
    {
        try {

            DB::table('order')
                ->where('owner_id', Auth::user()->id)
                ->whereIn('ord_id', explode(',', $ord_ids))
                ->update([
                    'upd_user' => Auth::user()->id,
                    'delete_flg' => '1'
                ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function insertOrder($data)
    {
        try {
            return DB::table('order')->insertGetId($data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return $id;
    }

    public function updateOrder($order)
    {
        try {
            $ord_id = $order['ord_id'];
            unset($order['ord_id']);
            DB::table('order')
                ->where([
                    ['owner_id', '=', Auth::user()->id],
                    ['ord_id', '=', $ord_id]
                ])
                ->update($order);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function makeWhereRaw($search = '')
    {
        $params = [0];
        $where_raw = 'order.delete_flg = ?';
        $params[] = Auth::user()->id;
        $where_raw .= ' AND order.owner_id = ? ';

        if ($search != '') {
            $search_val = "%" . $search . "%";
            $where_raw .= " AND ( ";
            $where_raw .= " order.ord_no like ? ";
            $params[] = $search_val;
            if ($this->dateValidator($search) == true) {
                $where_raw .= " OR order.ord_date = ? ";
                $params[] = $search;
            } else {
                if (is_numeric(str_replace(',', '', $search)) == false) {

                    $where_raw .= " OR users.name like ? ";
                    $params[] = $search_val;

                    $where_raw .= " OR customer.cus_name like ? ";
                    $params[] = $search_val;
                } else {
                    $where_raw .= " OR order.ord_amount = ? ";
                    $params[] = $search;

                    $where_raw .= " OR order.ord_amount_tax = ? ";
                    $params[] = str_replace(',', '', $search);

                    $where_raw .= " OR order.ord_paid = ? ";
                    $params[] = str_replace(',', '', $search);

                    $where_raw .= " OR order.ord_debt = ? ";
                    $params[] = str_replace(',', '', $search);
                }
            }
            $where_raw .= " ) ";

        }
        return [$where_raw, $params];
    }

    public function dateValidator($date)
    {
        $credential_name = "name";
        $credential_data = $date;
        $rules = [
            $credential_name => 'date'
        ];
        $credentials = [
            $credential_name => $credential_data
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return false;
        }
        return true;
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
