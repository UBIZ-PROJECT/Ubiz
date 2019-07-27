<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\OrderHistory;

class OrderHistoryController extends Controller
{
    public function getOrders(Request $request, $ord_id)
    {
        try {
            $order = new OrderHistory();
            list($page, $sort, $search) = $this->getRequestData($request);
            $orderData = $order->getOrders($ord_id, $page, $sort, $search);
            $pagingData = $order->getPagingInfo($ord_id, $search);
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
