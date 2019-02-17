<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;
use App\Helper;

class Pricing implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exp_date',
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

    public function getAllPricing()
    {
        $pricingList = DB::table('pricing')
						->leftJoin('customer', 'pricing.cus_id', '=', 'customer.cus_id')
						->leftJoin('users', 'pricing.user_id', '=', 'users.id')
						->select('pricing.*', 'customer.cus_name', 'users.name')
						->where('pricing.delete_flg', '0')->get();
        return $pricingList;
    }

    public function getPricingProduct($pri_id)
    {
        $pricingProduct = DB::table('pricing_product')
							//->leftJoin('product', 'pricing_product.pro_id', '=', 'product.id')
							//->select('pricing_product.*', 'product.*')
                            ->select('pricing_product.*')
							->where('pri_id', $pri_id)
							->where('pricing_product.delete_flg', '0')
// 							->where('product.delete_flg', '0')
							->get();

// 		foreach($pricingProduct as $key => $product){
// 			$productImgData = DB::table('product_image')
// 							->where('prd_id', $product->id)
// 							->where('delete_flg', '0')
// 							->limit(1)
// 							->get();
// 			$productImg = $productImgData[0]->prd_id.'-'.$productImgData[0]->id.'.'.$productImgData[0]->extension;
// 			$pricingProduct[$key]->pro_img = Helper::readImage($productImg, 'prd');
// 		}
        return $pricingProduct;
    }
	
	public function deletePricing($ids = '')
    {
        DB::beginTransaction();
        try {

            DB::table('pricing')
                ->whereIn('pri_id', explode(',', $ids))
                ->update(['delete_flg' => '1']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

	public function getPricingList($page = 0, $sort = '', $search = []) 
	{
		try {
            list($where_raw,$params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);
			
			$rows_per_page = env('ROWS_PER_PAGE', 10);

			$pricingList = DB::table('pricing')
				->leftJoin('customer', 'pricing.cus_id', '=', 'customer.cus_id')
				->leftJoin('users', 'pricing.user_id', '=', 'users.id')
				->select('pricing.*', 'customer.cus_name', 'users.name')
				->whereRaw($where_raw, $params)
				->orderBy($field_name, $order_by)
				->offset($page * $rows_per_page)
				->limit($rows_per_page)
				->get();
		}catch (\Throwable $e) {
            throw $e;
        }
        return $pricingList;
    }
	
	public function countPricing(){
		$totalPricing = DB::table('pricing')->where('delete_flg', '0')->count();
		
		return $totalPricing;
	}
	
	public function getPricing($id) 
	{
		try {
			$pricing = DB::table('pricing')
				->leftJoin('customer', 'pricing.cus_id', '=', 'customer.cus_id')
				->leftJoin('users', 'pricing.user_id', '=', 'users.id')
				->select('pricing.*', 'customer.*', 'users.name')
				->where('pri_id', $id)
				->get();
				
			// $pricingProducts = DB::table('pricing_product')
				// ->select('pricing_product.*')
				// ->where('pri_id', $id)
				// ->get();
			// $pricing->product = $pricingProducts;
			
			$pricing[0]->avt_src = Helper::readImage($pricing[0]->cus_avatar, 'cus');
		}catch (\Throwable $e) {
            throw $e;
        }
        return $pricing;
    }
	
	public function getPricingPaging($index, $sort, $order) 
	{
		try {
			$pricing = DB::table('pricing')
				->leftJoin('customer', 'pricing.cus_id', '=', 'customer.cus_id')
				->leftJoin('users', 'pricing.user_id', '=', 'users.id')
				->select('pricing.*', 'customer.*', 'users.name')
				->where('pricing.delete_flg', '0')
				->orderBy($sort, $order)
				->offset($index)
				->limit(1)
				->get();
				
			$pricing[0]->avt_src = Helper::readImage($pricing[0]->cus_avatar, 'cus');
		}catch (\Throwable $e) {
            throw $e;
        }
        return $pricing;
    }

    public function countAllPricing()
    {
        try {
            $count = DB::table('pricing')
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
            $rows_num = $this->countAllPricing();
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }
	
	public function insertPricing($param) {
		try {
			$id = DB::table('pricing')->insertGetId(
			  [
				  'pri_code'=>$param['pri_code'],
				  'cus_id'=>$param['cus_id'],
				  'user_id'=>$param['user_id'],
				  'pri_date'=>$param['pri_date'],
				  'exp_date'=>$param['exp_date'],
				  'inp_date'=>now(),
				  'upd_date'=>now(),
				  'inp_user'=>'1',
				  'upd_user'=>'1'
			  ]
			);
			foreach($param['pri_products'] as $pri_product){
				$this->insertPricingProduct($id, $pri_product);
			}
		} catch (\Throwable $e) {
            throw $e;
        }
        return $id;
    }
	
	public function insertPricingProduct($pri_id, $pri_product) {
		try {
			DB::table('pricing_product')->insert(
			  [
				  'pri_id'=>$pri_id,
				  'pro_id'=>$pri_product['pro_id'],
				  'detail'=>$pri_product['detail'],
				  'amount'=>$pri_product['amount'],
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
	
	public function updatePricing($param) {
		try {
			DB::table('pricing')->where('cus_id', $param['cus_id'])->update(
			  [
				  'cus_id'=>$param['cus_id'],
				  'user_id'=>$param['user_id'],
				  'pri_date'=>$param['pri_date'],
				  'exp_date'=>$param['exp_date'],
				  'upd_date'=>now(),
				  'upd_user'=>'1'
			  ]
			);
			
		} catch (\Throwable $e) {
            throw $e;
        }
    }
	
	public function makeWhereRaw($search = [])
    {
        $params = [0];
        $where_raw = 'customer.delete_flg = ?';
        if (sizeof($search) > 0) {
            if (isset($search['contain']) || isset($search['notcontain'])) {

                $search_val = "%" . $search['search'] . "%";
                if(isset($search['contain'])){
                    $where_raw .= " AND (";
                    $where_raw .= "customer.cus_code like ?'";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_name like ?";
                    $params[] = $search_val;
					$where_raw .= " OR customer.cus_type like ?";
                    $params[] = $search_val;
					$where_raw .= " OR customer.cus_fax like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_mail like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_phone like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer_address.address like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if(isset($search['notcontain'])){
                    $where_raw .= "customer.cus_code not like ?'";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_name not like ?";
                    $params[] = $search_val;
					$where_raw .= " OR customer.cus_type not like ?";
                    $params[] = $search_val;
					$where_raw .= " OR customer.cus_fax not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_mail not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_phone not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer_address.cad_address not like ?";
                    $params[] = $search_val;
                }

            } else {

                $where_raw_tmp = [];
                if (isset($search['cus_code'])) {
                    $where_raw_tmp[] = "customer.cus_code = ?";
                    $params[] = $search['cus_code'];
                }
                if (isset($search['cus_name'])) {
                    $where_raw_tmp[] = "customer.cus_name = ?";
                    $params[] = $search['cus_name'];
                }
                if (isset($search['cus_mail'])) {
                    $where_raw_tmp[] = "customer.cus_mail = ?";
                    $params[] = $search['cus_mail'];
                }
				if (isset($search['cus_type'])) {
                    $where_raw_tmp[] = "customer.cus_type = ?";
                    $params[] = $search['cus_type'];
                }
				if (isset($search['cus_fax'])) {
                    $where_raw_tmp[] = "customer.cus_fax = ?";
                    $params[] = $search['cus_fax'];
                }
                if (isset($search['cus_phone'])) {
                    $where_raw_tmp[] = "customer.cus_phone = ?";
                    $params[] = $search['cus_phone'];
                }
                if (isset($search['address'])) {
                    $where_raw_tmp[] = "customer_address.cad_address = ?";
                    $params[] = $search['address'];
                }
                if (sizeof($where_raw_tmp) > 0) {
                    $where_raw .= " AND ( " . implode(" OR ", $where_raw_tmp) . " )";
                }
            }
        }
        return [$where_raw, $params];
    }

    public function makeOrderBy($sort)
    {
        $field_name = 'pri_code';
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
