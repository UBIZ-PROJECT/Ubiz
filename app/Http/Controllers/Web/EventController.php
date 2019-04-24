<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class EventController extends Controller
{

    public function index(Request $request)
    {
        try {
            return view('event');
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
