<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Model\Drive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DriveController extends Controller
{
    public function index(Request $request)
    {
        try {
            $drive = new Drive();
            $driveData = $drive->getData();
            return view('drive', ['drive' => $driveData]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
