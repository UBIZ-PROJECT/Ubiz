<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Order;

class OrderController extends Controller
{
    public function getOrderList(Request $request)
    {
        try {
            list($page, $sort, $search) = $this->getRequestData($request);
            $order = new Order();
            $orders = $order->getOrderList($page, $sort, $search);
            $paging = $order->getPagingInfo();
            $paging['page'] = $page;
            foreach ($orders as $key => $item) {
                $order_detail = $order->getOrderDetail($item->ord_id);
                $orders[$key]->order_detail = $order_detail;
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['orders' => $orders, 'paging' => $paging, 'success' => true, 'message' => ''], 200);
    }

    public function getOrder(Request $request)
    {
        try {
            if ($request->has('page')) {
                $page = $request->page;
            } else {
                $page = 0;
            }

            if ($request->has('sort')) {
                $sort = $request->sort;
            } else {
                $sort = '';
            }

            if ($request->has('order')) {
                $order = $request->order;
            } else {
                $order = '';
            }

            $orderModel = new Order();
            if ($request->ord_id != 0) {
                $orders = $orderModel->getOrder($request->ord_id);
            } else {
                $orders = $orderModel->getOrderPaging($request->index, $sort, $order);
            }
            $totalOrder = $orderModel->countOrder();
            if(isset($orders[0])){
                $order_detail = $orderModel->getOrderDetail($orders[0]->ord_id);
                $orders[0]->order_detail = $order_detail;
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['orders' => $orders, 'totalOrder' => $totalOrder, 'success' => true, 'message' => ''], 200);
    }

    public function insertOrder(Request $request)
    {
        try {
            $order = new Order();
            $order->insertOrderDetail($request);
            list($page, $sort, $search) = $this->getRequestData($request);
            $orders = $order->getOrderList($page, $sort, $search);
            $paging = $order->getPagingInfo();
            $paging['page'] = $page;
            foreach ($orders as $key => $item) {
                $order_detail = $order->getOrder($item->ord_id);
                $orders[$key]->order_detail = $order_detail;
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['orders' => $orders, 'paging' => $paging, 'success' => true, 'message' => 'Xử lý thành công'], 200);
    }

    public function updateOrder(Request $request)
    {
        try {
            $orderModel = new Order();
            $orderModel->updateOrder($request);
            list($page, $sort, $search) = $this->getRequestData($request);
            $orders = $orderModel->getOrderList($page, $sort, $search);
            $paging = $orderModel->getPagingInfo();
            $paging['page'] = $page;
            foreach ($orders as $key => $order) {
                $order_detail = $orderModel->getOrder($order->ord_id);
                $orders[$key]->order_detail = $order_detail;
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['orders' => $orders, 'paging' => $paging, 'success' => true, 'message' => 'Xử lý thành công'], 200);
    }

    public function deleteOrder($ids, Request $request)
    {
        try {
            $order = new Order();
            $order->deleteOrder();
            $orders = $order->getOrder($request->ord_id);
            $paging = $order->getPagingInfo();
            $paging['page'] = 0;
            foreach ($pricings as $key => $item) {
                $pricingProducts = $pricing->getPricingProduct($item->cus_id);
                $pricings[$key]->product = $pricingProducts;
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['orders' => $orders, 'paging' => $paging, 'success' => true, 'message' => 'Xử lý thành công'], 200);
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

        $search = [];
        if ($request->has('search')) {
            $search['search'] = $request->search;
        }
        if ($request->has('ord_')) {
            $search['ord_code'] = $request->ord_code;
        }
        if ($request->has('ord_date')) {
            $search['ord_date'] = $request->ord_date;
        }
        if ($request->has('exp_date')) {
            $search['exp_date'] = $request->exp_date;
        }
        if ($request->has('contain')) {
            $search['contain'] = $request->contain;
        }
        if ($request->has('notcontain')) {
            $search['notcontain'] = $request->notcontain;
        }
        return [$page, $sort, $search];
    }
}
