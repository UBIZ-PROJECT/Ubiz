<?php
/**
 * Created by PhpStorm.
 * User: hoait
 * Date: 8/10/2019
 * Time: 5:23 PM
 */

namespace App\Http\Controllers\Common;


abstract class AbstractUpload implements iUpload
{
    private $fileType = "";
    private $filePath = "";
    const DIR_PATH_TEMP = "E:/Test/";
    public function uploadFile($fileUpload, $controlName)
    {
        $message = "";
        $target_dir = self::DIR_PATH_TEMP;
        if (!file_exists($target_dir)) {
            mkdir($target_dir);
        }
        $target_file = $target_dir . basename($fileUpload[$controlName]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            $message =  "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($fileUpload[$controlName]["size"] > 500000) {
            $message =  "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if(empty($this->fileType) && stripos($imageFileType,$this->fileType) > -1 ) {
            $message =  "Sorry, $this->fileType files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $message =  "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($fileUpload[$controlName]["tmp_name"], $target_file)) {
                $message =  "The file ". basename($fileUpload[$controlName]["name"]). " has been uploaded.";
                $this->filePath = $target_file;
            } else {
                $message =  "Sorry, there was an error uploading your file.";
            }
        }
        return $message;
    }

    private function removeDir($dirPath = self::DIR_PATH_TEMP) {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::removeDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function saveToDatabase($listPathFiles, $lstImport)
    {
        foreach ($lstImport as $import) {
            $this->import($listPathFiles, $import);
        }
        $this->removeDir();
    }

    protected function setFileType($fileType) {
        $this->fileType = $fileType;
    }

    protected function getFilePath() {
        return $this->filePath;
    }
    abstract public function analyzeFile();
    abstract public function import($lstPathFile, $typeName);

}