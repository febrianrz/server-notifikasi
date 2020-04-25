<?php

namespace App\Http\Controllers\V1;

use App\Template;
use App\Notification;
use Ramsey\Uuid\Uuid;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SendController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'channel'   => 'required|array',
            'channel.*' => 'required|array',
            'subject'   => 'required|string|max:255',
            'attachment'=> 'nullable|file|max:2048',
            'body'      => 'required|string|max:5000',
            'description'=> 'nullable|string',
            'from'      => 'nullable'
        ]);

        try {
            DB::beginTransaction();
            // dd($request->channel);
            $file = null;
            if($request->has('attachment')) $file = $request->file('attachment')->store('public/attachment');
            
            foreach($request->channel as $key => $value){
                $arr = ["email","telegram","web"];
                if(in_array($key,$arr)){
                    foreach($value as $to){
                        Notification::create([
                            'id' => Uuid::uuid1(),
                            'attachment'=> $file,
                            'app_id'    => $request->app_id,
                            'channel'   => $key,
                            'to'        =>  $to,
                            'from'      => ($request->has('from')?$request->from:'system@alterindonesia.com'),
                            'subject'   => $request->subject,
                            'body'      => $request->body,
                            'description'=> $request->description
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'message'   => 'Berhasil membuat notifikasi dan masuk dalam antrian'
            ]);
        } catch(\Exception $e){
            DB::rollback();
            return abort(500,$e->getMessage());
        }
    }

    public function sendV2(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);
            if(!$data) throw new \Exception("Invalid data");
            DB::beginTransaction();
            foreach($data as $dt){
                if(!isset($dt['to'])) throw new \Exception("Tujuan pengiriman tidak valid atau format tidak sesuai");
                if(!isset($dt['template'])) throw new \Exception("Template wajib diisi");
                if(!isset($dt['data'])) throw new \Exception("Data wajib diisi");
                if(!is_array($dt['data'])) throw new \Exception("Data harus berupa array key value");
                
                
                $attachment_storage = [];
                if(isset($dt['attachment'])) {
                    if(!is_array($dt['attachment'])) throw new \Exception("Data harus berupa array");
                    foreach($dt['attachment'] as $key){
                        if (!filter_var($key, FILTER_VALIDATE_URL)) throw new \Exception("[{$key}] Attachment harus berupa link URL pdf / png");
                        $file = Notification::downloadAttachmentToStorage($key);
                        array_push($attachment_storage,$file);
                    }
                }
                
                $to = $dt['to'];
                $template = Template::where('code',$dt['template'])->first();
                if(!$template) throw new \Exception("Template tidak tesedia");

                if ($template->channel->code == "email") {
                    if(!filter_var($to, FILTER_VALIDATE_EMAIL)){
                        throw new \Exception("${to} bukan email yang valid");
                    }
                }

                $queue = $dt['queue'] ?? false;
                $title = $dt['title'] ?? $template->name;
                $from = $dt['from'] ?? 'system@alterindonesia.com';
                $notes = $dt['notes'] ?? null;

                Notification::create([
                    'app_id'    => 1,
                    'app'       => null,
                    'channel_id'   => $template->channel_id,
                    'template_id' => $template->id,
                    'to'        =>  $to,
                    'from'      => $from,
                    'subject'   => $title,
                    'is_sending'=> false,
                    'description'=> $notes,
                    'is_queue'  => $queue,
                    'data'      => $dt['data'],
                    'attachment_request'    => $dt['attachment'] ?? [],
                    'attachment_storage' => $attachment_storage
                ]);
                
            }
            DB::commit();
            return response()->json([
                'message'   => 'Ok'
            ]);
        } catch(\Exception $e){
            DB::rollback();
            return abort(400,$e->getMessage());
        }
    }

    private function isUrlValid($url){
        $file = $url;
        $file_headers = @get_headers($file);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $exists = false;
        }
        else {
            $exists = true;
        }
    }

    public function resend($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->send();
        return response()->json([
            'message'   => 'Notifikasi telah dikirim',
            'data'      => $notif
        ]);
    }
}
