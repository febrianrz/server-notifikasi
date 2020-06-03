<?php

namespace App\Http\Controllers\Api;

use DataTables;
use App\WebNotification;
use App\Helpers\Select2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebNotificationRequest;
use App\Http\Resources\WebNotificationResource;
use Febrianrz\Makeapi\Helpers\MAHelper;

class WebNotificationController extends Controller
{
    protected $model = WebNotification::class;

    protected $relationships = [];

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = WebNotification::query();

        $this->loadRelationships($query);

        if($request->has('to') && $request->to){
            $query->where('to',$request->to);
        }

        switch ($request->format) {
            case "datatable":
                return DataTables::of($query)
                    ->make(true);
            default:
                    MAHelper::filter($request,$query);
                    return WebNotificationResource::collection($query->paginate());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\WebNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebNotificationRequest $request)
    {
        $webNotification = new WebNotification();

        $webNotification->fill(
            $request->only([
                'to',
                'title',
                'content',
                'type',
                'link'
            ])
        );

        $webNotification->save();

        return [
            'message' => "Web Notification [{$webNotification->to}] berhasil dibuat",
            'data' => $webNotification,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WebNotification  $webNotification
     * @return \Illuminate\Http\Response
     */
    public function show(WebNotification $webNotification)
    {
        $this->loadRelationships($webNotification);

        return ['data' => $webNotification];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\WebNotificationRequest  $request
     * @param  \App\WebNotification  $webNotification
     * @return \Illuminate\Http\Response
     */
    public function update(WebNotificationRequest $request, WebNotification $webNotification)
    {
        $name = $webNotification->name;

        $webNotification->fill(
            $request->only([
                'name',
            ])
        );

        $webNotification->save();

        return [
            'message' => "Web Notification [{$name}] berhasil diubah",
            'data' => $webNotification,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WebNotification  $webNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebNotification $webNotification)
    {
        $webNotification->delete();

        return [
            'message' => "Web Notification [{$webNotification->name}] berhasil dihapus",
            'data' => $webNotification,
        ];
    }
}
