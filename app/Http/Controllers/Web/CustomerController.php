<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Customer;

class CustomerController extends Controller
{
    public function customer(Request $request)
    {
		try {
			$customer = new Customer();
			$customers = $customer->getCustomers();
			$users = $customer->getUsers();
			$paging = $customer->getPagingInfo();
			$paging['page'] = 0;
			foreach($customers as $key => $item){
				$customerAddress = $customer->getCustomerAddress($item->cus_id);
				$customers[$key]->address = $customerAddress;
			}
			return view('customer', ['customers' => $customers, 'users' => $users, 'paging' => $paging]);
		} catch (\Throwable $e) {
            throw $e;
        }
    }

}
