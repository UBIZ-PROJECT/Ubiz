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
        try {

            $data = $request->json()->all();

            $permission = new Permission();
            $permission->setPermissions($data);
            return response()->json(['permissions' => $permissions, 'success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getDepPermissions($dep_id, $scr_id, Request $request)
    {
        try {

            if (empty($dep_id) || empty($scr_id)) {
                return response()->json(['success' => false, 'message' => __('Please choose department and screen.')], 200);
            }

            $permission = new Permission();
            $permissions = $permission->getDepPermissions($dep_id, $scr_id);
            return response()->json(['permissions' => $permissions, 'success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getUsrPermissions($dep_id, $scr_id, $usr_id, Request $request)
    {
        try {

            if (empty($dep_id) || empty($scr_id) || empty($usr_id)) {
                return response()->json(['success' => false, 'message' => __('Please choose user and screen.')], 200);
            }

            $permission = new Permission();
            $permissions = $permission->getUsrPermissions($dep_id, $scr_id, $usr_id);
            return response()->json(['permissions' => $permissions, 'success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
