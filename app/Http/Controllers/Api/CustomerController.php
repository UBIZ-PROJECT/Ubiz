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
	
	public function getCustomer($cus_id, Request $request)
    {
        try {

            $cusModel = new Customer();

            if ($request->has('pos')) {
                list ($page, $sort, $search) = $this->getRequestData($request);
                $cusData = $cusModel->getCustomerByPos($request->pos, $sort, $search);
            } else {
                $cusData = $cusModel->getCustomerById($cus_id);
            }

            if($cusData == null){
                return response()->view('errors.404', [], 404);
            }

            $cusData->address = $cusModel->getCustomerAddress($cus_id);

            $conData = $cusModel->getCustomerContact($cus_id);

            return response()->json([
                'cus' => $cusData,
                'con' => $conData,
                'success' => true,
                'message' => __("Successfully processed.")
            ], 200);

        } catch (\Throwable $e) {
            throw $e;
        }
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
	
	public function updateCustomer($cus_id, Request $request)
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

    public function deleteCustomer($cus_ids, Request $request)
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

    public function getContacts($cus_id, Request $request)
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

    public function getContact($cus_id, $con_id, Request $request)
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

    public function generateCusCode(Request $request)
    {
        try {
            $customer = new Customer();
            $cus_code = $customer->generateCusCode();
            return response()->json(['cus_code' => $cus_code, 'success' => true, 'message' => __('Successfully processed.')], 200);
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
