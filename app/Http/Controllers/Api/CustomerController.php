<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Customer;

class CustomerController extends Controller
{
    public function getCustomers(Request $request)
    {
        try {
			list($page, $sort, $search) = $this->getRequestData($request);
            $customer = new Customer();
            $customers = $customer->getCustomers($page, $sort, $search);
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
	
	public function getCustomer(Request $request)
    {
        try {
			if ($request->has('page')) {
				$page = $request->page;
			}else{
				$page = 0;
			}

			if ($request->has('sort')) {
				$sort = $request->sort;
			}else{
				$sort = '';
			}
			
			if ($request->has('order')) {
				$order = $request->order;
			}else{
				$order = '';
			}
			
            $customer = new Customer();
			if($request->cus_id != 0){
				$customers = $customer->getCustomer($request->cus_id);
			}else{
				$customers = $customer->getCustomerPaging($request->index, $sort, $order);
			}
			$totalCustomers = $customer->countCustomers();
			$customerAddress = $customer->getCustomerAddress($customers[0]->cus_id);
			$customers[0]->address = $customerAddress;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['customers' => $customers, 'totalCustomers' => $totalCustomers, 'success' => true, 'message' => ''], 200);
    }
	
	public function insertCustomer(Request $request)
    {
        try {

            $customer = new Customer();
            $validator = $customer->validateData($request);
            if ($validator['success'] == false) {
                return response()->json(['success' => false, 'message' => $validator['message']], 200);
            }

            $customer->insertCustomer($request);
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
        return response()->json(['customers' => $customers, 'paging' => $paging, 'success' => true, 'message' => __('Successfully processed.')], 200);
    }
	
	public function updateCustomer(Request $request)
    {
        try {
            $customer = new Customer();
            $customer->updateCustomer($request);
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
        return response()->json(['customers' => $customers, 'paging' => $paging, 'success' => true, 'message' => __('Successfully processed.')], 200);
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
        return response()->json(['customers' => $customers, 'paging' => $paging, 'success' => true, 'message' => __('Successfully processed.')], 200);
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
        if ($request->has('cus_code')) {
            $search['cus_code'] = $request->cus_code;
        }
        if ($request->has('cus_name')) {
            $search['cus_name'] = $request->cus_name;
        }
		if ($request->has('cus_type')) {
            $search['cus_type'] = $request->cus_type;
        }
        if ($request->has('cus_phone')) {
            $search['cus_phone'] = $request->cus_phone;
        }
        if ($request->has('cus_fax')) {
            $search['cus_fax'] = $request->cus_fax;
        }
        if ($request->has('cus_mail')) {
            $search['cus_mail'] = $request->cus_mail;
        }
        if ($request->has('cus_address')) {
            $search['cus_address'] = $request->cus_address;
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
