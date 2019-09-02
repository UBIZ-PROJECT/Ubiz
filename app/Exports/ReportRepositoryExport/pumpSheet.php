<?php

namespace App\Exports\ReportRepositoryExport;

use App\Model\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class pumpSheet implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize, WithTitle
{
    private $request;
    private $prdTypeFlg;

    public function __construct($request, $prdTypeFlg = 1)
    {
        $this->request = $request;
        $this->prdTypeFlg = $prdTypeFlg;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $reportModel = new Report();
        $this->request->export_flg = 1;
        $this->request->prd_type_flg = $this->prdTypeFlg;
        $report = $reportModel->getReportData(0, '', $this->request);
        $reportExportData = [];

        foreach ($report as $row) {
            if ($this->prdTypeFlg == 1) {
                $reportExportData[] = array(
                    '0' => $row->brd_name,
                    '1' => $row->prd_name,
                    '2' => $row->prd_unit,
                    '3' => (string) $row->start_time_cnt,
                    '4' => (string) $row->import_cnt,
                    '5' => (string) $row->export_cnt,
                    '6' => (string) $row->start_time_cnt,
                    '7' => (string) $row->keep_prd_cnt,
                    '8' => $row->serial_no_list,
                    '9' => $row->prd_note,
                );
            } else {
                $reportExportData[] = array(
                    '0' => $row->brd_name,
                    '1' => $row->prd_name,
                    '2' => $row->prd_unit,
                    '3' => (string) $row->start_time_cnt,
                    '4' => (string) $row->import_cnt,
                    '5' => (string) $row->export_cnt,
                    '6' => (string) $row->start_time_cnt,
                    '7' => (string) $row->keep_prd_cnt,
                    '8' => $row->prd_note,
                );
            }
        }

        return (collect($reportExportData));
    }

    /**
     * @return string
     */
    public function title(): string
    {
        if ($this->prdTypeFlg == 2) {
            return 'Phụ tùng';
        }
        
        return 'Bơm';
    }

    public function headings(): array
    {
        if ($this->prdTypeFlg == 2) {
            return [
                'Hãng bơm',
                'Tên hàng hoá',
                'Đơn vị tính',
                'Tồn đầu kì',
                'Nhập kho',
                'Xuất kho',
                'Tồn cuối kì',
                'số lượng giữ',
                'Ghi chú',
            ];
        }

        return [
            'Hãng bơm',
            'Tên hàng hoá',
            'Đơn vị tính',
            'Tồn đầu kì',
            'Nhập kho',
            'Xuất kho',
            'Tồn cuối kì',
            'số lượng giữ',
            'Series',
            'Ghi chú',
        ]; 
    }

    public function registerEvents(): array
    {
        if ($this->prdTypeFlg == 2) {
            return [
                AfterSheet::class => function (AfterSheet $event) {
                    $event->sheet->getDelegate()->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('A2C4C9');;
                },
            ];
        }

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('A2C4C9');;
            },
        ];
    }
}