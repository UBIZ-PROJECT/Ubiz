<?php

namespace App\Imports\ReportRepositoryExImport;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Model\Report;

class AcsExportRepSheet implements ToCollection
{
    public function collection(Collection $rows)
    {
        if ($rows[2][0] != 'PHIẾU XUẤT KHO PHỤ TÙNG') {
            abort(500, __('Invalid file.'));
        }

        $reportModel = new Report();

        foreach ($rows as $index => $row) {
            if ($index < 10) {
                continue;
            }

            if (trim($row[0]) == "" && trim($row[1]) == "") {
                break;
            }

            $reportModel->exportAcsRep(['brd_name' => $row[1], 'prd_name' => $row[2], 'quantity' => (integer) $row[5]]);
        }
        
    }
}