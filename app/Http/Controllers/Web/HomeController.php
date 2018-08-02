<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $user = new User();
        $data = $user->getAllUsers();
        return view('home', ['data' => $data]);
    }
}
