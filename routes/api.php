<?php

use Illuminate\Http\Request;

Route::middleware('auth.micro')->group(function(){
    Route::prefix('v1')->group(function(){        
        Route::apiResource('channels','Api\ChannelController')->only(['index']);
        Route::apiResource('templates','Api\TemplateController');
        Route::apiResource('notifications','Api\NotificationController')->only(['index']);
        Route::get('resend/{id}','V1\SendController@resend');
    });
});

Route::post('v1/send','V1\SendController@sendV2');