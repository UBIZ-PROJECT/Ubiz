<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Report;
use App\Exports\ReportRepositoryExport;
use App\Exports\ReportRevenueExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
		try {
            $reportModel = new Report();
            $sum = 0;

            switch ($request->type) {
                case "repository":
                    $viewName = "report-rep";
                    $paging = $reportModel->getPagingInfoRep();
                    break;
                case "revenue":
                    $viewName = "report-rev";
                    $request->order_from_date = date('Y/m') . "/01";
                    $request->order_to_date = date('Y/m/d');
                    $sum = $reportModel->sumOrders($request->order_from_date, $request->order_to_date);
                    $paging = $reportModel->getPagingInfoRev($request->order_from_date, $request->order_to_date);
                    break;
                case "pricing":
                    $viewName = "report-pri";
                    $paging = $reportModel->getPagingInfoPri();
                    break;
                default:
                    $viewName = "report-rep";
                    $paging = $reportModel->getPagingInfoRep();
                    break;
                
            }
            $report = $reportModel->getReportData(0, '', $request);
            $report->sum = $sum;
			$paging['page'] = 0;
            
			return view($viewName, [
                'report' => $report,
                'paging' => $paging
            ]);
		} catch (\Throwable $e) {
            throw $e;
        }
    }

    public function exportExcel(Request $request)
    {
        switch ($request->type) {
            case "revenue":
                return Excel::download(new ReportRevenueExport($request)
                                        , 'reportRevenue.xlsx');
            case "pricing":

            default:
                return Excel::download(new ReportRepositoryExport, 'reportRepository.xlsx');
        }
    }

}
