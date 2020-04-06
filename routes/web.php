<?php

// use Parsedown;
use App\Template;
use App\Notification;
use Webpatser\Uuid\Uuid;
use App\Mail\GlobalMaillable;
use Illuminate\Support\HtmlString;

Route::get('/', function(){
    return redirect('https://alterindonesia.com');
});

Route::get('format', function(){
    $format = [
        [
            'user_id'=> null,
            'to'    => 'febrianrz@gmail.com',
            'template' => 'simple_reset_password',
            'queue' => false,
            'title' => 'Title',
            'from'  => 'from@from.com',
            'notes' => 'catatan',
            'data'    => [
                'name'  => 'Febrian Reza',
                'email' => 'febrianrz@gmail.com',
                'link'  => 'asdfadsf'
            ],
            'attachment' => [
                [
                    'url'   => 'https://www.te.com/commerce/DocumentDelivery/DDEController?Action=srchrtrv&DocNm=5223955&DocType=Customer+Drawing&DocLang=English',
                    'name'  => 'ujicoba.pdf'
                ]
            ]
        ],
        [
            'to'    => 'febrianrzh@gmail.com',
            'template' => 'simple_reset_password',
            'queue' => true,
            'data'    => [
                'name'  => 'Reza',
                'email' => 'febrianrz@gmail.com',
                'link'  => 'asdfadsf'
            ],
            'attachment' => [
                'http://asdfasdf',
                'http://tesattachement'
            ]
        ],
    ];
//    dd(json_encode($format));
    return response()->json($format);
});

Route::get('tesdownload', function(Request $request){
    $url = "http://www.orimi.com/pdf-test.pdf";
    return Notification::downloadAttachmentToStorage($url);
});

Route::get('tesmail/{id}', function($id){
    $notif = Notification::findOrFail($id);
    $notif->send();
    dd($notif->to);
});

Route::get('view/{code}',function($code){
    $template = Template::where('code',$code)->firstOrFail();
    return new GlobalMaillable($template);
});