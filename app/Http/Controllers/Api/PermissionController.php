<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Permission;
use App\User;

class PermissionController extends Controller
{
    public function setPermissions(Request $request)
    {
        $b = $request->getContent();
        $a='';
    }

    public function getDepPermissions($dep_id, $scr_id, Request $request)
    {
        try {

            if (empty($dep_id) || empty($scr_id)) {
                return response()->json(['success' => false, 'message' => __('Please choose department and screen.')], 200);
            }

            $permission = new Permission();
            $permissions = $permission->getDepPermissions($dep_id, $scr_id);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['permissions' => $permissions, 'success' => true, 'message' => ''], 200);
    }

    public function getUsrPermissions($dep_id, $scr_id, $usr_id, Request $request)
    {
        try {

            if (empty($dep_id) || empty($scr_id) || empty($usr_id)) {
                return response()->json(['success' => false, 'message' => __('Please choose user and screen.')], 200);
            }

            $permission = new Permission();
            $permissions = $permission->getUsrPermissions($dep_id, $scr_id, $usr_id);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['permissions' => $permissions, 'success' => true, 'message' => ''], 200);
    }
}
