<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\EventEmail;

class SendEventEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        try {

            $data = [
                'user_id' => $this->data['user_id'],
                'subject' => $this->data['subject'],
                'event_id' => $this->data['event_id'],
                'event_date' => $this->data['event_date'],
                'event_title_1' => $this->data['event_title_1'],
                'event_title_2' => $this->data['event_title_2'],
                'event_time' => $this->data['event_time'],
                'event_mail' => $this->data['event_mail'],
                'event_pic' => $this->data['event_pic'],
                'event_link' => $this->data['event_link']
            ];

            sleep(60);

            $email = new EventEmail($data);
            Mail::to($data['event_mail'])->send($email);

            if (!Mail::failures()) {
                DB::table('m_event_mail')
                    ->where([
                        ['event_id', '=', $data['event_id']],
                        ['delete_flg', '=', '0']
                    ])
                    ->update([
                        'send' => '1',
                        'send_time' => now(),
                        'upd_user' => $data['user_id'],
                        'upd_date' => now()
                    ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
}
