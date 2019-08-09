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

            if ($eventData == null) {
                return response()->view('errors.404', [], 404);
            }

            $tags = $event->getTags();

            return view('event_edit', [
                'event' => $eventData,
                'tags' => $tags
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function exportEvent(Request $request, $uniqid, $file_name)
    {
        try {

            $is_exists = Storage::disk('event')->exists("$uniqid.xlsx");
            if ($is_exists == false) {
                return response()->view('errors.404', [], 404);
            }

            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Expires' => '0',
                'Cache-Control' => 'max-age=0'
            ];

            $file_path = Storage::disk('event')->path("$uniqid.xlsx");

            return response()->download($file_path, $file_name, $headers);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
