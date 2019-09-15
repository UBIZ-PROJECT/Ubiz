<?php

namespace App\Imports\ReportRepositoryExImport;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Model\Report;

class AcsExportRepSheet implements ToCollection
{
    public function collection(Collection $rows)
    {
        $reportModel = new Report();

        foreach ($rows as $index => $row) {
            if ($index < 10) {
                continue;
            }

            if ($row[0] == "" && $row[1] == "") {
                break;
            }

            $reportModel->exportAcsRep(['brd_name' => $row[1], 'prd_name' => $row[2], 'quantity' => (integer) $row[5]]);
        }
        
    }
}