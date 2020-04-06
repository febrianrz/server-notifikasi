<?php

namespace App\Http\Controllers\Api;

use DataTables;
use App\Channel;
use Illuminate\Http\Request;
use Febrianrz\Makeapi\Select2;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChannelRequest;
use App\Http\Resources\ChannelResource;
use Febrianrz\Makeapi\Helpers\MAHelper;

class ChannelController extends Controller
{
    protected $model = Channel::class;

    protected $relationships = [];

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Channel::query();

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
                    return ChannelResource::collection($query->paginate());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ChannelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChannelRequest $request)
    {
        $channel = new Channel();

        $channel->fill(
            $request->only([
                'name',
            ])
        );

        $channel->save();

        return [
            'message' => "Channel [{$channel->name}] berhasil dibuat",
            'data' => $channel,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        $this->loadRelationships($channel);

        return ['data' => $channel];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ChannelRequest  $request
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(ChannelRequest $request, Channel $channel)
    {
        $name = $channel->name;

        $channel->fill(
            $request->only([
                'name',
            ])
        );

        $channel->save();

        return [
            'message' => "Channel [{$name}] berhasil diubah",
            'data' => $channel,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();

        return [
            'message' => "Channel [{$channel->name}] berhasil dihapus",
            'data' => $channel,
        ];
    }
}
