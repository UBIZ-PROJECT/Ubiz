<?php

namespace App\Exports;

use App\Model\Event;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportEventExport implements FromCollection,
    WithHeadings,
    WithEvents,
    ShouldAutoSize,
    WithColumnFormatting,
    WithMapping
{
    protected $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'Tiêu đề',
            'Bắt đầu',
            'Kết thúc',
            'Cả ngày',
            'Địa điểm',
            'Thẻ',
            'Nội dung',
            'Kết quả',
            'Chi phí',
            'Người phụ trách'
        ];
    }

    public function collection()
    {
        $start = $this->request->get('start', null);
        $end = $this->request->get('end', null);
        $tag = $this->request->get('tag', []);
        $user = $this->request->get('user', []);
        $view = $this->request->get('view', 'dayGridMonth');

        $start_dt = new \DateTime($start);
        $start_fm = $start_dt->format('Y-m-d');

        $end_dt = new \DateTime($end);
        $end_fm = $end_dt->format('Y-m-d');

        $eventModel = new Event();
        $eventData = $eventModel->getEvents($start, $end, $tag, $view, $user);

        $eventExportData = [];
        foreach ($eventData as $row) {

            $pic = [];
            if ($row['pic_see_list'] == '1'
                || $row['owner_id'] == Auth::user()->id
            ) {

                foreach ($row['pic'] as $item) {
                    $pic[] = $item['name'];
                }
            }

            $start_dt = new \DateTime($row['start']);
            $start_fm = $start_dt->format('Y-m-d g:i A');

            $end_dt = new \DateTime($row['end']);
            $end_fm = $end_dt->format('Y-m-d g:i A');

            $eventExportData[] = array(
                'title' => $row['title'],
                'start' => $start_fm,
                'end' => $end_fm,
                'allDay' => ($row['allDay'] == '0' ? 'x' : ''),
                'location' => $row['location'],
                'tag_title' => $row['tag_title'],
                'desc' => $row['desc'],
                'result' => $row['result'],
                'fee' => $row['fee'],
                'pic' => implode(', ', $pic)
            );
        }

        return (collect($eventExportData));
    }

    public function map($event): array
    {
        $a = 0;
        return [
            $event['title'],
            $event['start'],
            $event['end'],
            $event['allDay'],
            $event['location'],
            $event['tag_title'],
            $event['desc'],
            $event['result'],
            $event['fee'],
            $event['pic']
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => 'yyyy-mm-dd h:mm AM/PM',
            'C' => 'yyyy-mm-dd h:mm AM/PM',
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => '#,##0',
            'J' => NumberFormat::FORMAT_TEXT
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet
                    ->getDelegate()
                    ->getStyle('A1:J1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('A2C4C9');

                $event->sheet
                    ->getDelegate()
                    ->getStyle('B1:B' . $event->sheet->getDelegate()->getHighestDataRow())
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $event->sheet
                    ->getDelegate()
                    ->getStyle('C1:C' . $event->sheet->getDelegate()->getHighestDataRow())
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $event->sheet
                    ->getDelegate()
                    ->getStyle('D1:D' . $event->sheet->getDelegate()->getHighestDataRow())
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet
                    ->getDelegate()
                    ->getStyle('I1:I' . $event->sheet->getDelegate()->getHighestDataRow())
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            },
        ];
    }
}
