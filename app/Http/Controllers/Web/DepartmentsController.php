<?php

namespace App\Http\Controllers\Web;

use App\Model\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentsController extends Controller
{
    public function index(Request $request)
    {
        try {
            checkUserRight(2,1);
            $department = new Department();
            $departments = $department->search();
            $paging = $department->getPagingInfo();
            $paging['page'] = 0;
            return view('departments', ['departments' => $departments, 'paging' => $paging]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
