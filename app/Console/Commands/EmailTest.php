<?php

namespace App\Console\Commands;

use App\Template;
use App\Notification;
use App\Mail\GlobalMaillable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EmailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing koneksi email';

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
        $template = Template::where('code','tes_mail')->first();
        if(!$template) $this->info('Template testing tidak ditemukan, mohon jalankan seeder TemplatesSeeder terlebih dahulu');
        else {
            $to  = $this->argument('email');
            $this->info('Memulai pengiriman email ke '.$to);
            $html = Notification::convert(null,$template->template,['email'=>$to]);
            
            Mail::to($to)->send(new GlobalMaillable($html));
            
            $this->info('Selesai mengirim email');
        }
    }
}
