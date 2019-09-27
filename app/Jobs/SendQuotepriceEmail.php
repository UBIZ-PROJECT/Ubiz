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

use App\Mail\QuotepriceEmail;


class SendQuotepriceEmail implements ShouldQueue
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
                'subject' => $this->data['subject'],
                'com_name' => $this->data['com_name'],
                'cus_name' => $this->data['cus_name'],
                'sale_name' => $this->data['sale_name'],
                'file_path' => $this->data['file_path'],
                'file_name' => $this->data['file_name']
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

            $email = new QuotepriceEmail($data);
            $mailer->to($this->data['cus_mail'])->send($email);

            if (!$mailer->failures()){
                DB::table('quoteprice_mail')
                    ->where([
                        ['qp_id', '=', $this->data['qp_id']],
                        ['uniqid', '=', $this->data['uniqid']],
                        ['delete_flg', '=', '0']
                    ])
                    ->update([
                        'send' => '1',
                        'send_time' => now(),
                        'upd_user' => $this->data['user_id'],
                        'upd_date' => now(),
                    ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
}
