<?php

namespace App;

use Webpatser\Uuid\Uuid;
use App\Mail\GlobalMaillable;
use Febrianrz\Makeapi\HasUUID;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Notification extends Model
{
    use HasUUID;

    protected $guarded = [];

    public $incrementing = false;

    protected $casts = [
        'data'  => 'json',
        'is_sending'    => 'boolean',
        'is_queue'  => 'boolean',
        'attachment_request'    => 'json',
        'attachment_storage'    => 'json',
        'to_user'               => 'json'
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class,'channel_id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class,'template_id');
    }

    public function send()
    {
        if($this->channel->code == "email" && $this->channel->is_active){
            $this->sendEmail();
        }
    }

    private function sendEmail()
    {
        $this->trying_send += 1;
        try {
            Mail::to($this->to)->send(new GlobalMaillable($this));
            $this->response_text = "Email berhasil dikirim";
            $this->is_sending = true;
            $this->sent_at = date('Y-m-d H:i:s');    
            $this->save();
        } catch(\Exception $e){
            $this->response_text = $e->getMessage();
            $this->save();
        }
    }

    public static function convert($templateHtml, $arrayData){
        // dd($arrayData);
        foreach($arrayData as $key => $value){
            $templateHtml = str_replace("[{$key}]",$value,$templateHtml);
        }
        return $templateHtml;
    }

    public static function downloadAttachmentToStorage($url){
        $tempId = (string)Uuid::generate();
        $tempImage = tempnam(sys_get_temp_dir(), $tempId);
        copy($url, $tempImage);
        $path = date('Y-m-d');
        $storagePath = "public/attachment/{$path}";
        Storage::makeDirectory($storagePath);

        $fileName = (string)Uuid::generate();
        
        if(mime_content_type($tempImage) == "application/pdf"){
            $fileName .= ".pdf";
        } else if(mime_content_type($tempImage) == "image/png"){
            $fileName .= ".png";
        } 

        $storagePath = Storage::path("{$storagePath}/{$fileName}");
        copy($tempImage, $storagePath);
        return $storagePath;
    }
}
