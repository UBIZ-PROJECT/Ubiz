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

class Accessory implements JWTSubject
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

    public function getAccessoryPaging($page, $sort='', $search = []) {
        list($where_raw,$params) = $this->makeWhereRaw($search);
        list($field_name, $order_by) = $this->makeOrderBy($sort);
        $rows_per_page = env('ROWS_PER_PAGE', 10);
        $accessory = DB::select("
            SELECT accessory.acs_id as id,accessory.acs_name as name,product_type.prd_type_id ,product_type.prd_type_name as name_type, 
            accessory.acs_note,accessory.acs_unit, product_image.extension,product_image.prd_img_id, accessory.acs_quantity,brand.brd_name, brand.brd_id from (
                SELECT *
                FROM accessory $where_raw
                 ) accessory
            LEFT JOIN product_type product_type ON 
            accessory.acs_type_id = product_type.prd_type_id
            LEFT JOIN brand brand ON 
            accessory.brd_id = brand.brd_id
            LEFT JOIN product_image product_image ON
            product_image.prd_img_id = (select prd_img_id from product_image as pis where accessory.acs_id = pis.acs_id and pis.delete_flg = '0' and pis.prd_id is null limit 1) 
            WHERE product_type.prd_type_flg = '2'
            ORDER BY $field_name $order_by
            LIMIT $rows_per_page OFFSET " . ($page * $rows_per_page) . "
              ", $params);
        foreach ($accessory as &$item) {
            if (!empty($item->prd_img_id)) {
                $item->image = readImage($item->id . '-' . $item->prd_img_id . '.' . $item->extension, "acs");
            }
        }
        return $accessory;
    }

    public function getEachAccessoryPaging($page, $sort='', $search = []) {
        list($where_raw,$params) = $this->makeWhereRaw($search);
        list($field_name, $order_by) = $this->makeOrderBy($sort);
        $rows_per_page = 1;
        $product = DB::select("
            SELECT accessory.acs_id,accessory.acs_name,product_type.prd_type_id ,product_type.prd_type_name,accessory.acs_note,accessory.acs_unit, 
            product_image.extension,product_image.prd_img_id, accessory.acs_quantity,  brand.brd_name, brand.brd_id from (
                SELECT *
                FROM accessory $where_raw 
            ORDER BY $field_name $order_by
                LIMIT $rows_per_page OFFSET " . ($page * $rows_per_page)." ) accessory
            LEFT JOIN product_type product_type ON 
            accessory.acs_type_id = product_type.prd_type_id
            LEFT JOIN brand brand ON 
            accessory.brd_id = brand.brd_id
            LEFT JOIN product_image product_image ON
            product_image.prd_img_id in (select prd_img_id from product_image as pis where accessory.acs_id = pis.acs_id and pis.delete_flg = '0' and pis.prd_id is null)
            WHERE product_type.prd_type_flg = '2'
            ", $params);
        $data = array();
        $data[0] = (object) array();
        $images = array();
        foreach ($product as $index=>&$item) {
            $data[0]->id = $item->acs_id;
            $data[0]->name = $item->acs_name;
            $data[0]->name_type = $item->prd_type_name;
            $data[0]->acs_note = $item->acs_note;
            $data[0]->acs_type_id = $item->prd_type_id;
            $data[0]->acs_unit = $item->acs_unit;
            $data[0]->acs_quantity = $item->acs_quantity;
            $data[0]->brd_name = $item->brd_name;
            $data[0]->brd_id = $item->brd_id;
            if (!empty($item->prd_img_id)) {
                $imageName = $item->acs_id . '-' . $item->prd_img_id . '.' . $item->extension;
                $images[$index]['src'] = readImage($imageName, "acs");
                $images[$index]['name'] = $imageName;
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

    public function insertAccessory($param) {
        DB::beginTransaction();
        try {
//            $seri_no = $this->generateCode();
            $id = DB::table('accessory')->insertGetId(
                [
                    'acs_name'=> $param['acs_name'],
                    'acs_quantity'=>!empty($param['acs_quantity'])? $param['acs_quantity'] : '0',
                    'acs_note'=>!empty($param['acs_note'])? $param['acs_note'] : null,
                    'acs_type_id'=>!empty($param['acs_type_id'])? $param['acs_type_id'] : null,
                    'acs_unit'=>!empty($param['acs_unit'])? $param['acs_unit'] : null,
                    'brd_id'=> $param['brd_id'],
                    'delete_flg'=>'0',
                    'inp_date'=>date('Y-m-d H:i:s'),
                    'upd_date'=>date('Y-m-d H:i:s'),
                    'inp_user'=>$this->CONST_USER,
                    'upd_user'=>$this->CONST_USER
                ]
            );
            foreach ($param['images'] as $element=>$image) {
                if ($element === "delete") continue;
                $this->insertAccessoryImage($id,$image['extension'], $image['temp_name']);
            }
            if (!empty($param['keeper'])) {
                $keeper = new Keeper();
                foreach ($param['keeper'] as $item) {
                    $item['acs_id'] = $id;
                    $keeper->insertKeeper($item);
                }
            }
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insertAccessoryImage($acsId, $extension, $temp_name) {
        DB::beginTransaction();
        try {
            $id = DB::table('product_image')->insertGetId(
                [
                    'acs_id'=>$acsId,
                    'extension'=>$extension,
                    'delete_flg'=>'0',
                    'inp_date'=>date('Y-m-d H:i:s'),
                    'upd_date'=>date('Y-m-d H:i:s'),
                    'inp_user'=>$this->CONST_USER,
                    'upd_user'=>$this->CONST_USER
                ]
            );
            $rederImageName = $acsId . '-' . $id . '.' . $extension;
            saveOriginalImage($temp_name, $rederImageName, 'acs');
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

    public function updateAccessory($param) {
        DB::beginTransaction();
        try {
            DB::table('accessory')->where('acs_id','=',$param['id'])
                ->update([
                    'acs_name'=>$param['acs_name'],
                    'acs_note'=>!empty($param['acs_note']) ? $param['acs_note'] : null,
                    'acs_type_id'=>!empty($param['acs_type_id']) ? $param['acs_type_id'] : null,
                    'acs_quantity'=>!empty($param['acs_quantity']) ? $param['acs_quantity'] : 0,
                    'acs_unit'=>!empty($param['acs_unit']) ? $param['acs_unit'] : null,
                    'upd_date'=>date('Y-m-d H:i:s')
                ]);
            if (!empty($param['images']['delete'])) {
                $this->deleteAccessoryImage($param['images']['delete']);
            }
            if (!empty($param['images']['insert'])) {
                foreach ($param['images']['insert'] as $image) {
                    $this->insertAccessoryImage($param['id'],$image['extension'],$image['temp_name']);
                }
            }
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteAccessoryImage($id = null, $acsId = null) {
        DB::beginTransaction();
        try {
            if ($id && is_array($id)) {
                DB::table('product_image')->whereIn('prd_img_id', $id)
                    ->update([
                        'delete_flg'=>'1',
                        'upd_date'=>date('Y-m-d H:i:s')
                    ]);
            }
            if ($acsId && is_array($acsId)) {
                DB::table('product_image')->whereIn('acs_id', $acsId)
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

    public function deleteAccessory($id) {
        DB::beginTransaction();
        try {
            if ($id && is_array($id)) {
                DB::table('accessory')->whereIn('acs_id', $id)
                    ->update([
                        'delete_flg'=>'1',
                        'upd_date'=>date('Y-m-d H:i:s')
                    ]);
                $this->deleteAccessoryImage(null,$id);
            }
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getAllAccessoryType() {
        try {
            $product_type = DB::table("product_type")
                ->select("prd_type_id as id","prd_type_name as name_type")
                ->where("prd_type_flg",'=','2')
                ->get();
        } catch(\Throwable $e) {
            throw $e;
        }
        return $product_type;
    }

    public function makeWhereRaw($search = [])
    {
        $params[] = "0";
        $where_raw = "where accessory.delete_flg = ? ";
        if (sizeof($search) > 0) {
            if (!empty($search['contain']) || !empty($search['notcontain'])) {
                if(!empty($search['contain'])){
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "accessory.acs_name like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR accessory.acs_note like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR accessory.acs_type_id like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if(!empty($search['notcontain'])){
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "accessory.acs_name not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR accessory.acs_note not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR accessory.acs_type_id not like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }

            } else {
                $where_raw_tmp = [];
                if (!empty($search['acs_name'])) {
                    $where_raw_tmp[] = "accessory.acs_name = ?";
                    $params[] = $search['acs_name'];
                }
                if (!empty($search['acs_note'])) {
                    $where_raw_tmp[] = "accessory.acs_note = ?";
                    $params[] = $search['acs_note'];
                }
                if (!empty($search['type_id'])) {
                    $where_raw_tmp[] = "accessory.acs_type_id = ?";
                    $params[] = $search['type_id'];
                }
                if (!empty($search['brd_id'])) {
                    $where_raw_tmp[] = "accessory.brd_id = ?";
                    $params[] = $search['brd_id'];
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
            $rows_num = $this->countAllAccessory($sort,$search);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function getPagingInfoDetailAccessoryWithConditionSearch($sort = '', $search = []) {
        try {
            $rows_per_page = 1;
            $rows_num = $this->countAllAccessory($sort,$search);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function countAllAccessory($sort, $search)
    {
        try {
            list($where_raw,$params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);
            $count = DB::select("
                SELECT count(*) as count from (
                    SELECT *
                    FROM accessory $where_raw 
                ORDER BY $field_name $order_by ) accessory
                LEFT JOIN product_type product_type ON 
                accessory.acs_type_id = product_type.prd_type_id
                LEFT JOIN product_image product_image ON
                product_image.prd_img_id = (select prd_img_id from product_image as pis where accessory.acs_id = pis.acs_id limit 1) 
                ", $params);
            $count = $count[0]->count;
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    private function makeOrderBy($sort)
    {
        $field_name = 'accessory.acs_name';
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