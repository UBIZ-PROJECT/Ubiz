<?php

namespace App\Http\Controllers\Api;

use App;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Event;

class EventController extends Controller
{
    public function getEvents(Request $request)
    {
        try {

            $start = $request->get('start', null);
            $end = $request->get('end', null);

            if (empty($start) || $start == '' || $start == null
                || empty($end) || $end == '' || $end == null
            ) {
                return response()->json(['success' => false, 'message' => 'Ko dung ngay'], 200);
            }

            $start_dt = new \DateTime($start);
            $start_fm = $start_dt->format('Y-m-d H:i:s');

            $end_dt = new \DateTime($end);
            $end_fm = $end_dt->format('Y-m-d H:i:s');


            $event = new Event();
            $events = $event->getEvents($start_fm, $end_fm);
            return response()->json(['events' => $events, 'success' => true, 'message' => __("Successfully processed.")], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getEvent($id, Request $request)
    {
        try {
            $department = new Department();
            if ($request->has('pos')) {
                list ($page, $sort, $search) = $this->getRequestData($request);
                $data = $department->getDepartmentByPos($request->pos, $sort, $search);
            } else {
                $data = $department->getDepartmentById($id);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['department' => $data, 'message' => __("Successfully processed.")], 200);
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
            return response()->json(['departments' => $departments, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed.")], 200);

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function insertEvent(Request $request)
    {
        try {

            $data = $request->all();

            $evModel = new Event();
            $res = $evModel->validateData($data);
            if ($res['success'] == false) {
                return response()->json(['success' => false, 'message' => $res['message']], 200);
            }

            $map_data = $this->mapData($data);
            $event_id = $evModel->insertEvent($map_data);
            $event = $evModel->getEvent($event_id);

            return response()->json([
                'event' => $event,
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
            return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function mapData($data)
    {
        try {

            $map_data = [];
            $map_data['event'] = [
                'id' => $data['event_id'],
                'start' => $data['event_start'],
                'end' => $data['event_end'],
                'title' => $data['event_title'],
                'desc' => $data['event_desc'],
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
