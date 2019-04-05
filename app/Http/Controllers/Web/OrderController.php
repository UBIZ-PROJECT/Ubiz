<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
		try {
			$order = new Order();
            $orders = $order->getAllOrder();
			$paging = $order->getPagingInfo();
			$paging['page'] = 0;
	
			return view('order', ['orders' => $orders, 'paging' => $paging]);
		} catch (\Throwable $e) {
            throw $e;
        }
    }

}
