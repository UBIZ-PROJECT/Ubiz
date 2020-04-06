<?php

namespace App\Http\Controllers\Api;

use App;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MyAccountController extends Controller
{

    public function update($id, Request $request)
    {
        try {

            if ($id != Auth::user()->id) {
                abort(403);
            }

            $user = new User();
            $data = $this->getRequestData($request);
            if ($data['keep_info'] == "true") {
                $userData = get_object_vars($user->getUserOnlyById($id));
                if(isset($data['name'])){
                    $userData['name'] = $data['name'];
                }
                if(isset($data['phone'])){
                    $userData['phone'] = $data['phone'];
                }
                if(isset($data['address'])){
                    $userData['address'] = $data['address'];
                }
                if(isset($data['avatar'])){
                    $userData['tmp_avatar'] = $data['avatar'];
                }
                unset($userData['id']);
                $user->keepInfo($userData);
                $user->deleteUser($id);
            } else {
                $validator = $this->validateData($data);
                if ($validator['success'] == false) {
                    return response()->json(['success' => false, 'message' => $validator['message']], 200);
                }
                unset($data['keep_info']);
                $user->updateUser($id, $data);
            }
            return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function validateData($data)
    {
        try {

            $res = ['success' => true, 'message' => ''];
            $message = [];

            if (!array_key_exists('name', $data) || $data['name'] == '' || $data['name'] == null) {
                $res['success'] = false;
                $message[] = __('User name is required.');
            }
            if (array_key_exists('name', $data) && mb_strlen($data['name'], "utf-8") > 100) {
                $res['success'] = false;
                $message[] = __('User name is too long.');
            }

            $res['message'] = implode("\n", $message);
            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }

    }

    public function passwd($id, Request $request)
    {
        try {
            if ($id != Auth::user()->id) {
                abort(403);
            }

            $ath_passwd = Auth::user()->getAuthPassword();
            $old_passwd = $request->get('old_passwd');
            $new_passwd = $request->get('new_passwd');
            $ver_passwd = $request->get('ver_passwd');
            if (!newPasswdValidator($new_passwd)
                || !Hash::check($old_passwd, $ath_passwd)
                || $new_passwd != $ver_passwd
            ) {
                return response()->json(['success' => false, 'message' => __("Password is not right.\nPlease retry.")], 200);
            }

            $user = new User();
            $user->updatePasswd($id, $new_passwd);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function getRequestData(Request $request)
    {
        $data = [];
        if ($request->has('txt_name')) {
            $data['name'] = $request->txt_name;
        }
        if ($request->has('txt_phone')) {
            $data['phone'] = $request->txt_phone;
        }
        if ($request->has('txt_address')) {
            $data['address'] = $request->txt_address;
        }
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->avatar;
        }
        if ($request->has("keep_info")) {
            $data['keep_info'] = $request->keep_info;
        }

        return $data;
    }
}
