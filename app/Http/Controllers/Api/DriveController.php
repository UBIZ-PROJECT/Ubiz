<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Model\Drive;

class DriveController extends Controller
{
    public function getFiles($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            //get data
            $driveData = $drive->getData($uniqid);

            return response()->json([
                'data' => $driveData,
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getDetail($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            //get data
            $driveData = $drive->getDetail($uniqid);

            return response()->json([
                'data' => $driveData,
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getSibling($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            //get data
            $detail = $drive->getDetail($uniqid);
            $parent = $drive->getDetail($detail->dri_funiq);
            $sibling = $drive->getChildren($parent->dri_uniq);

            return response()->json([
                'detail' => $detail,
                'parent' => $parent,
                'sibling' => $sibling,
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getChildren($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            //get data
            $detail = $drive->getDetail($uniqid);
            $sibling = $drive->getChildren($detail->dri_uniq);

            return response()->json([
                'detail' => $detail,
                'parent' => $detail,
                'sibling' => $sibling,
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function uploadFiles($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            if (!$request->hasFile('upload-files')
                || !$request->has('file-ids')
                || !$request->has('upload-files')
            ) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            $upload_data = $request->allFiles();
            $upload_data['file-ids'] = $request->get('file-ids', []);
            $upload_data['relative-paths'] = $request->get('relative-paths', []);

            if (sizeof($upload_data['upload-files']) != sizeof($upload_data['file-ids'])
                || sizeof($upload_data['upload-files']) != sizeof($upload_data['relative-paths'])
                || sizeof($upload_data['file-ids']) != sizeof($upload_data['relative-paths'])
            ) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            $drive->uploadFiles($uniqid, $upload_data);

            return response()->json([
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function downloadFiles($uniqid, Request $request)
    {
        try {

            $drive = new Drive();

            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                abort('404');
            }

            $data = $drive->getDetail($uniqid);
            if ($data->dri_type == '0') {
                abort('404');
            }

            //download_file
            $download_file = $data->dri_uniq . "." . $data->dri_ext;
            return response()->stream(function() use ($download_file) {
                $stream = Storage::disk('marketing')->readStream($download_file);
                fpassthru($stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }
            }, 200, [
                'Cache-Control'         => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type'          => Storage::disk('marketing')->mimeType($download_file),
                'Content-Length'        => Storage::disk('marketing')->size($download_file),
                'Content-Disposition'   => 'attachment; filename="' . basename($data->dri_name) . '"',
                'Pragma'                => 'public',
            ]);

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function addNewFolder($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            $folder_name = $request->get('folder-name', null);
            if ($folder_name == null) {
                $res['success'] = false;
                $res['message'] = __('Please enter folder name.');
                return $res;
            }

            if (preg_replace('/\s+/', '', $folder_name) == '') {
                $res['success'] = false;
                $res['message'] = __('Please enter folder name.');
                return $res;
            }

            //upload files
            $drive->addNewFolder($uniqid, $folder_name);

            return response()->json([
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function doCopy($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            //make a copy
            $drive->doCopy($uniqid);

            return response()->json([
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function moveTo($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            $target_uniqid = $request->get('target-uniqid', null);
            if ($target_uniqid == null) {
                $res['success'] = false;
                $res['message'] = __('Please enter new name.');
                return $res;
            }
            $validateResult = $drive->validateDriUniq($target_uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            //move to
            $drive->moveTo($uniqid, $target_uniqid);

            return response()->json([
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function changeName($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            $new_name = $request->get('new-name', null);
            if ($new_name == null) {
                $res['success'] = false;
                $res['message'] = __('Please enter new name.');
                return $res;
            }

            if (preg_replace('/\s+/', '', $new_name) == '') {
                $res['success'] = false;
                $res['message'] = __('Please enter new name.');
                return $res;
            }

            //change name
            $drive->changeName($uniqid, $new_name);

            return response()->json([
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function changeColor($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            $color = $request->get('color', null);
            if ($color == null) {
                $res['success'] = false;
                $res['message'] = __('Please selecte color.!');
                return $res;
            }

            //change color
            $drive->changeColor($uniqid, $color);

            return response()->json([
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteFiles($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $validateResult = $drive->validateDriUniq($uniqid);
            if ($validateResult == false) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            //delete files
            $f_uniqid = $drive->deleteFiles($uniqid);

            return response()->json([
                'uniqid' => $f_uniqid,
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
