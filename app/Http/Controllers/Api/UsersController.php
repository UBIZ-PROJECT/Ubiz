<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class UsersController extends Controller
{
    public function getUsers(Request $request)
    {
        try {

            $page = 0;
            if ($request->has('page')) {
                $page = $request->page;
            }

            $user = new User();
            $users = $user->getUsers($page);
            $paging = $user->getPagingInfo();
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['users' => $users, 'paging' => $paging,'success' => true, 'message' => ''], 200);
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
        return response()->json(['users' => $users, 'paging' => $paging, 'success' => true, 'message' => 'Xử lý thành công'], 200);
    }
}
