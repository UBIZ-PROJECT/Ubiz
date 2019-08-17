<?php

namespace App\Model;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Customer
{
    public function getAllCustomers()
    {
        try {
            $user_id = Auth::user()->id;
            $customers = DB::table('customer_copy')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['cus_pic', '=', $user_id],
                ])
                ->get();
            return $customers;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getCustomerAddress($cus_id)
    {
        try {
            $customerAddress = DB::table('customer_address_copy')
                ->where('cus_id', $cus_id)
                ->where('delete_flg', '0')
                ->get();
            return $customerAddress;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getCustomerContact($cus_id)
    {
        try {
            $customerContact = DB::table('customer_contact')
                ->where('cus_id', $cus_id)
                ->where('delete_flg', '0')
                ->get();
            return $customerContact;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteCustomer($ids = '')
    {
        DB::beginTransaction();
        try {
            $user_id = Auth::user()->id;
            DB::table('customer_copy')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['cus_pic', '=', $user_id],
                ])
                ->whereIn('cus_id', explode(',', $ids))
                ->update(['delete_flg' => '1']);

            DB::table('customer_address_copy')
                ->where([
                    ['delete_flg', '=', '0']
                ])
                ->whereIn('cus_id', explode(',', $ids))
                ->update(['delete_flg' => '1']);

            DB::table('customer_contact')
                ->where([
                    ['delete_flg', '=', '0']
                ])
                ->whereIn('cus_id', explode(',', $ids))
                ->update(['delete_flg' => '1']);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getCustomers($page = 0, $sort = '', $search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $firstAddress = DB::table('customer_address_copy')
                ->select('cus_id as cad_cus_id', DB::raw('min(cad_id) as cad_id'))
                ->whereRaw("delete_flg = '0'")
                ->groupBy('cus_id')->toSql();

            $customers = DB::table('customer_copy')
                ->leftJoin(DB::raw('(' . $firstAddress . ') customer_adr'), function ($join) {
                    $join->on('customer_adr.cad_cus_id', '=', 'customer_copy.cus_id');
                })
                ->leftJoin('customer_address_copy', 'customer_adr.cad_id', '=', 'customer_address_copy.cad_id')
                ->leftJoin('m_customer_type', 'customer_copy.cus_type', '=', 'm_customer_type.id')
                ->select('customer_copy.*',
                    'customer_address_copy.cad_address as address',
                    'customer_address_copy.cad_id',
                    'm_customer_type.title as cus_type_name'
                )
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();
            return $customers;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countCustomers()
    {
        try {
            $user_id = Auth::user()->id;
            $totalCustomers = DB::table('customer_copy')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['cus_pic', '=', $user_id],
                ])
                ->count();
            return $totalCustomers;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getCustomer($cus_id)
    {
        try {
            $user_id = Auth::user()->id;
            $customers = DB::table('customer_copy')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['cus_id', '=', $cus_id],
                    ['cus_pic', '=', $user_id]
                ])
                ->get();
            $customers[0]->avt_src = readImage($customers[0]->cus_avatar, 'cus');
        } catch (\Throwable $e) {
            throw $e;
        }
        return $customers;
    }

    public function getCustomerById($cus_id)
    {
        try {
            $user_id = Auth::user()->id;
            $data = DB::table('customer_copy')
                ->leftJoin('m_customer_type', 'customer_copy.cus_type', '=', 'm_customer_type.id')
                ->where([
                    ['customer_copy.delete_flg', '=', '0'],
                    ['customer_copy.cus_id', '=', $cus_id],
                    ['customer_copy.cus_pic', '=', $user_id]
                ])
                ->select('customer_copy.*')
                ->first();
            if ($data != null) {
                $data->cus_avatar = readImage($data->cus_avatar, 'cus');
            }
            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getCustomerByPos($pos = 0, $sort = '', $search = '')
    {
        try {

            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $data = DB::table('customer_copy')
                ->leftJoin('m_customer_type', 'customer_copy.cus_type', '=', 'm_customer_type.id')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($pos - 1)
                ->limit(1)
                ->first();
            if ($data != null) {
                $data->cus_avatar = readImage($data->cus_avatar, 'cus');
            }
            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countAllCustomers()
    {
        try {
            $user_id = Auth::user()->id;
            $count = DB::table('customer_copy')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['cus_pic', '=', $user_id]
                ])
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    public function getPagingInfo()
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countAllCustomers();
        } catch (\Throwable $e) {
            throw $e;
        }
        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function insertCustomer($param)
    {
        try {
            if ($param['cus_avatar']) {
                $avatar = $param['cus_id'] . '.' . $param['cus_avatar']->getClientOriginalExtension();
                resizeImage($param['cus_avatar']->getRealPath(), $param['cus_id'] . '.' . $param['cus_avatar']->getClientOriginalExtension(), 200, 200, 'cus');
            } else {
                $avatar = '';
            }
            $id = DB::table('customer_copy')->insertGetId(
                [
                    'cus_code' => $param['cus_code'],
                    'cus_name' => $param['cus_name'],
                    'cus_avatar' => $avatar,
                    'cus_type' => $param['cus_type'],
                    'cus_phone' => $param['cus_phone'],
                    'cus_fax' => $param['cus_fax'],
                    'cus_mail' => $param['cus_mail'],
                    'cus_sex' => $param['cus_sex'],
                    'cus_pic' => $param['cus_pic'],
                    'inp_date' => now(),
                    'upd_date' => now(),
                    'inp_user' => Auth::user()->id,
                    'upd_user' => Auth::user()->id
                ]
            );
            foreach ($param['cus_address'] as $cad_address) {
                if ($cad_address) {
                    $this->insertCustomerAddress($id, $cad_address);
                }
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return $id;
    }

    public function insertCustomerAddress($cus_id, $cad_address)
    {
        try {
            DB::table('customer_address_copy')->insert(
                [
                    'cus_id' => $cus_id,
                    'cad_address' => $cad_address,
                    'inp_date' => now(),
                    'upd_date' => now(),
                    'inp_user' => '1',
                    'upd_user' => '1'
                ]
            );
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateCustomer($param)
    {
        try {
            if ($param['cus_avatar'] && ($param['cus_avatar_flg'] == 2)) {
                $avatar = $param['cus_id'] . '.' . $param['cus_avatar']->getClientOriginalExtension();
                resizeImage($param['cus_avatar']->getRealPath(), $param['cus_id'] . '.' . $param['cus_avatar']->getClientOriginalExtension(), 200, 200, 'cus');
            } else {
                if ($param['cus_avatar_flg'] == 0) {
                    $customerAvatar = DB::table('customer_copy')
                        ->select('cus_avatar')
                        ->where('cus_id', $param['cus_id'])
                        ->get();

                    $avatar = $customerAvatar[0]->cus_avatar;
                } else {
                    $avatar = '';
                }
            }

            DB::table('customer_copy')->where('cus_id', $param['cus_id'])->update(
                [
                    'cus_code' => $param['cus_code'],
                    'cus_name' => $param['cus_name'],
                    'cus_avatar' => $avatar,
                    'cus_type' => $param['cus_type'],
                    'cus_phone' => $param['cus_phone'],
                    'cus_fax' => $param['cus_fax'],
                    'cus_mail' => $param['cus_mail'],
                    'cus_sex' => $param['cus_sex'],
                    'cus_pic' => $param['cus_pic'],
                    'upd_date' => now(),
                    'upd_user' => '1'
                ]
            );

            DB::table('customer_address_copy')->where('cus_id', '=', $param['cus_id'])->delete();

            foreach ($param['cus_address'] as $cad_address) {
                if ($cad_address) {
                    $this->insertCustomerAddress($param['cus_id'], $cad_address);
                }
            }

        } catch (\Throwable $e) {
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
            if (array_key_exists('ord_exp_date', $order) && $this->dateValidator($order['ord_exp_date']) == false) {
                $res['success'] = false;
                $message[] = __('Order Exp Date is wrong format YYYY/MM/DD.');
            }
            if (array_key_exists('ord_dlv_date', $order) && $this->dateValidator($order['ord_dlv_date']) == false) {
                $res['success'] = false;
                $message[] = __('Order Delivery Date is wrong format YYYY/MM/DD.');
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

    public function getUsers()
    {
        $users = DB::table('users')
            ->select('id', 'name')
            ->get();

        return $users;
    }

    public function mailValidator($mail)
    {
        $credential_name = "name";
        $credential_data = $mail;
        $rules = [
            $credential_name => 'email'
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

    public function makeWhereRaw($search = '')
    {
        $params = [0];
        $where_raw = 'customer_copy.delete_flg = ?';
        $params[] = Auth::user()->id;
        $where_raw .= ' AND customer_copy.cus_pic = ?';

        if ($search != '') {
            $search_val = "%" . $search . "%";
            $where_raw .= " AND ( ";
            $where_raw .= " customer_copy.cus_code like ? ";
            $params[] = $search_val;
            $params[] = $search_val;
            $where_raw .= " OR customer_copy.cus_name like ?";
            $params[] = $search_val;
            $where_raw .= " OR m_customer_type.title like ?";
            $params[] = $search_val;
            $where_raw .= " OR customer_copy.cus_fax like ?";
            $params[] = $search_val;
            $where_raw .= " OR customer_copy.cus_mail like ?";
            $params[] = $search_val;
            $where_raw .= " OR customer_copy.cus_phone like ?";
            $params[] = $search_val;
            $where_raw .= " ) ";

        }

        return [$where_raw, $params];
    }

    public function makeOrderBy($sort)
    {
        $field_name = 'cus_code';
        $order_by = 'asc';
        if ($sort != '') {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $field_name = implode('_', $sort_info);
        }
        return [$field_name, $order_by];
    }

    public function generateCusCode()
    {
        try {
            $user = new User();
            $user_id = Auth::user()->id;
            $curUser = $user->getCurrentUser();
            $pre_reg = strtoupper(explode('@', $curUser->email)[0]) . '_CUS';
            $reg = '^' . $pre_reg . '[0-9]{5,}$';
            $customer = DB::select("SELECT MAX(cus_code) AS cus_code FROM `customer` WHERE cus_pic = $user_id AND cus_code REGEXP :reg;", ['reg' => $reg]);
            if ($customer[0]->cus_code == null) {
                $cus_code_num = 1;
            } else {
                $cus_code_num = intval(str_replace($pre_reg, '', $customer[0]->cus_code)) + 1;
            }
            $cus_code = $pre_reg . str_pad($cus_code_num, 5, '0', STR_PAD_LEFT);
            return $cus_code;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
