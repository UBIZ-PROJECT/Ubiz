<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/18/2018
 * Time: 4:45 PM
 */

namespace App\Model;


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

    public function getSeriesPaging($page, $sort = '', $search = '') {
        list($where_raw,$params) = $this->makeWhereRaw($search);
        list($field_name, $order_by) = $this->makeOrderBy($sort);
        $rows_per_page = env('ROWS_PER_PAGE', 30);
        $series = DB::table('product_series')
            ->select('prd_series_id','prd_id','serial_no','serial_sts','serial_note')
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
            $id = DB::table('product')->insertGetId(
                [
                    'prd_id'=> $param['prd_id'],
                    'serial_no'=>$param['serial_no'],
                    'serial_sts'=>$param['serial_sts'],
                    'serial_note'=>$param['serial_note'],
                    'delete_flg'=>'0',
                    'inp_date'=>date('Y-m-d H:i:s'),
                    'upd_date'=>date('Y-m-d H:i:s'),
                    'inp_user'=>$this->CONST_USER,
                    'upd_user'=>$this->CONST_USER
                ]
            );
            foreach ($param['images'] as $element=>$image) {
                if ($element === "delete") continue;
                $this->insertProductImage($id,$image['extension'], $image['temp_name']);
            }

            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateSeries($param) {
        DB::beginTransaction();
        $param['brd_id'] = '1';
        try {
            DB::table('product')->where('prd_series_id','=',$param['prd_series_id'])
                ->update([
                    'prd_id'=> $param['prd_id'],
                    'serial_no'=>$param['serial_no'],
                    'serial_sts'=>$param['serial_sts'],
                    'serial_note'=>$param['serial_note'],
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
            if ($id && is_array($id)) {
                DB::table('product')->whereIn('prd_series_id', $id)
                    ->update([
                        'delete_flg'=>'1',
                        'upd_date'=>date('Y-m-d H:i:s')
                    ]);
                $this->deleteProductImage(null,$id);
            }
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function makeWhereRaw($search = '')
    {
        $params = [0];
        $where_raw = "where delete_flg = ? ";
        if ($search != '') {
            $where_raw .= " AND (";
            $where_raw .= " OR serial_no like ?";
            $params[] = $search;
            $where_raw .= " ) ";
        }
        return [$where_raw, $params];
    }

    public function getPagingInfo($sort = '', $search = []) {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countAllBrand($sort,$search);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }


    public function countAllSeries($sort, $search)
    {
        try {
            list($where_raw,$params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);
            $count = DB::select("
                SELECT count(*) as count
                    FROM product_series $where_raw 
                ORDER BY $field_name $order_by
                ", $params);
            $count = $count[0]->count;
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    private function makeOrderBy($sort)
    {
        $field_name = 'serial_no';
        $order_by = 'asc';
        if ($sort != '') {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $field_name = implode('_', $sort_info);
        }
        return [$field_name, $order_by];
    }
}