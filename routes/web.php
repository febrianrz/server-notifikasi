<?php

// use Parsedown;
// use App\Template;
// use App\Mail\GlobalMaillable;

Route::view('/', 'welcome');


// Route::get('view/{code}',function($code){
//     $template = Template::where('code',$code)->firstOrFail();
//     return new GlobalMaillable($template);
// });