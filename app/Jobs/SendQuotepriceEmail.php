<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\QuotepriceEmail;


class SendQuotepriceEmail implements ShouldQueue
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
                'subject' => $this->data['subject'],
                'com_name' => $this->data['com_name'],
                'cus_name' => $this->data['cus_name'],
                'sale_name' => $this->data['sale_name'],
                'file_path' => $this->data['file_path'],
                'file_name' => $this->data['file_name']
            ];

            sleep(60);

            $email = new QuotepriceEmail($data);
            Mail::to($this->data['cus_mail'])->send($email);

            if (!Mail::failures()){
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
