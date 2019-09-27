<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ReportRepositoryExImport;
use App\Imports\ReportRepositoryImImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Model\Report;

class ReportController extends Controller
{
    public function getReport(Request $request)
    {
        try {
            list($page, $sort) = $this->getRequestData($request);
            $reportModel = new Report();
            $report = $reportModel->getReportData($page, $sort, $request);
            switch ($request->type) {
                case "revenue":
                    $orderFromDate = $request->report_from_date ?? "";
                    $orderToDate = $request->report_to_date ?? date('Y/m/d');
                    $paging = $reportModel->getPagingInfoRev($orderFromDate, $orderToDate, $request->get('cus_name', ''), $request->get('sale_name', ''));
                    $sum = $reportModel->sumOrders($orderFromDate, $orderToDate, $request->get('cus_name', ''), $request->get('sale_name', ''));
                    $totalStartTimeCnt = 0;
                    $totalEndTimeCnt = 0;
                    break;
                case "quoteprice":
                    $qpFromDate = $request->report_from_date ?? "";
                    $qpToDate = $request->report_to_date ?? date('Y/m/d');
                    $paging = $reportModel->getPagingInfoQP($qpFromDate, $qpToDate, $request->get('cus_name', ''), $request->get('sale_name', ''));
                    $sum = $reportModel->sumQPs($qpFromDate, $qpToDate, $request->get('cus_name', ''), $request->get('sale_name', ''));
                    $totalStartTimeCnt = 0;
                    $totalEndTimeCnt = 0;
                    break;
                default:
                    $paging = $reportModel->getPagingInfoRep($request->get('prd_name', ''), $request->get('brd_name', ''), $request->get('prd_query_type', 1));
                    $sum = 0;
                    $totalStartTimeCnt = $report->total_start_time_cnt;
                    $totalEndTimeCnt = $report->total_end_time_cnt;
                    break;
            }
            $paging['page'] = $page;

            return response()->json(['report' => $report, 'report_sum' => $sum, 'total_start_time_cnt' => $totalStartTimeCnt, 'total_end_time_cnt' => $totalEndTimeCnt, 'paging' => $paging, 'type' => $request->type, 'success' => true, 'message' => ''], 200);
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

    public function exportRep(Request $request)
    {
        $file = $request->fileExportRep;
        Excel::import(new ReportRepositoryExImport($request), $file->getRealPath());

        return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
    }

    public function importRep(Request $request)
    {
        $file = $request->fileImportRep;
        Excel::import(new ReportRepositoryImImport($request), $file->getRealPath());

        return response()->json(['success' => true, 'message' => __('Successfully processed.')], 200);
    }
}
