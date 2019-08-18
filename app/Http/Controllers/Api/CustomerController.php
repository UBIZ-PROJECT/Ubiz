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
            foreach ($customers as $key => $item) {
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

            if ($cusData == null) {
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

            $data = $request->get('data', null);
            if (empty($data) == true || $data == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $cusModel = new Customer();
            $validator = $cusModel->insertValidation($data);
            if ($validator['success'] == false) {
                return response()->json(['success' => false, 'message' => $validator['message']], 200);
            }

            $map_data = $this->mapData($data);
            $cusModel->insertCustomer($map_data);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateCustomer($cus_id, Request $request)
    {
        try {

            $data = $request->get('data', null);
            if (empty($data) == true || $data == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $cusModel = new Customer();
            $cusData = $cusModel->getCustomerById($cus_id);
            if ($cusData == null) {
                return response()->json(['success' => false, 'message' => __("Order doesn't existed.!")], 200);
            }

            $validator = $cusModel->updateValidation($data);
            if ($validator['success'] == false) {
                return response()->json(['success' => false, 'message' => $validator['message']], 200);
            }

            $map_data = $this->mapData($data);
            $cusModel->updateCustomer($map_data);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteCustomer($cus_ids, Request $request)
    {
        try {
            $cusModel = new Customer();
            $cusModel->deleteCustomer($cus_ids);
            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
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

    public function mapData($data)
    {
        try {

            $map_data = [];
            $map_data['cus'] = [
                'cus_id' => $data['cus']['cus_id'],
                'cus_code' => $data['cus']['cus_code'],
                'cus_name' => $data['cus']['cus_name'],
                'cus_fax' => $data['cus']['cus_fax'],
                'cus_phone' => $data['cus']['cus_phone'],
                'cus_field' => $data['cus']['cus_field'],
                'cus_address_1' => $data['cus']['cus_address_1'],
                'cus_address_2' => $data['cus']['cus_address_2'],
                'cus_address_3' => $data['cus']['cus_address_3'],
                'cus_type' => $data['cus']['cus_type'],
                'cus_pic' => $data['cus']['cus_pic'],
                'cus_avatar' => $data['cus']['cus_avatar']
            ];

            $map_data['cad'] = [];
            $map_data['cad'][] = [
                'cad_id' => $data['cus']['cad_id_1'],
                'cad_address' => $data['cus']['cus_address_1'],
            ];
            $map_data['cad'][] = [
                'cad_id' => $data['cus']['cad_id_2'],
                'cad_address' => $data['cus']['cus_address_2'],
            ];
            $map_data['cad'][] = [
                'cad_id' => $data['cus']['cad_id_3'],
                'cad_address' => $data['cus']['cus_address_3'],
            ];

            $map_data['con'] = [];
            foreach ($data['con'] as $con) {
                $map_data['con'][] = [
                    'con_id' => $con['con_id'],
                    'con_name' => $con['con_name'],
                    'con_mail' => $con['con_mail'],
                    'con_phone' => $con['con_phone'],
                    'con_duty' => $con['con_duty'],
                    'con_avata' => $con['con_avatar']
                ];
            }

            return $map_data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
