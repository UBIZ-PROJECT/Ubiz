<?php

namespace App\Exports;

use App\Model\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ReportQuotePriceExport
    extends DefaultValueBinder
    implements WithCustomValueBinder,
    FromCollection,
    WithHeadings,
    WithEvents,
    ShouldAutoSize
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
                '3' => $row->qp_amount_tax . ' ₫',
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
            'Mã Báo Giá',
            'Ngày Báo Giá',
            'Ngày Hết Hạn',
            'Tổng Tiền (cả thuế)',
            'Khách hàng',
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
                $event->sheet->getDelegate()->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('A2C4C9');;
            },
        ];
    }

    public function bindValue(Cell $cell, $value)
    {

        $row = $cell->getRow();
        $col = $cell->getColumn();
        if ($value != '' && ($col == 'G' || $col == 'H') && $row > 1) {
            $html = str_get_html("<p><strong>BƠM ĐỊNH LƯỢNG DOSEURO</strong><br />- Model: D-100N-70/C-13 DC<br /><strong>Th&ocirc;ng số kỹ thuật:</strong><br />- Lưu lượng tối đa:146 l&iacute;t/ giờ<br />- &Aacute;p suất tối đa: 5 Kg/cm2 <br />- Chất bơm: n/a<br />- Độ nhớt: n/a<br />- Nhiệt độ chất bơm: m&ocirc;i trường<br />- Tỷ trọng: n/a<br />- Đường k&iacute;nh m&agrave;ng: 70 mm<br />- Cổng kết nối: 1/2&rdquo;G.m <br /><strong>Vật liệu chi tiết:</strong><br />- Đầu bơm: PVC<br />- M&agrave;ng bơm: PTFE/NBR<br />- Valve (ball): PYREX<br />- Valve seat: PVC<br />- Valve gasket: FPM<br /><strong>Th&ocirc;ng tin phần dẫn động:</strong><br />- C&ocirc;ng suất: 0.18 kW<br />- Tốc đ&ocirc;̣ quay: 1400 Vòng/phút<br />- Điện áp: 380V/3 pha/50 Hz<br />- Cấp bảo vệ: IP55<br />- Cấp chịu nhiệt: F<br />Xuất xứ : ITALIA</p>");
            $value = $this->htmlToRichText($html);
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function htmlToRichText($html)
    {
        $mceText = [];
        foreach ($html->nodes as $node) {

            if ($node->tag == 'root')
                continue;

            switch ($node->tag) {
                case'text'://text
                    $type = 'text';
                    if ($node->parent->tag == 'strong') {
                        $type = 'bold';
                    }

                    $value = html_entity_decode($node->text());
                    $mceText[] = [
                        'type' => $type,
                        'value' => $value
                    ];
                    break;
                case'br'://br
                    $mceText[] = [
                        'type' => 'br',
                        'value' => "\n"
                    ];
                    break;
            }
        }

        if (sizeof($mceText) == 0)
            return null;

        $richText = new RichText();
        $richText->createText('');

        foreach ($mceText as $text) {

            $textType = $text['type'];
            $textValue = $text['value'];

            if ($textType == 'bold') {
                $boldText = $richText->createTextRun($textValue);
                $boldText->getFont()->setBold(true);
            } else {
                $richText->createText($textValue);
            }
        }

        return $richText;

    }
}
