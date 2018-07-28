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
            $paging = $user->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['users' => $users, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function insertUser(Request $request)
    {
        try {
            $user = new User();
            $paging = $user->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['users' => $users, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed.")], 200);
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
        if ($request->has('search')) {
            $search['search'] = $request->search;
        }
        if ($request->has('search_code')) {
            $search['code'] = $request->search_code;
        }
        if ($request->has('search_name')) {
            $search['name'] = $request->search_name;
        }
        if ($request->has('search_phone')) {
            $search['phone'] = $request->search_phone;
        }
        if ($request->has('search_email')) {
            $search['email'] = $request->search_email;
        }
        if ($request->has('search_dep_name')) {
            $search['dep_name'] = $request->search_dep_name;
        }
        if ($request->has('search_address')) {
            $search['address'] = $request->search_address;
        }
        if ($request->has('search_contain')) {
            $search['contain'] = $request->search_contain;
        }
        if ($request->has('search_notcontain')) {
            $search['notcontain'] = $request->search_notcontain;
        }
        return [$page, $sort, $search];
    }
}
