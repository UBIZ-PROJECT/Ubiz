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

            $pmModel = new Permission();
            $res = $pmModel->setPermissions($data);
            if ($res['usr_id'] == '0') {
                $opt = 'dep';
                $pmData = $pmModel->getDepPermissions($res['dep_id'], $res['scr_id']);
            } else {
                $opt = 'usr';
                $pmData = $pmModel->getUsrPermissions($res['dep_id'], $res['scr_id'], $res['usr_id']);
            }
            return response()->json(['permissions' => $pmData, 'opt' => $opt, 'success' => true, 'message' => __('Successfully processed.')], 200);
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

            $pmModel = new Permission();
            $pmData = $pmModel->getDepPermissions($dep_id, $scr_id);
            return response()->json(['permissions' => $pmData, 'success' => true, 'message' => __('Successfully processed.')], 200);
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

            $pmModel = new Permission();
            $pmData = $pmModel->getUsrPermissions($dep_id, $scr_id, $usr_id);
            return response()->json(['permissions' => $pmData, 'success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
