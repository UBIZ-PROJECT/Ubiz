<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    public function delete($ids = '')
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

    public function update($id, $data = [])
    {
        DB::beginTransaction();
        try {
            $data['upd_user'] = Auth::user()->id;
            DB::table('m_department')
                ->where([['id', '=', $id], ['delete_flg', '=', '0']])
                ->update($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insert($data = [])
    {
        DB::beginTransaction();
        try {

            $data['inp_user'] = Auth::user()->id;
            $data['upd_user'] = Auth::user()->id;
            DB::table('m_department')->insert($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function search($page = 0, $sort = '', $search = '')
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
}
