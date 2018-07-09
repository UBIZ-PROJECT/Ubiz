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

    public function getUsers($page = 0)
    {
        $rows_per_page = env('ROWS_PER_PAGE', 10);
        $users = DB::table('users')
            ->select('users.*', 'm_department.dep_id', 'm_department.dep_name', 'm_department.dep_type', 'm_department.per_id')
            ->leftJoin('m_department', 'users.dep_id', '=', 'm_department.dep_id')
            ->where('users.delete_flg', '=', '0')
            ->orderBy('id', 'asc')
            ->offset($page * $rows_per_page)
            ->limit($rows_per_page)
            ->get();
        return $users;
    }

    public function paging(){
        $rows_per_page = env('ROWS_PER_PAGE', 10);
        $rows_num = DB::table('users')
            ->where('delete_flg', '=', '0')
            ->count();
        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }
}