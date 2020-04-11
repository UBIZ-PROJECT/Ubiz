<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Order;
use App\Model\Quoteprice;
use App\Model\QuotepriceDetail;

class OrderController extends Controller
{
    public function search(Request $request)
    {
        try {
            checkUserRight(12, 1);
            $order = new Order();
            list($page, $sort, $search) = $this->getRequestData($request);
            $orderData = $order->search($page, $sort, $search);
            $pagingData = $order->getPagingInfo($search);
            $pagingData['page'] = $page;
            return response()->json([
                'orders' => $orderData,
                'paging' => $pagingData,
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function create($qp_id, Request $request)
    {
        try {

            checkUserRight(11, 7);

            $qp = new Quoteprice();
            $qpData = $qp->getQuoteprice($qp_id);
            if (empty($qpData) == true || $qpData == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $order = new Order();
            $is_exists = $order->checkOrderIsExistsByQpId($qp_id);
            if ($is_exists == false) {
                return response()->json(['success' => false, 'message' => __("Order is existed.\nYou can not create it.!")], 200);
            }

            $qpDetail = new QuotepriceDetail();
            $qpDetailData = $qpDetail->getQuotepriceDetailsByQpId($qp_id);

            //create order
            $ord_id = $order->transactionCreateOrder($qpData, $qpDetailData);

            return response()->json(['ord_id' => $ord_id, 'success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function update($ord_id, Request $request)
    {
        try {
            checkUserRight(12, 4);
            $data = $request->get('data', null);
            if (empty($data) == true || $data == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $order = new Order();
            $orderData = $order->getOrder($ord_id);
            if($orderData == null){
                return response()->json(['success' => false, 'message' => __("Order doesn't existed.!")], 200);
            }

            $validator = $order->validateData($data);
            if ($validator['success'] == false) {
                return response()->json(['success' => false, 'message' => $validator['message']], 200);
            }

            //update order
            $order->transactionUpdateOrder($ord_id, $data);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function delivery($ord_id, Request $request)
    {
        try {
            checkUserRight(12, 4);
            $sale_step = $request->get('sale_step', null);
            if (empty($sale_step) == true || $sale_step == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $order = new Order();
            $orderData = $order->getOrder($ord_id);
            if($orderData == null){
                return response()->json(['success' => false, 'message' => __("Order doesn't existed.!")], 200);
            }

            $order->transactionDelivery($ord_id, $orderData->qp_id, $sale_step);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function delete($ord_ids, Request $request)
    {
        try {
            checkUserRight(12, 3);
            if (empty($ord_ids) || $ord_ids == '') {
                return response()->json(['success' => false, 'message' => __('Data is wrong')], 200);
            }

            $order = new Order();
            $order->transactionDeleteOrdersByIds($ord_ids);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
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
