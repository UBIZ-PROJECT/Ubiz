<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;
use App\Helper;

class Customer implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cus_name', 'cus_type', 'cus_phone', 'cus_fax', 'cus_mail',
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

    public function getAllCustomers()
    {
        $customers = DB::table('customer')->where('delete_flg', '0')->get();
        return $customers;
    }

    public function getCustomerAddress($cus_id)
    {
        $customerAddress = DB::table('customer_address')->where('cus_id', $cus_id)->where('delete_flg', '0')->get();
        return $customerAddress;
    }
	
	public function deleteCustomer($ids = '')
    {
        DB::beginTransaction();
        try {

            DB::table('customer')
                ->whereIn('cus_id', explode(',', $ids))
                ->update(['delete_flg' => '1']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

public function getCustomers($page = 0, $sort = '') 
	{
		try {
            $sort_name = 'cus_id';
            $order_by = 'asc';
            if ($sort != '') {
                $sort_info = explode('_', $sort);
                $order_by = $sort_info[sizeof($sort_info) - 1];
                unset($sort_info[sizeof($sort_info) - 1]);
                $sort_name = implode('_', $sort_info);
            }
			
        $rows_per_page = env('ROWS_PER_PAGE', 10);
		$firstAddress = DB::table('customer_address')
                   ->select('cus_id as cad_cus_id', DB::raw('min(cad_id) as cad_id'))
                   ->whereRaw("delete_flg = '0'")
                   ->groupBy('cus_id')->toSql();

		$customers = DB::table('customer')
			->leftJoin(DB::raw('('.$firstAddress.') customer_adr'),function($join){
				$join->on('customer_adr.cad_cus_id','=','customer.cus_id');
			})
			->leftJoin('customer_address', 'customer_adr.cad_id', '=', 'customer_address.cad_id')
			->select('customer.*', 'customer_address.cad_address as address', 'customer_address.cad_id')
			->whereRaw("customer.delete_flg = '0'")
			->orderBy($sort_name, $order_by)
			->offset($page * $rows_per_page)
			->limit($rows_per_page)
			->get();
		}catch (\Throwable $e) {
            throw $e;
        }
        return $customers;
    }
	
public function getCustomer($id) 
	{
		try {
		$customers = DB::table('customer')
			->where('cus_id', $id)
			->get();
		}catch (\Throwable $e) {
            throw $e;
        }
        return $customers;
    }

    public function countAllCustomers()
    {
        try {
            $count = DB::table('customer')
                ->where('delete_flg', '0')
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    public function getPagingInfo()
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countAllCustomers();
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }
	
	public function insertCustomer($param) {
		try {
			$id = DB::table('customer')->insertGetId(
			  [
				  'cus_code'=>$param['cus_code'],
				  'cus_name'=>$param['cus_name'],
				  //'cus_avatar'=>$param['cus_avatar'],
				  'cus_type'=>$param['cus_type'],
				  'cus_phone'=>$param['cus_phone'],
				  'cus_fax'=>$param['cus_fax'],
				  'cus_mail'=>$param['cus_mail'],
				  'user_id'=>$param['user_id'],
				  'inp_date'=>now(),
				  'upd_date'=>now(),
				  'inp_user'=>'1',
				  'upd_user'=>'1'
			  ]
			);
			
			foreach($param['cus_address'] as $cad_address){
				$this->insertCustomerAddress($id, $cad_address);
			}
		} catch (\Throwable $e) {
            throw $e;
        }
        return $id;
    }
	
	public function insertCustomerAddress($cus_id, $cad_address) {
		try {
			DB::table('customer_address')->insert(
			  [
				  'cus_id'=>$cus_id,
				  'cad_address'=>$cad_address,
				  'inp_date'=>now(),
				  'upd_date'=>now(),
				  'inp_user'=>'1',
				  'upd_user'=>'1'
			  ]
			);
		} catch (\Throwable $e) {
            throw $e;
        }
    }
	
	public function updateCustomer($param) {
		try {
			DB::table('customer')->where('cus_id', $param['cus_id'])->update(
			  [
				  'cus_code'=>$param['cus_code'],
				  'cus_name'=>$param['cus_name'],
				  'cus_avatar'=>$param['cus_id'].'.'.$param['avatar']->getClientOriginalExtension(),
				  'cus_type'=>$param['cus_type'],
				  'cus_phone'=>$param['cus_phone'],
				  'cus_fax'=>$param['cus_fax'],
				  'cus_mail'=>$param['cus_mail'],
				  'user_id'=>$param['user_id'],
				  'upd_date'=>now(),
				  'upd_user'=>'1'
			  ]
			);
			
			Helper::resizeImage($param['avatar']->getRealPath(), $param['cus_id'].'.'.$param['avatar']->getClientOriginalExtension(), 200, 200, 'cus');
			
		} catch (\Throwable $e) {
            throw $e;
        }
    }
	

}
