<?php

namespace App\Exports;

use App\Model\Event;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportEventExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
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

        $start = $request->get('startStr', null);
        $end = $request->get('endStr', null);
        $tag = $request->get('tag', []);
        $user = $request->get('user', null);

        $start_dt = new \DateTime($start);
        $start_fm = $start_dt->format('Y-m-d H:i:s');

        $end_dt = new \DateTime($end);
        $end_fm = $end_dt->format('Y-m-d H:i:s');

        $eventModel = new Event();
        $eventData = $eventModel->getEvents($start, $end, $tag, $user);

        $eventExportData = [];
        foreach ($eventData as $row) {

            $pic = [];
            if ($row['pic_see_list'] == '1'
                || $row['owner_id'] == Auth::user()->id) {
                
                foreach ($row['pic'] as $item) {
                    $pic[] = $item['name'];
                }
            }

            $eventExportData[] = array(
                '0' => $row->title,
                '1' => $row->start,
                '2' => $row->end,
                '3' => ($row->allDay == '0' ? 'x' : ''),
                '4' => $row->location,
                '5' => $row->tag_title,
                '6' => $row->desc,
                '7' => $row->result,
                '9' => number_format($row->fee),
                '10' => implode(', ', $pic)
            );
        }

        return (collect($eventExportData));
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet
                    ->getDelegate()
                    ->getStyle('A1:H1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('A2C4C9');;
            },
        ];
    }
}
