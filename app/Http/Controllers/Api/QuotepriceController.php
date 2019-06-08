<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Customer;
use App\Model\Quoteprice;
use App\Model\QuotepriceDetail;

class QuotepriceController extends Controller
{
    public function getQuoteprices(Request $request)
    {
        try {
            $qpModel = new Quoteprice();
            list($page, $sort, $search) = $this->getRequestData($request);
            $qpData = $qpModel->getQuoteprices($page, $sort, $search);
            $pagingData = $qpModel->getPagingInfo($search);
            $pagingData['page'] = $page;
            return response()->json([
                'quoteprices' => $qpData,
                'paging' => $pagingData,
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function createQuoteprice($cus_id, Request $request)
    {
        try {

            $data = $request->get('data', null);
            if (empty($data) == true || $data == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $cus = new Customer();
            $cusData = $cus->getCustomerById($cus_id);
            if ($cusData == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $qpModel = new Quoteprice();
            $validator = $qpModel->validateData($data);
            if ($validator['success'] == false) {
                return response()->json(['success' => false, 'message' => $validator['message']], 200);
            }

            $is_exists = $qpModel->isQpNoExists($data['quoteprice']['qp_no']);
            if ($is_exists == true) {
                $qp_no = $qpModel->generateQpNo();
                return response()->json(['qp_no' => $qp_no, 'success' => false, 'message' => __('QP No is exists.', ['qp_no_old' => $data['quoteprice']['qp_no'], 'qp_no_new' => $qp_no])], 200);
            }

            //create quoteprice
            $qpModel->transactionCreateQuoteprice($cus_id, $data);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateQuoteprice($ord_id, Request $request)
    {
        try {

            $data = $request->get('data', null);
            if (empty($data) == true || $data == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $qpModel = new Quoteprice();
            $validator = $qpModel->validateData($data);
            if ($validator['success'] == false) {
                return response()->json(['success' => false, 'message' => $validator['message']], 200);
            }

            //update quoteprice
            $qpModel->transactionUpdateQuoteprice($ord_id, $data);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteQuoteprices($ord_ids, Request $request)
    {
        try {

            if (empty($ord_ids) || $ord_ids == '') {
                return response()->json(['success' => false, 'message' => __('Successfully processed.')], 200);
            }

            $qpModel = new Quoteprice();
            $qpModel->transactionDeleteQuotepricesByIds($ord_ids);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function sendQuoteprice($qp_id, Request $request)
    {
        try {

            $qpModel = new Quoteprice();
            $qpData = $qpModel->getQuoteprice($qp_id);
            if (empty($qpData) == true || $qpData == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $qpDetailModel = new QuotepriceDetail();
            $qpDetailData = $qpDetailModel->getQuotepriceDetailsByQpId($qp_id);

            $user = new User();
            $userData = $user->getCurrentUser();

            $tmp_quoteprices_detail = [];
            foreach ($qpDetailData as $idx => $item) {

                if (array_key_exists($item->type, $tmp_quoteprices_detail) == false) {
                    $tmp_quoteprices_detail[$item->type] = [];
                }
                $tmp_quoteprices_detail[$item->type][] = $item;
            }

            $uniqid = uniqid();
            $file_name = '[TKP] ' . date('d.m.Y') . '_' . $qpData->qp_no . '_' . $qpData->cus_code;
            file_put_contents(
                "/tmp/$uniqid.html",
                view('quoteprice_pdf',
                    [
                        'user' => $userData,
                        'title' => $file_name,
                        'quoteprice' => $qpData,
                        'quoteprices_detail' => $tmp_quoteprices_detail
                    ]
                )->render()
            );
            //send quoteprice
//            $uniqid = $qpModel->sendQuoteprice($qpData, $qpDetailData);
//            if ($uniqid == false) {
//                return response()->json(['success' => false, 'message' => __('Send quoteprices fail.')], 200);
//            }

            return response()->json(['uniqid' => $uniqid, 'success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getRequestData(Request $request)
    {
        $page = 0;
        if ($request->has('page')) {
            $page = $request->page;
        }

        $sort = '';
        if ($request->has('sort')) {
            $sort = $request->sort;
        }

        $search = $request->get('search', '');

        return [$page, $sort, $search];
    }
}
