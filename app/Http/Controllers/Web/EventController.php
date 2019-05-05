<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Event;

class EventController extends Controller
{

    public function index(Request $request)
    {
        try {
            $event = new Event();
            $tags = $event->getTags();
            return view('event', ['tags' => $tags]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
