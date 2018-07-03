<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;

class CustomerController extends Controller
{
    public function customer(Request $request)
    {
        $user = new Customer();
        $data = $user->getAllCustomers();
        return view('customer', ['data' => $data]);
    }

}
