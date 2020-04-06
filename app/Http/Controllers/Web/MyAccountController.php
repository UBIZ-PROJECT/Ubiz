<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class MyAccountController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = new User();
            $account = $user->getCurrentUser();
            $companies = $user->getCompanies();
            $departments = $user->getDepartments();
            return view('myaccount', [
                'account' => $account,
                'companies' => $companies,
                'departments' => $departments
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}