<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TodoController extends Controller
{

    public function index(Request $request)
    {
        try {
            return view('todo');
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
