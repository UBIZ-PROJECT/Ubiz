<?php

namespace App\Http\Controllers\Api;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class UsersController extends Controller
{
    public function getUsers(Request $request)
    {
        try {

            list($page, $sort, $search) = $this->getRequestData($request);

            $user = new User();
            $users = $user->getUsers($page, $sort, $search);
            $paging = $user->getPagingInfo($search);
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['users' => $users, 'paging' => $paging, 'success' => true, 'message' => ''], 200);
    }

    public function getUser($id, Request $request)
    {
        try {
            $user = new User();
            if ($request->has('pos')) {
                list ($page, $sort, $search) = $this->getRequestData($request);
                $data = $user->getUserByPos($request->pos, $sort, $search);
            }else{
                $data = $user->getUserById($id);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['user' => $data, 'message' => __("Successfully processed.")], 200);
    }

    public function updateUser($id, Request $request)
    {
        try {
            $user = new User();
            list($page, $sort, $search, $user_data) = $this->getRequestData($request);
            $user->updateUser($id, $user_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function insertUser(Request $request)
    {
        try {
            $user = new User();
            list($page, $sort, $search, $user_data) = $this->getRequestData($request);
            $user->insertUser($user_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function deleteUsers($ids, Request $request)
    {
        try {
            $user = new User();
            $user->deleteUsers($ids);
            $users = $user->getUsers(0);
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
        if ($request->has('txt_code')) {
            $user['code'] = $request->txt_code;
        }
        if ($request->has('txt_name')) {
            $user['name'] = $request->txt_name;
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

        return [$page, $sort, $search, $user];
    }
}
