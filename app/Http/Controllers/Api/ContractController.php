<?php

namespace App\Http\Controllers\Api;

use App\Exports\ContractExport;
use App\Model\ContractDetail;
use App\Model\Order;
use App\Model\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Contract;
use App\Model\Quoteprice;
use App\Model\QuotepriceDetail;

class ContractController extends Controller
{
    public function getContracts(Request $request)
    {
        try {
            $contract = new Contract();
            list($page, $sort, $search) = $this->getRequestData($request);
            $contractData = $contract->getContracts($page, $sort, $search);
            $pagingData = $contract->getPagingInfo($search);
            $pagingData['page'] = $page;
            return response()->json([
                'contracts' => $contractData,
                'paging' => $pagingData,
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function createContract($ord_id, Request $request)
    {
        try {
            $ordt_ids = $request->get("ordt_ids");
            $order = new Order();
            $orderData = $order->getOrder($ord_id);
            if (empty($orderData) == true || $orderData == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }
            $orderDetail = new OrderDetail();
            $orderDetailData = $orderDetail->getMultiOrderDetailByOrdIds($ordt_ids);
            if (empty($orderDetailData) == true || $orderDetailData == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $contract = new Contract();
            $is_exists = $contract->checkContractIsExistsByOrdId($ord_id);
            if ($is_exists == false) {
                return response()->json(['success' => false, 'message' => __("Contract is existed.\nYou can not create it.!")], 200);
            }

            $ctr_id = $contract->transactionCreateContract($orderData, $orderDetailData);

            return response()->json(['ctr_id' => $ctr_id, 'success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateContract($ctr_id, Request $request)
    {
        try {
            $data = $request->get('data', null);
            if (empty($data) == true || $data == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }
            $data = json_decode($data, true);
            $contract = new Contract();
            $contractData = $contract->getContract($ctr_id);
            if ($contractData == null) {
                return response()->json(['success' => false, 'message' => __("Contract doesn't existed.!")], 200);
            }

//            $validator = $contract->validateData($data);
//            if ($validator['success'] == false) {
//                return response()->json(['success' => false, 'message' => $validator['message']], 200);
//            }

            //update contract
            $contract->transactionUpdateContract($ctr_id, $data);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteContracts($ctr_ids, Request $request)
    {
        try {
            if (empty($ctr_ids) || $ctr_ids == '') {
                return response()->json(['success' => false, 'message' => __('Successfully processed.')], 200);
            }

            $contract = new Contract();
            $contract->transactionDeleteContractsByIds($ctr_ids);

            return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
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
