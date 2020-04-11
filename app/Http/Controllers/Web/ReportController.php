<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Report;
use App\Exports\ReportRepositoryExport;
use App\Exports\ReportRevenueExport;
use App\Exports\ReportQuotePriceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
		try {
		    checkUserRight(14, 1);
            $reportModel = new Report();
            $sum = 0;

            switch ($request->type) {
                case "revenue":
                    $viewName = "report-rev";
                    $request->order_from_date = date('Y/m') . "/01";
                    $request->order_to_date = date('Y/m/d');
                    $sum = $reportModel->sumOrders($request->order_from_date, $request->order_to_date, $request->get('cus_name', ''), $request->get('sale_name', ''));
                    $paging = $reportModel->getPagingInfoRev($request->order_from_date, $request->order_to_date, $request->get('cus_name', ''), $request->get('sale_name', ''));
                    break;
                case "quoteprice":
                    $viewName = "report-qp";
                    $request->qp_from_date = date('Y/m') . "/01";
                    $request->qp_to_date = date('Y/m/d');
                    $sum = $reportModel->sumQPs($request->qp_from_date, $request->qp_to_date, $request->get('cus_name',''), $request->get('sale_name', ''));
                    $paging = $reportModel->getPagingInfoQP($request->qp_from_date, $request->qp_to_date, $request->get('cus_name',''), $request->get('sale_name', ''));
                    break;
                default:
                    $viewName = "report-rep";
                    $sum = 0;
                    $paging = $reportModel->getPagingInfoRep($request->get('prd_name', ''), $request->get('brd_name', ''), $request->get('prd_query_type', 1));
                    break;
                
            }
            $report = $reportModel->getReportData(0, '', $request);
            $report->sum = $sum;
            $paging['page'] = 0;
            $report->status = $request->status;
            
			return view($viewName, [
                'report' => $report,
                'paging' => $paging,
                'permission' => Auth::user()->admin
            ]);
		} catch (\Throwable $e) {
            throw $e;
        }
    }

    public function exportExcel($type, Request $request)
    {
        checkUserRight(14, 1);
        switch ($type) {
            case "revenue":
                return Excel::download(new ReportRevenueExport($request), 'reportRevenue.xlsx');
            case "quoteprice":
                return Excel::download(new ReportQuotePriceExport($request), 'reportQuotePrice.xlsx');
            default:
                return Excel::download(new ReportRepositoryExport($request), 'reportRepository.xlsx');
        }
    }
}
