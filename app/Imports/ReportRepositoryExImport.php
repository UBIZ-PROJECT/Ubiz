<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\ReportRepositoryExImport\PumpExportRepSheet;
use App\Imports\ReportRepositoryExImport\AcsExportRepSheet;

class ReportRepositoryExImport implements WithMultipleSheets 
{
   
    public function sheets(): array
    {
        return [
            0 => new PumpExportRepSheet(),
            1 => new AcsExportRepSheet(),
        ];
    }
}