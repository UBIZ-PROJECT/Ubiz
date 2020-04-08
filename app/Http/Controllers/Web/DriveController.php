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
            checkUserRight(15, 1);
            return view('drive');
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
