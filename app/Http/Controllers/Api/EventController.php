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
            $department = new Department();
            list($page, $sort, $search, $Department_data) = $this->getRequestData($request);
            $department->updateDepartment($id, $Department_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function insertEvent(Request $request)
    {
        try {
            $department = new Department();
            list($page, $sort, $search, $Department_data) = $this->getRequestData($request);
            $department->insertDepartment($Department_data);
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['success' => true, 'message' => __("Successfully processed.")], 200);
    }

    public function deleteEvent($id, Request $request)
    {
        try {
            $department = new Department();
            $department->deleteDepartments($ids);
            $departments = $department->getDepartments();
            $paging = $department->getPagingInfo();
            $paging['page'] = 0;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['departments' => $departments, 'paging' => $paging, 'success' => true, 'message' => __("Successfully processed.")], 200);
    }
}
