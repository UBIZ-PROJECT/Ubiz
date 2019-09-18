<?php

namespace App\Imports\ReportRepositoryImImport;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Model\Report;

class AcsImportRepSheet implements ToCollection
{
    public function collection(Collection $rows)
    {
        $reportModel = new Report();

        foreach ($rows as $index => $row) {
            if ($index < 10) {
                continue;
            }

            if (trim($row[0]) == "" && trim($row[1]) == "") {
                break;
            }

            $reportModel->importAcsRep(['brd_name' => $row[1], 'prd_name' => $row[2], 'quantity' => (integer) $row[4]]);
        }

    }
}