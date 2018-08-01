<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class DepartmentsController extends Controller
{
    public function index(Request $request)
    {
        return view('departments');
    }
}
