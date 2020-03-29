<?php
/**
 * Created by PhpStorm.
 * User: hoait
 * Date: 10/2/2019
 * Time: 9:39 PM
 */

namespace App\Exports;


use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\PHPWord_Template;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;

class ContractExport
{
    private $FILE_PATH = "";
    private $exportFileName = "";
    public function __construct()
    {
        $this->FILE_PATH = dirname(__FILE__) . "/Template/";
    }

    public function execute($data, $fileName, $type) {
        $phpWord = new PhpWord();
//        print_r($this->FILE_PATH + $fileName); exit;
        $document = $phpWord->loadTemplate($this->FILE_PATH . $fileName);
        $this->cloneRowAndSetValues($document,"spec", $data->lstData);
        $document->setValue("address", $data->cus_addr);
        $document->setValue("phone",$data->contact_phone);
        $document->setValue("fax", $data->cus_fax);
        $document->setValue("rank",$data->contact_rank);
        $document->setValue("name", $data->contact_name);
        $document->setValue("tax",$data->tax);
        $document->setValue("totalBeforeTax",$data->totalBeforeTax);
        $document->setValue("taxAmount",$data->taxAmount);
        $document->setValue("totalAfterTax",$data->totalAfterTax);
        $currentDate = date('Y-m-d-H-i-s');
        $this->exportFileName =  "export-contract-" . $type . "-" . $currentDate . ".docx";
        $document->saveAs($this->FILE_PATH . $this->exportFileName);
        $this->download();
    }

    private function download() {
        $fileName = $this->FILE_PATH . $this->exportFileName;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($this->exportFileName) . "\"");
        readfile($fileName);
        $this->delete($fileName);
    }

    private function delete($fileName) {
        unlink($fileName);
    }


    private function cloneRowAndSetValues($document, $search, $values)
    {
        $document->cloneRow($search, count($values));
        foreach ($values as $rowKey => $rowData) {
            $rowNumber = $rowKey + 1;
            foreach ($rowData as $macro => $replace) {
                $document->setValue($macro . '#' . $rowNumber, $replace);
            }
        }
    }
}