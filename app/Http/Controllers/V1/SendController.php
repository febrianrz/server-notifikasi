<?php

namespace App\Http\Controllers\V1;

use App\Notification;
use Ramsey\Uuid\Uuid;
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
                        Notification::firstOrCreate([
                            'app_id'    => $request->app_id,
                            'channel'   => $key,
                            'to'        =>  $to,
                            'from'      => ($request->has('from')?$request->from:'system@alterindonesia.com'),
                            'subject'   => $request->subject,
                            'body'      => $request->body,
                            'description'=> $request->description
                        ], [

                            'id' => Uuid::uuid1(),
                            'attachment'=> $file
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
}
