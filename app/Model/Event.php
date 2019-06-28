<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Event
{

    public function getEvents($start, $end)
    {
        try {
            $data_tmp = DB::table('m_event')
                ->leftJoin('m_event_pic', 'm_event.id', '=', 'm_event_pic.event_id')
                ->leftJoin('users as usr_1', 'm_event_pic.user_id', '=', 'usr_1.id')
                ->leftJoin('users as usr_2', 'm_event.owner_id', '=', 'usr_2.id')
                ->leftJoin('m_event_att', 'm_event.id', '=', 'm_event_att.event_id')
                ->leftJoin('m_tag', 'm_event.tag_id', '=', 'm_tag.id')
                ->select(
                    'm_event.*',
                    'm_event_pic.user_id',
                    'usr_1.name as user_name',
                    'usr_1.avatar as user_avatar',
                    'usr_2.email as owner_email',
                    'm_event_att.id as att_id',
                    'm_event_att.file_v_name',
                    'm_event_att.file_d_name',
                    'm_tag.title as tag_title',
                    'm_tag.color as tag_color'
                )
                ->where(
                    [
                        ['m_event.delete_flg', '=', '0'],
                        ['m_event.start', '>=', $start],
                        ['m_event.end', '<=', $end]
                    ]
                )
                ->orderBy('m_event.id', 'asc')
                ->get();

            $data = [];
            foreach ($data_tmp as $event) {

                if (!isset($data[$event->id])) {
                    $data[$event->id] = [
                        'id' => $event->id,
                        'start' => $event->start,
                        'end' => $event->end,
                        'title' => $event->title,
                        'desc' => $event->desc,
                        'allDay' => ($event->all_day == '1' ? true : false),
                        'tag_id' => $event->tag_id,
                        'tag_title' => $event->tag_title,
                        'tag_color' => $event->tag_color,
                        'owner_id' => $event->owner_id,
                        'owner_email' => $event->owner_email,
                        'rrule' => $event->rrule == '' ? null : $event->rrule,
                        'pic_edit' => $event->pic_edit,
                        'pic_assign' => $event->pic_assign,
                        'pic_see_list' => $event->pic_see_list,
                        'pic' => [],
                        'att' => []
                    ];
                }

                if (!empty($event->user_id)) {
                    $data[$event->id]['pic'][] = [
                        'id' => $event->user_id,
                        'name' => $event->user_name,
                        'avatar' => $event->user_avatar,
                    ];
                }

                if (!empty($event->att_id)) {
                    $data[$event->id]['att'][] = [
                        'id' => $event->att_id,
                        'file_v_name' => $event->file_v_name,
                        'file_d_name' => $event->file_d_name,
                    ];
                }
            }

            $events = [];
            foreach ($data as $event) {
                $events[] = $event;
            }

            return $events;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getEvent($id)
    {
        try {
            $event_data_tmp = DB::table('m_event')
                ->leftJoin('users', 'm_event.owner_id', '=', 'users.id')
                ->leftJoin('m_tag', 'm_event.tag_id', '=', 'm_tag.id')
                ->select(
                    'm_event.*',
                    'users.email as owner_email',
                    'm_tag.title as tag_title',
                    'm_tag.color as tag_color'
                )
                ->where(
                    [
                        ['m_event.id', '=', $id],
                        ['users.delete_flg', '=', '0']
                    ]
                )
                ->first();

            if ($event_data_tmp == null)
                return null;

            $event = [
                'id' => $event_data_tmp->id,
                'start' => $event_data_tmp->start,
                'end' => $event_data_tmp->end,
                'title' => $event_data_tmp->title,
                'desc' => $event_data_tmp->desc,
                'allDay' => ($event_data_tmp->all_day == '1' ? true : false),
                'tag_id' => $event_data_tmp->tag_id,
                'tag_title' => $event_data_tmp->tag_title,
                'tag_color' => $event_data_tmp->tag_color,
                'owner_id' => $event_data_tmp->owner_id,
                'owner_email' => $event_data_tmp->owner_email,
                'rrule' => $event_data_tmp->rrule == '' ? null : $event_data_tmp->rrule,
                'pic_edit' => $event_data_tmp->pic_edit,
                'pic_assign' => $event_data_tmp->pic_assign,
                'pic_see_list' => $event_data_tmp->pic_see_list,
                'pic' => [],
                'att' => []
            ];

            $event_pic_tmp = DB::table('m_event_pic')
                ->join('users', 'm_event_pic.user_id', '=', 'users.id')
                ->select(
                    'users.id',
                    'users.name'
                )
                ->where(
                    [
                        ['m_event_pic.event_id', '=', $id],
                        ['m_event_pic.delete_flg', '=', '0']
                    ]
                )
                ->orderBy('users.id', 'asc')
                ->get();

            foreach ($event_pic_tmp as $pic) {

                $event['pic'][] = [
                    'id' => $pic->id,
                    'name' => $pic->name,
                    'avatar' => $pic->avatar,
                ];
            }

            $event_att_tmp = DB::table('m_event_att')
                ->select(
                    'm_event_att.id',
                    'm_event_att.file_v_name',
                    'm_event_att.file_d_name'
                )
                ->where(
                    [
                        ['m_event_att.event_id', '=', $id],
                        ['m_event_att.delete_flg', '=', '0']
                    ]
                )
                ->orderBy('m_event_att.id', 'asc')
                ->get();

            foreach ($event_att_tmp as $att) {

                $event['att'][] = [
                    'id' => $att->id,
                    'file_v_name' => $att->file_v_name,
                    'file_d_name' => $att->file_d_name
                ];
            }

            return $event;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getTags()
    {
        try {
            $tags = DB::table('m_tag')
                ->select('*')
                ->where('m_tag.delete_flg', '=', '0')
                ->orderBy('m_tag.id', 'asc')
                ->get();
            return $tags;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteEvent($id = '')
    {
        DB::beginTransaction();
        try {

            DB::table('m_department')
                ->whereIn('id', explode(',', $ids))
                ->update(['delete_flg' => '1']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateEvent($id, $data = [])
    {
        DB::beginTransaction();
        try {
            DB::table('m_department')
                ->where([['id', '=', $id], ['delete_flg', '=', '0']])
                ->update($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insertEvent($data = [])
    {
        DB::beginTransaction();
        try {
            $event = $data['event'];
            $event_pic = $data['event_pic'];

            //Insert Event
            unset($event['event_id']);
            $event['owner_id'] = Auth::user()->id;
            $event['upd_user'] = Auth::user()->id;
            $event['inp_user'] = Auth::user()->id;
            $event_id = DB::table('m_event')->insertGetId($event);

            //Insert Event Pic
            foreach ($event_pic as &$item) {
                $item['event_id'] = $event_id;
                $item['upd_user'] = Auth::user()->id;
                $item['inp_user'] = Auth::user()->id;
            }
            DB::table('m_event_pic')->insert($event_pic);

            DB::commit();
            return $event_id;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function validateData($data)
    {
        try {

            $res = ['success' => true, 'message' => ''];
            $message = [];

            if (requiredValidator($data['event_title']) == false) {
                $res['success'] = false;
                $message[] = __('Event title is required.');
            }
            if (requiredValidator($data['event_title']) == true && maxlengthValidator($data['event_title'], 255) == false) {
                $res['success'] = false;
                $message[] = __('Event title is too long.');
            }

            $event_start_validator = true;
            if (requiredValidator($data['event_start']) == false) {
                $res['success'] = false;
                $event_start_validator = false;
                $message[] = __('Start date is required.');
            }
            if ($event_start_validator == true && dateValidator($data['event_start'], 'Y-m-d H:i:s') == false) {
                $res['success'] = false;
                $event_start_validator = false;
                $message[] = __('Start date is wrong format Y-m-d H:i:s.');
            }

            $event_end_validator = true;
            if (requiredValidator($data['event_end']) == false) {
                $res['success'] = false;
                $event_end_validator = false;
                $message[] = __('End date is required.');
            }
            if ($event_end_validator == true && dateValidator($data['event_end'], 'Y-m-d H:i:s') == false) {
                $res['success'] = false;
                $event_end_validator = false;
                $message[] = __('End date is wrong format Y-m-d H:i:s.');
            }

            if ($event_start_validator == true && $event_end_validator == true) {
                if (beforeOrEqualValidator($data['event_start'], $data['event_end']) == false) {
                    $res['success'] = false;
                    $message[] = __('Start time must be before or equal end time.');
                }
            }

            if (existsInDBValidator($data['event_tag'], 'm_tag', 'id') == false) {
                $res['success'] = false;
                $message[] = __('Event tag is not exists.');
            }

            if (requiredValidator($data['event_id']) == false
                || inArrayValidator($data['event_all_day'], ['0', '1']) == false
                || inArrayValidator($data['event_pic_edit'], ['0', '1']) == false
                || inArrayValidator($data['event_pic_assign'], ['0', '1']) == false
                || inArrayValidator($data['event_pic_see_list'], ['0', '1']) == false
                || isArrayValidator($data['event_pic_list']) == false
                || presentValidator($data['event_desc']) == false
            ) {
                $res['success'] = false;
                $message[] = __('Data is wrong');
            }

            if (isArrayValidator($data['event_pic_list']) == true) {
                foreach ($data['event_pic_list'] as $pic) {
                    if (existsInDBValidator($pic, 'users', 'id') == false) {
                        $res['success'] = false;
                        $message[] = __('Event tag is not exists.');
                        break;
                    }
                }
            }

            $res['message'] = implode("\n", $message);
            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }

    }
}
