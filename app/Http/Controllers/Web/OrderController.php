<?php

namespace App\Http\Controllers\Web;

use App\Model\Order;
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

    public function addNew(Request $request, $prc_no)
    {
        return view('order_input');
    }

    public function detail(Request $request, $prc_no, $ord_no)
    {

    }
}
