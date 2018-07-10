<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/4/2018
 * Time: 11:56 PM
 */

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

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

    public function getSupplierPaging($page) {
        $rows_per_page = env('ROWS_PER_PAGE', 10);
        $supplier = DB::table('suppliers')
            ->select('sup_id','sup_name','sup_phone','sup_fax','sup_mail','sup_website')
            ->where('delete_flg', '=', '0')
            ->orderBy('sup_id', 'asc')
            ->offset($page * $rows_per_page)
            ->limit($rows_per_page)
            ->get();
        return $supplier;
    }

    public function getSupplierById($id) {
        $supplier = DB::table('suppliers')
            ->select('sup_id','sup_name','sup_phone','sup_fax','sup_mail','sup_website')
            ->where([['delete_flg','=','0'],['sup_id','=',$id]])
            ->get();
        return $supplier;
    }

    public function insertSupplier($param) {
        $id = DB::table('suppliers')->insertGetId(
          [
              'sup_name'=>$param['sup_name'],
              'sup_phone'=>$param['sup_phone'],
              'sup_fax'=>$param['sup_fax'],
              'sup_mail'=>$param['sup_mail'],
              'sup_website'=>$param['sup_website'],
              'delete_flg'=>'0',
              'inp_date'=>'now()',
              'upd_date'=>'now()',
              'inp_user'=>'2',
              'upd_user'=>'2'
          ]
        );
        return $id;
    }
}