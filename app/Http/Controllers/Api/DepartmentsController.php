<?php

namespace App\Http\Controllers\Api;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Department;

class DepartmentsController extends Controller
{
    public function search(Request $request)
    {
        try {
            checkUserRight(2,1);
            list($page, $sort, $search) = $this->getRequestData($request);

            $department = new Department();
            $departments = $department->search($page, $sort, $search);
            $paging = $department->getPagingInfo($search);
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['departments' => $departments, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function detail($id, Request $request)
    {
        try {
            checkUserRight(2,1);
            $department = new Department();
            if ($request->has('pos')) {
                list ($page, $sort, $search) = $this->getRequestData($request);
                $data = $department->getDepartmentByPos($request->pos, $sort, $search);
            }else{
                $data = $department->getDepartmentById($id);
            }
            return response()->json(['department' => $data, 'message' => __("Successfully processed.")], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function update($id, Request $request)
    {
        try {
            checkUserRight(2,4);
            $department = new Department();
            list($page, $sort, $search, $Department_data) = $this->getRequestData($request);
            $department->update($id, $Department_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function insert(Request $request)
    {
        try {
            checkUserRight(2,2);
            $department = new Department();
            list($page, $sort, $search, $Department_data) = $this->getRequestData($request);
            $department->insert($Department_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function delete($ids, Request $request)
    {
        try {
            checkUserRight(2,3);
            $department = new Department();
            $department->delete($ids);
            $departments = $department->search();
            $paging = $department->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['departments' => $departments, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed.")], 200);
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

        $department = [];
        if ($request->has('txt_dep_code')) {
            $department['dep_code'] = $request->txt_dep_code;
        }
        if ($request->has('txt_dep_name')) {
            $department['dep_name'] = $request->txt_dep_name;
        }

        return [$page, $sort, $search, $department];
    }
}
