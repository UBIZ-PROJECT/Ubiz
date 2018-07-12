<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Customer;

class CustomerController extends Controller
{
    public function getCustomers(Request $request)
    {
        try {

            $page = 0;
            if ($request->has('page')) {
                $page = $request->page;
            }

            $sort = '';
            if ($request->has('sort')) {
                $sort = $request->sort;
            }

            $customer = new Customer();
            $customers = $customer->getCustomers($page, $sort);
            $paging = $customer->getPagingInfo();
            $paging['page'] = $page;
			foreach($customers as $key => $item){
				$customerAddress = $customer->getCustomerAddress($item->cus_id);
				$customers[$key]->address = $customerAddress;
			}
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['customers' => $customers, 'paging' => $paging, 'success' => true, 'message' => ''], 200);
    }

    public function deleteCustomer($ids, Request $request)
    {
        try {
            $customer = new Customer();
            $customer->deleteCustomer($ids);
            $customers = $customer->getCustomers(0);
            $paging = $customer->getPagingInfo();
            $paging['page'] = 0;
			foreach($customers as $key => $item){
				$customerAddress = $customer->getCustomerAddress($item->cus_id);
				$customers[$key]->address = $customerAddress;
			}
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['customers' => $customers, 'paging' => $paging, 'success' => true, 'message' => 'Xử lý thành công'], 200);
    }
}