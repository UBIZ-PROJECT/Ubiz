<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Customer;

class CustomerController extends Controller
{
    public function search(Request $request)
    {
        try {
            checkUserRight(5, 1);
            list($page, $sort, $search) = $this->getRequestData($request);
            $customer = new Customer();
            $customers = $customer->search($page, $sort, $search);
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

    public function detail($cus_id, Request $request)
    {
        try {
            checkUserRight(5, 1);
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

    public function insert(Request $request)
    {
        try {
            checkUserRight(5, 2);
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
            $cusModel->insert($map_data);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function update($cus_id, Request $request)
    {
        try {
            checkUserRight(5, 4);
            $data = $request->get('data', null);
            if (empty($data) == true || $data == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $cusModel = new Customer();
            $cusData = $cusModel->getCustomerById($cus_id);
            if ($cusData == null) {
                return response()->json(['success' => false, 'message' => __("Order doesn't existed.!")], 200);
            }

            $validator = $cusModel->updateValidation($cus_id, $data);
            if ($validator['success'] == false) {
                return response()->json(['success' => false, 'message' => $validator['message']], 200);
            }

            $map_data = $this->mapData($data);
            $cusModel->update($cus_id, $map_data);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function delete($cus_ids, Request $request)
    {
        try {
            checkUserRight(5, 3);
            $cusModel = new Customer();
            $cusModel->delete($cus_ids);
            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function generateCusCode(Request $request)
    {
        try {
            checkUserRight(5, 2);
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
                'cus_mail' => $data['cus']['cus_mail'],
                'cus_phone' => $data['cus']['cus_phone'],
                'cus_field' => $data['cus']['cus_field'],
                'cus_type' => $data['cus']['cus_type'],
                'cus_pic' => $data['cus']['cus_pic'],
                'cus_avatar' => ($data['cus']['cus_avatar'] == null ? '' : $data['cus']['cus_avatar']),
                'cus_avatar_base64' => ($data['cus']['cus_avatar_base64'] == null ? '' : $data['cus']['cus_avatar_base64']),
            ];

            $map_data['cad'] = [];
            $map_data['cad'][] = [
                'cad_id' => $data['cus']['cad_id_1'],
                'lct_id' => $data['cus']['lct_location_1'],
                'cad_address' => $data['cus']['cus_address_1'],
            ];
            $map_data['cad'][] = [
                'cad_id' => $data['cus']['cad_id_2'],
                'lct_id' => $data['cus']['lct_location_2'],
                'cad_address' => $data['cus']['cus_address_2'],
            ];
            $map_data['cad'][] = [
                'cad_id' => $data['cus']['cad_id_3'],
                'lct_id' => $data['cus']['lct_location_3'],
                'cad_address' => $data['cus']['cus_address_3'],
            ];

            $map_data['con'] = [];
            foreach ($data['con'] as $con) {
                $map_data['con'][] = [
                    'con_id' => $con['con_id'],
                    'con_name' => $con['con_name'],
                    'con_mail' => $con['con_mail'],
                    'con_phone' => $con['con_phone'],
                    'con_rank' => $con['con_rank'],
                    'con_action' => $con['con_action'],
                    'con_avatar' => ($con['con_avatar'] == null ? '' : $con['con_avatar']),
                    'con_avatar_base64' => ($con['con_avatar_base64'] == null ? '' : $con['con_avatar_base64'])
                ];
            }

            return $map_data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
