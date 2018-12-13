<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/18/2018
 * Time: 9:42 AM
 */

namespace App\Model;
use App\Helper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Brand implements JWTSubject
{
    private $CONST_USER = 1;
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


    public function getBrandPaging($page, $sort = '', $search =[]) {
        list($where_raw,$params) = $this->makeWhereRaw($search);
        list($field_name, $order_by) = $this->makeOrderBy($sort);
        $rows_per_page = env('ROWS_PER_PAGE', 10);
        $brands = DB::table('brand')
            ->select('brd_id','brd_name','brd_img')
            ->whereRaw($where_raw, $params)
            ->orderBy($field_name, $order_by)
            ->offset($page * $rows_per_page)
            ->limit($rows_per_page)
            ->get();
        $brands[0]->brdImage = array('src'=>'', 'name'=>'');
        foreach ($brands as &$brand) {
            if (!empty($brand->brd_img)) {
                $brdImageName = $brand->brd_id . '.' . $brand->brd_img;
                $brdImage['src'] = Helper::readImage($brdImageName, "brd");;
                $brdImage['name'] = $brdImageName;
                $brand->brdImage = $brdImage;
            }
        }
        return $brands;
    }

    public function getEachBrandPaging($brd_id) {
        $rows_per_page = 1;
        $brands = DB::table('brand')
            ->select('brd_id','brd_name','brd_img')
            ->where('brd_id','=', $brd_id)
            ->limit($rows_per_page)
            ->get();
        $brands[0]->brdImage = array('src'=>'', 'name'=>'');
        foreach ($brands as &$brand) {
            if (!empty($brand->brd_img)) {
                $brdImageName = $brand->brd_id . '.' . $brand->brd_img;
                $brdImage['src'] = Helper::readImage($brdImageName, "brd");;
                $brdImage['name'] = $brdImageName;
                $brand->brdImage = $brdImage;
            }
        }

        return $brands[0];
    }

    public function insertBrand($param) {
        DB::beginTransaction();
        try {
            $extension = isset($param['images']) ?  $param['images']['insert'][0]['extension'] : '';
            $id = DB::table('brand')->insertGetId(
                [
                    'brd_name'=> $param['brd_name'],
                    'brd_img'=> $extension,
                    'delete_flg'=>'0',
                    'inp_date'=>date('Y-m-d H:i:s'),
                    'upd_date'=>date('Y-m-d H:i:s'),
                    'inp_user'=>$this->CONST_USER,
                    'upd_user'=>$this->CONST_USER
                ]
            );
            $rederImageName = $id . '.' . $extension;
            $this->insertBrandImage($rederImageName,$param['images']['insert'][0]['temp_name']);
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateBrand($param) {
        DB::beginTransaction();
        $extension = isset($param['images']) ?  $param['images']['insert'][0]['extension'] : '';
        try {
            if ($extension) {
                DB::table('brand')->where('brd_id','=',$param['brd_id'])
                    ->update([
                        'brd_name'=>$param['brd_name'],
                        'brd_img'=> $extension,
                        'upd_date'=>date('Y-m-d H:i:s')
                    ]);
                $rederImageName = $param['brd_id'] . '.' . $extension;
                $this->insertBrandImage($rederImageName,$param['images']['insert'][0]['temp_name']);
            } else {
                if ($param['brd_img'] == true || $param['brd_img'] == 'true') {
                    DB::table('brand')->where('brd_id','=',$param['brd_id'])
                        ->update([
                            'brd_name'=>$param['brd_name'],
                            'brd_img'=> '',
                            'upd_date'=>date('Y-m-d H:i:s')
                        ]);
                } else {
                    DB::table('brand')->where('brd_id','=',$param['brd_id'])
                        ->update([
                            'brd_name'=>$param['brd_name'],
                            'upd_date'=>date('Y-m-d H:i:s')
                        ]);
                }
            }

            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteBrand($id) {
        DB::beginTransaction();
        try {
            if ($id && is_array($id)) {
                DB::table('brand')->whereIn('brd_id', $id)
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

    private function insertBrandImage($rederImageName, $temp_name) {
        Helper::saveOriginalImage($temp_name, $rederImageName, 'brd');
    }

    private function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    public function makeWhereRaw($search = [])
    {
        $params = [0];
        $where_raw = " brand.delete_flg = ? ";
        if (sizeof($search) > 0) {
            if (!empty($search['contain']) || !empty($search['notcontain'])) {
                if(!empty($search['contain'])){
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= " OR brand.brd_name like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if(!empty($search['notcontain'])){
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= " OR brand.brd_name not like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }

            } else {

                $where_raw_tmp = [];
                if (!empty($search['brd_name'])) {
                    $where_raw_tmp[] = " brand.brd_name = ?";
                    $params[] = $search['brd_name'];
                }
                if (sizeof($where_raw_tmp) > 0) {
                    $where_raw .= " AND ( " . implode(" OR ", $where_raw_tmp) . " )";
                }
            }
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

    public function getPagingInfoDetailBrandWithConditionSearch($sort = '', $search = []) {
        try {
            $rows_per_page = 1;
            $rows_num = $this->countAllBrand($sort,$search);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }


    public function countAllBrand($sort, $search)
    {
        try {
            list($where_raw,$params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);
            $count = DB::select("
                SELECT count(*) as count
                    FROM brand where $where_raw 
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
        $field_name = 'brand.brd_id';
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