<?php
/**
 * Created by PhpStorm.
 * User: hoait
 * Date: 8/10/2019
 * Time: 7:14 PM
 */

namespace App\Http\Controllers\Common;


use App\Imports\AccessoriesImport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductUpload extends AbstractUpload
{
    const PATH_EXTRACT_ZIP = "E:\Test\Extract";
    const EXCEL_FILE_TYPE = ["xlsx","xls"];
    public function __construct($fileType = "")
    {
        if (empty($fileType)) {
            echo "File type does not specified"; exit;
        }
        $this->setFileType($fileType);
    }

    public function analyzeFile()
    {
        $zip = new \ZipArchive;
        $res = $zip->open($this->getFilePath());
        if ($res === TRUE) {
            if (!file_exists(self::PATH_EXTRACT_ZIP)) {
                mkdir(self::PATH_EXTRACT_ZIP, 0777);
            }
            $zip->extractTo(self::PATH_EXTRACT_ZIP);
            $zip->close();
        } else {
            echo "Can't read the file!";
        }
    }

    private function getListPathFile($dir, &$result = array()) {
        $files = array_values(array_diff(scandir($dir), array('.', '..')));
        foreach($files as $key=>$value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                if (array_search($ext, self::EXCEL_FILE_TYPE) > -1) {
                    if (stripos($path,"pump") > -1) {
                        $result['excel']["pump"] = $path;
                    } else {
                        $result['excel']["accessory"] = $path;
                    }
                } else {
                    $value = trim($value);
                    if (stripos($path,"pump") > -1) {
                        $result['image']["pump"][$value] = $path;
                    } else {
                        $result['image']["accessory"][$value] = $path;
                    }

                }

            } else {
                $this->getListPathFile($path, $result);
            }
        }
        return $result;
    }

    public function getAllFilePathAfterExtract() {
       return $this->getListPathFile(self::PATH_EXTRACT_ZIP);
    }

    public function import($lstPathFile, $typeName){
        if ($typeName == "pump") {
            Excel::import(new ProductsImport($lstPathFile['image'][$typeName]), $lstPathFile['excel'][$typeName]);
        } else if ($typeName == "accessory") {
            Excel::import(new AccessoriesImport($lstPathFile['image'][$typeName]), $lstPathFile['excel'][$typeName]);
        }
    }
}