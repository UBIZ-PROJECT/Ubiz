<?php

namespace App\Exports;

use App\Model\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportQuotePriceExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
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
                '0' => $row->qp_no,
                '1' => $row->qp_date,
                '2' => $row->qp_exp_date,
                '3' => $row->qp_amount_tax,
                '4' => $row->contact_name,
                '5' => $row->contact_phone,
                '6' => $row->contact_email,
                '7' => $row->sale_name,
            );
        }

        return (collect($reportExportData));
    }

    public function headings(): array
    {
        return [
            'Mã Báo Giá',
            'Ngày Báo Giá',
            'Ngày Hết Hạn',
            'Tổng Tiền (Bao gồm thuế)',
            'Tên Người Liên Hệ',
            'Số ĐT Người Liên Hệ',
            'Email Người Liên Hệ',
            'Sale',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('A2C4C9');;
            },
        ];
    }
}
