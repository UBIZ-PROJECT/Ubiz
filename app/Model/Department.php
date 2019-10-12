<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;

class Department
{

    public function getAllDepartments()
    {
        try {
            $department = DB::table('m_department')
                ->select('*')
                ->where('delete_flg', '=', '0')
                ->orderBy('id', 'asc')
                ->get();
            return $department;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteDepartments($ids = '')
    {
        DB::beginTransaction();
        try {

            DB::table('m_department')
                ->whereIn('id', explode(',', $ids))
                ->update(['delete_flg' => '1']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateDepartment($id, $data = [])
    {
        DB::beginTransaction();
        try {
            DB::table('m_department')
                ->where([['id', '=', $id], ['delete_flg', '=', '0']])
                ->update($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insertDepartment($data = [])
    {
        DB::beginTransaction();
        try {
            DB::table('m_department')->insert($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getDepartments($page = 0, $sort = '', $search = '')
    {
        try {

            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $departments = DB::table('m_department')
                ->select('*')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();
            return $departments;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getDepartmentById($id = '')
    {
        try {

            $department = DB::table('m_department')
                ->select('*')
                ->where([['delete_flg', '=', '0'], ['id', '=', $id]])
                ->first();
            return $department;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getDepartmentByPos($pos = 0, $sort = '', $search = '')
    {
        try {

            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $department = DB::table('m_department')
                ->select('*')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($pos - 1)
                ->limit(1)
                ->first();
            return $department;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countAllDepartments()
    {
        try {
            $count = DB::table('m_department')
                ->where('delete_flg', '=', '0')
                ->count();
            return $count;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function countDepartments($search = '')
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            $count = DB::table('m_department')
                ->whereRaw($where_raw, $params)
                ->count();
            return $count;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getPagingInfo($search = '')
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countDepartments($search);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function makeWhereRaw($search = '')
    {
        $params = ['0'];
        $where_raw = 'm_department.delete_flg = ?';
        if ($search != '') {
            $search_val = "%" . $search . "%";
            $where_raw .= " AND ( ";
            $where_raw .= " m_department.dep_code like ? ";
            $params[] = $search_val;
            $where_raw .= " OR m_department.dep_name like ? ";
            $params[] = $search_val;
            $where_raw .= " ) ";

        }
        return [$where_raw, $params];
    }

    public function makeOrderBy($sort)
    {
        $field_name = 'dep_code';
        $order_by = 'asc';
        if ($sort != '') {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $field_name = implode('_', $sort_info);
        }
        return [$field_name, $order_by];
    }

    public function getPermissions($dep_id)
    {
        try {
            $permissions = DB::table('permission')
                ->select(
                    'permission.dep_id',
                    'permission.screen_id',
                    'permission.screen_name',
                    'permission.screen_status',
                    'permission_function.function_id',
                    'permission_function.function_name',
                    'permission_function_status.function_status'
                )
                ->leftJoin('permission_function', function ($join) {
                    $join->on('permission.dep_id', '=', 'permission_function.dep_id');
                    $join->on('permission.screen_id', '=', 'permission_function.screen_id');
                    $join->where('permission_function.delete_flg', '=', '0');
                })
                ->leftJoin('permission_detail', function ($join) {
                    $join->on('permission.dep_id', '=', 'permission_function_status.dep_id');
                    $join->on('permission.screen_id', '=', 'permission_function_status.screen_id');
                    $join->on('permission_function.function_id', '=', 'permission_function_status.function_id');
                    $join->where('permission_function_status.delete_flg', '=', '0');
                })
                ->where([['permission.delete_flg', '=', '0'], ['permission.dep_id', '=', $dep_id]])
                ->orderBy('permission.dep_id', 'asc')
                ->get();

            $data = [];
            foreach ($permissions as $permission) {

                $screen_id = $permission->screen_id;
                $screen_name = $permission->screen_name;
                $screen_status = $permission->screen_status;

                $function_id = $permission->function_id;
                $function_name = $permission->function_name;
                $function_status = $permission->function_status;

                $data['screens'][$screen_id] = [
                    'screen_name' => $screen_name,
                    'screen_status' => $screen_status
                ];

                if($function_id == null)
                    continue;

                $data['functions'][$screen_id][$function_id] = [
                    'function_name' => $function_name,
                    'function_status' => $function_status
                ];
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return (object)$data;
    }
}
