<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Model\Customer;
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
            $orderData = $order->getOrders();
            $pagingData = $order->getPagingInfo();
            $pagingData['page'] = 0;

            $userData = [];
            $userModel = new User();
            $curUser = $userModel->getCurrentUser();
            if ($curUser->role == '1' || $curUser->role == '2') {
                $userData = $userModel->getAllUsers();
            }

            $cusModel = new Customer();
            $cusData = $cusModel->getAllCustomers();

            return view('order', [
                'orders' => $orderData,
                'customers' => $cusData,
                'users' => $userData,
                'paging' => $pagingData,
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function detail(Request $request, $ord_id)
    {
        $order = new Order();
        $orderData = $order->getOrder($ord_id);

        if ($orderData == null) {
            return response()->view('errors.404', [], 404);
        }
        $orderDetail = new OrderDetail();
        $orderDetailData = $orderDetail->getOrderDetailsByOrdId($ord_id);

        $productStatus = new ProductStatus();
        $statusList = $productStatus->getAllStatus();
        return view('order_input', [
            'order' => $orderData,
            'orderDetail' => $orderDetailData,
            'statusList' => convertDataToDropdownOptions($statusList, 'id', 'title')
        ]);
    }
}
