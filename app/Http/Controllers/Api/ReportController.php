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
                $orderFromDate = $request->order_from_date ? $request->order_from_date : "";
                $orderToDate = $request->order_to_date ? $request->order_to_date : date('Y/m/d');
                $paging = $reportModel->getPagingInfoRev($orderFromDate, $orderToDate);
                $sum = $reportModel->sumOrders($orderFromDate, $orderToDate);
            } elseif ($request->type == "pricing") {
                //todo
            } else {
                $paging = $reportModel->getPagingInfoRep();
            }
			$paging['page'] = $page;

			return response()->json(['report' => $report, 'order_sum' => $sum, 'paging' => $paging, 'type' => $request->type, 'success' => true, 'message' => ''], 200);
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
