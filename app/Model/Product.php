<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/30/2018
 * Time: 9:45 PM
 */

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Product implements JWTSubject
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

    public function getProductPaging($page, $sort='', $search = []) {
        list($where_raw,$params) = $this->makeWhereRaw($search);
        list($field_name, $order_by) = $this->makeOrderBy($sort);
        $rows_per_page = env('ROWS_PER_PAGE', 10);
        $product = DB::select("
            SELECT product.id,product.seri_no,product.name,product_type.name_type,product.branch,product.model,product_image.extension,product_image.id as image_id from (
                SELECT *
                FROM product
                LIMIT $rows_per_page OFFSET " . ($page * $rows_per_page)." ) product
            LEFT JOIN product_type product_type ON 
            product.type_id = product_type.id
            LEFT JOIN product_image product_image ON
            product_image.id = (select id from product_image as pis where product.id = pis.prd_id limit 1) 
            WHERE $where_raw 
            ORDER BY $field_name $order_by", $params);
        foreach ($product as &$item) {
            if (!empty($item->image_id)) {
                $item->image = $item->id . '-' . $item->image_id . '.' . $item->extension;
            }
        }
        return $product;
    }

    public function getEachProductPaging($page, $sort='', $search = []) {
        list($where_raw,$params) = $this->makeWhereRaw($search);
        list($field_name, $order_by) = $this->makeOrderBy($sort);
        $rows_per_page = 1;
        $product = DB::select("
            SELECT product.id,product.seri_no,product.name,product.detail,product_type.name_type,product.branch,product.model,product_image.extension,product_image.id as image_id from (
                SELECT *
                FROM product
                LIMIT $rows_per_page OFFSET " . ($page * $rows_per_page)." ) product
            LEFT JOIN product_type product_type ON 
            product.type_id = product_type.id
            LEFT JOIN product_image product_image ON
            product_image.prd_id = product.id 
            WHERE $where_raw 
            ORDER BY $field_name $order_by", $params);
        $data = array();
        $data[0] = (object) array();
        $images = array();
        foreach ($product as &$item) {
            $data[0]->id = $item->id;
            $data[0]->seri_no = $item->seri_no;
            $data[0]->name = $item->name;
            $data[0]->name_type = $item->name_type;
            $data[0]->branch = $item->branch;
            $data[0]->model = $item->model;
            $data[0]->detail = $item->detail;
            if (!empty($item->image_id)) {
                $images[] = $item->id . '-' . $item->image_id . '.' . $item->extension;
                $data[0]->images = $images;
            }
        }
        return $data;
    }

    /** INSERT
    {  
       "seri_no":"99999",
       "name":"xxxxx",
       "branch":"xxxxx",
       "model":"xxxxx",
       "detail":"xxxxx",
       "type_id":"9999",
       "images":{ 
             "0":{  
                "temp_name":"xxxxxxxx",
                "extension":"xxxxxxxx"
             },
             "1":{  
                "temp_name":"xxxxxxxx",
                "extension":"xxxxxxxx"
             }
          }
       }
    }
    */

    public function insertProduct($param) {
        DB::beginTransaction();
        try {
            $seri_no = $this->generateCode();
            $id = DB::table('product')->insertGetId(
                [
                    'seri_no'=>$param['seri_no'],
                    'name'=>$param['name'],
                    'branch'=>$param['branch'],
                    'model'=>$param['model'],
                    'detail'=>$param['detail'],
                    'type_id'=>$param['type_id'],
                    'delete_flg'=>'0',
                    'inp_date'=>date('Y-m-d H:i:s'),
                    'upd_date'=>date('Y-m-d H:i:s'),
                    'inp_user'=>$this->CONST_USER,
                    'upd_user'=>$this->CONST_USER
                ]
            );

            foreach ($param['images'] as $image) {
                $this->insertProductImage($id,$image['extension'], $image['temp_name']);
            }

            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insertProductImage($proId, $extension, $temp_name) {
        DB::beginTransaction();
        try {
            $id = DB::table('product_image')->insertGetId(
                [
                    'prd_id'=>$proId,
                    'extension'=>$extension,
                    'delete_flg'=>'0',
                    'inp_date'=>date('Y-m-d H:i:s'),
                    'upd_date'=>date('Y-m-d H:i:s'),
                    'inp_user'=>$this->CONST_USER,
                    'upd_user'=>$this->CONST_USER
                ]
            );
            $rederImageName = $proId . '-' . $id . '.' . $extension;
            Helper::saveOriginalImage($temp_name, $rederImageName, 'pro');
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /** Update
    {
       "id":"99999",
       "seri_no":"99999",
       "name":"xxxxx",
       "branch":"xxxxx",
       "model":"xxxxx",
       "detail":"xxxxx",
       "type_id":"9999",
       "images":{  
          "delete":{  
             "0":"image_id",
             "1":"image_id"
          },
          "insert":{  
             "0":{  
                "temp_name":"xxxxxxxx",
                "extension":"xxxxxxxx"
             },
             "1":{  
                "temp_name":"xxxxxxxx",
                "extension":"xxxxxxxx"
             }
          }
       }
    }

    */

    public function updateProduct($param) {
        DB::beginTransaction();
        try {
            DB::table('product')->where('id','=',$param['id'])
                ->update([
                    'seri_no'=>$param['seri_no'],
                    'name'=>$param['name'],
                    'branch'=>$param['branch'],
                    'model'=>$param['model'],
                    'detail'=>$param['detail'],
                    'type_id'=>$param['type_id'],
                    'upd_date'=>date('Y-m-d H:i:s')
                ]);
            if (!empty($param['images']['delete'])) {
                $this->deleteProductImage($param['images']['delete']);
            }
            if (!empty($param['images']['insert'])) {
                foreach ($param['images']['insert'] as $image) {
                    $this->insertProductImage($param['id'],$image['extenstion'],$image['temp_name']);
                }
            }
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteProductImage($id = null, $prdId = null) {
        DB::beginTransaction();
        try {
            if ($id && is_array($id)) {
                DB::table('product_image')->whereIn('id', $id)
                    ->update([
                        'delete_flg'=>'1',
                        'upd_date'=>date('Y-m-d H:i:s')
                    ]);
            }
            if ($prdId && is_array($prdId)) {
                DB::table('product_image')->whereIn('prd_id', $prdId)
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

    public function deleteProduct($id) {
        DB::beginTransaction();
        try {
            if ($id && is_array($id)) {
                DB::table('product')->whereIn('id', $id)
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

    public function getAllProductType() {
        try {
            $product_type = DB::table("product_type")
                ->select("id","name_type")
                ->get();
        } catch(\Throwable $e) {
            throw $e;
        }
        return $product_type;
    }

    public function makeWhereRaw($search = [])
    {
        $params = [0];
        $where_raw = 'product.delete_flg = ?';
        if (sizeof($search) > 0) {
            if (!empty($search['contain']) || !empty($search['notcontain'])) {
                if(!empty($search['contain'])){
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "product.seri_no like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.branch like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.model like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.detail like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product_type.name_type like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if(!empty($search['notcontain'])){
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "product.seri_no not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.branch not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.model not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.detail not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product_type.name_type not like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }

            } else {

                $where_raw_tmp = [];
                if (!empty($search['seri_no'])) {
                    $where_raw_tmp[] = "product.seri_no = ?";
                    $params[] = $search['seri_no'];
                }
                if (!empty($search['branch'])) {
                    $where_raw_tmp[] = "product.branch = ?";
                    $params[] = $search['branch'];
                }
                if (!empty($search['model'])) {
                    $where_raw_tmp[] = "product.model = ?";
                    $params[] = $search['model'];
                }
                if (!empty($search['detail'])) {
                    $where_raw_tmp[] = "product.detail = ?";
                    $params[] = $search['detail'];
                }
                if (!empty($search['name_type'])) {
                    $where_raw_tmp[] = "product.name_type = ?";
                    $params[] = $search['name_type'];
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
            $rows_num = $this->countAllProduct($sort,$search);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function getPagingInfoDetailProductWithConditionSearch($sort = '', $search = []) {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countAllProduct($sort,$search);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function countAllProduct($sort, $search)
    {
        try {
            list($where_raw,$params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);
            $count = DB::select("
                SELECT count(*) as count from (
                    SELECT *
                    FROM product) product
                LEFT JOIN product_type product_type ON 
                product.type_id = product_type.id
                LEFT JOIN product_image product_image ON
                product_image.id = (select id from product_image as pis where product.id = pis.prd_id limit 1) 
                WHERE $where_raw 
                ORDER BY $field_name $order_by", $params);
            $count = $count[0]->count;
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    private function makeOrderBy($sort)
    {
        $field_name = 'product.seri_no';
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