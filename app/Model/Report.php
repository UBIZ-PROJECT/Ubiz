<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Report implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getReportData($page = 0, $sort = '', $request)
    {
        switch ($request->type) {
            case "repository":
                $report = $this->getRepReport($page, $sort);
                break;
            case "revenue":
                $orderFromDate = $request->report_from_date ? $request->report_from_date : date('Y/m') . "/01";
                $orderToDate = $request->report_to_date ? $request->report_to_date : date('Y/m/d');
                $report = $this->getRevReport($page, $sort, $orderFromDate, $orderToDate);
                break;
            case "quoteprice":
                $qpFromDate = $request->report_from_date ? $request->report_from_date : "";
                $qpToDate = $request->report_to_date ? $request->report_to_date : date('Y/m') . "/01";
                $report = $this->getQPReport($page, $sort, $qpFromDate, $qpToDate);
                break;
            default:
                $report = $this->getRepReport($page, $sort);
                break;
            
        }

        return $report;
    }

    public function getRepReport($page, $sort) {
        try{
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            list($field_name, $order_by) = $this->makeOrderBy($sort, 'prd_id');
            $data = DB::table('product_series')
                        ->leftJoin('product', 'product_series.prd_id', '=', 'product.prd_id')
                        ->leftJoin('brand', 'product.brd_id', '=', 'brand.brd_id')
                        ->leftjoin('product_type', 'product.type_id', '=', 'product_type.prd_type_id')
                        ->select('product_series.*', 'product.prd_name', 'product.prd_model', 'brand.brd_name', 'product_type.prd_type_name')
                        ->where('product_series.delete_flg', '0')
                        ->where('product_series.sold_flg', '0')
                        ->orderBy($field_name, $order_by)
                        ->offset($page * $rows_per_page)
                        ->limit($rows_per_page)
                        ->get();
        } catch (\Throwable $e) {
            throw $e;
        }
        
        return $data;
    }

    public function getRevReport($page, $sort, $orderFromDate, $orderToDate) {
        try{
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            list($field_name, $order_by) = $this->makeOrderBy($sort, 'ord_id');
            $data = DB::table('order')
                        ->leftjoin('users', 'order.sale_id', '=', 'users.id')
                        ->select('order.*', 'users.name as sale_name')
                        ->where('order.delete_flg', '0')
                        ->where('order.sale_step', '4')
                        ->whereRaw('order.ord_date between ? AND ?', [$orderFromDate, $orderToDate])
                        ->orderBy($field_name, $order_by)
                        ->offset($page * $rows_per_page)
                        ->limit($rows_per_page)
                        ->get();
        } catch (\Throwable $e) {
            throw $e;
        }
        
        return $data;
    }

    public function getQPReport($page, $sort, $qpFromDate, $qpToDate) {
        try{
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            list($field_name, $order_by) = $this->makeOrderBy($sort, 'qp_id');
            $data = DB::table('quoteprice')
                        ->leftjoin('users', 'quoteprice.sale_id', '=', 'users.id')
                        ->select('quoteprice.*', 'users.name as sale_name')
                        ->where('quoteprice.delete_flg', '0')
                        ->whereRaw('quoteprice.qp_date between ? AND ?', [$qpFromDate, $qpToDate])
                        ->orderBy($field_name, $order_by)
                        ->offset($page * $rows_per_page)
                        ->limit($rows_per_page)
                        ->get();
        } catch (\Throwable $e) {
            throw $e;
        }

        return $data;
    }

    public function countPrdSerials()
    {
        try {
            $count = DB::table('product_series')
                ->where('delete_flg', '0')
                ->where('sold_flg', '0')
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }

        return $count;
    }

    public function countOrders($orderFromDate, $orderToDate)
    {
        try {
            $count = DB::table('order')
                ->where('delete_flg', '0')
                ->where('sale_step', '4')
                ->whereRaw('order.ord_date between ? AND ?', [$orderFromDate, $orderToDate])
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }

        return $count;
    }

    public function sumOrders($orderFromDate, $orderToDate)
    {
        try {
            $sum = DB::table('order')
                ->where('delete_flg', '0')
                ->where('sale_step', '4')
                ->whereRaw('order.ord_date between ? AND ?', [$orderFromDate, $orderToDate])
                ->sum('ord_amount_tax');
        } catch (\Throwable $e) {
            throw $e;
        }

        return $sum;
    }

    public function sumQPs($qpFromDate, $qpToDate)
    {
        try {
            $sum = DB::table('quoteprice')
                ->where('delete_flg', '0')
                ->whereRaw('quoteprice.qp_date between ? AND ?', [$qpFromDate, $qpToDate])
                ->sum('qp_amount_tax');
        } catch (\Throwable $e) {
            throw $e;
        }

        return $sum;
    }

    public function countQP($orderFromDate, $orderToDate)
    {
        try {
            $count = DB::table('qouteprice')
                ->where('delete_flg', '0')
                ->whereRaw('order.ord_date between ? AND ?', [$orderFromDate, $orderToDate])
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }

        return $count;
    }

    public function getPagingInfoRep()
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countPrdSerials();
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function getPagingInfoRev($orderFromDate, $orderToDate)
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countOrders($orderFromDate, $orderToDate);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function getPagingInfoQP($qpFromDate, $qpToDate)
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countOrders($qpFromDate, $qpToDate);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function makeOrderBy($sort, $field_name)
    {
        $order_by = 'asc';
        if ($sort != '') {
            $sort_info = explode('_', $sort);
            $order_by = $sort_info[sizeof($sort_info) - 1];
            unset($sort_info[sizeof($sort_info) - 1]);
            $field_name = implode('_', $sort_info);
        }
        return [$field_name, $order_by];
    }
}
