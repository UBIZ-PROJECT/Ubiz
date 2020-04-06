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
                'user_id' => $this->data['id'],
                'user_inp' => $this->data['inp_user'],
                'user_code' => $this->data['code'],
                'user_name' => $this->data['name'],
                'user_email' => $this->data['email'],
                'user_passwd' => $this->data['password']
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
                        ['user_id', '=', $data['id']],
                        ['delete_flg', '=', '0']
                    ])
                    ->update([
                        'send' => '1',
                        'send_time' => now(),
                        'upd_user' => $data['user_inp']
                    ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
}
