<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\User;

class Permission
{

    public function setPermissions($data)
    {
        DB::beginTransaction();
        try {

            $user_id = \Auth::user()->id;
            foreach ($data as $permission) {
                if (isset($permission['dep_allow']) && !isset($permission['usr_allow'])) {
                    DB::select(
                        DB::raw("call proc_setDepPermission(?,?,?,?,?,?)"),
                        [
                            $permission['id'],
                            $permission['dep_id'],
                            $permission['scr_id'],
                            $permission['fnc_id'],
                            $user_id,
                            $permission['dep_allow']
                        ]
                    );
                } else {
                    DB::select(
                        DB::raw("call proc_setUsrPermission(?,?,?,?,?,?)"),
                        [
                            $permission['id'],
                            $permission['dep_id'],
                            $permission['scr_id'],
                            $permission['fnc_id'],
                            $permission['usr_id'],
                            $permission['dep_allow']
                        ]
                    );
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
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
