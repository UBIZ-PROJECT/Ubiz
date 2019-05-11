<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Order;

class OrderController extends Controller
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

    public function updateOrder(Request $request)
    {
        try {
            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteOrder(Request $request)
    {
        try {
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
