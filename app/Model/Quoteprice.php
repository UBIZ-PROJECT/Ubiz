<?php

namespace App\Model;

use Mail;
use App\User;
use App\Jobs\SendQuotepriceEmail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Model\QuotepriceDetail;

class Quoteprice
{
    public function getQuoteprices($page = 0, $sort = '', $search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);

            $quoteprices = DB::table('quoteprice')
                ->leftJoin('customer', 'customer.cus_id', '=', 'quoteprice.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'quoteprice.cad_id')
                ->leftJoin('users', 'users.id', '=', 'quoteprice.sale_id')
                ->select(
                    'quoteprice.*',
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
            return $quoteprices;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getQuoteprice($qp_id)
    {
        try {
            $quoteprice = DB::table('quoteprice')
                ->leftJoin('order', 'order.qp_id', '=', 'quoteprice.qp_id')
                ->leftJoin('customer', 'customer.cus_id', '=', 'quoteprice.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'quoteprice.cad_id')
                ->leftJoin('users', 'users.id', '=', 'quoteprice.sale_id')
                ->select(
                    'quoteprice.*',
                    'order.ord_id',
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
                    ['quoteprice.qp_id', '=', $qp_id],
                    ['quoteprice.owner_id', '=', Auth::user()->id]
                ])
                ->first();
            return $quoteprice;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countQuoteprices($search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            return DB::table('quoteprice')
                ->leftJoin('customer', 'customer.cus_id', '=', 'quoteprice.cus_id')
                ->leftJoin('m_customer_type', 'customer.cus_type', '=', 'm_customer_type.id')
                ->leftJoin('customer_address', 'customer_address.cad_id', '=', 'quoteprice.cad_id')
                ->leftJoin('users', 'users.id', '=', 'quoteprice.sale_id')
                ->select(
                    'quoteprice.*',
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
            $rows_num = $this->countQuoteprices($search);
            return [
                'rows_num' => $rows_num,
                'rows_per_page' => $rows_per_page
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function transactionDeleteQuotepricesByIds($qp_ids = '')
    {
        DB::beginTransaction();
        try {

            //delete quoteprices
            $this->deleteQuotepricesByIds($qp_ids);

            //delete quoteprices detail
            $quotepriceDetail = new QuotepriceDetail();
            $quotepriceDetail->deleteQuotepriceDetailsByOrdIds($qp_ids);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function transactionUpdateQuoteprice($qp_id, $data)
    {
        DB::beginTransaction();
        try {

            $insert_quoteprice_detail_data = [];
            $delete_quoteprice_detail_data = [];
            $update_quoteprice_detail_data = [];

            $quoteprice_detail = array_key_exists('quoteprice_detail', $data) ? $data['quoteprice_detail'] : [];
            foreach ($quoteprice_detail as $item) {

                $quoteprice_detail_data = [
                    "note" => $item['dt_note'],
                    "unit" => $item['dt_unit'],
                    "quantity" => $item['dt_quantity'],
                    "status" => $item['dt_status'],
                    "delivery_time" => $item['dt_delivery_time'],
                    "price" => $item['dt_price'],
                    "amount" => $item['dt_amount'],
                    "type" => $item['dt_type'],
                    "sort_no" => $item['dt_sort_no'],
                    "owner_id" => Auth::user()->id,
                    "upd_user" => Auth::user()->id
                ];

                if ($item['dt_type'] == '1') {
                    $quoteprice_detail_data["prod_specs"] = $item['dt_prod_specs'];
                    $quoteprice_detail_data["prod_specs_mce"] = $item['dt_prod_specs_mce'];
                    $quoteprice_detail_data["acce_code"] = null;
                    $quoteprice_detail_data["acce_name"] = null;
                }

                if ($item['dt_type'] == '2') {
                    $quoteprice_detail_data["prod_specs"] = null;
                    $quoteprice_detail_data["prod_specs_mce"] = null;
                    $quoteprice_detail_data["acce_code"] = $item['dt_acce_code'];
                    $quoteprice_detail_data["acce_name"] = $item['dt_acce_name'];
                }

                $action = $item['action'];
                switch ($action) {
                    case'insert':
                        $quoteprice_detail_data["qp_id"] = $qp_id;
                        $quoteprice_detail_data["inp_user"] = Auth::user()->id;
                        $insert_quoteprice_detail_data[] = $quoteprice_detail_data;
                        break;
                    case'update':
                        $quoteprice_detail_data["qpdt_id"] = $item['dt_id'];
                        $update_quoteprice_detail_data[] = $quoteprice_detail_data;
                        break;
                    case'delete':
                        $delete_quoteprice_detail_data[] = $item['dt_id'];
                        break;
                }
            }

            //update quoteprices
            $quoteprice = $data['quoteprice'];
            $this->updateQuoteprice($quoteprice);

            $quotepriceDetail = new QuotepriceDetail();
            //insert quoteprice detail
            if (!empty($insert_quoteprice_detail_data)) {
                $quotepriceDetail->insertQuotepriceDetail($insert_quoteprice_detail_data);
            }

            //delete quoteprice detail
            if (!empty($delete_quoteprice_detail_data)) {
                $quotepriceDetail->deleteQuotepriceDetailsByIds($delete_quoteprice_detail_data);
            }

            //update quoteprice detail
            foreach ($update_quoteprice_detail_data as $quoteprice_detail) {
                $quotepriceDetail->updateQuotepriceDetail($quoteprice_detail);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function transactionCreateQuoteprice($cus_id, $data)
    {
        DB::beginTransaction();
        try {

            //insert quoteprice
            $data['quoteprice']['cus_id'] = $cus_id;
            $data['quoteprice']['owner_id'] = Auth::user()->id;
            $data['quoteprice']['inp_user'] = Auth::user()->id;
            $data['quoteprice']['upd_user'] = Auth::user()->id;
            $qp_id = $this->createQuoteprice($data['quoteprice']);

            $insert_quoteprice_detail_data = [];
            $quoteprice_detail = array_key_exists('quoteprice_detail', $data) ? $data['quoteprice_detail'] : [];
            foreach ($quoteprice_detail as $item) {

                $quoteprice_detail_data = [
                    "qp_id" => $qp_id,
                    "note" => $item['dt_note'],
                    "unit" => $item['dt_unit'],
                    "quantity" => $item['dt_quantity'],
                    "status" => $item['dt_status'],
                    "delivery_time" => $item['dt_delivery_time'],
                    "price" => $item['dt_price'],
                    "amount" => $item['dt_amount'],
                    "type" => $item['dt_type'],
                    "sort_no" => $item['dt_sort_no'],
                    "owner_id" => Auth::user()->id,
                    "upd_user" => Auth::user()->id,
                    "inp_user" => Auth::user()->id
                ];

                if ($item['dt_type'] == '1') {
                    $quoteprice_detail_data["prod_specs"] = $item['dt_prod_specs'];
                    $quoteprice_detail_data["prod_specs_mce"] = $item['dt_prod_specs_mce'];
                    $quoteprice_detail_data["acce_code"] = null;
                    $quoteprice_detail_data["acce_name"] = null;
                }

                if ($item['dt_type'] == '2') {
                    $quoteprice_detail_data["prod_specs"] = null;
                    $quoteprice_detail_data["prod_specs_mce"] = null;
                    $quoteprice_detail_data["acce_code"] = $item['dt_acce_code'];
                    $quoteprice_detail_data["acce_name"] = $item['dt_acce_name'];
                }
                $insert_quoteprice_detail_data[] = $quoteprice_detail_data;
            }

            //insert quoteprice detail
            $quotepriceDetail = new QuotepriceDetail();
            if (!empty($insert_quoteprice_detail_data)) {
                $quotepriceDetail->insertQuotepriceDetail($insert_quoteprice_detail_data);
            }

            DB::commit();
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

            if (!array_key_exists('quoteprice', $data)) {
                $res['success'] = false;
                $message[] = __('Data is wrong.!');
                return $res;
            }

            $quoteprice = $data['quoteprice'];
            if (requiredValidator($quoteprice['qp_no']) == false) {
                $res['success'] = false;
                $message[] = __('QP No is required.');
            }
            if (requiredValidator($quoteprice['qp_no']) == true && maxlengthValidator($quoteprice['qp_no'], 30) == false) {
                $res['success'] = false;
                $message[] = __('QP No is too long.');
            }
            if (requiredValidator($quoteprice['qp_date']) == false) {
                $res['success'] = false;
                $message[] = __('QP Date is required.');
            }
            if (requiredValidator($quoteprice['qp_date']) == true && dateValidator($quoteprice['qp_date']) == false) {
                $res['success'] = false;
                $message[] = __('QP Date is wrong format YYYY/MM/DD.');
            }
            if (requiredValidator($quoteprice['qp_exp_date']) == false) {
                $res['success'] = false;
                $message[] = __('QP Exp Date is required.');
            }
            if (array_key_exists('qp_exp_date', $quoteprice) && dateValidator($quoteprice['qp_exp_date']) == false) {
                $res['success'] = false;
                $message[] = __('QP Exp Date is wrong format YYYY/MM/DD.');
            }
            if (requiredValidator($quoteprice['qp_exp_date']) == true && dateValidator($quoteprice['qp_exp_date']) == false) {
                $res['success'] = false;
                $message[] = __('QP Exp Date is wrong format YYYY/MM/DD.');
            }
            if (requiredValidator($quoteprice['sale_id']) == false || existsInDBValidator($quoteprice['sale_id'], 'users', 'id') == false) {
                $res['success'] = false;
                $message[] = __('User is not exists.');
            }

            $amount_check = true;
            if (!array_key_exists('qp_tax', $quoteprice)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('QP Tax is required.');
            }
            if (!array_key_exists('qp_amount', $quoteprice)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of quoteprices (before VAT) is required.');
            }
            if (!array_key_exists('qp_amount_tax', $quoteprice)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of quoteprices (VAT included) is required.');
            }
            if (array_key_exists('qp_tax', $quoteprice) && (is_numeric($quoteprice['qp_tax']) == false || intval($quoteprice['qp_tax']) < 0 || intval($quoteprice['qp_tax']) > 2147483647)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('QP Tax is wrong data.');
            }
            if (array_key_exists('qp_amount', $quoteprice) && (is_numeric($quoteprice['qp_amount']) == false || floatval($quoteprice['qp_amount']) < 0 || floatval($quoteprice['qp_amount']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of quoteprices (before VAT) is wrong.');
            }
            if (array_key_exists('qp_amount_tax', $quoteprice) && (is_numeric($quoteprice['qp_amount_tax']) == false || floatval($quoteprice['qp_amount_tax']) < 0 || floatval($quoteprice['qp_amount']) > 9223372036854775807)) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Total value of quoteprices (VAT included) is wrong.');
            }

            if ($amount_check == true) {

                $qp_tax = $quoteprice['qp_tax'] == null || $quoteprice['qp_tax'] == '' ? 0 : intval($quoteprice['qp_tax']);
                $qp_amount = $quoteprice['qp_amount'] == null || $quoteprice['qp_amount'] == '' ? 0 : doubleval($quoteprice['qp_amount']);
                $qp_amount_tax = $quoteprice['qp_amount_tax'] == null || $quoteprice['qp_amount_tax'] == '' ? 0 : doubleval($quoteprice['qp_amount_tax']);

                $chk_qp_amount_tax = $qp_amount + $qp_amount * $qp_tax / 100;
                if ($qp_amount_tax != $chk_qp_amount_tax) {
                    $amount_check = false;
                    $res['success'] = false;
                    $message[] = __('Amount total is wrong.');
                }
            }

            $dt_total_amount = 0;
            $quoteprice_details = array_key_exists('quoteprice_detail', $data) ? $data['quoteprice_detail'] : [];
            foreach ($quoteprice_details as $line_no => $item) {

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
                $dt_total_amount += $item['dt_amount'] == null || $item['dt_amount'] == '' ? 0 : doubleval($item['dt_amount']);
            }

            if ($amount_check == true && $dt_total_amount != $qp_amount) {
                $amount_check = false;
                $res['success'] = false;
                $message[] = __('Amount total of quoteprice details is not equal amount total of quoteprice.');
            }

            $res['message'] = implode("\n", $message);
            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }

    }

    public function isQpNoExists($qp_no)
    {
        try {
            $cnt = DB::table('quoteprice')
                ->where([
                    ['quoteprice.qp_no', '=', $qp_no],
                    ['quoteprice.delete_flg', '=', '0']
                ])
                ->count();
            if ($cnt > 0)
                return true;
            return false;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function generateQpNo()
    {
        try {
            $user = new User();
            $curUser = $user->getCurrentUser();
            $pre_reg = strtoupper(explode('@', $curUser->email)[0]) . 'BG' . date('y');
            $reg = '^' . $pre_reg . '[0-9]{5,}$';
            $quoteprice = DB::select("SELECT MAX(qp_no) AS qp_no FROM quoteprice WHERE qp_no REGEXP :reg;", ['reg' => $reg]);
            if ($quoteprice[0]->qp_no == null) {
                $qp_no_num = 1;
            } else {
                $qp_no_num = intval(str_replace($pre_reg, '', $quoteprice[0]->qp_no)) + 1;
            }
            $qp_no = $pre_reg . str_pad($qp_no_num, 5, '0', STR_PAD_LEFT);
            return $qp_no;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteQuotepricesByIds($qp_ids = '')
    {
        try {

            DB::table('quoteprice')
                ->where('owner_id', Auth::user()->id)
                ->whereIn('qp_id', explode(',', $qp_ids))
                ->update([
                    'upd_user' => Auth::user()->id,
                    'delete_flg' => '1'
                ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function createQuoteprice($data)
    {
        try {
            return DB::table('quoteprice')->insertGetId($data);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateQuoteprice($quoteprice)
    {
        try {
            $qp_id = $quoteprice['qp_id'];
            unset($quoteprice['qp_id']);
            DB::table('quoteprice')
                ->where([
                    ['owner_id', '=', Auth::user()->id],
                    ['qp_id', '=', $qp_id]
                ])
                ->update($quoteprice);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function sendQuoteprice($quoteprice, $quoteprices_detail, $extra_data)
    {
        DB::beginTransaction();
        try {

            $file = $this->makeFilePDF($quoteprice, $quoteprices_detail, $extra_data);
            if ($file == false)
                return false;

            $user = new User();
            $curUser = $user->getCurrentUser();

            DB::table('quoteprice_file')
                ->insert([
                    'qp_id' => $quoteprice->qp_id,
                    'uniqid' => $file['uniqid'],
                    'file_name' => $file['file_name'],
                    'upd_user' => $curUser->id,
                    'upd_date' => now(),
                    'inp_user' => $curUser->id,
                    'inp_date' => now()
                ]);

            DB::table('quoteprice_mail')
                ->insert([
                    'qp_id' => $quoteprice->qp_id,
                    'uniqid' => $file['uniqid'],
                    'file_name' => $file['file_name'],
                    'upd_user' => $curUser->id,
                    'upd_date' => now(),
                    'inp_user' => $curUser->id,
                    'inp_date' => now()
                ]);

            //add mail queue
            $mail_data = [];
            $mail_data['qp_id'] = $quoteprice->qp_id;
            $mail_data['uniqid'] = $file['uniqid'];
            $mail_data['user_id'] = $curUser->id;
            $mail_data['subject'] = 'Báo giá';
            $mail_data['com_name'] = $curUser->com_nm_shot;
            $mail_data['cus_name'] = $quoteprice->contact_name;
            $mail_data['cus_mail'] = $quoteprice->contact_email;
            $mail_data['sale_name'] = $quoteprice->sale_name;
            $mail_data['file_path'] = $file['file_path'];
            $mail_data['file_name'] = $file['file_name'] . ".pdf";

            $mail_conf = makeMailConf(
                $curUser->email,
                $curUser->app_pass,
                $curUser->email,
                $curUser->name
            );
            dispatch(new SendQuotepriceEmail($mail_data, $mail_conf));

            DB::commit();
            return $file['uniqid'];
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getPdfFile($qp_id, $uniqid)
    {
        try {
            $file = DB::table('quoteprice_file')
                ->where([
                    ['quoteprice_file.qp_id', '=', $qp_id],
                    ['quoteprice_file.uniqid', '=', $uniqid],
                    ['quoteprice_file.delete_flg', '=', '0']
                ])
                ->first();

            if ($file == null)
                return;

            $is_exists = Storage::disk('quoteprices')->exists("$uniqid.pdf");
            if ($is_exists == false)
                return null;

            return [
                'name' => $file->file_name,
                'path' => Storage::disk('quoteprices')->path("$uniqid.pdf")
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function makeFilePDF($quoteprice, $quoteprices_detail, $extra_data)
    {
        try {
            $user = new User();
            $userData = $user->getCurrentUser();

            $tmp_quoteprices_detail = [];
            foreach ($quoteprices_detail as $idx => $item) {

                if (array_key_exists($item->type, $tmp_quoteprices_detail) == false) {
                    $tmp_quoteprices_detail[$item->type] = [];
                }
                $tmp_quoteprices_detail[$item->type][] = $item;
            }

            $company = presentValidator($extra_data['md_company']) == true ? ($extra_data['md_company'] == '1' ? 'tk' : 'ht') : 'tk';
            $language = presentValidator($extra_data['md_language']) == true ? $extra_data['md_language'] : 'vn';

            $uniqid = uniqid();
            if ($company == 'tk') {
                $file_name = '[TKT]' . strtoupper($language) . date('d.m.Y') . '_' . $quoteprice->qp_no . '_' . $quoteprice->cus_code;
            } else {
                $file_name = '[HT]' . strtoupper($language) . date('d.m.Y') . '_' . $quoteprice->qp_no . '_' . $quoteprice->cus_code;
            }


            $view_name = "quoteprice_pdf_{$company}_{$language}";

            $pdf = PDF::loadView($view_name, [
                'user' => $userData,
                'title' => $file_name,
                'extra_data' => $extra_data,
                'quoteprice' => $quoteprice,
                'quoteprices_detail' => $tmp_quoteprices_detail
            ]);
            $is_put = Storage::disk('quoteprices')->put("$uniqid.pdf", $pdf->output());
            if ($is_put == false)
                return false;

            return [
                'uniqid' => $uniqid,
                'file_path' => Storage::disk('quoteprices')->path("$uniqid.pdf"),
                'file_name' => $file_name
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function makeWhereRaw($search = '')
    {
        $params = [0];
        $where_raw = 'quoteprice.delete_flg = ?';
        $params[] = Auth::user()->id;
        $where_raw .= ' AND quoteprice.owner_id = ? ';

        //advance search
        if (is_array($search) == true) {
            foreach ($search as $item) {
                $search_name = '';
                switch ($item['search_name']) {
                    case 'qp-code'://qp-code
                        $search_name = 'quoteprice.qp_no';
                        break;
                    case 'qp-date'://qp-date
                        $search_name = 'quoteprice.qp_date';
                        break;
                    case 'qp-exp-date'://qp-exp-date
                        $search_name = 'quoteprice.qp_exp_date';
                        break;
                    case 'sale-id'://sale-id
                        $search_name = 'quoteprice.sale_id';
                        break;
                    case 'cus-id'://cus-id
                        $search_name = 'quoteprice.cus_id';
                        break;
                    case 'qp-amount-tax'://qp-amount-tax
                        $search_name = 'quoteprice.qp_amount_tax';
                        break;
                    case 'qp-note'://qp-note
                        $search_name = 'quoteprice.qp_note';
                        break;
                    case 'sale-step'://qp-amount-tax
                        $search_name = 'quoteprice.sale_step';
                        break;
                }

                if ($search_name == '')
                    continue;

                $search_cond = buildSearchCond($search_name, $item['search_value'], $item['search_operator']);
                if (sizeof($search_cond) == 0)
                    continue;

                $params = array_merge($params, $search_cond['params']);
                $where_raw .= " AND " . $search_cond['where_raw'];
            }
        }

        //fuzzy search
        if (is_string($search) && $search != '') {
            $search_val = "%" . $search . "%";
            $where_raw .= " AND ( ";
            $where_raw .= " quoteprice.qp_no like ? ";
            $params[] = $search_val;
            if (dateValidator($search) == true) {
                $where_raw .= " OR quoteprice.qp_date = ? ";
                $params[] = $search;
                $where_raw .= " OR quoteprice.qp_exp_date = ? ";
                $params[] = $search;
            } else {
                if (is_numeric(str_replace(',', '', $search)) == false) {

                    $where_raw .= " OR users.name like ? ";
                    $params[] = $search_val;

                    $where_raw .= " OR customer.cus_name like ? ";
                    $params[] = $search_val;
                } else {
                    $where_raw .= " OR quoteprice.qp_amount = ? ";
                    $params[] = $search;

                    $where_raw .= " OR quoteprice.qp_amount_tax = ? ";
                    $params[] = str_replace(',', '', $search);
                }
            }
            $where_raw .= " ) ";

        }
        return [$where_raw, $params];
    }

    public function makeOrderBy($sort = '')
    {
        $field_name = 'qp_no';
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
