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
            checkUserRight(16, 1);
            $permission = new Permission();
            $departments = $permission->getAllDepartment();
            $screens = $permission->getAllScreen();
            $permissions = $permission->getDepPermissions($departments[0]->id, $screens[0]->scr_id);
            return view('permission', [
                'departments' => $departments,
                'screens' => $screens,
                'permissions' => $permissions,
                'for' => 'department'
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

}
