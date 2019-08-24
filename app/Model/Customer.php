<?php

namespace App\Model;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Customer
{
    public function getAllCustomers()
    {
        try {
            $user_id = Auth::user()->id;
            $customers = DB::table('customer')
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
            $customerAddress = DB::table('customer_address')
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
                ->where([
                    ['delete_flg', '=', '0'],
                    ['cus_id', '=', $cus_id]
                ])
                ->orderBy('con_id', 'asc')
                ->get();

            foreach ($customerContact as &$data) {
                if ($data->con_avatar == '' || $data->con_avatar == null) {
                    $data->con_avatar_base64 = '';
                    continue;
                }
                $data->con_avatar_base64 = readImage($data->con_avatar, 'con');
            }

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
            DB::table('customer')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['cus_pic', '=', $user_id],
                ])
                ->whereIn('cus_id', explode(',', $ids))
                ->update(['delete_flg' => '1']);

            DB::table('customer_address')
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
            $firstAddress = DB::table('customer_address')
                ->select('cus_id as cad_cus_id', DB::raw('min(cad_id) as cad_id'))
                ->whereRaw("delete_flg = '0'")
                ->groupBy('cus_id')->toSql();

            $customers = DB::table('customer')
                ->leftJoin(DB::raw('(' . $firstAddress . ') customer_adr'), function ($join) {
                    $join->on('customer_adr.cad_cus_id', '=', 'customer.cus_id');
                })
                ->leftJoin('customer_address', 'customer_adr.cad_id', '=', 'customer_address.cad_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->select('customer.*',
                    'customer_address.cad_address as address',
                    'customer_address.cad_id',
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

    public function getCustomerById($cus_id)
    {
        try {
            $user_id = Auth::user()->id;
            $data = DB::table('customer')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->where([
                    ['customer.delete_flg', '=', '0'],
                    ['customer.cus_id', '=', $cus_id],
                    ['customer.cus_pic', '=', $user_id]
                ])
                ->select('customer.*', 'm_customer_type.title as cus_type_name')
                ->first();
            if ($data != null) {
                $data->cus_avatar_base64 = readImage($data->cus_avatar, 'cus');
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

            $data = DB::table('customer')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($pos - 1)
                ->limit(1)
                ->first();
            if ($data != null) {
                $data->cus_avatar_base64 = readImage($data->cus_avatar, 'cus');
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
            $count = DB::table('customer')
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

    public function getAddressLocation()
    {
        try {
            $data = DB::table('m_location')
                ->where('delete_flg', '0')
                ->orderBy('lct_id', 'asc')
                ->get();

            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
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

    public function insertCustomer($data)
    {
        DB::beginTransaction();
        try {

            $user_id = Auth::user()->id;

            //Insert customer
            $cus = $data['cus'];
            if ($cus['cus_avatar_base64'] != '') {
                $cus['cus_avatar'] = resizeImageBase64($cus['cus_avatar_base64'], uniqid(), 200, 200, 'cus');

            }

            unset($cus['cus_id']);
            unset($cus['cus_avatar_base64']);

            $cus['inp_date'] = now();
            $cus['inp_user'] = $user_id;
            $cus['upd_date'] = now();
            $cus['upd_user'] = $user_id;
            $cus_id = DB::table('customer')->insertGetId($cus);

            //Insert customer address
            $cad = $data['cad'];
            foreach ($cad as &$item) {
                unset($item['cad_id']);
                $item['cus_id'] = $cus_id;
                $item['inp_date'] = now();
                $item['inp_user'] = $user_id;
                $item['upd_date'] = now();
                $item['upd_user'] = $user_id;
            }
            DB::table('customer_address')->insert($cad);

            //Insert customer contact
            $con = $data['con'];
            foreach ($con as &$item) {

                if ($item['con_avatar_base64'] != '') {
                    $item['con_avatar'] = resizeImageBase64($item['con_avatar_base64'], uniqid(), 200, 200, 'con');
                }

                unset($item['con_id']);
                unset($item['con_avatar_base64']);

                $item['cus_id'] = $cus_id;
                $item['inp_date'] = now();
                $item['inp_user'] = $user_id;
                $item['upd_date'] = now();
                $item['upd_user'] = $user_id;
            }
            DB::table('customer_contact')->insert($con);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateCustomer($cus_id, $data)
    {
        DB::beginTransaction();
        try {

            //Update customer
            $cus = $data['cus'];
            $user_id = Auth::user()->id;

            //Add image
            if ($cus['cus_avatar'] == '' && $cus['cus_avatar_base64'] != '') {
                $cus['cus_avatar'] = resizeImageBase64($cus['cus_avatar_base64'], uniqid(), 200, 200, 'cus');
            }else//Upd image
            if ($cus['cus_avatar'] != '' && $cus['cus_avatar_base64'] != '') {
                Storage::disk('images')->delete('cus/' . $cus['cus_avatar']);
                $cus['cus_avatar'] = resizeImageBase64($cus['cus_avatar_base64'], uniqid(), 200, 200, 'cus');
            }else//Del image
            if ($cus['cus_avatar'] != '' && $cus['cus_avatar_base64'] == '') {
                Storage::disk('images')->delete('cus/' . $cus['cus_avatar']);
                $cus['cus_avatar'] = '';
            }

            unset($cus['cus_id']);
            unset($cus['cus_avatar_base64']);

            $cus['upd_date'] = now();
            $cus['upd_user'] = $user_id;

            DB::table('customer')
                ->where([
                    ['cus_id', '=', $cus_id],
                    ['cus_pic', '=', $user_id],
                    ['delete_flg', '=', '0'],
                ])
                ->update($cus);

            //Update customer address
            $cad_insert = [];
            $cad = $data['cad'];
            foreach ($cad as $item) {

                $cad_id = $item['cad_id'];
                unset($item['cad_id']);
                if($cad_id == '0'){
                    $item['cus_id'] = $cus_id;
                    $item['inp_date'] = now();
                    $item['inp_user'] = $user_id;
                    $item['upd_date'] = now();
                    $item['upd_user'] = $user_id;
                    $cad_insert[] = $item;
                    continue;
                }

                $item['upd_date'] = now();
                $item['upd_user'] = $user_id;

                DB::table('customer_address')
                    ->where([
                        ['cad_id', '=', $cad_id],
                        ['cus_id', '=', $cus_id],
                        ['delete_flg', '=', '0']
                    ])
                    ->update($item);
            }

            if (sizeof($cad_insert) > 0) {
                DB::table('customer_address')->insert($cad_insert);
            }

            //Customer contact
            $con_insert = [];
            $con_update = [];
            $con_delete = [];

            $con = $data['con'];
            foreach ($con as $item) {

                $item['upd_date'] = now();
                $item['upd_user'] = $user_id;

                //insert array
                if ($item['con_id'] == '0') {

                    $item['cus_id'] = $cus_id;
                    $item['inp_date'] = now();
                    $item['inp_user'] = $user_id;

                    if ($item['con_avatar_base64'] != '') {
                        $item['con_avatar'] = resizeImageBase64($item['con_avatar_base64'], uniqid(), 200, 200, 'con');
                    }

                    unset($item['con_id']);
                    unset($item['con_action']);
                    unset($item['con_avatar_base64']);

                    $con_insert[] = $item;
                    continue;
                }

                //delete array
                if ($item['con_id'] != '0' && $item['con_action'] == 'del') {
                    $con_delete[] = $item['con_id'];
                    continue;
                }

                //update array
                if ($item['con_id'] != '0' && $item['con_action'] == 'upd') {

                    //Add image
                    if ($item['con_avatar'] == '' && $item['con_avatar_base64'] != '') {
                        $item['con_avatar'] = resizeImageBase64($item['con_avatar_base64'], uniqid(), 200, 200, 'con');
                    }else//Upd image
                    if ($item['con_avatar'] != '' && $item['con_avatar_base64'] != '') {
                        Storage::disk('images')->delete('con/' . $item['con_avatar']);
                        $item['con_avatar'] = resizeImageBase64($item['con_avatar_base64'], uniqid(), 200, 200, 'con');
                    }else//Del image
                    if ($item['con_avatar'] != '' && $item['con_avatar_base64'] == '') {
                        Storage::disk('images')->delete('con/' . $item['con_avatar']);
                        $item['con_avatar'] = '';
                    }

                    unset($item['con_action']);
                    unset($item['con_avatar_base64']);

                    $con_update[] = $item;
                    continue;
                }

            }

            //Insert Contact
            if (sizeof($con_insert) > 0) {
                DB::table('customer_contact')->insert($con_insert);
            }

            //Update Contact
            if (sizeof($con_update) > 0) {
                foreach ($con_update as $item) {

                    $con_id = $item['con_id'];
                    unset($item['con_id']);

                    $item['upd_date'] = now();
                    $item['upd_user'] = $user_id;

                    DB::table('customer_contact')
                        ->where([
                            ['con_id', '=', $con_id],
                            ['cus_id', '=', $cus_id],
                            ['delete_flg', '=', '0']
                        ])
                        ->update($item);
                }
            }

            //Update Contact
            if (sizeof($con_delete) > 0) {

                DB::table('customer_contact')
                    ->whereIn('con_id', $con_delete)
                    ->where([
                        ['cus_id', '=', $cus_id],
                        ['delete_flg', '=', '0']
                    ])
                    ->update([
                        'delete_flg' => '1',
                        'upd_date' => now(),
                        'upd_user' => $user_id
                    ]);
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

            $cusValidator = $this->validateCusData($data);
            $conValidator = $this->validateConData($data);

            if ($cusValidator['success'] == false) {
                $res['success'] = false;
                $message[] = implode("\n", $cusValidator['message']);
            }

            if ($conValidator['success'] == false) {
                $res['success'] = false;
                $message[] = implode("\n", $conValidator['message']);
            }

            $res['message'] = implode("\n", $message);
            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }

    }

    public function validateCusData($data)
    {
        try {

            $res = ['success' => true, 'message' => ''];
            $message = [];

            if (presentValidator($data['cus']) == false) {
                $res['success'] = false;
                $message[] = __('Data is wrong.!');
                return $res;
            }

            $cus = $data['cus'];
            //validate cus_code
            if (requiredValidator($cus['cus_code']) == false) {
                $res['success'] = false;
                $message[] = __('Customer code is required.');
            }
            if (presentValidator($cus['cus_code']) == true && maxlengthValidator($cus['cus_code'], 50) == false) {
                $res['success'] = false;
                $message[] = __('Customer code is too long.');
            }

            //validate cus_name
            if (requiredValidator($cus['cus_name']) == false) {
                $res['success'] = false;
                $message[] = __('Customer name is required.');
            }
            if (presentValidator($cus['cus_name']) == true && maxlengthValidator($cus['cus_name'], 250) == false) {
                $res['success'] = false;
                $message[] = __('Customer name is too long.');
            }

            //validate cus_fax
            if (presentValidator($cus['cus_fax']) == false) {
                $res['success'] = false;
                $message[] = __('Customer fax is missing.');
            }
            if (presentValidator($cus['cus_fax']) == true && maxlengthValidator($cus['cus_fax'], 250) == false) {
                $res['success'] = false;
                $message[] = __('Customer fax is too long.');
            }

            //validate cus_mail
            if (presentValidator($cus['cus_mail']) == false) {
                $res['success'] = false;
                $message[] = __('Customer mail is missing.');
            }
            if (presentValidator($cus['cus_mail']) == true && maxlengthValidator($cus['cus_mail'], 250) == false) {
                $res['success'] = false;
                $message[] = __('Customer mail is too long.');
            }

            //validate cus_field
            if (presentValidator($cus['cus_field']) == false) {
                $res['success'] = false;
                $message[] = __('Customer field is missing.');
            }
            if (presentValidator($cus['cus_field']) == true && maxlengthValidator($cus['cus_field'], 250) == false) {
                $res['success'] = false;
                $message[] = __('Customer field is too long.');
            }

            //validate cus_phone
            if (presentValidator($cus['cus_phone']) == false) {
                $res['success'] = false;
                $message[] = __('Customer phone is missing.');
            }

            //validate cus_avatar
            if (presentValidator($cus['cus_avatar']) == false
                || presentValidator($cus['cus_avatar_base64']) == false) {
                $res['success'] = false;
                $message[] = __('Customer avatar is missing.');
            }

            //validate cus_address_1
            if (presentValidator($cus['cus_address_1']) == false) {
                $res['success'] = false;
                $message[] = __('Customer address 1 is missing.');
            }

            //validate lct_location_1
            if (existsInDBValidator($cus['lct_location_1'], 'm_location', 'lct_id') == false) {
                $res['success'] = false;
                $message[] = __('Customer address location 1 is not exists.');
            }

            //validate cus_address_2
            if (presentValidator($cus['cus_address_2']) == false) {
                $res['success'] = false;
                $message[] = __('Customer address 2 is missing.');
            }

            //validate lct_location_2
            if (existsInDBValidator($cus['lct_location_2'], 'm_location', 'lct_id') == false) {
                $res['success'] = false;
                $message[] = __('Customer address location 2 is not exists.');
            }

            //validate cus_address_3
            if (presentValidator($cus['cus_address_3']) == false) {
                $res['success'] = false;
                $message[] = __('Customer address 3 is missing.');
            }

            //validate lct_location_3
            if (existsInDBValidator($cus['lct_location_3'], 'm_location', 'lct_id') == false) {
                $res['success'] = false;
                $message[] = __('Customer address location 3 is not exists.');
            }

            //validate cus_type
            if (existsInDBValidator($cus['cus_type'], 'm_customer_type', 'id') == false) {
                $res['success'] = false;
                $message[] = __('Customer type is not exists.');
            }

            //validate cus_pic
            if (existsInDBValidator($cus['cus_pic'], 'users', 'id') == false) {
                $res['success'] = false;
                $message[] = __('Customer pic is not exists.');
            }

            $res['message'] = implode("\n", $message);
            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }

    }

    public function validateConData($data)
    {
        try {

            $res = ['success' => true, 'message' => ''];
            $message = [];

            if (presentValidator($data['con']) == false) {
                $res['success'] = false;
                $message[] = __('Contact data is wrong.!');
                return $res;
            }

            foreach ($data['con'] as $idx => $con) {

                //validate con_name
                if (requiredValidator($con['con_name']) == false) {
                    $res['success'] = false;
                    $message[] = __('[' . ($idx + 1) . ']Contact name is required.');
                }
                if (presentValidator($con['con_name']) == true && maxlengthValidator($con['con_name'], 250) == false) {
                    $res['success'] = false;
                    $message[] = __('[' . ($idx + 1) . ']Customer name is too long.');
                }

                //validate con_mail
                if (requiredValidator($con['con_mail']) == false) {
                    $res['success'] = false;
                    $message[] = __('[' . ($idx + 1) . ']Contact mail is required.');
                }
                if (presentValidator($con['con_mail']) == true && maxlengthValidator($con['con_mail'], 250) == false) {
                    $res['success'] = false;
                    $message[] = __('[' . ($idx + 1) . ']Contact mail is too long.');
                }

                //validate cus_phone
                if (presentValidator($con['con_phone']) == false) {
                    $res['success'] = false;
                    $message[] = __('[' . ($idx + 1) . ']Contact phone is missing.');
                }

                //validate con_rank
                if (presentValidator($con['con_rank']) == false) {
                    $res['success'] = false;
                    $message[] = __('[' . ($idx + 1) . ']Contact duty is missing.');
                }

                //validate con_avatar
                if (presentValidator($con['con_avatar']) == false
                    || presentValidator($con['con_avatar_base64']) == false) {
                    $res['success'] = false;
                    $message[] = __('[' . ($idx + 1) . ']Contact avatar is missing.');
                }

            }

            $res['message'] = implode("\n", $message);
            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }

    }

    public function insertValidation($data)
    {
        try {
            return $this->validateData($data);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateValidation($cus_id, $data)
    {
        try {

            $res = ['success' => true, 'message' => ''];

            if (requiredValidator($cus_id) == false || numericValidator($cus_id) == false) {
                $res['success'] = false;
                $message[] = __('Data is wrong');
                return $res;
            }

            $cusData = $this->getCustomerById($cus_id);
            if ($cusData == null) {
                $res['success'] = false;
                $res['message'] = __('Customer is not exists.');
                return $res;
            }

            return $this->validateData($data);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function makeWhereRaw($search = '')
    {
        $params = [0];
        $where_raw = 'customer.delete_flg = ?';
        $params[] = Auth::user()->id;
        $where_raw .= ' AND customer.cus_pic = ?';

        if ($search != '') {
            $search_val = "%" . $search . "%";
            $where_raw .= " AND ( ";
            $where_raw .= " customer.cus_code like ? ";
            $params[] = $search_val;
            $params[] = $search_val;
            $where_raw .= " OR customer.cus_name like ?";
            $params[] = $search_val;
            $where_raw .= " OR m_customer_type.title like ?";
            $params[] = $search_val;
            $where_raw .= " OR customer.cus_fax like ?";
            $params[] = $search_val;
            $where_raw .= " OR customer.cus_mail like ?";
            $params[] = $search_val;
            $where_raw .= " OR customer.cus_phone like ?";
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
