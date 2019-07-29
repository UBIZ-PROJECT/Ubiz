<?php

namespace App\Model;

use App\User;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Customer implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cus_name', 'cus_type', 'cus_phone', 'cus_fax', 'cus_mail',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAllCustomers()
    {
        try {
            $user_id = Auth::user()->id;
            $customers = DB::table('customer')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['user_id', '=', $user_id],
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
            $customerAddress = DB::table('customer_address')->where('cus_id', $cus_id)->where('delete_flg', '0')->get();
            return $customerAddress;
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
                    ['user_id', '=', $user_id],
                ])
                ->whereIn('cus_id', explode(',', $ids))
                ->update(['delete_flg' => '1']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getCustomers($page = 0, $sort = '', $search = [])
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
                ->select('customer.*', 'customer_address.cad_address as address', 'customer_address.cad_id')
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
            $totalCustomers = DB::table('customer')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['user_id', '=', $user_id],
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
            $customers = DB::table('customer')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['cus_id', '=', $cus_id],
                    ['user_id', '=', $user_id]
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
            $data = DB::table('customer')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['cus_id', '=', $cus_id],
                    ['user_id', '=', $user_id]
                ])
                ->select('customer.*', 'm_customer_type.title as cus_type')
                ->first();
            if ($data != null) {
                $data->avt_src = readImage($data->cus_avatar, 'cus');
            }
            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getCustomerPaging($index, $sort, $order)
    {
        try {
            $user_id = Auth::user()->id;
            $customers = DB::table('customer')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['user_id', '=', $user_id]
                ])
                ->orderBy($sort, $order)
                ->offset($index)
                ->limit(1)
                ->get();
            $customers[0]->avt_src = readImage($customers[0]->cus_avatar, 'cus');
        } catch (\Throwable $e) {
            throw $e;
        }
        return $customers;
    }

    public function countAllCustomers()
    {
        try {
            $user_id = Auth::user()->id;
            $count = DB::table('customer')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['user_id', '=', $user_id]
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
            $id = DB::table('customer')->insertGetId(
                [
                    'cus_code' => $param['cus_code'],
                    'cus_name' => $param['cus_name'],
                    'cus_avatar' => $avatar,
                    'cus_type' => $param['cus_type'],
                    'cus_phone' => $param['cus_phone'],
                    'cus_fax' => $param['cus_fax'],
                    'cus_mail' => $param['cus_mail'],
                    'cus_sex' => $param['cus_sex'],
                    'user_id' => $param['user_id'],
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
            DB::table('customer_address')->insert(
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
                    $customerAvatar = DB::table('customer')
                        ->select('cus_avatar')
                        ->where('cus_id', $param['cus_id'])
                        ->get();

                    $avatar = $customerAvatar[0]->cus_avatar;
                } else {
                    $avatar = '';
                }
            }

            DB::table('customer')->where('cus_id', $param['cus_id'])->update(
                [
                    'cus_code' => $param['cus_code'],
                    'cus_name' => $param['cus_name'],
                    'cus_avatar' => $avatar,
                    'cus_type' => $param['cus_type'],
                    'cus_phone' => $param['cus_phone'],
                    'cus_fax' => $param['cus_fax'],
                    'cus_mail' => $param['cus_mail'],
                    'cus_sex' => $param['cus_sex'],
                    'user_id' => $param['user_id'],
                    'upd_date' => now(),
                    'upd_user' => '1'
                ]
            );

            DB::table('customer_address')->where('cus_id', '=', $param['cus_id'])->delete();

            foreach ($param['cus_address'] as $cad_address) {
                if ($cad_address) {
                    $this->insertCustomerAddress($param['cus_id'], $cad_address);
                }
            }

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function validateData($request)
    {
        try {

            $res = ['success' => true, 'message' => ''];
            $message = [];

            $data = $request->all();
            if (!array_key_exists('cus_code', $data) || $data['cus_code'] == '' || $data['cus_code'] == null) {
                $res['success'] = false;
                $message[] = __('Customer code is required.');
            }
            if (array_key_exists('cus_code', $data) && mb_strlen($data['cus_code'], "utf-8") > 50) {
                $res['success'] = false;
                $message[] = __('Customer code is too long.');
            }
            if (!array_key_exists('cus_name', $data) || $data['cus_name'] == '' || $data['cus_name'] == null) {
                $res['success'] = false;
                $message[] = __('Customer name is required.');
            }
            if (array_key_exists('cus_name', $data) && mb_strlen($data['cus_name'], "utf-8") > 100) {
                $res['success'] = false;
                $message[] = __('Customer name is too long.');
            }
            if (array_key_exists('cus_mail', $data) && $this->mailValidator($data['cus_mail']) == false) {
                $res['success'] = false;
                $message[] = __('Customer mail is wrong format.');
            }
            if (array_key_exists('cus_mail', $data) && mb_strlen($data['cus_mail'], "utf-8") > 100) {
                $res['success'] = false;
                $message[] = __('Customer mail is too long.');
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

    public function makeWhereRaw($search = [])
    {
        $params = [0];
        $where_raw = 'customer.delete_flg = ?';
        $params[] = Auth::user()->id;
        $where_raw .= ' AND customer.user_id = ?';

        if (sizeof($search) > 0) {
            if (isset($search['contain']) || isset($search['notcontain'])) {

                if (isset($search['contain'])) {
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "customer.cus_code like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_name like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_type like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_fax like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_mail like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_phone like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer_address.cad_address like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if (isset($search['notcontain'])) {
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= "customer.cus_code not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_name not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_type not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_fax not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_mail not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_phone not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer_address.cad_address not like ?";
                    $params[] = $search_val;
                }

            } else {

                $where_raw_tmp = [];
                if (isset($search['cus_code'])) {
                    $where_raw_tmp[] = "customer.cus_code = ?";
                    $params[] = $search['cus_code'];
                }
                if (isset($search['cus_name'])) {
                    $where_raw_tmp[] = "customer.cus_name = ?";
                    $params[] = $search['cus_name'];
                }
                if (isset($search['cus_mail'])) {
                    $where_raw_tmp[] = "customer.cus_mail = ?";
                    $params[] = $search['cus_mail'];
                }
                if (isset($search['cus_type'])) {
                    $where_raw_tmp[] = "customer.cus_type = ?";
                    $params[] = $search['cus_type'];
                }
                if (isset($search['cus_fax'])) {
                    $where_raw_tmp[] = "customer.cus_fax = ?";
                    $params[] = $search['cus_fax'];
                }
                if (isset($search['cus_phone'])) {
                    $where_raw_tmp[] = "customer.cus_phone = ?";
                    $params[] = $search['cus_phone'];
                }
                if (isset($search['address'])) {
                    $where_raw_tmp[] = "customer_address.cad_address = ?";
                    $params[] = $search['address'];
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
            $customer = DB::select("SELECT MAX(cus_code) AS cus_code FROM `customer` WHERE user_id = $user_id AND cus_code REGEXP :reg;", ['reg' => $reg]);
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
