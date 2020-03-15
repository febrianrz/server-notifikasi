<?php

use Illuminate\Http\Request;

Route::middleware('auth.micro-app')->group(function(){
    Route::prefix('v1')->group(function(){
        Route::post('send','V1\SendController@send');
    });
});
