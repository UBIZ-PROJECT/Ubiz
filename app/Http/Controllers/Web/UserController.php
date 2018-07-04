<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = new User();
        $data = $user->getAllUsers();
        return view('user', ['data' => $data]);
    }
}
