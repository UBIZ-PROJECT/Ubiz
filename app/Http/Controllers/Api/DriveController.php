<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Drive;

class DriveController extends Controller
{
    public function getData($uniqid, Request $request)
    {
        try {
            $drive = new Drive();
            $driveData = $drive->getData();
            return response()->json([
                'drive' => $driveData,
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
