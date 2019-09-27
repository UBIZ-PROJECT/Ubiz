<?php
/**
 * Created by PhpStorm.
 * User: hoait
 * Date: 8/10/2019
 * Time: 5:24 PM
 */

namespace App\Http\Controllers\Common;


interface iUpload
{
    public function uploadFile($fileUpload, $controlName);
    public function saveToDatabase($listPathFiles, $lstImport);
}