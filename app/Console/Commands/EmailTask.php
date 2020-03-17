<?php

namespace App\Console\Commands;

use App\Notification;
use App\Mail\NotifMaillable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lakukan task untuk mengirim email dalam antrian';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $notifications = Notification::where('channel','email')
            ->whereNull('sent_at')
            ->where('trying_send','<=',5)
            ->orderBy('created_at','asc')
            ->limit(50)->get();
        foreach($notifications as $notif){
            $notif->trying_send += 1;
            $notif->save();
            try {
                $this->info('Trying send to '.$notif->to);
                DB::beginTransaction();
                Mail::to($notif->to)->send(new NotifMaillable($notif));
                $notif->sent_at = now();
                $notif->save();
                DB::commit();
                $this->info('Success send email.');
            } catch(\Exception $e){
                DB::rollback();
                $notif->response_text = $e->getMessage();
                $notif->save();
                $this->info($e->getMessage());
            }
        }
    }
}
