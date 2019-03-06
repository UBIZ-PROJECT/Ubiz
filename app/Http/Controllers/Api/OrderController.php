<?php

namespace App\Http\Controllers\Api;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Order;

class OrderController extends Controller
{
    public function getOrders(Request $request)
    {
        try {

            list($page, $sort, $search) = $this->getRequestData($request);

            $order = new Order();
            $orders = $order->getOrders($page, $sort, $search);
            $paging = $order->getPagingInfo($search);
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['orders' => $orders, 'paging' => $paging, 'success' => true, 'message' => ''], 200);
    }

    public function getOrder($id, Request $request)
    {
        try {
            $order = new Order();
            if ($request->has('pos')) {
                list ($page, $sort, $search) = $this->getRequestData($request);
                $data = $order->getOrderByPos($request->pos, $sort, $search);
            } else {
                $data = $order->getOrderById($id);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['order' => $data, 'message' => __("Successfully processed.")], 200);
    }

    public function updateOrder($id, Request $request)
    {
        try {
            $department = new Department();
            list($page, $sort, $search, $Department_data) = $this->getRequestData($request);
            $department->updateDepartment($id, $Department_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function insertOrder(Request $request)
    {
        try {
            $department = new Department();
            list($page, $sort, $search, $Department_data) = $this->getRequestData($request);
            $department->insertDepartment($Department_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function deleteOrder($ids, Request $request)
    {
        try {
            $department = new Department();
            $department->deleteDepartments($ids);
            $departments = $department->getDepartments();
            $paging = $department->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['departments' => $departments, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function getRequestData(Request $request)
    {
        $page = $request->has('page', '0');
        $sort = $request->get('sort', '');
        $search = $request->get('search', '');
        return [$page, $sort, $search];
    }
}
