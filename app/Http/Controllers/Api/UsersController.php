<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class UsersController extends Controller
{
    public function getUsers(Request $request)
    {
        $page = 0;
        if ($request->has('page')) {
            $page = $request->page;
        }

        $user = new User();
        $users = $user->getUsers($page);
        $paging = $user->paging();
        $paging['page'] = $page;
        echo json_encode(['users' => $users, 'paging' => $paging]);
    }
}
