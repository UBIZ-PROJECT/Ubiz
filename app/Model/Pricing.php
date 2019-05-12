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
                            ->orderBy('pricing_product.pro_id')
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
				->select('customer.*','pricing.*', 'users.name')
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
    
    public function getPricingCustomer($id)
    {
        try {
            $customer = DB::table('customer')
            ->leftJoin('customer_address', 'customer.cus_id', '=', 'customer_address.cus_id')
            ->select('customer.*', 'customer_address.cad_address')
            ->where('customer.cus_id', $id)
            ->limit(1)
            ->get();
            
            $customer[0]->avt_src = Helper::readImage($customer[0]->cus_avatar, 'cus');
        }catch (\Throwable $e) {
            throw $e;
        }
        return $customer;
    }
    
    public function getPricingSale($id)
    {
        try {
            $sale = DB::table('users')
            ->select('users.*')
            ->where('id', $id)
            ->get();
        }catch (\Throwable $e) {
            throw $e;
        }
        return $sale;
    }
	
	public function insertPricing($param) {
// 	    print_r($param->request);exit;
	    if(!$param['user_id']){
	        $user_id = 1;
	    }else{
	        $user_id = $param['user_id'];
	    }
	    if(!$param['pri_code']){
	        $pri_code = '99999';
	    }else{
	        $pri_code = $param['pri_code'];
	    }
		try {
			$id = DB::table('pricing')->insertGetId(
			  [
			      'pri_code'=>$pri_code,
				  'cus_id'=>$param['cus_id'],
			      'user_id'=>$user_id,
				  'pri_date'=>$param['pri_date'],
				  'exp_date'=>$param['exp_date'],
				  'inp_date'=>now(),
				  'upd_date'=>now(),
				  'inp_user'=>'1',
				  'upd_user'=>'1'
			  ]
			);
			
			$priCode = str_pad($id,5,'0',STR_PAD_LEFT);
			
			DB::table('pricing')->where('pri_id', $id)->update(
			    [
			        'pri_code'=>$priCode
			    ]
			);
			
			//insert new product
			$productArrInsert = array();
			if( !empty($param->new_p_specs) ){
			    foreach($param->new_p_specs as $key => $new_p_specs){
			        if(!$new_p_specs && !$param['new_p_unit'][$key] && !$param['new_p_amount'][$key] && !$param['new_p_delivery_date'][$key] && !$param['new_p_price'][$key])
			        {
			            continue;
			        }
			        
			        $productArrInsert[] = ['pri_id' => $id,
                    			            'code'   => null,
                    			            'name'   => null,
                    			            'type'   => 1,
                    			            'price'  => str_replace('.','',$param['new_p_price'][$key]),
                    			            'unit'   => $param['new_p_unit'][$key],
                    			            'amount' => $param['new_p_amount'][$key],
                    			            'delivery_date' => $param['new_p_delivery_date'][$key],
                    			            'status' => $param['new_p_status'][$key],
                    			            'specs'  => $new_p_specs,
                    			            'inp_user' => 1,
                    			            'inp_date' => date('Y-m-d'),
                    			            'upd_user' => 1,
                    			            'upd_date' => date('Y-m-d')
			        ];
			    }
			}
			
			if( !empty($param->new_f_code) ){
			    foreach($param->new_f_code as $key => $new_f_code){
			        if(!$new_f_code && !$param['new_f_name'][$key] && !$param['new_f_unit'][$key] && !$param['new_f_amount'][$key] && !$param['new_f_delivery_date'][$key] && !$param['new_f_price'][$key])
			        {
			            continue;
			        }
			        
			        $productArrInsert[] = ['pri_id' => $id,
                    			            'code'   => $param['new_f_code'][$key],
                    			            'name'   => $param['new_f_name'][$key],
                    			            'type'   => 2,
                    			            'price'  => str_replace('.','',$param['new_f_price'][$key]),
                    			            'unit'   => $param['new_f_unit'][$key],
                    			            'amount' => $param['new_f_amount'][$key],
                    			            'delivery_date' => $param['new_f_delivery_date'][$key],
                    			            'status' => $param['new_f_status'][$key],
                    			            'specs'  => null,
                    			            'inp_user' => 1,
                    			            'inp_date' => date('Y-m-d'),
                    			            'upd_user' => 1,
                    			            'upd_date' => date('Y-m-d')
			        ];
			    }
			}
			
			if( !empty($productArrInsert) ){
			    DB::table('pricing_product')->insert($productArrInsert);
			}
		} catch (\Throwable $e) {
            throw $e;
        }
        return $priCode;
    }
	
