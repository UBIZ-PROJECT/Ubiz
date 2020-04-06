<?php

namespace App\Jobs;

use Swift_Mailer;
use Swift_SmtpTransport;
use Illuminate\Mail\Mailer;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Mail\UserRegistEmail;

class SendUserRegistEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $configuration;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $configuration)
    {
        $this->data = $data;
        $this->configuration = $configuration;
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
                'event_date_day' => $this->data['event_date_day'],
                'event_date_month' => $this->data['event_date_month'],
                'event_title_1' => $this->data['event_title_1'],
                'event_title_2' => $this->data['event_title_2'],
                'event_fee' => $this->data['event_fee'],
                'event_desc' => $this->data['event_desc'],
                'event_result' => $this->data['event_result'],
                'event_pic_see_list' => $this->data['event_pic_see_list'],
                'event_location' => $this->data['event_location'],
                'event_day' => $this->data['event_day'],
                'event_time' => $this->data['event_time'],
                'event_mail' => $this->data['event_mail'],
                'event_pic' => $this->data['event_pic'],
                'event_link' => $this->data['event_link'],
                'event_action' => $this->data['event_action']
            ];

            sleep(60);

            $smtp_host = array_get($this->configuration, 'smtp_host');
            $smtp_port = array_get($this->configuration, 'smtp_port');
            $smtp_username = array_get($this->configuration, 'smtp_username');
            $smtp_password = array_get($this->configuration, 'smtp_password');
            $smtp_encryption = array_get($this->configuration, 'smtp_encryption');

            $from_email = array_get($this->configuration, 'from_email');
            $from_name = array_get($this->configuration, 'from_name');

            $transport = new Swift_SmtpTransport($smtp_host, $smtp_port);
            $transport->setUsername($smtp_username);
            $transport->setPassword($smtp_password);
            $transport->setEncryption($smtp_encryption);

            $swift_mailer = new Swift_Mailer($transport);

            $mailer = new Mailer(app()->get('view'), $swift_mailer, app()->get('events'));
            $mailer->alwaysFrom($from_email, $from_name);
            $mailer->alwaysReplyTo($from_email, $from_name);

            $email = new UserRegistEmail($data);
            $mailer->to($this->data['mail'])->send($email);

            if (!$mailer->failures()) {
                DB::table('users_regist_mail')
                    ->where([
                        ['user_id', '=', $data['user_id']],
                        ['delete_flg', '=', '0']
                    ])
                    ->update([
                        'send' => '1',
                        'send_time' => now(),
                        'upd_user' => $data['user_id']
                    ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
}
