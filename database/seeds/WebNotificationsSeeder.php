<?php

use Illuminate\Database\Seeder;

class WebNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\WebNotification::class, 25)->create();
    }
}
