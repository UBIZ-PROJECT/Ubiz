<?php

namespace App\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class Permission
{

    public function setPermissions($data)
    {
        DB::beginTransaction();
        try {

            $res = [
                'dep_id' => '0',
                'scr_id' => '0',
                'usr_id' => '0'
            ];
            $user_id = Auth::user()->id;
            foreach ($data as $permission) {
                if (isset($permission['dep_allow']) && !isset($permission['usr_allow'])) {
                    if ($permission['id'] == '0') {
                        DB::table('m_permission_department')->insert([
                            'dep_id' => $permission['dep_id'],
                            'scr_id' => $permission['scr_id'],
                            'fnc_id' => $permission['fnc_id'],
                            'dep_allow' => $permission['dep_allow'],
                            'inp_user' => $user_id,
                            'upd_user' => $user_id,
                        ]);
                    } else {
                        DB::table('m_permission_department')
                            ->where([
                                ['id', '=', $permission['id']],
                                ['delete_flg', '=', '0']
                            ])
                            ->update([
                                'dep_allow' => $permission['dep_allow'],
                                'upd_user' => $user_id
                            ]);
                    }
                    $res['dep_id'] = $permission['dep_id'];
                    $res['scr_id'] = $permission['scr_id'];
                } else {
                    if ($permission['id'] == '0') {
                        DB::table('m_permission_user')->insert([
                            'dep_id' => $permission['dep_id'],
                            'scr_id' => $permission['scr_id'],
                            'fnc_id' => $permission['fnc_id'],
                            'usr_id' => $permission['usr_id'],
                            'usr_allow' => $permission['usr_allow'],
                            'inp_user' => $user_id,
                            'upd_user' => $user_id,
                        ]);
                    } else {
                        DB::table('m_permission_user')
                            ->where([
                                ['id', '=', $permission['id']],
                                ['delete_flg', '=', '0']
                            ])
                            ->update([
                                'usr_allow' => $permission['usr_allow'],
                                'upd_user' => $user_id
                            ]);
                    }
                    $res['dep_id'] = $permission['dep_id'];
                    $res['scr_id'] = $permission['scr_id'];
                    $res['usr_id'] = $permission['usr_id'];
                }
            }
            DB::commit();
            return $res;
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
