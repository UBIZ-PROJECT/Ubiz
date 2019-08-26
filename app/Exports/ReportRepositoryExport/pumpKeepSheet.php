<?php

namespace App\Exports\ReportRepositoryExport;

use App\Model\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class pumpKeepSheet implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize, WithTitle
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
        if ($this->prdTypeFlg == 1) {
            $report = $reportModel->getKeepPrd($this->request->brd_name, $this->request->prd_name, $this->request->report_to_date);
        } else {
            $report = $reportModel->getKeepAcs($this->request->brd_name, $this->request->prd_name);
        }
        $reportExportData = [];

        foreach ($report as $row) {
            if ($this->prdTypeFlg == 1) {
                $reportExportData[] = array(
                    '0' => $row->brd_name,
                    '1' => $row->prd_name,
                    '2' => $row->serial_no,
                    '3' => $row->keeper,
                    '4' => \Carbon\Carbon::parse($row->serial_keep_date)->format('d/m/Y'),
                    '5' => \Carbon\Carbon::parse($row->serial_expired_date)->format('d/m/Y'),
                    '6' => $row->serial_note,
                );
            } else {
                $reportExportData[] = array(
                    '0' => $row->brd_name,
                    '1' => $row->prd_name,
                    '2' => $row->quantity,
                    '3' => $row->keeper,
                    '4' => \Carbon\Carbon::parse($row->acs_keep_date)->format('d/m/Y'),
                    '5' => \Carbon\Carbon::parse($row->acs_expired_date)->format('d/m/Y'),
                    '6' => $row->acs_note,
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
            return 'Giữ hàng phụ tùng';
        }

        return 'Giữ Hàng Bơm';
    }

    public function headings(): array
    {
        if ($this->prdTypeFlg == 2) {
            return [
                'Hãng bơm',
                'Tên hàng hoá',
                'Nhân viên',
                'Số lượng',
                'Ngày giữ',
                'Ngày hết hạn',
                'Ghi chú',
            ];
        }

        return [
            'Hãng bơm',
            'Tên hàng hoá',
            'Series',
            'Nhân viên',
            'Ngày giữ',
            'Ngày hết hạn',
            'Ghi chú',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('A2C4C9');;
            },
        ];
    }
}