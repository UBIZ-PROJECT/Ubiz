<?php

namespace App\Http\Controllers\Web;

use App\Model\OrderHistory;
use App\Model\OrderDetailHistory;
use App\Model\ProductStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderHistoryController extends Controller
{
    public function index(Request $request, $ord_id)
    {
        try {
            checkUserRight(12, 1);
            $order = new OrderHistory();
            $orderData = $order->search($ord_id);
            $pagingData = $order->getPagingInfo($ord_id);
            $pagingData['page'] = 0;
            return view('his_order', ['ord_id' => $ord_id, 'orders' => $orderData, 'paging' => $pagingData]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function detail(Request $request, $ord_id, $his_ord_id)
    {
        checkUserRight(12, 1);
        $order = new OrderHistory();
        $orderData = $order->getOrder($ord_id, $his_ord_id);

        if($orderData == null){
            return response()->view('errors.404', [], 404);
        }
        $orderDetail = new OrderDetailHistory();
        $orderDetailData = $orderDetail->getOrderDetailsByOrdId($ord_id, $his_ord_id);

        $productStatus = new ProductStatus();
        $statusList = $productStatus->getAllStatus();
        return view('his_order_input', [
            'order' => $orderData,
            'orderDetail' => $orderDetailData,
            'statusList' => convertDataToDropdownOptions($statusList, 'id', 'title')
        ]);
    }
}
