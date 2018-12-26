<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\User;

class Permission
{

    public function getData()
    {
        try {
            $departments = $this->getAllDepartment();
            $screens = $this->getAllScreen();
            $functions = $this->getAllFunction($departments[0]->id, $screens[0]->scr_id);
            return [$departments, $screens, $functions];
        } catch (\Throwable $e) {
            throw $e;
        }

    }

    public function getAllDepartment()
    {
        try {

            $departments = DB::table('m_department')
                ->where('delete_flg', '=', '0')
                ->orderBy('dep_code', 'asc')
                ->get();

            $user = new User();
            foreach ($departments as &$department) {
                $department->users = $user->getAllUserByDepId($department->id);
            }

            return $departments;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getAllScreen()
    {
        try {
            $screens = DB::table('m_screen')
                ->where('delete_flg', '=', '0')
                ->orderBy('scr_id', 'asc')
                ->get();

            return $screens;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getAllFunction($dep_id, $scr_id)
    {
        try {
            $functions = DB::table('m_screen_function')
                ->select(
                    'm_screen_function.scr_id',
                    'm_screen_function.fn_id',
                    'm_function.fn_name',
                    'm_function.fn_memo',
                    'm_permission.dep_id',
                    'm_permission.dep_allow',
                    'm_permission.user_id',
                    'm_permission.user_allow'
                )
                ->leftJoin('m_function', 'm_function.fn_id', '=', 'm_screen_function.fn_id')
                ->leftJoin('m_permission', 'm_permission.fn_id', '=', 'm_function.fn_id')
                ->where([
                    ['m_screen_function.delete_flg', '=', '0'],
                    ['m_screen_function.scr_id', '=', $scr_id],
                    ['m_permission.scr_id', '=', $scr_id],
                    ['m_permission.dep_id', '=', $dep_id],
                    ['m_permission.delete_flg', '=', '0'],
                    ['m_function.delete_flg', '=', '0']
                ])
                ->orderBy('m_screen_function.scr_id', 'asc')
                ->get();

            return $functions;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
