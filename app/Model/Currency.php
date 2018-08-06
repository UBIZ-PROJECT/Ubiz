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
        $currency = DB::table('m_currency')->get();
        return $currency;
    }

    public function getCurrency($page = 0, $sort = '', $search=[])
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $currency = DB::table('m_currency')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();
        }catch (\Throwable $e) {
            throw $e;
        }
        return $currency;
    }

    public  function getCurrencyById($id){
        try{
            $currency = DB::table('m_currency')
                ->where('cur_id', $id)
                ->first();
            if ($currency != null && !empty($currency->cur_avatar)) {
                $currency->cur_avatar = \Helper::readImage($currency->cur_avatar, 'cur');
            }
        }catch (\Throwable $e){
            throw $e;
        }
        return $currency;
    }

    public function getCurrencyByPos($pos = 0, $sort = '', $search = [])
    {
        try {

            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $currency = DB::table('m_currency')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($pos - 1)
                ->limit(1)
                ->first();
            if ($currency != null && !empty($currency->cur_avatar)) {
                $currency->cur_avatar = \Helper::readImage($currency->cur_avatar, 'cur');
            }

        } catch (\Throwable $e) {
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

    public function makeWhereRaw($search = [])
    {
        $params = ['0'];
        $where_raw = 'm_currency.delete_flg = ?';
        if (sizeof($search) > 0) {
            if (isset($search['contain']) || isset($search['notcontain'])) {
                if (isset($search['contain'])) {
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "m_currency.cur_code like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_currency.cur_name like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_currency.cur_symbol like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_currency.cur_state like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if (isset($search['notcontain'])) {
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= " AND m_currency.cur_code not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_currency.cur_name not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_currency.cur_symbol not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_currency.cur_state not like ?";
                    $params[] = $search_val;
                }

            } else {

                $where_raw_tmp = [];
                if (isset($search['code'])) {
                    $where_raw_tmp[] = "m_currency.cur_code = ?";
                    $params[] = $search['code'];
                }
                if (isset($search['name'])) {
                    $where_raw_tmp[] = "m_currency.cur_name = ?";
                    $params[] = $search['name'];
                }
                if (isset($search['symbol'])) {
                    $where_raw_tmp[] = "m_currency.cur_symbol = ?";
                    $params[] = $search['symbol'];
                }
                if (isset($search['state'])) {
                    $where_raw_tmp[] = "m_currency.cur_state = ?";
                    $params[] = $search['state'];
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
        $field_name = 'cur_code';
        $order_by = 'asc';
        if ($sort != '') {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $field_name = implode('_', $sort_info);
        }
        return [$field_name, $order_by];
    }

    public function insertCurrency($param) {
        DB::beginTransaction();
        try {
            $id = DB::table('m_currency')->max('cur_id') + 1;
            if (isset($param['cur_avatar'])) {
                $avatar = $param['cur_avatar'];
                $path = $avatar->path();
                $extension = $avatar->extension();
                $avatar = $id . "." . $extension;
                \Helper::resizeImage($path, $avatar, 200, 200, 'cur');
                $param['cur_avatar'] = $avatar;
            }
            DB::table('m_currency')->insert($param);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateCurrency($param)
    {
        DB::beginTransaction();
        try {
            if (isset($param['cur_avatar'])) {
                $avatar = $param['cur_avatar'];
                $path = $avatar->path();
                $extension = $avatar->extension();
                $avatar = $param['cur_id'] . "." . $extension;
                \Helper::resizeImage($path, $avatar, 200, 200, 'cur');
                $param['cur_avatar'] = $avatar;
            }
            DB::table('m_currency')
                ->where('cur_id', $param['cur_id'])
                ->update($param);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteCurrency($ids)
    {
        DB::beginTransaction();
        try {
            DB::table('m_currency')
                ->whereIn('cur_id', $ids)
                ->update([
                    'delete_flg' => '1',
                    'upd_date' => date('Y-m-d H:i:s')
                ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return response()->json(['success']);
    }

}
