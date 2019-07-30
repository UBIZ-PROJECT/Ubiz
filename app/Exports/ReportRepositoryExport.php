<?php

namespace App\Exports;

use App\Model\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportRepositoryExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $reportModel = new Report();
        $report = $reportModel->getReportData(0, '', 'repository');

        foreach ($report as $row) {
            $reportExportData[] = array(
                '0' => $row->prd_id,
                '1' => $row->prd_name,
                '2' => $row->prd_type_name,
                '3' => $row->brd_name,
                '4' => $row->serial_no,
                '5' => $row->serial_sts,
                '6' => $row->serial_note,
            );
        }

        return (collect($reportExportData));
    }

    public function headings(): array
    {
        return [
            'Mã Sản Phẩm',
            'Tên Sản Phẩm',
            'Loại Sản Phẩm',
            'Thương Hiệu',
            'Số Seri',
            'Trạng Thái',
            'Ghi chú',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('A2C4C9');;
            },
        ];
    }
}
