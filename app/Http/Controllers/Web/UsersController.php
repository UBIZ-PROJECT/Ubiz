<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = new User();
            $users = $user->getUsers();
            $paging = $user->getPagingInfo();
            $paging['page'] = 0;
            $departments = $user->getDepartments();
            return view('users', ['users' => $users, 'paging' => $paging, 'departments' => $departments]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function login(Request $request)
    {
        return view('login');
    }
}
