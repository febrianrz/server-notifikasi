<?php

namespace App\Http\Controllers\Api;

use DataTables;
use App\Notification;
use App\Helpers\Select2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use Febrianrz\Makeapi\Helpers\MAHelper;

class NotificationController extends Controller
{
    protected $model = Notification::class;

    protected $relationships = [];

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Notification::query();

        $this->loadRelationships($query);

        switch ($request->format) {
            case 'select2':
                return Select2::of(
                    $query->orderBy('id'),
                    'name',
                    'id'
                );

            case "datatable":
                return DataTables::of($query)
                    ->toJson();
            default:
                    MAHelper::filter($request,$query);
                    return NotificationResource::collection($query->paginate());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\NotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationRequest $request)
    {
        $notification = new Notification();

        $notification->fill(
            $request->only([
                'name',
            ])
        );

        $notification->save();

        return [
            'message' => "Notification [{$notification->name}] berhasil dibuat",
            'data' => $notification,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        $this->loadRelationships($notification);

        return ['data' => $notification];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\NotificationRequest  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationRequest $request, Notification $notification)
    {
        $name = $notification->name;

        $notification->fill(
            $request->only([
                'name',
            ])
        );

        $notification->save();

        return [
            'message' => "Notification [{$name}] berhasil diubah",
            'data' => $notification,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return [
            'message' => "Notification [{$notification->name}] berhasil dihapus",
            'data' => $notification,
        ];
    }
}
