<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\ReportRepositoryExport\pumpSheet;
use App\Exports\ReportRepositoryExport\pumpKeepSheet;

class ReportRepositoryExport implements WithMultipleSheets
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function sheets(): array
    {
        $prdQueryType = $this->request->prd_query_type == 2 ? $this->request->prd_query_type : 1;

        return [
            new pumpSheet($this->request, $prdQueryType),
            new pumpKeepSheet($this->request, $prdQueryType),
        ];
    }
}
