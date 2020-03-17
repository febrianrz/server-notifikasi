<?php

use App\Notification;
use App\Mail\NotifMaillable;
use Illuminate\Support\Facades\Mail;
use Febrianrz\Micronotification\Notif;

Route::get('/tesnotif', function(Request $request){
    Notif::send('','');
});
