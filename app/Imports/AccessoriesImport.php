<?php

namespace App\Imports;

use App\Model\Accessory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AccessoriesImport implements ToCollection
{
    private $imageLst;
    public function __construct($imageLst)
    {
        if (!empty($imageLst)) {
            $this->imageLst = $imageLst;
        }
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        if (empty($this->imageLst)) {
            return;
        }
        $accessories = array();
        foreach ($rows as $index=>$row) {
            if (($row[1] == "" && $row[2] == "") || $index == 0) {
                continue;
            }
            $accessories[$index]['brd_id'] = $row[1];
            $accessories[$index]['acs_name'] = $row[2];
            $accessories[$index]['acs_type_id'] = $row[3];
            $accessories[$index]['acs_quantity'] = $row[4];
            $accessories[$index]['acs_unit'] = $row[5];
            $accessories[$index]['acs_note'] = $row[6];
            $accessories[$index]['images'] = $this->getImagesList($row[0]);
        }
        $accessories = array_values($accessories);
        $acc = new Accessory();
        foreach ($accessories as $accessory)
        {
            $acc->insertAccessory($accessory);
        }

    }

    private function getImagesList($imageNameFromFile) {
        $lstImageUpload = array();
        $imagePathList = $this->imageLst;
        $lstNameImages = explode(",",$imageNameFromFile);
        foreach ($lstNameImages as $index=>$imageName) {
            $imageName = trim($imageName);
            $lstImageUpload[$index]['temp_name'] = $imagePathList[$imageName];
            $lstImageUpload[$index]['extension'] = pathinfo($imagePathList[$imageName], PATHINFO_EXTENSION);
        }
        return $lstImageUpload;
    }
}