// 	public function insertPricingProduct($pri_id, $pri_product) {
// 		try {
// 			DB::table('pricing_product')->insert(
// 			  [
// 				  'pri_id'=>$pri_id,
// 				  'pro_id'=>$pri_product['pro_id'],
// 				  'detail'=>$pri_product['detail'],
// 				  'amount'=>$pri_product['amount'],
// 				  'inp_date'=>now(),
// 				  'upd_date'=>now(),
// 				  'inp_user'=>'1',
// 				  'upd_user'=>'1'
// 			  ]
// 			);
// 		} catch (\Throwable $e) {
//             throw $e;
//         }
//     }
	
	public function updatePricing($param) {
// 	    print_r($param->request);exit;
	    $exp_date = explode('/', $param['exp_date']);
		try {
			DB::table('pricing')->where('pri_id', $param['pri_id'])->update(
			  [
				  'user_id'=>'1',
			      'exp_date'=>$exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0],
				  'upd_date'=>now(),
				  'upd_user'=>'1'
			  ]
			);
			
			if( !empty($param->pro_id) ){
    			foreach($param->pro_id as $key => $pro_id){
    			    if($param->type[$key] == '1'){
    			        DB::table('pricing_product')->where('pro_id', $param['pro_id'][$key])->update(
    			            [
    			                'price'=>str_replace('.','',$param['price'][$key]),
    			                'unit'=>$param['unit'][$key],
    			                'amount'=>$param['amount'][$key],
    			                'delivery_date'=>$param['delivery_date'][$key],
    			                'status'=>$param['status'][$key],
    			                'specs'=>$param['specs'][$key],
    			                'upd_date'=>now(),
    			                'upd_user'=>'1'
    			            ]
    			        );
    			    }else{
    			        DB::table('pricing_product')->where('pro_id', $param['pro_id'][$key])->update(
    			            [
    			                'price'=>str_replace('.','',$param['price'][$key]),
    			                'code'=>$param['code'][$key],
    			                'name'=>$param['name'][$key],
    			                'unit'=>$param['unit'][$key],
    			                'amount'=>$param['amount'][$key],
    			                'delivery_date'=>$param['delivery_date'][$key],
    			                'status'=>$param['status'][$key],
    			                'upd_date'=>now(),
    			                'upd_user'=>'1'
    			            ]
    			            );
    			    }
    			}
			}
			
			//insert new product
			$productArrInsert = array();
			if( !empty($param->new_p_specs) ){
    			foreach($param->new_p_specs as $key => $new_p_specs){
    			    if(!$new_p_specs && !$param['new_p_unit'][$key] && !$param['new_p_amount'][$key] && !$param['new_p_delivery_date'][$key] && !$param['new_p_price'][$key])
    			    {
    			        continue;
    			    }
    			    
    			    $productArrInsert[] = ['pri_id' => $param['pri_id'],
    			                           'code'   => null,
    			                           'name'   => null,
    			                           'type'   => 1, 
    			                           'price'  => str_replace('.','',$param['new_p_price'][$key]),
    			                           'unit'   => $param['new_p_unit'][$key],
    			                           'amount' => $param['new_p_amount'][$key],
    			                           'delivery_date' => $param['new_p_delivery_date'][$key],
    			                           'status' => $param['new_p_status'][$key],
    			                           'specs'  => $new_p_specs,
    			                           'inp_user' => 1,
    			                           'inp_date' => date('Y-m-d'),
                        			       'upd_user' => 1,
    			                           'upd_date' => date('Y-m-d')
    			    ];
    			}
			}
			
			if( !empty($param->new_f_code) ){
    			foreach($param->new_f_code as $key => $new_f_code){
    			    if(!$new_f_code && !$param['new_f_name'][$key] && !$param['new_f_unit'][$key] && !$param['new_f_amount'][$key] && !$param['new_f_delivery_date'][$key] && !$param['new_f_price'][$key])
    			    {
    			        continue;
    			    }
    			    
    			    $productArrInsert[] = ['pri_id' => $param['pri_id'],
    			                           'code'   => $param['new_f_code'][$key],
    			                           'name'   => $param['new_f_name'][$key],
                        			       'type'   => 2,
    			                           'price'  => str_replace('.','',$param['new_f_price'][$key]),
                        			       'unit'   => $param['new_f_unit'][$key],
                        			       'amount' => $param['new_f_amount'][$key],
                        			       'delivery_date' => $param['new_f_delivery_date'][$key],
                        			       'status' => $param['new_f_status'][$key],
                        			       'specs'  => null,
    			                           'inp_user' => 1,
    			                           'inp_date' => date('Y-m-d'),
                        			       'upd_user' => 1,
    			                           'upd_date' => date('Y-m-d')
    			    ];
    			}
			}
			
			if( !empty($productArrInsert) ){
			 DB::table('pricing_product')->insert($productArrInsert);
			}
			
			//delete product
			if($param['del_list']){
			    $delList = explode(",", $param['del_list']);
			    DB::table('pricing_product')->whereIn('pro_id', $delList)->update(
			         [
			             'delete_flg' => '1'
			         ]
			    );
			}
			
		} catch (\Throwable $e) {
            throw $e;
        }
    }
	
	public function makeWhereRaw($search = [])
    {
        $params = [0];
        $where_raw = 'pricing.delete_flg = ?';
        if (sizeof($search) > 0) {
            if (isset($search['contain']) || isset($search['notcontain'])) {

                if(isset($search['contain'])){
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "pricing.pri_code like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR pricing.pri_date like ?";
                    $params[] = $search_val;
					$where_raw .= " OR pricing.exp_date like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_name like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR users.name like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if(isset($search['notcontain'])){
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "pricing.pri_code not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR pricing.pri_date not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR pricing.exp_date not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_name not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR users.name not like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }

            } else {

                $where_raw_tmp = [];
                if (isset($search['pri_code'])) {
                    $where_raw_tmp[] = "pricing.pri_code = ?";
                    $params[] = $search['pri_code'];
                }
                if (isset($search['pri_date'])) {
                    $where_raw_tmp[] = "pricing.pri_date = ?";
                    $params[] = $search['pri_date'];
                }
                if (isset($search['cus_mail'])) {
                    $where_raw_tmp[] = "pricing.exp_date = ?";
                    $params[] = $search['exp_date'];
                }
				if (isset($search['cus_type'])) {
                    $where_raw_tmp[] = "customer.cus_name = ?";
                    $params[] = $search['cus_name'];
                }
				if (isset($search['cus_fax'])) {
                    $where_raw_tmp[] = "users.name = ?";
                    $params[] = $search['name'];
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
