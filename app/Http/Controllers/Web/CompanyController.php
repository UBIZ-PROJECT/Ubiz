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
            $company = new Company();
            $companies = $company->getCompany();
            $paging = $company->getPagingInfo();
            $paging['page'] = 0;
            return view('company', ['companies' => $companies, 'paging' => $paging]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

}
