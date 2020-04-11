<?php

namespace App;

use App\Jobs\SendUserRegistEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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

    public function getAllUsers()
    {
        try {
            $users = DB::table('users')
                ->select(
                    'users.*',
                    'm_company.com_id',
                    'm_company.com_nm',
                    'm_company.com_nm_shot',
                    'm_company.com_logo',
                    'm_company.com_address',
                    'm_company.com_phone',
                    'm_company.com_fax',
                    'm_company.com_web',
                    'm_company.com_email',
                    'm_company.com_hotline',
                    'm_company.com_mst',
                    'm_department.dep_name')
                ->join('m_company', 'users.com_id', '=', 'm_company.com_id')
                ->leftJoin('m_department', 'users.dep_id', '=', 'm_department.id')
                ->where('users.delete_flg', '=', '0')
                ->orderBy('id', 'asc')
                ->get();
            foreach ($users as &$user) {
                $user->avatar = readImage($user->avatar, 'usr');
                if ($user->avatar == "") {
                    $user->avatar = readImage("no_avatar.png", 'gen');
                }
            }
            return $users;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getAllUserByDepId($dep_id = '')
    {
        try {
            $cur_user = $this->getAuthUser();
            $users = DB::table('users')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['dep_id', '=', $dep_id],
                    ['com_id', '=', $cur_user->com_id]
                ])
                ->orderBy('id', 'asc')
                ->get();

            foreach ($users as &$user) {
                $user->avatar = readImage($user->avatar, 'usr');
                if ($user->avatar == '' || $user->avatar == null) {
                    $user->avatar_base64 = '';
                    $user->avatar = readImage("no_avatar.png", 'gen');
                    continue;
                }
                $user->avatar_base64 = readImage($user->avatar, 'usr');
            }
            return $users;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getAllUserByRole($role)
    {
        try {
            $cur_user = $this->getAuthUser();
            $users = DB::table('users')
                ->where([
                    ['delete_flg', '=', '0'],
                    ['role', '=', $role],
                    ['com_id', '=', $cur_user->com_id]
                ])
                ->orderBy('id', 'asc')
                ->get();

            foreach ($users as &$user) {

                if ($user->avatar == '' || $user->avatar == null) {
                    $user->avatar_base64 = '';
                    continue;
                }
                $user->avatar_base64 = readImage($user->avatar, 'usr');
            }
            return $users;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteUser($ids = '')
    {
        DB::beginTransaction();
        try {

            DB::table('users')
                ->whereIn('id', explode(',', $ids))
                ->update(['delete_flg' => '1']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateUser($id, $data = [])
    {
        DB::beginTransaction();
        try {

            if (isset($data['avatar'])) {
                $avatar = $data['avatar'];
                $path = $avatar->path();
                $extension = $avatar->extension();
                $avatar = $id . "." . $extension;
                resizeImage($path, $avatar, 200, 200, 'usr');
                $data['avatar'] = $avatar;
            }

            DB::table('users')
                ->where([['id', '=', $id], ['delete_flg', '=', '0']])
                ->update($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updatePasswd($id, $passwd)
    {
        DB::beginTransaction();
        try {
            DB::table('users')
                ->where([
                    ['id', '=', $id],
                    ['delete_flg', '=', '0']
                ])
                ->update([
                    'password' => Hash::make($passwd)
                ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insertUser($data = [])
    {
        DB::beginTransaction();
        try {

            $id = DB::table('users')->max('id') + 1;
            $data['id'] = $id;
            $data['f_id'] = $id;
            if (isset($data['avatar'])) {
                $avatar = $data['avatar'];
                $path = $avatar->path();
                $extension = $avatar->extension();
                $avatar = $id . "." . $extension;
                resizeImage($path, $avatar, 200, 200, 'usr');
                $data['avatar'] = $avatar;
            }
            $passwd = str_random(env('PASSWD_LENGTH', 8));
            $data['password'] = Hash::make($passwd);
            $data['inp_user'] = Auth::user()->id;
            $data['upd_user'] = Auth::user()->id;

            $this->insertMailQueue($id);

            $mail_conf = makeMailConf(
                env('MAIL_USERNAME'),
                env('MAIL_PASSWORD'),
                env('MAIL_USERNAME'),
                'TKP-TEAM'
            );
            dispatch(new SendUserRegistEmail($data, $mail_conf));

            DB::table('users')->insert($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insertMailQueue($id)
    {
        try {
            $data = [
                'user_id' => $id,
                'send' => '0'
            ];

            DB::table('users_regist_mail')->insert($data);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function keepInfo($data = [])
    {
        DB::beginTransaction();
        try {

            $id = DB::table('users')->max('id') + 1;
            $data['id'] = $id;
            if (isset($data['tmp_avatar'])) {
                $avatar = $data['tmp_avatar'];
                $path = $avatar->path();
                $extension = $avatar->extension();
                $avatar = $id . "." . $extension;
                resizeImage($path, $avatar, 200, 200, 'usr');
                $data['avatar'] = $avatar;
                unset($data['tmp_avatar']);
            }

            DB::table('users')->insert($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function search($page = 0, $sort = '', $search = [])
    {
        try {

            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $users = DB::table('users')
                ->select(
                    'users.*',
                    'm_company.com_id',
                    'm_company.com_nm',
                    'm_company.com_nm_shot',
                    'm_company.com_logo',
                    'm_company.com_address',
                    'm_company.com_phone',
                    'm_company.com_fax',
                    'm_company.com_web',
                    'm_company.com_email',
                    'm_company.com_hotline',
                    'm_company.com_mst',
                    'm_department.dep_name')
                ->join('m_company', 'users.com_id', '=', 'm_company.com_id')
                ->leftJoin('m_department', 'users.dep_id', '=', 'm_department.id')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();
            return $users;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getUserById($id = '')
    {
        try {

            $user = DB::table('users')
                ->select(
                    'users.*',
                    'm_company.com_id',
                    'm_company.com_nm',
                    'm_company.com_nm_shot',
                    'm_company.com_logo',
                    'm_company.com_address',
                    'm_company.com_phone',
                    'm_company.com_fax',
                    'm_company.com_web',
                    'm_company.com_email',
                    'm_company.com_hotline',
                    'm_company.com_mst',
                    'm_department.dep_name')
                ->join('m_company', 'users.com_id', '=', 'm_company.com_id')
                ->leftJoin('m_department', 'users.dep_id', '=', 'm_department.id')
                ->where([['users.delete_flg', '=', '0'], ['users.id', '=', $id]])
                ->first();

            if ($user != null && !empty($user->avatar)) {
                $user->temp_avatar = $user->avatar;
                $user->avatar = readImage($user->avatar, 'usr');
            }
            return $user;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getUserOnlyById($id = '')
    {
        try {

            $user = DB::table('users')
                ->select('*')
                ->where([['users.delete_flg', '=', '0'], ['users.id', '=', $id]])
                ->first();
            return $user;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getListOfUserByIds($id = [])
    {
        try {

            $data = DB::table('users')
                ->select(
                    'users.*',
                    'm_company.com_id',
                    'm_company.com_nm',
                    'm_company.com_nm_shot',
                    'm_company.com_logo',
                    'm_company.com_address',
                    'm_company.com_phone',
                    'm_company.com_fax',
                    'm_company.com_web',
                    'm_company.com_email',
                    'm_company.com_hotline',
                    'm_company.com_mst',
                    'm_department.dep_name')
                ->join('m_company', 'users.com_id', '=', 'm_company.com_id')
                ->leftJoin('m_department', 'users.dep_id', '=', 'm_department.id')
                ->where('users.delete_flg', '0')
                ->whereIn('users.id', $id)
                ->get();

            foreach ($data as &$user) {

                if (empty($user->avatar) == true)
                    continue;

                $user->avatar = readImage($user->avatar, 'usr');
            }

            return $data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getCurrentUser()
    {
        try {

            $user = DB::table('users')
                ->select(
                    'users.*',
                    'm_company.com_id',
                    'm_company.com_nm',
                    'm_company.com_nm_shot',
                    'm_company.com_logo',
                    'm_company.com_address',
                    'm_company.com_phone',
                    'm_company.com_fax',
                    'm_company.com_web',
                    'm_company.com_email',
                    'm_company.com_hotline',
                    'm_company.com_mst',
                    'm_department.dep_name')
                ->join('m_company', 'users.com_id', '=', 'm_company.com_id')
                ->leftJoin('m_department', 'users.dep_id', '=', 'm_department.id')
                ->where([
                    ['users.delete_flg', '=', '0'],
                    ['m_company.delete_flg', '=', '0'],
                    ['m_department.delete_flg', '=', '0'],
                    ['users.id', '=', Auth::user()->id]
                ])
                ->first();

            if ($user != null && !empty($user->avatar)) {
                $user->avatar = readImage($user->avatar, 'usr');
            }
            return $user;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getUserByPos($pos = 0, $sort = '', $search = [])
    {
        try {

            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $user = DB::table('users')
                ->select('users.*', 'm_department.dep_name')
                ->leftJoin('m_department', 'users.dep_id', '=', 'm_department.id')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($pos - 1)
                ->limit(1)
                ->first();
            return $user;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countAllUsers()
    {
        try {
            $count = DB::table('users')
                ->where('delete_flg', '=', '0')
                ->count();
            return $count;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countUsers($search = [])
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            $count = DB::table('users')
                ->leftJoin('m_department', 'users.dep_id', '=', 'm_department.id')
                ->whereRaw($where_raw, $params)
                ->count();
            return $count;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getPagingInfo($search = [])
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countUsers($search);
            return [
                'rows_num' => $rows_num,
                'rows_per_page' => $rows_per_page
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function makeWhereRaw($search = [])
    {
        $params = ['0'];
        $where_raw = 'users.delete_flg = ?';
        if (sizeof($search) > 0) {
            if (isset($search['contain']) || isset($search['notcontain'])) {
                if (isset($search['contain'])) {
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "users.code like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR users.name like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR users.email like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR users.phone like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR users.address like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_department.dep_name like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if (isset($search['notcontain'])) {
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= " AND users.code not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND users.name not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND users.email not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND users.phone not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND users.address not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_department.dep_name not like ?";
                    $params[] = $search_val;
                }

            } else {

                $where_raw_tmp = [];
                if (isset($search['code'])) {
                    $where_raw_tmp[] = "users.code = ?";
                    $params[] = $search['code'];
                }
                if (isset($search['name'])) {
                    $where_raw_tmp[] = "users.name = ?";
                    $params[] = $search['name'];
                }
                if (isset($search['email'])) {
                    $where_raw_tmp[] = "users.email = ?";
                    $params[] = $search['email'];
                }
                if (isset($search['phone'])) {
                    $where_raw_tmp[] = "users.phone = ?";
                    $params[] = $search['phone'];
                }
                if (isset($search['address'])) {
                    $where_raw_tmp[] = "users.address = ?";
                    $params[] = $search['address'];
                }
                if (isset($search['dep_name'])) {
                    $where_raw_tmp[] = "m_department.dep_name = ?";
                    $params[] = $search['dep_name'];
                }
                if (sizeof($where_raw_tmp) > 0) {
                    $where_raw .= " AND ( " . implode(" OR ", $where_raw_tmp) . " )";
                }
            }
        }
        return [$where_raw, $params];
    }

    public function validateData($data)
    {
        try {

            $res = ['success' => true, 'message' => ''];
            $message = [];

            if (!array_key_exists('code', $data) || $data['code'] == '' || $data['code'] == null) {
                $res['success'] = false;
                $message[] = __('User code is required.');
            }
            if (array_key_exists('code', $data) && mb_strlen($data['code'], "utf-8") > 5) {
                $res['success'] = false;
                $message[] = __('User code is too long.');
            }
            if (!array_key_exists('name', $data) || $data['name'] == '' || $data['name'] == null) {
                $res['success'] = false;
                $message[] = __('User name is required.');
            }
            if (array_key_exists('name', $data) && mb_strlen($data['name'], "utf-8") > 100) {
                $res['success'] = false;
                $message[] = __('User name is too long.');
            }
            if (!array_key_exists('com_id', $data) || $data['com_id'] == '' || $data['com_id'] == null) {
                $res['success'] = false;
                $message[] = __('Company is required.');
            }
            if (!array_key_exists('dep_id', $data) || $data['dep_id'] == '' || $data['dep_id'] == null) {
                $res['success'] = false;
                $message[] = __('Department is required.');
            }
            if (array_key_exists('join_date', $data) && $data['join_date'] != '' && $this->dateValidator($data['join_date']) == false) {
                $res['success'] = false;
                $message[] = __('Join date is wrong format YYYY/MM/DD.');
            }
            if (array_key_exists('email', $data) && $data['email'] != '' && $this->mailValidator($data['email']) == false) {
                $res['success'] = false;
                $message[] = __('E-mail is wrong format.');
            }

            $res['message'] = implode("\n", $message);
            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }

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

    public function makeOrderBy($sort)
    {
        $field_name = 'code';
        $order_by = 'asc';
        if ($sort != '') {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $field_name = implode('_', $sort_info);
        }
        return [$field_name, $order_by];
    }

    public function getDepartments()
    {
        try {
            $departments = DB::table('m_department')
                ->select('*')
                ->where('delete_flg', '=', '0')
                ->orderBy('id', 'asc')
                ->get()
                ->toArray();
            return $departments;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getCompanies()
    {
        try {
            $companies = DB::table('m_company')
                ->select('*')
                ->where('delete_flg', '=', '0')
                ->orderBy('com_id', 'asc')
                ->get()
                ->toArray();
            return $companies;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getAuthUser()
    {
        try {
            $user = null;
            if (\Auth::check()) {
                $id = \Auth::user()->id;
                $user = $this->getUserById($id);
            }
            return $user;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
