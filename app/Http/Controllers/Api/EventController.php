<?php

namespace App\Http\Controllers\Api;

use App;
use App\User;
use Illuminate\Http\Request;
use App\Exports\ReportEventExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use App\Model\Event;

class EventController extends Controller
{
    public function getEvents(Request $request)
    {
        try {
            checkUserRight(10, 1);
            $start = $request->get('start', null);
            $end = $request->get('end', null);
            $tag = $request->get('tag', []);
            $view = $request->get('view', 'dayGridMonth');
            $user = $request->get('user', []);

            if (isArrayValidator($tag) == false
                || isArrayValidator($user) == false
                || requiredValidator($start) == false
                || dateValidator($start) == false
                || requiredValidator($end) == false
                || requiredValidator($view) == false
                || dateValidator($end) == false
            ) {
                return response()->json(['success' => false, 'message' => __('Filter data is wrong.')], 200);
            }

            $start_dt = new \DateTime($start);
            $start_fm = $start_dt->format('Y-m-d');

            $end_dt = new \DateTime($end);
            $end_fm = $end_dt->format('Y-m-d');


            $event = new Event();
            $events = $event->getEvents($start_fm, $end_fm, $tag, $view, $user);
            return response()->json(['events' => $events, 'success' => true, 'message' => __("Successfully processed.")], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getEvent($id, Request $request)
    {
        try {
            checkUserRight(10, 1);
            if (requiredValidator($id) == false || numericValidator($id) == false) {
                $res['success'] = false;
                $message[] = __('Data is wrong');
                return $res;
            }

            $evModel = new Event();
            $event = $evModel->getEvent($id);
            if ($event == null) {
                $res['success'] = false;
                $res['message'] = __('Event is not exists.');
                return $res;
            }

            return response()->json([
                'event' => $event,
                'success' => true,
                'message' => __("Successfully processed.")
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getPic(Request $request)
    {
        try {
            $usrModel = new User();
            $usrData = $usrModel->getAllUsers();
            return response()->json(['users' => $usrData, 'success' => true, 'message' => __("Successfully processed.")], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateEvent($id, Request $request)
    {
        try {
            checkUserRight(10, 4);
            $data = $request->all();

            $evModel = new Event();
            $res = $evModel->updateValidation($id ,$data);
            if ($res['success'] == false) {
                return response()->json(['success' => false, 'message' => $res['message']], 200);
            }

            $map_data = $this->mapData($data);
            $evModel->updateEvent($id ,$map_data);

            return response()->json([
                'success' => true,
                'message' => __("Successfully processed.")
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function insertEvent(Request $request)
    {
        try {
            checkUserRight(10, 2);
            $data = $request->all();

            $evModel = new Event();
            $res = $evModel->insertValidation($data);
            if ($res['success'] == false) {
                return response()->json(['success' => false, 'message' => $res['message']], 200);
            }

            $map_data = $this->mapData($data);
            $evModel->insertEvent($map_data);

            return response()->json([
                'success' => true,
                'message' => __("Successfully processed.")
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteEvent($id, Request $request)
    {
        try {
            checkUserRight(10, 3);
            $evModel = new Event();
            $res = $evModel->deleteValidation($id);
            if ($res['success'] == false) {
                return response()->json(['success' => false, 'message' => $res['message']], 200);
            }

            $evModel->deleteEvent($id);

            return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function exportEvent(Request $request)
    {
        try {
            checkUserRight(10, 1);
            $start = $request->get('start', null);
            $end = $request->get('end', null);
            $tag = $request->get('tag', []);
            $view = $request->get('view', 'dayGridMonth');
            $user = $request->get('user', []);

            if (isArrayValidator($tag) == false
                || isArrayValidator($user) == false
                || requiredValidator($start) == false
                || dateValidator($start) == false
                || requiredValidator($end) == false
                || requiredValidator($view) == false
                || dateValidator($end) == false
            ) {
                return response()->json(['success' => false, 'message' => __('Filter data is wrong.')], 200);
            }

            $uniqid = uniqid();
            $start_dt = new \DateTime($start);
            $start_fm = $start_dt->format('Ymd');

            $end_dt = new \DateTime($end);
            $end_fm = $end_dt->format('Ymd');
            $file_name = "LLV-$start_fm-$end_fm.xlsx";

            // Store on a different disk with a defined writer type.
            Excel::store(new ReportEventExport($request), "$uniqid.xlsx", 'event');
            return response()->json(['uniqid' => $uniqid, 'file_name' => $file_name, 'success' => true, 'message' => __('Successfully processed.')], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function mapData($data)
    {
        try {

            $map_data = [];
            $map_data['event'] = [
                'start' => $data['event_start'],
                'end' => $data['event_end'],
                'title' => $data['event_title'],
                'location' => $data['event_location'],
                'desc' => $data['event_desc'],
                'result' => $data['event_result'],
                'fee' => $data['event_fee'],
                'all_day' => $data['event_all_day'],
                'tag_id' => $data['event_tag'],
                'rrule' => null,
                'pic_edit' => $data['event_pic_edit'],
                'pic_assign' => $data['event_pic_assign'],
                'pic_see_list' => $data['event_pic_see_list']
            ];

            $map_data['event_pic'] = [];
            foreach ($data['event_pic_list'] as $pic) {
                $map_data['event_pic'][] = [
                    'user_id' => $pic
                ];
            }

            return $map_data;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
