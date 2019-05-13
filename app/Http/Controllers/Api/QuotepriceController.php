<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Order;

class QuotepriceController extends Controller
{
    public function getOrders(Request $request)
    {
        try {
            $order = new Order();
            list($page, $sort, $search) = $this->getRequestData($request);
            $orderData = $order->getOrders($page, $sort, $search);
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

    public function updateOrder($ord_id, Request $request)
    {
        try {

            $data = $request->get('data', null);
            if (empty($data) == true || $data == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $order = new Order();
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

    public function deleteOrders($ord_ids, Request $request)
    {
        try {

            if (empty($ord_ids) || $ord_ids == '') {
                return response()->json(['success' => false, 'message' => __('Successfully processed.')], 200);
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
