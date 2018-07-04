<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class UsersController extends Controller
{
    public function getAllUsers(Request $request)
    {
        $user = new User();
        $data = $user->getAllUsers();
        echo json_encode($data);
    }
}
