<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Report;

class ReportController extends Controller
{
    public function getReport(Request $request)
    {
		try {
            list($page, $sort) = $this->getRequestData($request);
			$reportModel = new Report();
            $report = $reportModel->getReportData($page, $sort, $request);
            if ($request->type == "revenue") {
                $orderFromDate = $request->report_from_date ? $request->report_from_date : "";
                $orderToDate = $request->report_to_date ? $request->report_to_date : date('Y/m/d');
                $paging = $reportModel->getPagingInfoRev($orderFromDate, $orderToDate);
                $sum = $reportModel->sumOrders($orderFromDate, $orderToDate);
            } elseif ($request->type == "quoteprice") {
                $qpFromDate = $request->report_from_date ? $request->report_from_date : "";
                $qpToDate = $request->report_to_date ? $request->report_to_date : date('Y/m/d');
                $paging = $reportModel->getPagingInfoQP($qpFromDate, $qpToDate);
                $sum = $reportModel->sumQPs($qpFromDate, $qpToDate);
            } else {
                $paging = $reportModel->getPagingInfoRep();
                $sum = 0;
            }
			$paging['page'] = $page;
            
			return response()->json(['report' => $report, 'report_sum' => $sum, 'paging' => $paging, 'type' => $request->type, 'success' => true, 'message' => ''], 200);
		} catch (\Throwable $e) {
            throw $e;
        }
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
       
        return [$page, $sort];
    }
}
