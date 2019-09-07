<?php

namespace App\Exports;

use App\Model\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportRevenueExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $request;

    function __construct($request)
    {
        $this->request = $request;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $reportModel = new Report();
        $report = $reportModel->getReportData(0, '', $this->request);

        foreach ($report as $row) {
            $reportExportData[] = array(
                '0' => $row->ord_no,
                '1' => $row->ord_date,
                '2' => $row->ord_rel_fee . ' ₫',
                '3' => $row->ord_amount . ' ₫',
                '4' => $row->cus_name,
                '5' => $row->contact_name,
                '6' => $row->contact_phone,
                '7' => $row->contact_email,
                '8' => $row->sale_name,
            );
        }

        return (collect($reportExportData));
    }

    public function headings(): array
    {
        return [
            'Mã Đơn Hàng',
            'Ngày Đặt Hàng',
            'Chi phí liên quan',
            'Tổng Tiền (cả thuế)',
            'Khách hàng',
            'Tên Người Liên Hệ',
            'Số ĐT Người Liên Hệ',
            'Email Người Liên Hệ',
            'Nhân viên',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('A2C4C9');;
            },
        ];
    }
}
