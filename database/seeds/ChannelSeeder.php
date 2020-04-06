<?php

use App\Channel;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Channel::truncate();
        Channel::updateOrCreate([
            'code'  => 'web',
        ],[
            'name'  => 'Web',
            'is_active' => true
        ]);
        Channel::updateOrCreate([
            'code'  => 'email',
        ], [
            'name'  => 'Email',
            'is_active' => true,
        ]);
        Channel::updateOrCreate([
            'code'  => 'tele',
        ], [
            'name'  => 'Telegram',
            'is_active' => false,
        ]);
        Channel::updateOrCreate([
            'code'  => 'wa',
        ], [
            'name'  => 'Whatsapp',
            'is_active' => false,
        ]);
    }
}
