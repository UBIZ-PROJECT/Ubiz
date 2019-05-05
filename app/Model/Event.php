<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;

class Event
{

    public function getEvents($start, $end)
    {
        try {
            $data_tmp = DB::table('m_event')
                ->leftJoin('m_event_pic', 'm_event.id', '=', 'm_event_pic.event_id')
                ->leftJoin('users', 'm_event_pic.user_id', '=', 'users.id')
                ->leftJoin('m_event_att', 'm_event.id', '=', 'm_event_att.event_id')
                ->leftJoin('m_event_tag', 'm_event.id', '=', 'm_event_tag.event_id')
                ->leftJoin('m_tag', 'm_event_tag.tag_id', '=', 'm_tag.id')
                ->select(
                    'm_event.*',
                    'm_event_pic.user_id',
                    'users.name as user_name',
                    'users.avatar as user_avatar',
                    'm_event_att.id as att_id',
                    'm_event_att.file_v_name',
                    'm_event_att.file_d_name',
                    'm_tag.id as tag_id',
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
                        'tag_id' => $event->tag_id,
                        'tag_title' => $event->tag_title,
                        'tag_color' => $event->tag_color,
                        'owner_id' => $event->owner_id,
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
            $department = DB::table('m_department')
                ->select('*')
                ->where('delete_flg', '=', '0')
                ->orderBy('id', 'asc')
                ->get();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }

        return $events;
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

    public function insertEvent($id = '')
    {
        DB::beginTransaction();
        try {
            DB::table('m_department')->insert($data);
            DB::commit();
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
}
