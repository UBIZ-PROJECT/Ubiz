<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/18/2018
 * Time: 4:45 PM
 */

namespace App\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Series implements JWTSubject
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];
    private $CONST_USER = 1;
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

    public function getSeriesPaging($prd_id, $page, $sort = '', $search = '') {
        list($where_raw,$params) = $this->makeWhereRaw($prd_id, $search);
        list($field_name, $order_by) = $this->makeOrderBy($sort);
        $rows_per_page = env('ROWS_PER_PAGE', 30);
        $series = DB::table('product_series')
            ->leftJoin("users", "users.id","=","product_series.serial_keeper")
            ->select('product_series.prd_series_id','product_series.prd_id','product_series.serial_no','product_series.serial_sts',
                DB::raw('IFNULL(product_series.serial_keeper,"") as serial_keeper'),DB::raw('IFNULL(product_series.serial_note,"") as serial_note'),
                DB::raw('IFNULL(product_series.serial_expired_date,"") as serial_expired_date'),DB::raw('IFNULL(product_series.serial_keep_date,"") as serial_keep_date'),'product_series.inp_date',DB::raw("IFNULL(users.name,'') as name"))
            ->whereRaw($where_raw, $params)
            ->orderBy($field_name, $order_by)
            ->offset($page * $rows_per_page)
            ->limit($rows_per_page)
            ->get();
        return $series;
    }


    public function insertSeries($param) {
        DB::beginTransaction();
        try {
//            $seri_no = $this->generateCode();
            $id = DB::table('product_series')->insertGetId(
                [
                    'prd_id'=> $param['prd_id'],
                    'serial_no'=>$param['serial_no'],
                    'serial_sts'=>$param['serial_sts'],
                    'serial_keeper'=>!empty($param['serial_keeper']) ? $param['serial_keeper'] : null,
                    'serial_note'=>!empty($param['serial_note']) ? $param['serial_note'] : null,
                    'delete_flg'=>'0',
                    'serial_expired_date'=>!empty($param['serial_expired_date']) ? $this->convertDBDateByString($param['serial_expired_date']) : null,
                    'serial_keep_date'=>!empty($param['serial_keep_date']) ? date('Y-m-d H:i:s') : null,
                    'inp_date'=>date('Y-m-d H:i:s'),
                    'upd_date'=>date('Y-m-d H:i:s'),
                    'inp_user'=>$this->CONST_USER,
                    'upd_user'=>$this->CONST_USER
                ]
            );

            DB::commit();
            return $id;
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateSeries($param) {
        DB::beginTransaction();
        try {
            DB::table('product_series')->where('prd_series_id','=',$param['prd_series_id'])
                ->update([
                    'serial_no'=>$param['serial_no'],
                    'serial_sts'=>$param['serial_sts'],
                    'serial_keeper'=>!empty($param['serial_keeper']) ? $param['serial_keeper'] : null,
                    'serial_note'=>!empty($param['serial_note']) ? $param['serial_note'] : null,
                    'serial_expired_date'=>!empty($param['serial_expired_date']) ? $this->convertDBDateByString($param['serial_expired_date']) : null,
                    'serial_keep_date'=>!empty($param['serial_keep_date']) ? date('Y-m-d H:i:s') : null,
                    'upd_date'=>date('Y-m-d H:i:s')
                ]);
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSeries($id) {
        DB::beginTransaction();
        try {
            if ($id) {
                DB::table('product_series')->where('prd_series_id', $id)
                    ->update([
                        'delete_flg'=>'1',
                        'upd_date'=>date('Y-m-d H:i:s')
                    ]);
            }
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function makeWhereRaw($prd_id, $search = '')
    {
        $params = [0];
        $where_raw = " product_series.delete_flg = ? ";
        if ($search != '' && !empty($search)) {
            $where_raw .= " AND (";
            $where_raw .= " OR product_series.serial_no like ?";
            $params[] = $search;
            $where_raw .= " ) ";
        }

        $where_raw .= " AND product_series.prd_id = ?";
        $params[] = $prd_id;
        return [$where_raw, $params];
    }

    public function getPagingInfo($prd_id, $sort = '', $search = []) {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countAllSeries($prd_id, $sort,$search);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }


    public function countAllSeries($prd_id, $sort, $search)
    {
        try {
            list($where_raw,$params) = $this->makeWhereRaw($prd_id, $search);
            $count = DB::table("product_series")
                ->whereRaw($where_raw, $params)
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    private function makeOrderBy($sort)
    {
        $field_name = 'product_series.serial_no';
        $order_by = 'asc';
        if ($sort != '' && !empty($sort)) {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $field_name = implode('_', $sort_info);
        }
        return [$field_name, $order_by];
    }

    private function convertDBDateByString($date) {
        if (!empty($date)) {
            $timestamp = strtotime($date);
            if ($timestamp === FALSE) {
                $timestamp = strtotime(str_replace('/', '-', $date));
            }
            $date = date('Y-m-d H:i:s', $timestamp);
        }
        return $date;
    }
}