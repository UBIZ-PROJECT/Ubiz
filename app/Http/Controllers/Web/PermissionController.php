<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        try {
            return view('permission');
        } catch (\Throwable $e) {
            throw $e;
        }
    }

}
