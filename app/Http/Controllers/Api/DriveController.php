<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Drive;

class DriveController extends Controller
{
    public function getFiles($uniqid, Request $request)
    {
        try {

            $drive = new Drive();
            $driveData = $drive->getData($uniqid);

            if ($driveData == null) {
                $res['success'] = false;
                $res['message'] = __('Data is not exists.');
                return $res;
            }

            return response()->json([
                'data' => $driveData,
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
            return response()->json([
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
