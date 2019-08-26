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
    protected $hidden = [];

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
            case "revenue":
                $orderFromDate = $request->report_from_date ?? date('Y/m') . "/01";
                $orderToDate = $request->report_to_date ?? date('Y/m/d');
                $report = $this->getRevReport($page, $sort, $orderFromDate, $orderToDate, $request->cus_name, $request->sale_name, $request->export_flg);
                break;
            case "quoteprice":
                $qpFromDate = $request->report_from_date ?? date('Y/m') . "/01";
                $qpToDate = $request->report_to_date ?? date('Y/m/d');
                $report = $this->getQPReport($page, $sort, $qpFromDate, $qpToDate, $request->cus_name, $request->sale_name, $request->export_flg);
                break;
            default:
                $prdFromDate = $request->report_from_date ?? date('Y/m') . "/01";
                $prdToDate = $request->report_to_date ?? date('Y/m/d');
                if ($request->get('prd_query_type', 1) == 1) {
                    $report = $this->getRepReport($page, $sort, $prdFromDate, $prdToDate, $request->prd_name, $request->brd_name, $request->export_flg);
                } else {
                    $report = $this->getRepReportAcs($page, $sort, $prdFromDate, $prdToDate, $request->prd_name, $request->brd_name, $request->export_flg);
                }
                break;
        }

        return $report;
    }

    public function getRepReport($page, $sort, $prdFromDate, $prdToDate, $prdName, $brdName, $exportFlg)
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            list($field_name, $order_by) = $this->makeOrderBy($sort, 'prd_id');
            $data = DB::table('product')
                ->leftJoin('product_series', function ($join) {
                    $join->on('product.prd_id', '=', 'product_series.prd_id')
                        ->where('product_series.delete_flg', '0')
                        ->whereNull('product_series.export_date');
                })
                ->leftJoin('brand', 'product.brd_id', '=', 'brand.brd_id')
                ->select('product.*', 'brand.brd_name')
                ->selectRaw("GROUP_CONCAT(product_series.serial_no SEPARATOR ', ') as serial_no_list")
                ->groupBy('product.prd_id')
                ->where('product.delete_flg', '0')
                ->when($prdName, function ($query) use ($prdName) {
                    if ($prdName) {
                        return $query->where('product.prd_name', $prdName);
                    }
                })
                ->when($brdName, function ($query) use ($brdName) {
                    if ($brdName) {
                        return $query->where('brand.brd_name', $brdName);
                    }
                })
                ->whereRaw('product_series.export_date is null OR product_series.export_date > ?', [$prdToDate])
                ->orderBy($field_name, $order_by)
                ->when($exportFlg, function () { }, function ($query) use ($rows_per_page, $page) {
                    return $query->limit($rows_per_page)->offset($page * $rows_per_page);
                })
                ->get();

            $data->total_start_time_cnt = 0;
            $data->total_end_time_cnt = 0;
            foreach ($data as $key => $item) {
                $importCount = DB::table('product')
                    ->leftJoin('product_series', 'product.prd_id', '=', 'product_series.prd_id')
                    ->where('product.prd_id', $item->prd_id)
                    ->whereRaw('product_series.inp_date between ? AND ?', [$prdFromDate, $prdToDate])
                    ->where('product.delete_flg', '0')
                    ->count();
                $exportCount = DB::table('product')
                    ->leftJoin('product_series', 'product.prd_id', '=', 'product_series.prd_id')
                    ->where('product.prd_id', $item->prd_id)
                    ->whereRaw('product_series.export_date between ? AND ?', [$prdFromDate, $prdToDate])
                    ->where('product.delete_flg', '0')
                    ->count();
                $endTimePrdCnt = DB::table('product_series')
                    ->where('product_series.prd_id', $item->prd_id)
                    ->whereRaw('product_series.export_date is null OR product_series.export_date > ?', [$prdToDate])
                    ->count();
                $startTimePrdCnt = $endTimePrdCnt - $importCount + $exportCount;
                $keepPrdCnt = DB::table('product_series')
                    ->where('product_series.prd_id', $item->prd_id)
                    ->where('product_series.serial_sts', '1')
                    ->whereRaw('product_series.serial_expired_date > now()')
                    ->whereRaw('product_series.export_date is null OR product_series.export_date > ?', [$prdToDate])
                    ->count();

                $data[$key]->import_cnt = (string) $importCount;
                $data[$key]->export_cnt = (string) $exportCount;
                $data[$key]->start_time_cnt = (string) $startTimePrdCnt;
                $data[$key]->end_time_cnt = (string) $endTimePrdCnt;
                $data->total_start_time_cnt += (string) $startTimePrdCnt;
                $data->total_end_time_cnt += (string) $endTimePrdCnt;
                $data[$key]->keep_prd_cnt = (string) $keepPrdCnt;
            }
        } catch (\Throwable $e) {
            throw $e;
        }

        return $data;
    }

    public function getRepReportAcs($page, $sort, $prdFromDate, $prdToDate, $prdName, $brdName, $exportFlg)
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            list($field_name, $order_by) = $this->makeOrderBy($sort, 'acs_id');
            $data = DB::table('accessory')
                ->leftJoin('brand', 'accessory.brd_id', '=', 'brand.brd_id')
                ->select('accessory.acs_id as prd_id', 'accessory.acs_name as prd_name', 'accessory.acs_unit as prd_unit', 'accessory.acs_quantity as prd_quantity', 'accessory.acs_note as prd_note', 'brand.brd_name')
                ->where('accessory.delete_flg', '0')
                ->when($prdName, function ($query) use ($prdName) {
                    if ($prdName) {
                        return $query->where('accessory.acs_name', $prdName);
                    }
                })
                ->when($brdName, function ($query) use ($brdName) {
                    if ($brdName) {
                        return $query->where('brand.brd_name', $brdName);
                    }
                })
                ->orderBy($field_name, $order_by)
                ->when($exportFlg, function () { }, function ($query) use ($rows_per_page, $page) {
                    return $query->limit($rows_per_page)->offset($page * $rows_per_page);
                })
                ->get();

            $data->total_start_time_cnt = 0;
            $data->total_end_time_cnt = 0;
            foreach ($data as $key => $item) {
                $importCount = DB::table('accessory')
                    ->leftJoin('accessory_in_out', 'accessory.acs_id', '=', 'accessory_in_out.acs_id')
                    ->where('accessory.acs_id', $item->prd_id)
                    ->whereRaw('accessory_in_out.acs_io_date between ? AND ?', [$prdFromDate, $prdToDate])
                    ->where('accessory.delete_flg', '0')
                    ->where('accessory_in_out.acs_io_type', '1')
                    ->sum('accessory_in_out.acs_io_quantity');
                $exportCount = DB::table('accessory')
                    ->leftJoin('accessory_in_out', 'accessory.acs_id', '=', 'accessory_in_out.acs_id')
                    ->where('accessory.acs_id', $item->prd_id)
                    ->whereRaw('accessory_in_out.acs_io_date between ? AND ?', [$prdFromDate, $prdToDate])
                    ->where('accessory.delete_flg', '0')
                    ->where('accessory_in_out.acs_io_type', '2')
                    ->sum('accessory_in_out.acs_io_quantity');
                $importCountAfter = DB::table('accessory')
                    ->leftJoin('accessory_in_out', 'accessory.acs_id', '=', 'accessory_in_out.acs_id')
                    ->where('accessory.acs_id', $item->prd_id)
                    ->whereRaw('accessory_in_out.acs_io_date > ?', [$prdToDate])
                    ->where('accessory.delete_flg', '0')
                    ->where('accessory_in_out.acs_io_type', '1')
                    ->sum('accessory_in_out.acs_io_quantity');
                $exportCountAfter = DB::table('accessory')
                    ->leftJoin('accessory_in_out', 'accessory.acs_id', '=', 'accessory_in_out.acs_id')
                    ->where('accessory.acs_id', $item->prd_id)
                    ->whereRaw('accessory_in_out.acs_io_date > ?', [$prdToDate])
                    ->where('accessory.delete_flg', '0')
                    ->where('accessory_in_out.acs_io_type', '2')
                    ->sum('accessory_in_out.acs_io_quantity');
                $endTimePrdCnt = $item->prd_quantity - $importCountAfter + $exportCountAfter;
                $startTimePrdCnt = $endTimePrdCnt - $importCount + $exportCount;
                $keepPrdCnt = DB::table('accessory_keeper')
                    ->where('acs_id', $item->prd_id)
                    ->whereRaw('expired_date > now()')
                    ->where('delete_flg', '0')
                    ->sum('quantity');

                $data[$key]->import_cnt = (string) $importCount;
                $data[$key]->export_cnt = (string) $exportCount;
                $data[$key]->start_time_cnt = (string) $startTimePrdCnt;
                $data[$key]->end_time_cnt = (string) $endTimePrdCnt;
                $data->total_start_time_cnt += (string) $startTimePrdCnt;
                $data->total_end_time_cnt += (string) $endTimePrdCnt;
                $data[$key]->keep_prd_cnt = (string) $keepPrdCnt;
            }
        } catch (\Throwable $e) {
            throw $e;
        }

        return $data;
    }

    public function getRevReport($page, $sort, $orderFromDate, $orderToDate, $customerName, $saleName, $exportFlg)
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            list($field_name, $order_by) = $this->makeOrderBy($sort, 'ord_id');
            $data = DB::table('order')
                ->leftjoin('users', 'order.sale_id', '=', 'users.id')
                ->leftjoin('customer', 'order.cus_id', '=', 'customer.cus_id')
                ->select('order.*', 'users.name as sale_name', 'customer.cus_name')
                ->selectRaw('FORMAT(order.ord_amount + order.ord_rel_fee, 0) as ord_amount')
                ->selectRaw('FORMAT(order.ord_rel_fee, 0) as ord_rel_fee')
                ->selectRaw('DATE_FORMAT(order.ord_date, "%Y/%m/%d") as ord_date')
                ->where('order.delete_flg', '0')
                ->where('order.sale_step', '4')
                ->whereRaw('order.ord_date between ? AND ?', [$orderFromDate, $orderToDate])
                ->when($customerName, function ($query) use ($customerName) {
                    if ($customerName) {
                        return $query->where('cus_name', $customerName);
                    }
                })
                ->when($saleName, function ($query) use ($saleName) {
                    if ($saleName) {
                        return $query->where('users.name', $saleName);
                    }
                })
                ->orderBy($field_name, $order_by)
                ->when($exportFlg, function () { }, function ($query) use ($rows_per_page, $page) {
                    return $query->limit($rows_per_page)->offset($page * $rows_per_page);
                })
                ->get();
        } catch (\Throwable $e) {
            throw $e;
        }
        
        return $data;
    }

    public function getQPReport($page, $sort, $qpFromDate, $qpToDate, $customerName, $saleName, $exportFlg)
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            list($field_name, $order_by) = $this->makeOrderBy($sort, 'qp_id');
            $data = DB::table('quoteprice')
                ->leftjoin('users', 'quoteprice.sale_id', '=', 'users.id')
                ->leftjoin('customer', 'quoteprice.cus_id', '=', 'customer.cus_id')
                ->select('quoteprice.*', 'users.name as sale_name', 'customer.cus_name')
                ->selectRaw('FORMAT(quoteprice.qp_amount_tax, 0) as qp_amount_tax')
                ->selectRaw('DATE_FORMAT(quoteprice.qp_date, "%Y/%m/%d") as qp_date')
                ->selectRaw('DATE_FORMAT(quoteprice.qp_exp_date, "%Y/%m/%d") as qp_exp_date')
                ->where('quoteprice.delete_flg', '0')
                ->whereRaw('quoteprice.qp_date between ? AND ?', [$qpFromDate, $qpToDate])
                ->when($customerName, function ($query) use ($customerName) {
                    if ($customerName) {
                        return $query->where('cus_name', $customerName);
                    }
                })
                ->when($saleName, function ($query) use ($saleName) {
                    if ($saleName) {
                        return $query->where('users.name', $saleName);
                    }
                })
                ->orderBy($field_name, $order_by)
                ->when($exportFlg, function () { }, function ($query) use ($rows_per_page, $page) {
                    return $query->limit($rows_per_page)->offset($page * $rows_per_page);
                })
                ->get();
        } catch (\Throwable $e) {
            throw $e;
        }

        return $data;
    }

    public function countPrd($prdName, $brdName)
    {
        try {
            $count = DB::table('product')
                ->leftjoin('brand', 'product.brd_id', '=', 'brand.brd_id')
                ->when($prdName, function ($query) use ($prdName) {
                    if ($prdName) {
                        return $query->where('product.prd_name', $prdName);
                    }
                })
                ->when($brdName, function ($query) use ($brdName) {
                    if ($brdName) {
                        return $query->where('brand.brd_name', $brdName);
                    }
                })
                ->where('product.delete_flg', '0')
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }

        return $count;
    }

    public function countAcs($prdName, $brdName)
    {
        try {
            $count = DB::table('accessory')
                ->leftjoin('brand', 'accessory.brd_id', '=', 'brand.brd_id')
                ->when($prdName, function ($query) use ($prdName) {
                    if ($prdName) {
                        return $query->where('accessory.acs_name', $prdName);
                    }
                })
                ->when($brdName, function ($query) use ($brdName) {
                    if ($brdName) {
                        return $query->where('brand.brd_name', $brdName);
                    }
                })
                ->where('accessory.delete_flg', '0')
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }

        return $count;
    }

    public function countOrders($orderFromDate, $orderToDate, $customerName, $saleName)
    {
        try {
            $count = DB::table('order')
                ->leftjoin('users', 'order.sale_id', '=', 'users.id')
                ->leftjoin('customer', 'order.cus_id', '=', 'customer.cus_id')
                ->where('order.delete_flg', '0')
                ->where('order.sale_step', '4')
                ->whereRaw('order.ord_date between ? AND ?', [$orderFromDate, $orderToDate])
                ->when($customerName, function ($query) use ($customerName) {
                    if ($customerName) {
                        return $query->where('cus_name', $customerName);
                    }
                })
                ->when($saleName, function ($query) use ($saleName) {
                    if ($saleName) {
                        return $query->where('users.name', $saleName);
                    }
                })
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }

        return $count;
    }

    public function sumOrders($orderFromDate, $orderToDate, $customerName, $saleName)
    {
        try {
            $sum = DB::table('order')
                ->leftjoin('users', 'order.sale_id', '=', 'users.id')
                ->leftjoin('customer', 'order.cus_id', '=', 'customer.cus_id')
                ->where('order.delete_flg', '0')
                ->where('order.sale_step', '4')
                ->whereRaw('order.ord_date between ? AND ?', [$orderFromDate, $orderToDate])
                ->when($customerName, function ($query) use ($customerName) {
                    if ($customerName) {
                        return $query->where('cus_name', $customerName);
                    }
                })
                ->when($saleName, function ($query) use ($saleName) {
                    if ($saleName) {
                        return $query->where('users.name', $saleName);
                    }
                })
                ->sum(DB::raw('order.ord_amount + order.ord_rel_fee'));
            $sum = number_format($sum);
        } catch (\Throwable $e) {
            throw $e;
        }

        return $sum;
    }

    public function countQPs($qpFromDate, $qpToDate, $customerName, $saleName)
    {
        try {
            $count = DB::table('quoteprice')
                ->leftjoin('users', 'quoteprice.sale_id', '=', 'users.id')
                ->leftjoin('customer', 'quoteprice.cus_id', '=', 'customer.cus_id')
                ->where('quoteprice.delete_flg', '0')
                ->whereRaw('quoteprice.qp_date between ? AND ?', [$qpFromDate, $qpToDate])
                ->when($customerName, function ($query) use ($customerName) {
                    if ($customerName) {
                        return $query->where('cus_name', $customerName);
                    }
                })
                ->when($saleName, function ($query) use ($saleName) {
                    if ($saleName) {
                        return $query->where('users.name', $saleName);
                    }
                })
                ->count();
        } catch (\Throwable $e) {
            throw $e;
        }

        return $count;
    }

    public function sumQPs($qpFromDate, $qpToDate, $customerName, $saleName)
    {
        try {
            $sum = DB::table('quoteprice')
                ->leftjoin('users', 'quoteprice.sale_id', '=', 'users.id')
                ->leftjoin('customer', 'quoteprice.cus_id', '=', 'customer.cus_id')
                ->where('quoteprice.delete_flg', '0')
                ->whereRaw('quoteprice.qp_date between ? AND ?', [$qpFromDate, $qpToDate])
                ->when($customerName, function ($query) use ($customerName) {
                    if ($customerName) {
                        return $query->where('cus_name', $customerName);
                    }
                })
                ->when($saleName, function ($query) use ($saleName) {
                    if ($saleName) {
                        return $query->where('users.name', $saleName);
                    }
                })
                ->sum('qp_amount_tax');
            $sum = number_format($sum);
        } catch (\Throwable $e) {
            throw $e;
        }

        return $sum;
    }

    public function getKeepPrd($brdName, $prdName, $prdToDate)
    {
        $data = DB::table('product_series')
            ->leftJoin('product', function ($join) {
                $join->on('product.prd_id', '=', 'product_series.prd_id')
                    ->where('product.delete_flg', '0');
            })
            ->leftJoin('brand', 'product.brd_id', '=', 'brand.brd_id')
            ->leftJoin('users', 'product_series.serial_keeper', '=', 'users.id')
            ->select('product.prd_name', 'brand.brd_name', 'product_series.*', 'users.name as keeper')
            ->where('product.delete_flg', '0')
            ->when($prdName, function ($query) use ($prdName) {
                if ($prdName) {
                    return $query->where('product.prd_name', $prdName);
                }
            })
            ->when($brdName, function ($query) use ($brdName) {
                if ($brdName) {
                    return $query->where('brand.brd_name', $brdName);
                }
            })
            ->where('product_series.serial_sts', '1')
            ->whereRaw('product_series.serial_expired_date > now()')
            ->whereRaw('product_series.export_date is null OR product_series.export_date > ?', [$prdToDate])
            ->orderBy('prd_id')
            ->get();

        return $data;
    }

    public function getKeepAcs($brdName, $prdName)
    {
        $data = DB::table('accessory_keeper')
                    ->leftJoin('accessory', function ($join) {
                        $join->on('accessory.acs_id', '=', 'accessory_keeper.acs_id')
                            ->where('accessory.delete_flg', '0');
                    })
                    ->leftJoin('brand', 'accessory.brd_id', '=', 'brand.brd_id')
                    ->leftJoin('users', 'accessory_keeper.keeper', '=', 'users.id')
                    ->select('brand.brd_name', 'accessory.acs_name as prd_name', 'users.name as keeper', 'accessory_keeper.inp_date as acs_keep_date', 'accessory_keeper.expired_date as acs_expired_date', 'accessory_keeper.quantity', 'accessory_keeper.note as acs_note')
                    ->when($prdName, function ($query) use ($prdName) {
                        if ($prdName) {
                            return $query->where('accessory.acs_name', $prdName);
                        }
                    })
                    ->when($brdName, function ($query) use ($brdName) {
                        if ($brdName) {
                            return $query->where('brand.brd_name', $brdName);
                        }
                    })
                    ->whereRaw('expired_date > now()')
                    ->where('accessory_keeper.delete_flg', '0')
                    ->orderBy('accessory_keeper.acs_id')
                    ->get();

        return $data;
    }

    public function getPagingInfoRep($prdName, $brdName, $prdQueryType)
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            if ($prdQueryType == 1) {
                $rows_num = $this->countPrd($prdName, $brdName);
            } else {
                $rows_num = $this->countAcs($prdName, $brdName);
            }
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function getPagingInfoRev($orderFromDate, $orderToDate, $customerName, $saleName)
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countOrders($orderFromDate, $orderToDate, $customerName, $saleName);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function getPagingInfoQP($qpFromDate, $qpToDate, $customerName, $saleName)
    {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countQPs($qpFromDate, $qpToDate, $customerName, $saleName);
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
