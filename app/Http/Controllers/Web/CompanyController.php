<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Company;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        try {
            checkUserRight(1, 1);
            $company = new Company();
            $companies = $company->search();
            $paging = $company->getPagingInfo();
            $paging['page'] = 0;
            return view('company', ['companies' => $companies, 'paging' => $paging]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

}
