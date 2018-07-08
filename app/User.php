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

    public function getUsers($page = 0)
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $users = DB::table('users')
                ->select('users.*', 'm_department.dep_id', 'm_department.dep_name', 'm_department.dep_type', 'm_department.per_id')
                ->leftJoin('m_department', 'users.dep_id', '=', 'm_department.dep_id')
                ->where('users.delete_flg', '=', '0')
                ->orderBy('id', 'asc')
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
