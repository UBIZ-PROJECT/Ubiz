<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;

class Currency implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cur_name', 'cur_code', 'cur_symbol', 'cur_state', 'cur_avatar',
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

    public function getAllCurrency()
    {
        $currencys = DB::table('m_currency')->where('delete_flg', '0')->get();
        return $currencys;
    }


    public function deleteCurrency($ids = '')
    {
        DB::beginTransaction();
        try {

            DB::table('m_currency')
                ->whereIn('cur_id', explode(',', $ids))
                ->update(['delete_flg' => '1']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getCurrency($page = 0, $sort = '')
    {
        try {
            $sort_name = 'cur_id';
            $order_by = 'asc';
            if ($sort != '') {
                $sort_info = explode('_', $sort);
                $order_by = $sort_info[sizeof($sort_info) - 1];
                unset($sort_info[sizeof($sort_info) - 1]);
                $sort_name = implode('_', $sort_info);
            }

            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $currency = DB::table('m_currency')
                ->where('delete_flg', '0')
                ->orderBy($sort_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();
        }catch (\Throwable $e) {
            throw $e;
        }
        return $currency;
    }

    public function countAllCurrency()
    {
        try {
            $count = DB::table('m_currency')
                ->where('delete_flg', '0')
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
            $rows_num = $this->countAllCurrency();
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function insertCurrency($param) {
        $id = DB::table('m_currency')->insertGetId(
            [
                'cur_name'=>$param['cur_name'],
                'cur_code'=>$param['cur_code'],
                'cur_symbol'=>$param['cur_symbol'],
                'cur_state'=>$param['cur_state'],
                'cur_avatar'=>$param['cur_avatar'],
                'inp_date'=>'now()',
                'upd_date'=>'now()',
                'inp_user'=>'1',
                'upd_user'=>'1'
            ]
        );
        return $id;
    }

}
