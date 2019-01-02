<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\User;

class Permission
{

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

    public function getDepPermissions($dep_id, $scr_id)
    {
        try {
            $permissions = DB::select(DB::raw("call proc_getDepPermissions(?,?)"), [$dep_id, $scr_id]);
            return $permissions;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getUsrPermissions($dep_id, $scr_id, $usr_id)
    {
        try {
            $permissions = DB::select(DB::raw("call proc_getUsrPermissions(?,?,?)"), [$dep_id, $scr_id, $usr_id]);
            return $permissions;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
