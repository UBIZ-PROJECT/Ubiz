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

    public function detail(Request $request, $id)
    {
        try {
            $event = new Event();
            $eventData = $event->getEvent($id);

            if($eventData == null){
                return response()->view('errors.404', [], 404);
            }

            return view('event_edit', ['event' => $eventData]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
