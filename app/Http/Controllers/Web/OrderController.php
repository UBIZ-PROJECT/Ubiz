<?php

namespace App\Http\Controllers\Web;

use App\Helper;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\ProductStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        try {
            $order = new Order();
            $orders = $order->getOrders();
            $paging = $order->getPagingInfo();
            $paging['page'] = 0;
            return view('order_output', ['orders' => $orders, 'paging' => $paging]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function detail(Request $request, $ord_id)
    {
        $order = new Order();
        $orderData = $order->getOrder($ord_id);

        if($orderData == null){
            return response()->view('errors.404', [], 404);
        }
        $orderDetail = new OrderDetail();
        $orderDetailData = $orderDetail->getOrderDetails($ord_id);

        $productStatus = new ProductStatus();
        $statusList = $productStatus->getAllStatus();
        return view('order_input', [
            'order' => $orderData,
            'orderDetail' => $orderDetailData,
            'statusList' => Helper::convertDataToDropdownOptions($statusList, 'id', 'title')
        ]);
    }
}
