<?php

namespace App\Http\Controllers\Api;

use App;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function search(Request $request)
    {
        try {
            checkUserRight('3', '1');
            list($page, $sort, $search) = $this->getRequestData($request);

            $user = new User();
            $users = $user->search($page, $sort, $search);
            $paging = $user->getPagingInfo($search);
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['users' => $users, 'paging' => $paging, 'success' => true, 'message' => ''], 200);
    }

    public function detail($id, Request $request)
    {
        try {
            checkUserRight('3', '1');
            $user = new User();
            if ($request->has('pos')) {
                list ($page, $sort, $search) = $this->getRequestData($request);
                $data = $user->getUserByPos($request->pos, $sort, $search);
            } else {
                $data = $user->getUserById($id);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['user' => $data, 'message' => __("Successfully processed.")], 200);
    }

    public function update($id, Request $request)
    {
        try {
            checkUserRight('3', '4');
            $user = new User();
            list($page, $sort, $search, $data) = $this->getRequestData($request);
            if ($data['keep_info'] == "true") {
                $userData = get_object_vars($user->getUserOnlyById($id));
                if(isset($data['code'])){
                    $userData['code'] = $data['code'];
                }
                if(isset($data['name'])){
                    $userData['name'] = $data['name'];
                }
                if(isset($data['rank'])){
                    $userData['rank'] = $data['rank'];
                }
                if(isset($data['phone'])){
                    $userData['phone'] = $data['phone'];
                }
                if(isset($data['email'])){
                    $userData['email'] = $data['email'];
                }
                if(isset($data['com_id'])){
                    $userData['com_id'] = $data['com_id'];
                }
                if(isset($data['dep_id'])){
                    $userData['dep_id'] = $data['dep_id'];
                }
                if(isset($data['join_date'])){
                    $userData['join_date'] = $data['join_date'];
                }
                if(isset($data['salary'])){
                    $userData['salary'] = $data['salary'];
                }
                if(isset($data['address'])){
                    $userData['address'] = $data['address'];
                }
                if(isset($data['bhxh'])){
                    $userData['bhxh'] = $data['bhxh'];
                }
                if(isset($data['bhyt'])){
                    $userData['bhyt'] = $data['bhyt'];
                }
                if(isset($data['avatar'])){
                    $userData['tmp_avatar'] = $data['avatar'];
                }
                unset($userData['id']);
                $user->keepInfo($userData);
                $user->deleteUser($id);
            } else {
                $validator = $user->validateData($data);
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

    public function insert(Request $request)
    {
        try {
            checkUserRight('3', '2');
            $user = new User();
            list($page, $sort, $search, $user_data) = $this->getRequestData($request);
            $validator = $user->validateData($user_data);
            if ($validator['success'] == false) {
                return response()->json(['success' => false, 'message' => $validator['message']], 200);
            }
            $user->insertUser($user_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function delete($ids, Request $request)
    {
        try {
            checkUserRight('3', '3');
            $user = new User();
            $user->deleteUser($ids);
            $users = $user->search(0);
            $paging = $user->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['users' => $users, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function getRequestData(Request $request)
    {
        $page = 0;
        if ($request->has('page')) {
            $page = $request->page;
        }

        $sort = '';
        if ($request->has('sort')) {
            $sort = $request->sort;
        }

        $search = [];
        if ($request->has('code')) {
            $search['code'] = $request->code;
        }
        if ($request->has('name')) {
            $search['name'] = $request->name;
        }
        if ($request->has('phone')) {
            $search['phone'] = $request->phone;
        }
        if ($request->has('email')) {
            $search['email'] = $request->email;
        }
        if ($request->has('dep_name')) {
            $search['dep_name'] = $request->dep_name;
        }
        if ($request->has('address')) {
            $search['address'] = $request->address;
        }
        if ($request->has('contain')) {
            $search['contain'] = $request->contain;
        }
        if ($request->has('notcontain')) {
            $search['notcontain'] = $request->notcontain;
        }

        $user = [];
        if ($request->has("txt_com_id")) {
            $user['com_id'] = $request->txt_com_id;
        }
        if ($request->has('txt_code')) {
            $user['code'] = $request->txt_code;
        }
        if ($request->has('txt_name')) {
            $user['name'] = $request->txt_name;
        }
        if ($request->has('txt_rank')) {
            $user['rank'] = $request->txt_rank;
        }
        if ($request->has('txt_phone')) {
            $user['phone'] = $request->txt_phone;
        }
        if ($request->has('txt_email')) {
            $user['email'] = $request->txt_email;
        }
        if ($request->has('txt_dep_id')) {
            $user['dep_id'] = $request->txt_dep_id;
        }
        if ($request->has('txt_join_date')) {
            $user['join_date'] = $request->txt_join_date;
        }
        if ($request->has('txt_salary')) {
            $user['salary'] = $request->txt_salary;
        }
        if ($request->has('txt_address')) {
            $user['address'] = $request->txt_address;
        }
        if ($request->has('txt_bhxh')) {
            $user['bhxh'] = $request->txt_bhxh;
        }
        if ($request->has('txt_bhyt')) {
            $user['bhyt'] = $request->txt_bhyt;
        }
        if ($request->hasFile('avatar')) {
            $user['avatar'] = $request->avatar;
        }
        if ($request->has("keep_info")) {
            $user['keep_info'] = $request->keep_info;
        }

        return [$page, $sort, $search, $user];
    }
}
