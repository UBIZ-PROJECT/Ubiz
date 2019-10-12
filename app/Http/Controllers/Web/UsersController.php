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
            checkUserRight('3', '1');
            $user = new User();
            $users = $user->getUsers();
            $paging = $user->getPagingInfo();
            $departments = $user->getDepartments();
            $comapnies = $user->getCompanies();
            $paging['page'] = 0;
            return view('users', [
                'users' => $users,
                'paging' => $paging,
                'departments' => $departments,
                "companies" => $comapnies
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function login(Request $request)
    {
        return view('login');
    }
}