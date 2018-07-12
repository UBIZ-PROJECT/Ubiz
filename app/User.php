<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;

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
        $users = DB::table('users')
            ->select('users.*', 'm_department.dep_id', 'm_department.dep_name', 'm_department.dep_type', 'm_department.per_id')
            ->leftJoin('m_department', 'users.dep_id', '=', 'm_department.dep_id')
            ->where('users.delete_flg', '=', '0')
            ->orderBy('id', 'asc')
            ->get();
        return $users;
    }

    public function deleteUsers($ids = '')
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

    public function getUsers($page = 0, $sort = '', $search = [])
    {
        try {

            $sort_name = 'code';
            $order_by = 'asc';
            if ($sort != '') {
                $sort_info = explode('_', $sort);
                $order_by = $sort_info[sizeof($sort_info) - 1];
                unset($sort_info[sizeof($sort_info) - 1]);
                $sort_name = implode('_', $sort_info);
            }

            $params = [];
            $where_raw = 'users.delete_flg = ?';
            $params[] = '0';
            if (sizeof($search) > 0) {
                if (isset($search['search'])) {
                    $search_val = $search['search'];
                    $where_raw .= " AND (";
                    $where_raw .= "users.code like '%?%'";
                    $params[] = $search_val;
                    $where_raw .= " OR users.name like '%?%'";
                    $params[] = $search_val;
                    $where_raw .= " OR users.email like '%?%'";
                    $params[] = $search_val;
                    $where_raw .= " OR users.phone like '%?%'";
                    $params[] = $search_val;
                    $where_raw .= " OR users.address like '%?%'";
                    $params[] = $search_val;
                    $where_raw .= " OR m_department.dep_name like '%?%'";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                } else {

                    $where_raw_tmp = [];
                    if (isset($search['code'])) {
                        $where_raw_tmp[] = "users.code = '%?%'";
                        $params[] = $search['code'];
                    }
                    if (isset($search['name'])) {
                        $where_raw_tmp[] = "users.name = '%?%'";
                        $params[] = $search['name'];
                    }
                    if (isset($search['email'])) {
                        $where_raw_tmp[] = "users.email = '%?%'";
                        $params[] = $search['email'];
                    }
                    if (isset($search['phone'])) {
                        $where_raw_tmp[] = "users.phone = '%?%'";
                        $params[] = $search['phone'];
                    }
                    if (isset($search['address'])) {
                        $where_raw_tmp[] = "users.address = '%?%'";
                        $params[] = $search['address'];
                    }
                    if (isset($search['dep_name'])) {
                        $where_raw_tmp[] = "m_department.dep_name = '%?%'";
                        $params[] = $search['dep_name'];
                    }
                    if (sizeof($where_raw_tmp) > 0) {
                        $where_raw .= " AND ( " . implode(" OR ", $where_raw_tmp) . " )";
                    }
                }
            }

            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $users = DB::table('users')
                ->select('users.*', 'm_department.dep_id', 'm_department.dep_name', 'm_department.dep_type', 'm_department.per_id')
                ->leftJoin('m_department', 'users.dep_id', '=', 'm_department.dep_id')
                ->whereRaw($where_raw, $params)
                ->orderBy($sort_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $users;
    }

    public function countAllUsers()
    {
        try {
            $count = DB::table('users')
                ->where('delete_flg', '=', '0')
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
            $rows_num = $this->countAllUsers();
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }
}
