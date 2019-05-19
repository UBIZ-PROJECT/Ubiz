<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/4/2018
 * Time: 11:56 PM
 */

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Helper;

class Supplier implements JWTSubject
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sup_id','sup_name', 'sup_website', 'sup_phone', 'sup_fax', 'sup_mail',
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
    public function getAllSupplier()
    {
        $supplier = DB::table('suppliers')->get();
        return $supplier;
    }

    public function getSupplierPaging($page,$sort = '', $search = []) {
        list($where_raw,$params) = $this->makeWhereRaw($search);
        list($field_name, $order_by) = $this->makeOrderBy($sort);
        $rows_per_page = env('ROWS_PER_PAGE', 10);
        $supplier = DB::table('suppliers')
            ->select('sup_id','sup_code','sup_avatar','sup_name','sup_phone','sup_fax','sup_mail','sup_website')
            ->whereRaw($where_raw, $params)
            ->orderBy($field_name, $order_by)
            ->offset($page * $rows_per_page)
            ->limit($rows_per_page)
            ->get();
        return $supplier;
    }

    public function getSupplierById($id) {
        $supplier = DB::table('suppliers')
            ->select('sup_id','sup_code','sup_avatar','sup_name','sup_phone','sup_fax','sup_mail','sup_website')
            ->where([['delete_flg','=','0'],['sup_id','=',$id]])
            ->get();
        return $supplier;
    }

    public function getEachSupplierByPaging($page,$sort = '', $search =[]) {
        list($where_raw,$params) = $this->makeWhereRaw($search);
        list($field_name, $order_by) = $this->makeOrderBy($sort);
        $rows_per_page = 1;
        $params[] = $rows_per_page;
        $params[] = $page * $rows_per_page;
        $supplier = DB::select("select addr.sad_id, sup.sup_id, sup_code,sup_avatar,sup_name,sup_phone, sup_fax,sup_mail,sup_website,sad_address from (select * 
                from suppliers 
                where $where_raw
                order by $field_name $order_by
                limit ? offset ?) sup
                LEFT JOIN supplier_address addr ON 
                addr.sad_id IN (select sad_id from supplier_address where delete_flg = '0' and sup.sup_id = sup_id) ",$params);
        $data = array();
        $data[0] = (object) array();
        $data[0]->sad_address = array();
        foreach ($supplier as $index=>$sup) {
            $data[0]->sup_id = $sup->sup_id;
            $data[0]->sup_code = $sup->sup_code;
            $data[0]->sup_avatar = $sup->sup_avatar;
            $data[0]->sup_name = $sup->sup_name;
            $data[0]->sup_phone = $sup->sup_phone;
            $data[0]->sup_fax = $sup->sup_fax;
            $data[0]->sup_mail = $sup->sup_mail;
            $data[0]->sup_website = $sup->sup_website;
            if (empty($sup->sad_id)) continue;
            $addrObj = (object) array();
            $addrObj->address = $sup->sad_address;
            $addrObj->id = $sup->sad_id;
            $data[0]->sad_address[] = $addrObj;
        }

        return $data;
    }

    public function insertSupplier($param) {
        DB::beginTransaction();
        $sup_ava = '';
        if (!empty($param['extension'])) {
            $sup_ava = $this->getNextId() . "." . $param['extension'];
        }
        try {
            $code = $this->generateCode();
            $id = DB::table('suppliers')->insertGetId(
                [
                    'sup_code'=>$code,
                    'sup_avatar'=>$sup_ava,
                    'sup_name'=>$param['sup_name'],
                    'sup_phone'=>$param['sup_phone'],
                    'sup_fax'=>$param['sup_fax'],
                    'sup_mail'=>$param['sup_mail'],
                    'sup_website'=>$param['sup_website'],
                    'delete_flg'=>'0',
                    'inp_date'=>date('Y-m-d H:i:s'),
                    'upd_date'=>date('Y-m-d H:i:s'),
                    'inp_user'=>'2',
                    'upd_user'=>'2'
                ]
            );
            if (!empty($param['addresses'])) {
                $addresses = $param['addresses'];
                foreach ($addresses as $address) {
                    if (empty($address)) continue;
                    $this->insertSupplierAddress($address,$id);
                }
            }
            if (!empty($param['tmp_name'])) {
                Helper::resizeImage($param['tmp_name'], $sup_ava, 200,200, 'sup');
            }
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insertSupplierAddress($param, $sup_id) {
        DB::beginTransaction();
        try {
            $id = DB::table('supplier_address')->insertGetId(
                [
                    'sup_id'=>$sup_id,
                    'sad_address'=>$param['address'],
                    'delete_flg'=> '0',
                    'inp_date'=>date('Y-m-d H:i:s'),
                    'upd_date'=>date('Y-m-d H:i:s'),
                    'inp_user'=>'2',
                    'upd_user'=>'2'
                ]
            );
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSuppliersById($listId) {
        DB::beginTransaction();
        try {
            DB::table('suppliers')->whereIn('sup_id', $listId)
                ->update([
                    'delete_flg'=>'1',
                    'upd_date'=>date('Y-m-d H:i:s')
                ]);
            $this->deleteSupplierAddress(null,$listId);
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSupplierAddress($listSadId = null, $listSupId = null) {
        if ($listSupId) {
            DB::table('supplier_address')->whereIn("sup_id", $listSupId)
                ->update([
                    'delete_flg'=>'1',
                    'upd_date'=>date('Y-m-d H:i:s')
                ]);
        } else if ($listSadId) {
            DB::table('supplier_address')->whereIn("sad_id", $listSadId)
                ->update([
                    'delete_flg'=>'1',
                    'upd_date'=>date('Y-m-d H:i:s')
                ]);
        }
    }

    public function updateSupplierById($supplier) {
        DB::beginTransaction();
        try {
            $sup_ava = $supplier['sup_avatar'];
            if (!empty($supplier['extension'])) {
                $sup_ava = explode(".",$supplier['sup_avatar']);
                $sup_ava = $sup_ava[0] . ".".$supplier['extension'];
                Helper::resizeImage($supplier['tmp_name'], $sup_ava, 200,200, 'sup');
            }
            DB::table('suppliers')->where('sup_id','=',$supplier['sup_id'])
                ->update([
                    'sup_name'=>$supplier['sup_name'],
                    'sup_avatar'=>$sup_ava,
                    'sup_phone'=>$supplier['sup_phone'],
                    'sup_fax'=>$supplier['sup_fax'],
                    'sup_mail'=>$supplier['sup_mail'],
                    'sup_website'=>$supplier['sup_website'],
                    'upd_date'=>date('Y-m-d H:i:s')
                ]);
            //Update Supplier Address
            $this->updateSupplierAddress($supplier['addresses'], $supplier['sup_id']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateSupplierAddress($listAddress, $sup_id) {
        $deleteListSadId = array();
        foreach ($listAddress as $address) {
            if (empty($address['address']) && !empty($address['sad_id'])){
                $deleteListSadId[] = $address['sad_id'];
            } else if (empty($address['sad_id']) && !empty($address['address'])) {
                $this->insertSupplierAddress($address, $sup_id);
            } else if (!empty($address['address']) && !empty($address['sad_id'])) {
                DB::table('supplier_address')->where('sad_id','=',$address['sad_id'])
                    ->update(
                        [
                            'sad_address'=>$address['address'],
                            'upd_date'=>date('Y-m-d H:i:s')
                        ]
                    );
            }
        }
        if (count($deleteListSadId) > 0) {
            $this->deleteSupplierAddress($deleteListSadId);
        }
    }

    public function getPagingInfo() {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countAllSuppliers();
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function countAllSuppliers()
    {
        try {
            $count = DB::table('suppliers')
                ->where('delete_flg', '=', '0')
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    private function getNextId() {
        $code = DB::table("suppliers")
            ->select('sup_code')
            ->max('sup_code');
        if (empty($code)) {
            return 1;
        }
        $code = (int)$code;
        $code++;
        return $code;
    }

    private function generateCode() {
        $code = $this->getNextId();
        return  sprintf("%05d", $code);
    }

    public function makeWhereRaw($search = [])
    {
        $params = [0];
        $where_raw = 'suppliers.delete_flg = ?';
        if (sizeof($search) > 0) {
            if (!empty($search['contain']) || !empty($search['notcontain'])) {
                if(!empty($search['contain'])){
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "suppliers.sup_code like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR suppliers.sup_name like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR suppliers.sup_website like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR suppliers.sup_phone like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR suppliers.sup_fax like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR suppliers.sup_mail like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if(!empty($search['notcontain'])){
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= " AND suppliers.sup_code not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND suppliers.sup_name not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND suppliers.sup_mail not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND suppliers.sup_phone not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND suppliers.sup_fax not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND suppliers.sup_website not like ?";
                    $params[] = $search_val;
                }

            } else {

                $where_raw_tmp = [];
                if (!empty($search['sup_code'])) {
                    $where_raw_tmp[] = "suppliers.sup_code = ?";
                    $params[] = $search['sup_code'];
                }
                if (!empty($search['sup_name'])) {
                    $where_raw_tmp[] = "suppliers.sup_name = ?";
                    $params[] = $search['sup_name'];
                }
                if (!empty($search['sup_mail'])) {
                    $where_raw_tmp[] = "suppliers.sup_mail = ?";
                    $params[] = $search['sup_mail'];
                }
                if (!empty($search['sup_phone'])) {
                    $where_raw_tmp[] = "suppliers.sup_phone = ?";
                    $params[] = $search['sup_phone'];
                }
                if (!empty($search['sup_fax'])) {
                    $where_raw_tmp[] = "suppliers.sup_fax = ?";
                    $params[] = $search['sup_fax'];
                }
                if (!empty($search['sup_website'])) {
                    $where_raw_tmp[] = "suppliers.sup_website = ?";
                    $params[] = $search['sup_website'];
                }
                if (sizeof($where_raw_tmp) > 0) {
                    $where_raw .= " AND ( " . implode(" OR ", $where_raw_tmp) . " )";
                }
            }
        }
        return [$where_raw, $params];
    }

    private function makeOrderBy($sort)
    {
        $field_name = 'sup_code';
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