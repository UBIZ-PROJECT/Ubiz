<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helper;

class Order
{

    public function getAllOrder()
    {
        $orderList = DB::table('order')
            ->leftJoin('customer', 'order.cus_id', '=', 'customer.cus_id')
            ->leftJoin('users', 'order.user_id', '=', 'users.id')
            ->select('order.*', 'customer.cus_name', 'users.name')
            ->where('order.delete_flg', '0')->get();
        return $orderList;
    }

    public function deleteOrder($ids = '')
    {
        DB::beginTransaction();
        try {

            DB::table('order')
                ->whereIn('ord_id', explode(',', $ids))
                ->update(['delete_flg' => '1']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getOrderList($page = 0, $sort = '', $search = [])
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);

            $orderList = DB::table('order')
                ->leftJoin('customer', 'order.cus_id', '=', 'customer.cus_id')
                ->leftJoin('users', 'order.user_id', '=', 'users.id')
                ->select('order.*', 'customer.cus_name', 'users.name')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $orderList;
    }

    public function countOrder()
    {
        return DB::table('order')->where('delete_flg', '0')->count();
    }

    public function getOrder($ord_id)
    {
        try {
            $order = DB::table('order')
                ->leftJoin('customer', 'customer.cus_id', '=', 'order.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'order.cad_id')
                ->leftJoin('users', 'users.id', '=', 'order.sale_id')
                ->select(
                    'order.*',
                    'customer.cus_code',
                    'customer.cus_name',
                    'customer.cus_phone',
                    'customer.cus_fax',
                    'customer.cus_mail',
                    'customer.cus_avatar',
                    'customer_address.cad_address as cus_addr',
                    'm_customer_type.title as cus_type',
                    'users.name as sale_name',
                    'users.rank as sale_rank',
                    'users.email as sale_email',
                    'users.phone as sale_phone'
                )
                ->where([
                    ['order.ord_id', '=', $ord_id],
                    ['order.owner_id', '=', Auth::user()->id]
                ])
                ->first();
            return $order;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getOrderPaging($index, $sort, $order)
    {
        try {
            $order = DB::table('order')
                ->leftJoin('customer', 'order.cus_id', '=', 'customer.cus_id')
                ->leftJoin('users', 'order.user_id', '=', 'users.id')
                ->select('order.*', 'customer.*', 'users.name')
                ->where('order.delete_flg', '0')
                ->orderBy($sort, $order)
                ->offset($index)
                ->limit(1)
                ->get();

            $order[0]->avt_src = Helper::readImage($order[0]->cus_avatar, 'cus');
        } catch (\Throwable $e) {
            throw $e;
        }
        return $order;
    }

    public function countAllOrder()
    {
        try {
            $count = DB::table('order')
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
            $rows_num = $this->countAllOrder();
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function insertOrder($param)
    {
        try {
            $id = DB::table('order')->insertGetId(
                [
                    'ord_code' => $param['ord_code'],
                    'cus_id' => $param['cus_id'],
                    'user_id' => $param['user_id'],
                    'ord_date' => $param['ord_date'],
                    'inp_date' => now(),
                    'upd_date' => now(),
                    'inp_user' => '1',
                    'upd_user' => '1'
                ]
            );
            foreach ($param['order_detail'] as $data) {
                $this->insertOrderDetail($id, $data);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return $id;
    }

    public function insertOrderDetail($ord_id, $order_detail)
    {
        try {
            DB::table('order_detail')->insert(
                [
                    'ord_id' => $ord_id,
                    'pro_id' => $order_detail['pro_id'],
                    'detail' => $order_detail['detail'],
                    'amount' => $order_detail['amount'],
                    'inp_date' => now(),
                    'upd_date' => now(),
                    'inp_user' => '1',
                    'upd_user' => '1'
                ]
            );
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateOrder($param)
    {
        try {
            DB::table('order')->where('ord_id', $param['ord_id'])->update(
                [
                    'user_id' => '1',
                    'exp_date' => $param['exp_date'],
                    'upd_date' => now(),
                    'upd_user' => '1'
                ]
            );

            if (!empty($param->pro_id)) {
                foreach ($param->pro_id as $key => $pro_id) {
                    if ($param->type[$key] == '1') {
                        DB::table('order_detail')->where('pro_id', $param['pro_id'][$key])->update(
                            [
                                'price' => str_replace('.', '', $param['price'][$key]),
                                'unit' => $param['unit'][$key],
                                'amount' => $param['amount'][$key],
                                'delivery_date' => $param['delivery_date'][$key],
                                'status' => $param['status'][$key],
                                'specs' => $param['specs'][$key],
                                'upd_date' => now(),
                                'upd_user' => '1'
                            ]
                        );
                    } else {
                        DB::table('order_detail')->where('pro_id', $param['pro_id'][$key])->update(
                            [
                                'price' => str_replace('.', '', $param['price'][$key]),
                                'code' => $param['code'][$key],
                                'name' => $param['name'][$key],
                                'unit' => $param['unit'][$key],
                                'amount' => $param['amount'][$key],
                                'delivery_date' => $param['delivery_date'][$key],
                                'status' => $param['status'][$key],
                                'upd_date' => now(),
                                'upd_user' => '1'
                            ]
                        );
                    }
                }
            }

            //insert new product
            $productArrInsert = array();
            if (!empty($param->new_p_specs)) {
                foreach ($param->new_p_specs as $key => $new_p_specs) {
                    $productArrInsert[] = ['ord_id' => $param['ord_id'],
                        'code' => null,
                        'name' => null,
                        'type' => 1,
                        'price' => str_replace('.', '', $param['new_p_price'][$key]),
                        'unit' => $param['new_p_unit'][$key],
                        'amount' => $param['new_p_amount'][$key],
                        'delivery_date' => $param['new_p_delivery_date'][$key],
                        'status' => $param['new_p_status'][$key],
                        'specs' => $new_p_specs,
                        'inp_user' => 1,
                        'inp_date' => date('Y-m-d'),
                        'upd_user' => 1,
                        'upd_date' => date('Y-m-d')
                    ];
                }
            }

            if (!empty($param->new_f_code)) {
                foreach ($param->new_f_code as $key => $new_f_code) {
                    $productArrInsert[] = ['ord_id' => $param['ord_id'],
                        'code' => $param['new_f_code'][$key],
                        'name' => $param['new_f_name'][$key],
                        'type' => 2,
                        'price' => str_replace('.', '', $param['new_f_price'][$key]),
                        'unit' => $param['new_f_unit'][$key],
                        'amount' => $param['new_f_amount'][$key],
                        'delivery_date' => $param['new_f_delivery_date'][$key],
                        'status' => $param['new_f_status'][$key],
                        'specs' => null,
                        'inp_user' => 1,
                        'inp_date' => date('Y-m-d'),
                        'upd_user' => 1,
                        'upd_date' => date('Y-m-d')
                    ];
                }
            }

            if (!empty($productArrInsert)) {
                DB::table('order_detail')->insert($productArrInsert);
            }

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function makeWhereRaw($search = [])
    {
        $params = [0];
        $where_raw = 'order.delete_flg = ?';
        if (sizeof($search) > 0) {
            if (isset($search['contain']) || isset($search['notcontain'])) {

                if (isset($search['contain'])) {
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "order.ord_code like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR order.ord_date like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_name like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR users.name like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if (isset($search['notcontain'])) {
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "order.ord_code not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR order.ord_date not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR customer.cus_name not like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR users.name not like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }

            } else {

                $where_raw_tmp = [];
                if (isset($search['ord_code'])) {
                    $where_raw_tmp[] = "ord.ord_code = ?";
                    $params[] = $search['ord_code'];
                }
                if (isset($search['ord_date'])) {
                    $where_raw_tmp[] = "ord.ord_date = ?";
                    $params[] = $search['ord_date'];
                }
                if (isset($search['cus_name'])) {
                    $where_raw_tmp[] = "customer.cus_name = ?";
                    $params[] = $search['cus_name'];
                }
                if (isset($search['user_name'])) {
                    $where_raw_tmp[] = "users.name = ?";
                    $params[] = $search['user_name'];
                }
            }
        }
        return [$where_raw, $params];
    }

    public function makeOrderBy($sort)
    {
        $field_name = 'ord_code';
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
