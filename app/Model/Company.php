<?php

namespace App\Model;

use App\Helper;
use Illuminate\Support\Facades\DB;

class Company
{

    public function getAllCompany()
    {
        $companies = DB::table('m_company')
            ->where([
                ['delete_flg', '=', '0']
            ])
            ->orderBy('com_id', 'asc')
            ->get();

        foreach ($companies as $key => $company) {
            if (!empty($company->com_logo)) {
                $company->com_logo = \Helper::readImage($company->com_logo, 'com');
            }
            $companies[$key] = $company;
        }

        return $companies;
    }

    public function getCompany($page = 0, $sort = '', $search = [])
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $companies = DB::table('m_company')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($page * $rows_per_page)
                ->limit($rows_per_page)
                ->get();

            foreach ($companies as $key => $company) {
                if (!empty($company->com_logo)) {
                    $company->com_logo = \Helper::readImage($company->com_logo, 'com');
                }
                $companies[$key] = $company;
            }

        } catch (\Throwable $e) {
            throw $e;
        }
        return $companies;
    }

    public function getCompanyById($id)
    {
        try {
            $company = DB::table('m_company')
                ->where('com_id', $id)
                ->first();

            if ($company != null && !empty($company->com_logo)) {
                $company->com_logo = \Helper::readImage($company->com_logo, 'com');
            }

        } catch (\Throwable $e) {
            throw $e;
        }
        return $company;
    }

    public function getCompanyByPos($pos = 0, $sort = '', $search = [])
    {
        try {

            list($where_raw, $params) = $this->makeWhereRaw($search);
            list($field_name, $order_by) = $this->makeOrderBy($sort);

            $company = DB::table('m_company')
                ->whereRaw($where_raw, $params)
                ->orderBy($field_name, $order_by)
                ->offset($pos - 1)
                ->limit(1)
                ->first();

            if ($company != null && !empty($company->com_logo)) {
                $company->com_logo = \Helper::readImage($company->com_logo, 'com');
            }

        } catch (\Throwable $e) {
            throw $e;
        }
        return $company;
    }

    public function countAllCompany()
    {
        try {
            $count = DB::table('m_company')
                ->where(['delete_flg', '=', '0'])
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    public function countCompany($search = [])
    {
        try {
            list($where_raw, $params) = $this->makeWhereRaw($search);
            $count = DB::table('m_company')
                ->whereRaw($where_raw, $params)
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

    public function getPagingInfo($search = [])
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countCompany($search);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function makeWhereRaw($search = [])
    {
        $params = ['0'];
        $where_raw = 'm_company.delete_flg = ?';
        if (sizeof($search) > 0) {
            if (isset($search['contain']) || isset($search['notcontain'])) {
                if (isset($search['contain'])) {
                    $search_val = "%" . $search['contain'] . "%";
                    $where_raw .= " AND (";
                    $where_raw .= "m_company.com_nm like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_company.com_address like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_company.com_fax like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_company.com_mst like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_company.com_email like ?";
                    $params[] = $search_val;
                    $where_raw .= " OR m_company.com_phone like ?";
                    $params[] = $search_val;
                    $where_raw .= " ) ";
                }
                if (isset($search['notcontain'])) {
                    $search_val = "%" . $search['notcontain'] . "%";
                    $where_raw .= "m_company.com_nm not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_company.com_address not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_company.com_fax not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_company.com_mst not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_company.com_email not like ?";
                    $params[] = $search_val;
                    $where_raw .= " AND m_company.com_phone not like ?";
                    $params[] = $search_val;
                }

            } else {

                $where_raw_tmp = [];
                if (isset($search['com_nm'])) {
                    $where_raw_tmp[] = "m_company.com_nm = ?";
                    $params[] = $search['com_nm'];
                }
                if (isset($search['com_address'])) {
                    $where_raw_tmp[] = "m_company.com_address = ?";
                    $params[] = $search['com_address'];
                }
                if (isset($search['com_fax'])) {
                    $where_raw_tmp[] = "m_company.com_fax = ?";
                    $params[] = $search['com_fax'];
                }
                if (isset($search['com_mst'])) {
                    $where_raw_tmp[] = "m_company.com_mst = ?";
                    $params[] = $search['com_mst'];
                }
                if (isset($search['com_email'])) {
                    $where_raw_tmp[] = "m_company.com_email = ?";
                    $params[] = $search['com_email'];
                }
                if (isset($search['com_phone'])) {
                    $where_raw_tmp[] = "m_company.com_phone = ?";
                    $params[] = $search['com_phone'];
                }
                if (sizeof($where_raw_tmp) > 0) {
                    $where_raw .= " AND ( " . implode(" OR ", $where_raw_tmp) . " )";
                }
            }
        }
        return [$where_raw, $params];
    }

    public function makeOrderBy($sort)
    {
        $field_name = 'com_id';
        $order_by = 'asc';
        if ($sort != '') {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $field_name = implode('_', $sort_info);
        }
        return [$field_name, $order_by];
    }

    public function insertCompany($param)
    {
        DB::beginTransaction();
        try {

            if (isset($param['com_logo'])) {
                $com_logo = $param['com_logo'];

                $path = $com_logo->path();
                $extension = $com_logo->extension();
                $com_logo = "logo-" . $param['com_id'] . '.' . $extension;

                Helper::saveOriginalImage($path, $com_logo, 'com');
            }

            DB::table('m_company')->insert($param);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateCompany($param)
    {
        DB::beginTransaction();
        try {

            if (isset($param['com_logo'])) {
                $com_logo = $param['com_logo'];

                $path = $com_logo->path();
                $extension = $com_logo->extension();
                $com_logo = "logo-" . $param['com_id'] . '.' . $extension;

                $param['com_logo'] = $com_logo;

                Helper::saveOriginalImage($path, $com_logo, 'com');
            }

            DB::table('m_company')
                ->where('com_id', $param['com_id'])
                ->update($param);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteCompany($ids)
    {
        DB::beginTransaction();
        try {
            DB::table('m_company')
                ->whereIn('com_id', $ids)
                ->update([
                    'delete_flg' => '1',
                    'upd_date' => date('Y-m-d H:i:s')
                ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return response()->json(['success']);
    }

}
