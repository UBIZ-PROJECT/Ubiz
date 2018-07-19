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

    public function getSupplierPaging($page,$sort = '') {
        $sort_name = 'sup_id';
        $order_by = 'asc';
        if ($sort != '') {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $sort_name = implode('_', $sort_info);
        }
        $rows_per_page = env('ROWS_PER_PAGE', 10);
        $supplier = DB::table('suppliers')
            ->select('sup_id','sup_code','sup_avatar','sup_name','sup_phone','sup_fax','sup_mail','sup_website')
            ->where('delete_flg', '=', '0')
            ->orderBy($sort_name, $order_by)
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
            
            Helper::resizeImage($param['tmp_name'], $sup_ava, 200,200, 'sup');
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSuppliersById($listId) {
        DB::beginTransaction();
        try {
            $listId = json_decode($listId,true);
            DB::table('suppliers')->whereIn('sup_id', $listId)
                ->update([
                    'delete_flg'=>'1',
                    'upd_date'=>date('Y-m-d H:i:s')
                ]);
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateSupplierById($supplier) {
        DB::beginTransaction();
        try {
            $sup_ava = '';
            if (!empty($supplier['extension'])) {
                $sup_ava = explode(".",$supplier['sup_avatar']);
                $sup_ava = $sup_ava[0] . ".".$supplier['extension'];
                Helper::resizeImage($supplier['tmp_name'], $sup_ava, 200,200, 'sup');
            } else {
                $sup_ava = $supplier['sup_avatar'];
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
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
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
}