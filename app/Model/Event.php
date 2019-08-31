<?php

namespace App\Model;

use App\User;
use App\Jobs\SendEventEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Event
{

    public function getEvents($start, $end, $tag, $view = 'dayGridMonth', $user = [])
    {
        try {

            $whereRaw = '`m_event`.`delete_flg` = ?
                        AND (
                            ( date(`m_event`.`start`) > ? AND date(`m_event`.`start`) < ? )
                            OR ( date(`m_event`.`start`) < ? AND date(`m_event`.`end`) > ? )
                            OR ( date(`m_event`.`end`) > ? AND date(`m_event`.`end`) < ? )
                        )';

            if ($view == 'timeGridDay') {
                $whereRaw = '`m_event`.`delete_flg` = ?
                            AND (
                                ( date(`m_event`.`start`) >= ? AND date(`m_event`.`start`) <= ? )
                                OR ( date(`m_event`.`start`) <= ? AND date(`m_event`.`end`) >= ? )
                                OR ( date(`m_event`.`end`) > ? AND date(`m_event`.`end`) <= ? )
                            )';
            }

            $query_builder = DB::table('m_event')
                ->leftJoin('m_event_pic', function ($join) {
                    $join->on('m_event.id', '=', 'm_event_pic.event_id')
                        ->where('m_event_pic.delete_flg', '=', '0');
                })
                ->leftJoin('users as usr_1', function ($join) {
                    $join->on('m_event_pic.user_id', '=', 'usr_1.id')
                        ->where('usr_1.delete_flg', '=', '0');
                })
                ->leftJoin('users as usr_2', function ($join) {
                    $join->on('m_event.owner_id', '=', 'usr_2.id')
                        ->where('usr_2.delete_flg', '=', '0');
                })
                ->leftJoin('m_event_att', function ($join) {
                    $join->on('m_event.id', '=', 'm_event_att.event_id')
                        ->where('m_event_att.delete_flg', '=', '0');
                })
                ->leftJoin('m_tag', function ($join) {
                    $join->on('m_event.tag_id', '=', 'm_tag.id')
                        ->where('m_tag.delete_flg', '=', '0');
                })
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
                ->whereRaw(
                    $whereRaw,
                    ['0', $start, $end, $start, $end, $start, $end]
                );

            //filter by tag
            if (sizeof($tag) > 0) {
                $query_builder->whereIn('m_event.tag_id', $tag);
            }

            //filter by user
            if (sizeof($user) > 0) {
                $query_builder->whereIn('m_event_pic.user_id', $user);
            }

            $data_tmp = $query_builder->orderBy('m_event.start', 'asc')->get();

            $data = [];
            $pic_list = [];
            foreach ($data_tmp as $event) {

                if (!isset($data[$event->id])) {
                    $data[$event->id] = [
                        'id' => $event->id,
                        'start' => $event->start,
                        'end' => $event->end,
                        'title' => $event->title,
                        'location' => $event->location,
                        'desc' => ($event->desc == null ? '' : $event->desc),
                        'result' => ($event->result == null ? '' : $event->result),
                        'fee' => $event->fee,
                        'allDay' => ($event->all_day == '1' ? true : false),
                        'tag_id' => $event->tag_id,
                        'tag_title' => $event->tag_title,
                        'tag_color' => $event->tag_color,
                        'is_owner' => ($event->owner_id == Auth::user()->id ? true : false),
                        'owner_id' => $event->owner_id,
                        'owner_email' => $event->owner_email,
                        'rrule' => $event->rrule == '' ? null : $event->rrule,
                        'pic_edit' => $event->pic_edit,
                        'pic_assign' => $event->pic_assign,
                        'pic_see_list' => $event->pic_see_list,
                        'pic' => [],
                        'att' => []
                    ];

                    $pic_list[$event->id] = [];
                }

                if (!empty($event->user_id)) {
                    $data[$event->id]['pic'][] = [
                        'id' => $event->user_id,
                        'name' => $event->user_name,
                        'avatar' => $event->user_avatar,
                    ];

                    $pic_list[$event->id][] = $event->user_id;
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

                if ($event['owner_id'] != Auth::user()->id
                    && inArrayValidator(Auth::user()->id, $pic_list[$event['id']]) == false) {
                    continue;
                }

                $events[] = $event;
            }

            return $events;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getEvent($id)
    {
        try {
            $event_data_tmp = DB::table('m_event')
                ->leftJoin('users', function ($join) {
                    $join->on('m_event.owner_id', '=', 'users.id')
                        ->where('users.delete_flg', '=', '0');
                })
                ->leftJoin('m_tag', function ($join) {
                    $join->on('m_event.tag_id', '=', 'm_tag.id')
                        ->where('m_tag.delete_flg', '=', '0');
                })
                ->select(
                    'm_event.*',
                    'users.email as owner_email',
                    'm_tag.title as tag_title',
                    'm_tag.color as tag_color'
                )
                ->where(
                    [
                        ['m_event.id', '=', $id],
                        ['m_event.delete_flg', '=', '0'],
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
                'location' => $event_data_tmp->location,
                'desc' => ($event_data_tmp->desc == null ? '' : $event_data_tmp->desc),
                'result' => ($event_data_tmp->result == null ? '' : $event_data_tmp->result),
                'fee' => $event_data_tmp->fee,
                'allDay' => ($event_data_tmp->all_day == '1' ? true : false),
                'tag_id' => $event_data_tmp->tag_id,
                'tag_title' => $event_data_tmp->tag_title,
                'tag_color' => $event_data_tmp->tag_color,
                'is_owner' => ($event_data_tmp->owner_id == Auth::user()->id ? true : false),
                'owner_id' => $event_data_tmp->owner_id,
                'owner_email' => $event_data_tmp->owner_email,
                'rrule' => ($event_data_tmp->rrule == '' ? null : $event_data_tmp->rrule),
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

            $pic_list = [];
            foreach ($event_pic_tmp as $pic) {

                $event['pic'][] = [
                    'id' => $pic->id,
                    'name' => $pic->name
                ];

                $pic_list[] = $pic->id;
            }

            if ($event['owner_id'] != Auth::user()->id
                && inArrayValidator(Auth::user()->id, $pic_list) == false) {
                return null;
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

    public function deleteEvent($id)
    {
        DB::beginTransaction();
        try {

            DB::table('m_event')
                ->where('id', $id)
                ->update(['delete_flg' => '1']);

            DB::table('m_event_pic')
                ->where('event_id', $id)
                ->update(['delete_flg' => '1']);

            DB::table('m_event_att')
                ->where('event_id', $id)
                ->update(['delete_flg' => '1']);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateEvent($id, $data)
    {
        DB::beginTransaction();
        try {
            //Update Event
            $event = $data['event'];
            $event['upd_user'] = Auth::user()->id;
            DB::table('m_event')->where('id', $id)->update($event);
            $this->insertMailQueue($id, '1');

            //Update Event Pic
            $pic_ids = [];
            $new_event_pic = $data['event_pic'];
            if (sizeof($new_event_pic) > 0) {

                $old_event_pic = DB::table('m_event_pic')
                    ->where('event_id', $id)
                    ->get();

                if (count($old_event_pic) == 0) {
                    foreach ($new_event_pic as &$item) {
                        $pic_ids[] = $item['user_id'];
                        $item['event_id'] = $id;
                        $item['upd_user'] = Auth::user()->id;
                        $item['inp_user'] = Auth::user()->id;
                    }
                    DB::table('m_event_pic')->insert($new_event_pic);
                } else {

                    $old_event_pic_ids = [];
                    foreach ($old_event_pic as $item) {
                        $old_event_pic_ids[] = $item->user_id;
                        $pic_ids[] = $item->user_id;
                    }

                    $inp_event_pic = [];
                    $upd_event_pic = [];
                    foreach ($new_event_pic as $item) {

                        $upd_event_pic[] = $item['user_id'];

                        if (!in_array($item['user_id'], $pic_ids)){
                            $pic_ids[] = $item['user_id'];
                        }

                        if (in_array($item['user_id'], $old_event_pic_ids))
                            continue;

                        $item['event_id'] = $id;
                        $item['upd_user'] = Auth::user()->id;
                        $item['inp_user'] = Auth::user()->id;

                        $inp_event_pic[] = $item;
                    }

                    if (count($upd_event_pic) > 0) {
                        DB::table('m_event_pic')
                            ->where([
                                ['event_id', '=', $id],
                                ['delete_flg', '=', '1']
                            ])
                            ->whereIn('user_id', $upd_event_pic)
                            ->update(['delete_flg' => '0']);

                        DB::table('m_event_pic')
                            ->where([
                                ['event_id', '=', $id],
                                ['delete_flg', '=', '0']
                            ])
                            ->whereNotIn('user_id', $upd_event_pic)
                            ->update(['delete_flg' => '1']);
                    }

                    if (count($inp_event_pic) > 0) {
                        DB::table('m_event_pic')->insert($inp_event_pic);
                    }
                }
            } else {
                DB::table('m_event_pic')
                    ->where([
                        ['event_id', $id],
                        ['delete_flg', '0']
                    ])
                    ->update(['delete_flg' => '1']);
            }

            $user = new User();
            $curUser = $user->getCurrentUser();
            $picUsers = $user->getListOfUserByIds($pic_ids);

            $event_pic = [];
            $event_mail = [];

            foreach ($picUsers as $pic) {

                $organizer = '';
                if ($pic->id == $curUser->id) {
                    $organizer = '(người tổ chức)';
                }
                $event_pic[] = [
                    'name' => $pic->name,
                    'email' => $pic->email,
                    'organizer' => $organizer,
                ];

                if ($pic->id == $curUser->id)
                    continue;

                $event_mail[] = $pic->email;
            }

            if (sizeof($event_pic) > 0 && sizeof($event_mail) > 0) {

                $event_day = '';
                $event_time = '';
                $event_title_2 = '';
                $subject = "Thư mời: " . $event['title'] . "@";

                $start_day = date("Y-m-d", strtotime($event['start']));
                $end_day = date("Y-m-d", strtotime($event['end']));

                if ($event['all_day'] == '0') {

                    $start_time = date("gA", strtotime($event['start']));
                    $end_time = date("gA", strtotime($event['end']));
                    $event_time = "$start_time - $end_time";

                    $event_title_2 = $start_time . " - " . $event['title'];

                    if ($start_day == $end_day) {
                        $subject .= "$start_day $start_time - $end_time";
                        $event_day = date("d", strtotime($event['start'])) . " Tháng " . date("n, Y", strtotime($event['start']));
                    } else {

                        $subject .= "$start_day $start_time - $end_day $end_time";

                        $event_day .= date("d", strtotime($event['start'])) . " Tháng " . date("n, Y", strtotime($event['start']));
                        $event_day .= " - ";
                        $event_day .= date("d", strtotime($event['end'])) . " Tháng " . date("n, Y", strtotime($event['end']));
                    }
                } else {

                    $event_title_2 = $start_day . " - " . $event['title'];
                    if ($start_day == $end_day) {

                        $subject .= $start_day;
                        $event_day = $start_day;
                    } else {
                        $subject .= "$start_day - $end_day";
                        $event_day = "$start_day - $end_day";
                    }
                }
                $subject .= "({$curUser->email})";

                //add mail queue
                $mail_data = [
                    'user_id' => $curUser->id,
                    'subject' => $subject,
                    'event_id' => $event_id,
                    'event_date_day' => date("d", strtotime($event['start'])),
                    'event_date_month' => "Tháng " . date("n", strtotime($event['start'])),
                    'event_title_1' => $event['title'],
                    'event_title_2' => $event_title_2,
                    'event_location' => $event['location'],
                    'event_desc' => $event['desc'],
                    'event_result' => $event['result'],
                    'event_pic_see_list' => $event['pic_see_list'],
                    'event_fee' => number_format($event['fee']),
                    'event_day' => $event_day,
                    'event_time' => $event_time,
                    'event_mail' => $event_mail,
                    'event_pic' => $event_pic,
                    'event_link' => env('APP_URL') . "/event/$event_id"
                ];
                $mail_conf = makeMailConf(
                    $curUser->email,
                    $curUser->app_pass,
                    $curUser->email,
                    $curUser->name
                );
                dispatch(new SendEventEmail($mail_data, $mail_conf));
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insertEvent($data)
    {
        DB::beginTransaction();
        try {
            $event = $data['event'];
            $event_pic = $data['event_pic'];

            //Insert Event
            $event['owner_id'] = Auth::user()->id;
            $event['upd_user'] = Auth::user()->id;
            $event['inp_user'] = Auth::user()->id;
            $event_id = DB::table('m_event')->insertGetId($event);

            if (sizeof($event_pic) > 0) {

                //Insert Event Pic
                $pic_ids = [];
                foreach ($event_pic as &$item) {
                    $item['event_id'] = $event_id;
                    $item['upd_user'] = Auth::user()->id;
                    $item['inp_user'] = Auth::user()->id;
                    $pic_ids[] = $item['user_id'];
                }
                DB::table('m_event_pic')->insert($event_pic);

                $user = new User();
                $curUser = $user->getCurrentUser();
                $picUsers = $user->getListOfUserByIds($pic_ids);

                $event_pic = [];
                $event_mail = [];

                foreach ($picUsers as $pic) {

                    $organizer = '';
                    if ($pic->id == $curUser->id) {
                        $organizer = '(người tổ chức)';
                    }
                    $event_pic[] = [
                        'name' => $pic->name,
                        'email' => $pic->email,
                        'organizer' => $organizer,
                    ];

                    if ($pic->id == $curUser->id)
                        continue;

                    $event_mail[] = $pic->email;
                }

                if (sizeof($event_pic) > 0 && sizeof($event_mail) > 0) {

                    $event_day = '';
                    $event_time = '';
                    $event_title_2 = '';
                    $subject = "Thư mời: " . $event['title'] . "@";

                    $start_day = date("Y-m-d", strtotime($event['start']));
                    $end_day = date("Y-m-d", strtotime($event['end']));

                    if ($event['all_day'] == '0') {

                        $start_time = date("gA", strtotime($event['start']));
                        $end_time = date("gA", strtotime($event['end']));
                        $event_time = "$start_time - $end_time";

                        $event_title_2 = $start_time . " - " . $event['title'];

                        if ($start_day == $end_day) {
                            $subject .= "$start_day $start_time - $end_time";
                            $event_day = date("d", strtotime($event['start'])) . " Tháng " . date("n, Y", strtotime($event['start']));
                        } else {

                            $subject .= "$start_day $start_time - $end_day $end_time";

                            $event_day .= date("d", strtotime($event['start'])) . " Tháng " . date("n, Y", strtotime($event['start']));
                            $event_day .= " - ";
                            $event_day .= date("d", strtotime($event['end'])) . " Tháng " . date("n, Y", strtotime($event['end']));
                        }
                    } else {

                        $event_title_2 = $start_day . " - " . $event['title'];
                        if ($start_day == $end_day) {

                            $subject .= $start_day;
                            $event_day = $start_day;
                        } else {
                            $subject .= "$start_day - $end_day";
                            $event_day = "$start_day - $end_day";
                        }
                    }
                    $subject .= "({$curUser->email})";

                    //add mail queue
                    $mail_data = [
                        'user_id' => $curUser->id,
                        'subject' => $subject,
                        'event_id' => $event_id,
                        'event_date_day' => date("d", strtotime($event['start'])),
                        'event_date_month' => "Tháng " . date("n", strtotime($event['start'])),
                        'event_title_1' => $event['title'],
                        'event_title_2' => $event_title_2,
                        'event_location' => $event['location'],
                        'event_desc' => $event['desc'],
                        'event_result' => $event['result'],
                        'event_pic_see_list' => $event['pic_see_list'],
                        'event_fee' => number_format($event['fee']),
                        'event_day' => $event_day,
                        'event_time' => $event_time,
                        'event_mail' => $event_mail,
                        'event_pic' => $event_pic,
                        'event_link' => env('APP_URL') . "/event/$event_id"
                    ];
                    $mail_conf = makeMailConf(
                        $curUser->email,
                        $curUser->app_pass,
                        $curUser->email,
                        $curUser->name
                    );
                    dispatch(new SendEventEmail($mail_data, $mail_conf));
                }
            }

            DB::commit();
            return $event_id;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insertMailQueue($id, $action = '0')
    {
        try {
            $data = [
                'event_id' => $id,
                'action' => $action,
                'send' => '0'
            ];

            DB::table('m_event_mail')->insert($data);
        } catch (\Throwable $e) {
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

            if (maxlengthValidator($data['event_location'], 500) == false) {
                $res['success'] = false;
                $message[] = __('Event location is too long.');
            }

            if (existsInDBValidator($data['event_tag'], 'm_tag', 'id') == false) {
                $res['success'] = false;
                $message[] = __('Event tag is not exists.');
            }

            if (numericValidator($data['event_fee']) == false) {
                $res['success'] = false;
                $message[] = __('Event fee is not number.');
            }

            if (inArrayValidator($data['event_all_day'], ['0', '1']) == false
                || inArrayValidator($data['event_pic_edit'], ['0', '1']) == false
                || inArrayValidator($data['event_pic_assign'], ['0', '1']) == false
                || inArrayValidator($data['event_pic_see_list'], ['0', '1']) == false
                || isArrayValidator($data['event_pic_list']) == false
                || presentValidator($data['event_desc']) == false
                || presentValidator($data['event_result']) == false
                || presentValidator($data['event_fee']) == false
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

    public function deleteValidation($id)
    {
        try {

            $res = ['success' => true, 'message' => ''];

            if (requiredValidator($id) == false || numericValidator($id) == false) {
                $res['success'] = false;
                $message[] = __('Data is wrong');
                return $res;
            }

            $event = $this->getEvent($id);
            if ($event == null) {
                $res['success'] = false;
                $res['message'] = __('Event is not exists.');
                return $res;
            }

            if ($event['pic_edit'] == '0' && $event['owner_id'] != Auth::user()->id) {
                $res['success'] = false;
                $res['message'] = __('You do not have permission to delete this event.');
                return $res;
            }

            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function insertValidation($data)
    {
        try {
            return $this->validateData($data);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateValidation($id, $data)
    {
        try {

            $res = ['success' => true, 'message' => ''];

            if (requiredValidator($id) == false || numericValidator($id) == false) {
                $res['success'] = false;
                $message[] = __('Data is wrong');
                return $res;
            }

            $event = $this->getEvent($id);
            if ($event == null) {
                $res['success'] = false;
                $res['message'] = __('Event is not exists.');
                return $res;
            }

            if ($event['pic_edit'] == '0' && $event['owner_id'] != Auth::user()->id) {
                $res['success'] = false;
                $res['message'] = __('You do not have permission to delete this event.');
                return $res;
            }

            return $this->validateData($data);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}