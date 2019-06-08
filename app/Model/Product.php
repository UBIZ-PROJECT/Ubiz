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
use Illuminate\Support\Facades\Auth;

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
            SELECT product.prd_id as id,product.prd_name as name,product_type.prd_type_id ,product_type.prd_type_name as name_type, 
            product.prd_note,product.prd_unit, product.prd_model as model,product_image.extension,product_image.prd_img_id, brand.brd_name, brand.brd_id from (
                SELECT *
                FROM product 
                $where_raw
                ORDER BY $field_name $order_by 
                LIMIT $rows_per_page OFFSET " . ($page * $rows_per_page)."  ) product
            LEFT JOIN product_type product_type ON 
            product.type_id = product_type.prd_type_id
            LEFT JOIN brand brand ON
            product.brd_id = brand.brd_id
            LEFT JOIN product_image product_image ON
            product_image.prd_img_id = (select prd_img_id from product_image as pis where product.prd_id = pis.prd_id and pis.delete_flg = '0' limit 1) 
           
             ", $params);
        foreach ($product as &$item) {
            if (!empty($item->prd_img_id)) {
                $item->image = readImage($item->id . '-' . $item->prd_img_id . '.' . $item->extension, "prd");
            }
        }
        return $product;
    }

    public function getEachProductPaging($page, $sort='', $search = []) {
        list($where_raw,$params) = $this->makeWhereRaw($search);
        list($field_name, $order_by) = $this->makeOrderBy($sort);
        $rows_per_page = 1;
        $product = DB::select("
            SELECT product.prd_id,product.prd_name,product_type.prd_type_id ,product_type.prd_type_name,product.prd_note,product.prd_unit, 
            product.prd_model,brand.brd_name,brand.brd_id, brand.brd_img,product_image.extension,product_image.prd_img_id from (
                SELECT *
                FROM product $where_raw 
            ORDER BY $field_name $order_by
                LIMIT $rows_per_page OFFSET " . ($page * $rows_per_page)." ) product
            LEFT JOIN product_type product_type ON 
            product.type_id = product_type.prd_type_id
            LEFT JOIN brand brand ON
            brand.brd_id = product.brd_id
            LEFT JOIN product_image product_image ON
            product_image.prd_img_id in (select prd_img_id from product_image as pis where product.prd_id = pis.prd_id and pis.delete_flg = '0')
            ", $params);
        $data = array();
        $data[0] = (object) array();
        $images = array();
        foreach ($product as $index=>&$item) {
            $data[0]->id = $item->prd_id;
            $data[0]->brd_name = $item->brd_name;
            $data[0]->name = $item->prd_name;
            $data[0]->name_type = $item->prd_type_name;
            $data[0]->brd_id = $item->brd_id;
            $data[0]->brd_img = $item->brd_img;
            $data[0]->model = $item->prd_model;
            $data[0]->prd_note = $item->prd_note;
            $data[0]->prd_type_id = $item->prd_type_id;
            $data[0]->prd_unit = $item->prd_unit;
            if (!empty($item->prd_img_id)) {
                $imageName = $item->prd_id . '-' . $item->prd_img_id . '.' . $item->extension;
                $images[$index]['src'] = readImage($imageName, "prd");
                $images[$index]['name'] = $imageName;
                $data[0]->images = $images;
            }
        }
        if (!empty($data[0]->brd_img)) {
            $brdImageName = $data[0]->brd_id . "." . $data[0]->brd_img;
            $brdImage['src'] = readImage($brdImageName, "brd");;
            $brdImage['name'] = $brdImageName;
            $data[0]->brdImage = $brdImage;
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
//            $seri_no = $this->generateCode();
            $id = DB::table('product')->insertGetId(
                [
                    'prd_name'=> $param['name'],
                    'brd_id'=>$param['brd_id'],
                    'prd_model'=>!empty($param['prd_model'])? $param['prd_model'] : null,
                    'prd_unit'=>!empty($param['prd_unit']) ? $param['prd_unit'] : null,
                    'prd_note'=>!empty($param['prd_note'])? $param['prd_note'] : null,
                    'type_id'=>!empty($param['type_id'])? $param['type_id'] : null,
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
            if ($param['series']) {
                $series = new Series();
                foreach($param['series'] as $item ) {
                    $item['prd_id'] = $id;
                    $series->insertSeries($item);
                }
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
            saveOriginalImage($temp_name, $rederImageName, 'prd');
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
            DB::table('product')->where('prd_id','=',$param['id'])
                ->update([
                    'prd_name'=>$param['name'],
                    'brd_id'=>!empty($param['brd_id']) ? $param['brd_id'] : null,
                    'prd_model'=>!empty($param['prd_model']) ? $param['prd_model'] : null,
                    'prd_unit'=>!empty($param['prd_unit']) ? $param['prd_unit'] : null,
                    'prd_note'=>!empty($param['prd_note']) ? $param['prd_note'] : null,
                    'type_id'=>!empty($param['type_id']) ? $param['type_id'] : null,
                    'upd_date'=>date('Y-m-d H:i:s')
                ]);
            if (!empty($param['images']['delete'])) {
                $this->deleteProductImage($param['images']['delete']);
            }
            if (!empty($param['images']['insert'])) {
                foreach ($param['images']['insert'] as $image) {
                    $this->insertProductImage($param['id'],$image['extension'],$image['temp_name']);
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
                DB::table('product_image')->whereIn('prd_img_id', $id)
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
                DB::table('product')->whereIn('prd_id', $id)
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
                ->select("prd_type_id as id","prd_type_name as name_type")
                ->where("prd_type_flg",'=','1')
                ->get();
        } catch(\Throwable $e) {
            throw $e;
        }
        return $product_type;
    }

    public function makeWhereRaw($search = [])
    {
        $params = [0];
        $where_raw = "where product.delete_flg = ? ";
        if (sizeof($search) > 0) {
            if (!empty($search['contain']) || !empty($search['notcontain'])) {
                if(!empty($search['contain'])){
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "product.prd_name like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.prd_model like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.prd_note like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.type_id like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if(!empty($search['notcontain'])){
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "product.prd_name not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.prd_model not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.prd_note not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR product.type_id not like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }

            } else {
                $where_raw_tmp = [];
                if (!empty($search['prd_name'])) {
                    $where_raw_tmp[] = "product.prd_name = ?";
                    $params[] = $search['prd_name'];
                }
                if (!empty($search['prd_model'])) {
                    $where_raw_tmp[] = "product.prd_model = ?";
                    $params[] = $search['prd_model'];
                }
                if (!empty($search['prd_note'])) {
                    $where_raw_tmp[] = "product.prd_note = ?";
                    $params[] = $search['prd_note'];
                }
                if (!empty($search['type_id'])) {
                    $where_raw_tmp[] = "product.type_id = ?";
                    $params[] = $search['type_id'];
                }

                if (sizeof($where_raw_tmp) > 0) {
                    $where_raw .= " AND ( " . implode(" OR ", $where_raw_tmp) ;
                }
                if (!empty($search['brd_id'])) {
                    if (sizeof($where_raw_tmp) > 0)
                        $where_raw .= " AND product.brd_id = ? )";
                    else
                        $where_raw .= " AND product.brd_id = ? ";
                    $params[] = $search['brd_id'];
                } else {
                    $where_raw .= " )";
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

    public function checkProductIsExistsByModel($prd_model)
    {
        try {
            $cnt = DB::table('product')
                ->where([
                    ['prd_model', '=', $prd_model],
                    ['delete_flg', '=', '0'],
                ])
                ->count();
            if($cnt > 0)
                return true;
            return false;
        } catch(\Throwable $e) {
            throw $e;
        }
    }

    public function getProductSeriesByModel($prd_model)
    {
        try {
            $data = DB::table('product_series')
                ->join('product', 'product_series.prd_id', '=', 'product.prd_id')
                ->where([
                    ['product.prd_model', '=', $prd_model],
                    ['product_series.serial_keeper', '=', Auth::user()->id],
                    ['product.delete_flg', '=', '0'],
                    ['product_series.delete_flg', '=', '0']
                ])
                ->select(
                    'product_series.serial_no'
                )
                ->get();
            return $data;
        } catch(\Throwable $e) {
            throw $e;
        }
    }

    public function getPagingInfoDetailProductWithConditionSearch($sort = '', $search = []) {
        try {
            $rows_per_page = 1;
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
                    FROM product $where_raw 
                ORDER BY $field_name $order_by ) product
                LEFT JOIN product_type product_type ON 
                product.type_id = product_type.prd_type_id
                LEFT JOIN product_image product_image ON
                product_image.prd_img_id = (select prd_img_id from product_image as pis where product.prd_id = pis.prd_id limit 1) 
                ", $params);
            $count = $count[0]->count;
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    private function makeOrderBy($sort)
    {
        $field_name = 'product.prd_id';
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