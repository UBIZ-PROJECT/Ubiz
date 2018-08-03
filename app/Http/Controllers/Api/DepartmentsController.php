<?php

namespace App\Http\Controllers\Api;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Department;

class DepartmentsController extends Controller
{
    public function getDepartments(Request $request)
    {
        try {

            list($page, $sort, $search) = $this->getRequestData($request);

            $department = new Department();
            $departments = $department->getDepartments($page, $sort, $search);
            $paging = $department->getPagingInfo($search);
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['departments' => $departments, 'paging' => $paging, 'success' => true, 'message' => ''], 200);
    }

    public function getDepartment($id, Request $request)
    {
        try {
            $department = new Department();
            if ($request->has('pos')) {
                list ($page, $sort, $search) = $this->getRequestData($request);
                $data = $department->getDepartmentByPos($request->pos, $sort, $search);
            }else{
                $data = $department->getDepartmentById($id);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['department' => $data, 'message' => __("Successfully processed.")], 200);
    }

    public function updateDepartment($id, Request $request)
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

    public function insertDepartment(Request $request)
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

    public function deleteDepartments($ids, Request $request)
    {
        try {
            $department = new Department();
            $department->deleteDepartments($ids);
            $departments = $department->getDepartments(0);
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

        $search = [];
        if ($request->has('txt_dep_code')) {
            $search['dep_code'] = $request->txt_dep_code;
        }
        if ($request->has('txt_dep_name')) {
            $search['dep_name'] = $request->txt_dep_name;
        }
        if ($request->has('contain')) {
            $search['contain'] = $request->contain;
        }
        if ($request->has('notcontain')) {
            $search['notcontain'] = $request->notcontain;
        }

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
