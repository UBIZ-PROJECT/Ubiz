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
            $permission = new Permission();
            list($departments, $screens, $functions) = $permission->getData();
            return view('permission', [
                'departments' => $departments,
                'screens' => $screens,
                'functions' => $functions
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

}
