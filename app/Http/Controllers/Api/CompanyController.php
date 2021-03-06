<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Company;
use App\User;

class CompanyController extends Controller
{

    public function search(Request $request)
    {
        try {
            checkUserRight(1, 1);
            list($page, $sort, $search) = $this->getRequestData($request);

            $company = new Company();
            $currencies = $company->search($page, $sort, $search);
            $paging = $company->getPagingInfo($search);
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['company' => $currencies, 'paging' => $paging, 'success' => true, 'message' => __('Successfully processed.')], 200);
    }

    public function detail($id, Request $request)
    {
        try {
            checkUserRight(1, 1);
            $company = new Company();
            if ($request->has('pos')) {
                list ($page, $sort, $search) = $this->getRequestData($request);
                $data = $company->getCompanyByPos($request->pos, $sort, $search);
            } else {
                $data = $company->detail($id);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['company' => $data, 'success' => true, 'message' => __('Successfully processed.')], 200);
    }

    public function insert(Request $request)
    {
        try {
            checkUserRight(1, 2);
            list($page, $sort, $search, $insert_data) = $this->getRequestData($request);
            $company = new Company();
            $company->insert($insert_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
    }

    public function update($id, Request $request)
    {
        try {
            checkUserRight(1, 4);
            list($page, $sort, $search, $update_data) = $this->getRequestData($request);
            $company = new Company();
            $company->updateCompany($update_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
    }

    public function delete($ids, Request $request)
    {
        try {
            checkUserRight(1, 3);
            $company = new Company();
            $id = explode(',', $ids);
            $company->delete($id);
            $companies = $company->search();
            $paging = $company->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['company' => $companies, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function getRequestData(Request $request)
    {
        $page = 0;
        if ($request->has('page')) {
            $page = $request->page;
        }

        $sort = '';
        if ($request->has('sort')) {
            $sort = $request->sort;
        }

        $search = [];
        if ($request->has('com_nm')) {
            $search['com_nm'] = $request->com_nm;
        }
        if ($request->has('com_address')) {
            $search['com_address'] = $request->com_address;
        }
        if ($request->has('com_phone')) {
            $search['com_phone'] = $request->com_phone;
        }
        if ($request->has('com_fax')) {
            $search['com_fax'] = $request->com_fax;
        }
        if ($request->has('com_mst')) {
            $search['com_mst'] = $request->com_mst;
        }
        if ($request->has('com_email')) {
            $search['com_email'] = $request->com_email;
        }
        if ($request->has('contain')) {
            $search['contain'] = $request->contain;
        }
        if ($request->has('notcontain')) {
            $search['notcontain'] = $request->notcontain;
        }


        $company = [];
        if ($request->has('txt_com_id')) {
            $company['com_id'] = $request->txt_com_id;
        }
        if ($request->has('txt_com_nm')) {
            $company['com_nm'] = $request->txt_com_nm;
        }
        if ($request->has('txt_com_nm_shot')) {
            $company['com_nm_shot'] = $request->txt_com_nm_shot;
        }
        if ($request->has('txt_com_address')) {
            $company['com_address'] = $request->txt_com_address;
        }
        if ($request->has('txt_com_phone')) {
            $company['com_phone'] = $request->txt_com_phone;
        }
        if ($request->has('txt_com_fax')) {
            $company['com_fax'] = $request->txt_com_fax;
        }
        if ($request->has('txt_com_web')) {
            $company['com_web'] = $request->txt_com_web;
        }
        if ($request->has('txt_com_email')) {
            $company['com_email'] = $request->txt_com_email;
        }
        if ($request->has('txt_com_hotline')) {
            $company['com_hotline'] = $request->txt_com_hotline;
        }
        if ($request->has('txt_com_mst')) {
            $company['com_mst'] = $request->txt_com_mst;
        }
        if ($request->hasFile('com_logo')) {
            $company['com_logo'] = $request->com_logo;
        }

        return [$page, $sort, $search, $company];
    }
}
