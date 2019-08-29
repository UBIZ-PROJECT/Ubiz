<?php

namespace App\Imports;

use App\Model\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection
{
    private $imageLst;
    public function __construct($imageLst)
    {
        if (!empty($imageLst)) {
            $this->imageLst = $imageLst;
        }
    }
    /*
     * {
     *      product: [{
     *          brd_id: "01",
     *          name: "abcd",
     *          prd_model: "abcd",
     *          type_id: "1",
     *          prd_unit: "abcd",
     *          prd_note: "abcd",
     *          series: [{
     *              num: "123",
     *              note: "abcd",
     *              date: "30/12/2019"
     *          }]
     *      }],
     *
     * }
     */
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        if (empty($this->imageLst)) {
            return;
        }
        $tempBrandId = 0;
        $tempPrdName = "";
        $index = -1;
        $seriesIndex = 0;
        $products = array();


        foreach ($rows as $row) {
            if ($tempBrandId != $row[1] && $tempPrdName != $row[2]) {
                $tempBrandId = $row[1];
                $tempPrdName = $row[2];
                $index++;
                if ($index > -1 && $row[1] != "" && $row[2] != "") {
                    $products[$index]["images"] = $this->getImagesList($row[0]);
                }
            }

            if (($row[1] == "" && $row[2] == "") || $index == -1) {
                continue;
            }

            $products[$index]['brd_id'] = $row[1];
            $products[$index]["name"] = $row[2];
            $products[$index]["prd_model"] = $row[3];
            $products[$index]["type_id"] = $row[4];
            $products[$index]["prd_unit"] = $row[5];
            $products[$index]["prd_note"] = $row[6];

            $products[$index]["series"][$seriesIndex]["serial_no"] = $row[7];
            $products[$index]["series"][$seriesIndex]["serial_note"] = $row[8];
            $products[$index]["series"][$seriesIndex]["serial_sts"] = "0";
            $seriesIndex++;
        }
        $products = array_values($products);
        $product = new Product();
        foreach ($products as $prd) {
            $product->insertProduct($prd);
        }

    }

    private function getImagesList($imageNameFromFile) {
        $lstImageUpload = array();
        $imagePathList = $this->imageLst;
//        print_r($imagePathList); echo "\n";
        $lstNameImages = explode(",",$imageNameFromFile);
        foreach ($lstNameImages as $index=>$imageName) {
//            print_r($imageName); echo "\n";
            $imageName = trim($imageName);
            $lstImageUpload[$index]['temp_name'] = $imagePathList[$imageName];
            $lstImageUpload[$index]['extension'] = pathinfo($imagePathList[$imageName], PATHINFO_EXTENSION);
        }
//        exit;
        return $lstImageUpload;
    }
}
