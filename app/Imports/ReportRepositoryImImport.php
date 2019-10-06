<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\ReportRepositoryImImport\PumpImportRepSheet;
use App\Imports\ReportRepositoryImImport\AcsImportRepSheet;

class ReportRepositoryImImport implements WithMultipleSheets 
{
   
    public function sheets(): array
    {
        return [
            0 => new PumpImportRepSheet(),
            1 => new AcsImportRepSheet(),
        ];
    }
}