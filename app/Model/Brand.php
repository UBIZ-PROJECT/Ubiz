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
        foreach ($brands as &$brand) {
            if (!empty($brand->brd_img)) {
                $brdImageName = $brand->brd_id . "." . $brand->brd_img;
                $brdImage['src'] = Helper::readImage($brdImageName, "brd");;
                $brdImage['name'] = $brdImageName;
                $brand->brdImage = $brdImage;
            }
        }

        return $brands;
    }

    public function makeWhereRaw($search = [])
    {
        $params = [0];
        $where_raw = "where brand.delete_flg = ? ";
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


    public function countAllBrand($sort, $search)
    {
        try {
            list($where_raw,$params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);
            $count = DB::select("
                SELECT count(*) as count
                    FROM brand $where_raw 
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
        $field_name = 'brand.brd_name';
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