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
            $data = $user->getUser($id);

            list($page, $sort, $search) = $this->getRequestData($request);
            $count = $user->countUsers($search);

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
        return [$page, $sort, $search];
    }
}
