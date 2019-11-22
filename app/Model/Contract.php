<?php
/**
 * Created by PhpStorm.
 * User: hoait
 * Date: 9/20/2019
 * Time: 12:35 AM
 */

namespace App\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\User;
use App\Model\Product;
use App\Model\Quoteprice;
use App\Model\ContractDetail;

class Contract implements JWTSubject
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

    public function getContracts($page = 0, $sort = '', $search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeContractBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);

            $orderList = DB::table('contract')
                ->leftJoin('customer', 'customer.cus_id', '=', 'contract.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'contract.cad_id')
                ->leftJoin('users', 'users.id', '=', 'contract.sale_id')
                ->select(
                    'contract.*',
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
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();
            return $orderList;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getContract($ctr_id)
    {
        try {
            $contract = DB::table('contract')
                ->leftJoin('customer', 'customer.cus_id', '=', 'contract.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'contract.cad_id')
                ->leftJoin('users', 'users.id', '=', 'contract.sale_id')
                ->select(
                    'contract.*',
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
                    ['contract.delete_flg', '=', '0'],
                    ['contract.ctr_id', '=', $ctr_id],
                    ['contract.owner_id', '=', Auth::user()->id]
                ])
                ->first();
            return $contract;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countContracts($search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            return DB::table('contract')
                ->leftJoin('customer', 'customer.cus_id', '=', 'contract.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'contract.cad_id')
                ->leftJoin('users', 'users.id', '=', 'contract.sale_id')
                ->select(
                    'contract.*',
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
                ->whereRaw($where_raw, $params)
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getPagingInfo($search = '')
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countContracts($search);
            return [
                'rows_num' => $rows_num,
                'rows_per_page' => $rows_per_page
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function transactionDeleteContractsByIds($ctr_ids = '')
    {
        DB::beginTransaction();
        try {

            //delete orders
            $this->deleteContractsByIds($ctr_ids);

            //delete orders detail
            $contractDetail = new ContractDetail();
            $contractDetail->deleteContractDetailsByCtrIds($ctr_ids);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function transactionUpdateContract($ctr_id, $contract)
    {
        DB::beginTransaction();
        try {
            //update contract
            $this->updateContract($ctr_id, $contract);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function transactionCreateContract($order, $order_details)
    {
        DB::beginTransaction();
        try {
            $totalAmountInContract = 0;
            $insert_contract_detail_data = [];

            foreach ($order_details as $item) {
                $totalAmountInContract += $item->amount;
                $contract_detail_data = [
                    "note" => $item->note,
                    "unit" => $item->unit,
                    "quantity" => $item->quantity,
                    "status" => $item->status,
                    "delivery_time" => $item->delivery_time,
                    "price" => $item->price,
                    "amount" => $item->amount,
                    "type" => $item->type,
                    "sort_no" => $item->sort_no,
                    "owner_id" => Auth::user()->id,
                    "inp_user" => Auth::user()->id,
                    "upd_user" => Auth::user()->id
                ];

                $contract_detail_data["prod_specs"] = $item->prod_specs;
                $contract_detail_data["prod_model"] = $item->prod_model;
                $contract_detail_data["prod_series"] = $item->prod_series;
                $contract_detail_data["prod_specs_mce"] = $item->prod_specs_mce;
                $contract_detail_data["acce_code"] = $item->acce_code;
                $contract_detail_data["acce_name"] = $item->acce_name;



                $insert_contract_detail_data[] = $contract_detail_data;
            }
            //create contracts
            $ctr_no = $this->generateCtrNo($order->ord_no);
            $totalAmountInContractTax = $totalAmountInContract + ($totalAmountInContract * $order->ord_tax / 100);
            $contract = [
                "ctr_no" => $ctr_no,
                "ctr_date" => date('Y-m-d'),
                "ctr_tax" => $order->ord_tax,
                "ctr_amount" => $totalAmountInContract,
                "ctr_amount_tax" => $totalAmountInContractTax,
                "ctr_rel_fee" => $order->ord_rel_fee,
                "ctr_debt" => $totalAmountInContractTax - $order->ord_paid,
                "ctr_note" => $order->ord_note,
                "ctr_paid" => $order->ord_paid,
                "ctr_pay_met"=> $order->ord_pay_met,
                "ord_id" => $order->ord_id,
                "cus_id" => $order->cus_id,
                "cad_id" => $order->cad_id,
                "sale_id" => Auth::user()->id,
                "contact_name" => $order->contact_name,
                "contact_rank" => $order->contact_rank,
                "contact_phone" => $order->contact_phone,
                "contact_email" => $order->contact_email,
                "owner_id" => Auth::user()->id,
                "inp_user" => Auth::user()->id,
                "upd_user" => Auth::user()->id
            ];
            $ctr_id = $this->insertContract($contract);


            $contractDetail = new ContractDetail();
            //insert contract detail
            if (!empty($insert_contract_detail_data)) {
                foreach ($insert_contract_detail_data as &$contract_detail_data) {
                    $contract_detail_data['ctr_id'] = $ctr_id;
                }
                $contractDetail->insertContractDetail($insert_contract_detail_data);
            }


            DB::commit();
            return $ctr_id;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function validateData($data)
    {
        try {

            $res = ['success' => true, 'message' => ''];
            $message = [];

            if (!array_key_exists('contract', $data)) {
                $res['success'] = false;
                $message[] = __('Data is wrong.!');
                return $res;
            }

            $contract = $data['contract'];
            if (!array_key_exists('ctr_no', $contract) || $contract['ctr_no'] == '' || $contract['ctr_no'] == null) {
                $res['success'] = false;
                $message[] = __('Contract No is required.');
            }
            if (array_key_exists('ctr_no', $contract) && mb_strlen($contract['ctr_no'], "utf-8") > 30) {
                $res['success'] = false;
                $message[] = __('Contract No is too long.');
            }
            if (!array_key_exists('ctr_date', $contract) || $contract['ctr_date'] == '' || $contract['ctr_date'] == null) {
                $res['success'] = false;
                $message[] = __('Contract Date is required.');
            }
            if (array_key_exists('ctr_date', $contract) && $this->dateValidator($contract['ctr_date']) == false) {
                $res['success'] = false;
                $message[] = __('Contract Date is wrong format YYYY/MM/DD.');
            }
            if (array_key_exists('ctr_exp_date', $contract) && $this->dateValidator($contract['ctr_exp_date']) == false) {
                $res['success'] = false;
                $message[] = __('Contract Exp Date is wrong format YYYY/MM/DD.');
            }
            if (array_key_exists('ctr_dlv_date', $contract) && $this->dateValidator($contract['ctr_dlv_date']) == false) {
                $res['success'] = false;
                $message[] = __('Contract Delivery Date is wrong format YYYY/MM/DD.');
            }

            $amount_check = true;
            if (!array_key_exists('ctr_tax', $contract)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Contract Tax is required.');
            }
            if (!array_key_exists('ctr_amount', $contract)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of orders (before VAT) is required.');
            }
            if (!array_key_exists('ctr_amount_tax', $contract)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of orders (VAT included) is required.');
            }
            if (!array_key_exists('ctr_rel_fee', $contract)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Relate Fee is required.');
            }
            if (!array_key_exists('ctr_debt', $contract)) {
                $res['success'] = false;
                $message[] = __('Debt is required.');
            }
            if (array_key_exists('ctr_tax', $contract) && (is_numeric($contract['ctr_tax']) == false || intval($contract['ctr_tax']) < 0 || intval($contract['ctr_tax']) > 2147483647)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Contract Tax is wrong data.');
            }
            if (array_key_exists('ctr_amount', $contract) && (is_numeric($contract['ctr_amount']) == false || floatval($contract['ctr_amount']) < 0 || floatval($contract['ctr_amount']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of orders (before VAT) is wrong.');
            }
            if (array_key_exists('ctr_amount_tax', $contract) && (is_numeric($contract['ctr_amount_tax']) == false || floatval($contract['ctr_amount_tax']) < 0 || floatval($contract['ctr_amount']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of orders (VAT included) is wrong.');
            }
            if (array_key_exists('ctr_rel_fee', $contract) && (is_numeric($contract['ctr_rel_fee']) == false || floatval($contract['ctr_rel_fee']) < 0 || floatval($contract['ctr_rel_fee']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Relate fee is wrong.');
            }
            if (array_key_exists('ctr_debt', $contract) && (is_numeric($contract['ctr_debt']) == false || floatval($contract['ctr_debt']) < 0 || floatval($contract['ctr_debt']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Debt is wrong.');
            }

            if ($amount_check == true) {

                $ctr_tax = $contract['ctr_tax'] == null || $contract['ctr_tax'] == '' ? 0 : intval($contract['ctr_tax']);
                $ctr_amount = $contract['ctr_amount'] == null || $contract['ctr_amount'] == '' ? 0 : doubleval($contract['ctr_amount']);
                $ctr_amount_tax = $contract['ctr_amount_tax'] == null || $contract['ctr_amount_tax'] == '' ? 0 : doubleval($contract['ctr_amount_tax']);
                $ctr_paid = $contract['ctr_rel_fee'] == null || $contract['ctr_rel_fee'] == '' ? 0 : doubleval($contract['ctr_rel_fee']);
                $ctr_debt = $contract['ctr_debt'] == null || $contract['ctr_debt'] == '' ? 0 : doubleval($contract['ctr_debt']);

                $chk_ctr_amount_tax = $ctr_amount + $ctr_amount * $ctr_tax / 100;
                $chk_ctr_debt = $ctr_amount_tax - $ctr_paid;
                if ($ctr_amount_tax != $chk_ctr_amount_tax || $chk_ctr_debt != $ctr_debt) {
                    $amount_check = false;
                    $res['success'] = false;
                    $message[] = __('Amount total is wrong.');
                }
            }

            $prdModel = new Product();
            $dt_total_amount = 0;
            $order_details = array_key_exists('order_detail', $data) ? $data['order_detail'] : [];
            foreach ($order_details as $line_no => $item) {

                if (!array_key_exists('dt_note', $item)
                    || !array_key_exists('dt_unit', $item)
                    || !array_key_exists('dt_quantity', $item)
                    || !array_key_exists('dt_delivery_time', $item)
                    || !array_key_exists('dt_status', $item)
                    || !array_key_exists('dt_price', $item)
                    || !array_key_exists('dt_amount', $item)
                    || !array_key_exists('dt_type', $item)
                    || !array_key_exists('dt_sort_no', $item)
                    || !array_key_exists('action', $item)
                ) {
                    $res['success'] = false;
                    switch ($item['dt_type']) {
                        case '1':
                            $message[] = __('[Row : :line ] pump detail is wrong data.', ['line' => "No." + ($line_no + 1)]);
                            break;
                        case '2':
                            $message[] = __('[Row : :line ] accessory detail is wrong data.', ['line' => "No." + ($line_no + 1)]);
                            break;
                    }
                    continue;
                }
                switch ($item['dt_type']) {
                    case '1':
                        if (!array_key_exists('dt_prod_specs_mce', $item)
                            || !array_key_exists('dt_prod_specs', $item)
                            || !array_key_exists('dt_prod_model', $item)
                            || !array_key_exists('dt_prod_series', $item)
                        ) {
                            $res['success'] = false;
                            $message[] = __('[Row : :line ] pump detail is wrong data.', ['line' => "No." + ($line_no + 1)]);
                            continue 2;
                        }
                        break;
                    case '2':
                        if (!array_key_exists('dt_acce_code', $item)
                            || !array_key_exists('dt_acce_name', $item)
                        ) {
                            $res['success'] = false;
                            $message[] = __('[Row : :line ] accessory detail is wrong data.', ['line' => "No." + ($line_no + 1)]);
                            continue 2;
                        }
                        break;
                }

                if ($item['action'] == 'delete')
                    continue;

                if ($item['dt_type'] == 1 && $item['dt_prod_model'] != '') {
                    $is_exists = $prdModel->checkProductIsExistsByModel($item['dt_prod_model']);
                    if ($is_exists == false) {
                        $res['success'] = false;
                        $message[] = __('[Row : :line ] model [ :model ] is not exists.', ['line' => "No." . ($line_no + 1), 'model' => $item['dt_prod_model']]);
                    }
                }

                if ($item['dt_type'] == 1 && $item['dt_prod_model'] != '' && $item['dt_prod_series'] != '') {

                    $prdSeriesObjData = $prdModel->getProductSeriesByModel($item['dt_prod_model']);
                    $prdSeriesArrData = [];
                    foreach ($prdSeriesObjData as $seri) {
                        $prdSeriesArrData[] = $seri->serial_no;
                    }

                    $dt_prod_series = explode(",", $item['dt_prod_series']);
                    $not_exists_series = [];
                    foreach ($dt_prod_series as $seri) {
                        if (in_array($seri, $prdSeriesArrData) == false) {
                            $not_exists_series[] = $seri;
                        }
                    }

                    if (sizeof($not_exists_series) > 0) {
                        $res['success'] = false;
                        $message[] = __('[Row : :line ] series [ :series ] is not exists.', ['line' => "No." . ($line_no + 1), 'series' => implode(",", $not_exists_series)]);
                    }
                }

                $dt_total_amount += $item['dt_amount'] == null || $item['dt_amount'] == '' ? 0 : doubleval($item['dt_amount']);
            }

            if ($amount_check == true && $dt_total_amount != $ctr_amount) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Amount total of contract details is not equal amount total of contract.');
            }

            $res['message'] = implode("\n", $message);
            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }

    }

    public function generateCtrNo($ord_no)
    {
        try {
            $pre_reg = $ord_no . "HD";
            $reg = '^' .$pre_reg. '[0-9]{5,}$';
            $contract = DB::select("SELECT MAX(ctr_no) AS ctr_no FROM `contract` WHERE ctr_no REGEXP :reg;", ['reg' => $reg]);
            if ($contract[0]->ctr_no == null) {
                $ctr_no_num = 1;
            } else {
                $ctr_no_num = intval(str_replace($pre_reg, '', $contract[0]->ctr_no)) + 1;
            }
            $ctr_no = $pre_reg . str_pad($ctr_no_num, 5, '0', STR_PAD_LEFT);
            return $ctr_no;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function checkContractIsExistsByOrdId($ord_id)
    {
        try {
            $cnt = DB::table('contract')
                ->where([
                    ['contract.ord_id', '=', $ord_id],
                    ['contract.delete_flg', '=', '0'],
                    ['contract.owner_id', '=', Auth::user()->id]
                ])
                ->count();
            if ($cnt > 0)
                return false;
            return true;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteContractsByIds($ctr_ids = '')
    {
        try {

            DB::table('contract')
                ->where('owner_id', Auth::user()->id)
                ->whereIn('ctr_id', explode(',', $ctr_ids))
                ->update([
                    'upd_user' => Auth::user()->id,
                    'delete_flg' => '1'
                ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function insertContract($data)
    {
        try {
            return DB::table('contract')->insertGetId($data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return $id;
    }

    public function updateContract($ctr_id, $contract)
    {
        try {
            DB::enableQueryLog();
            DB::table('contract')
                ->where([
                    ['owner_id', '=', Auth::user()->id],
                    ['ctr_id', '=', $ctr_id]
                ])
                ->update($contract);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function makeWhereRaw($search = '')
    {
        $params = [0];
        $where_raw = 'contract.delete_flg = ?';
        $params[] = Auth::user()->id;
        $where_raw .= ' AND contract.owner_id = ? ';

        if ($search != '') {
            $search_val = "%" . $search . "%";
            $where_raw .= " AND ( ";
            $where_raw .= " contract.ctr_no like ? ";
            $params[] = $search_val;
            if ($this->dateValidator($search) == true) {
                $where_raw .= " OR contract.ctr_date = ? ";
                $params[] = $search;
            } else {
                if (is_numeric(str_replace(',', '', $search)) == false) {

                    $where_raw .= " OR users.name like ? ";
                    $params[] = $search_val;

                    $where_raw .= " OR customer.cus_name like ? ";
                    $params[] = $search_val;
                } else {
                    $where_raw .= " OR contract.ctr_amount = ? ";
                    $params[] = $search;

                    $where_raw .= " OR contract.ctr_amount_tax = ? ";
                    $params[] = str_replace(',', '', $search);

                    $where_raw .= " OR contract.ctr_paid = ? ";
                    $params[] = str_replace(',', '', $search);

                    $where_raw .= " OR contract.ctr_debt = ? ";
                    $params[] = str_replace(',', '', $search);
                }
            }
            $where_raw .= " ) ";

        }
        return [$where_raw, $params];
    }

    public function dateValidator($date)
    {
        $credential_name = "name";
        $credential_data = $date;
        $rules = [
            $credential_name => 'date'
        ];
        $credentials = [
            $credential_name => $credential_data
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return false;
        }
        return true;
    }

    public function makeContractBy($sort = '')
    {
        $field_name = 'ctr_no';
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