<?php

namespace App\Http\Controllers\Api;

use DataTables;
use App\Template;
use App\Helpers\Select2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\TemplateRequest;
use App\Http\Resources\TemplateResource;
use Febrianrz\Makeapi\Helpers\MAHelper;

class TemplateController extends Controller
{
    protected $model = Template::class;

    protected $relationships = [
        'channel'
    ];

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Template::query();
        $query->select('templates.*');

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
                    return TemplateResource::collection($query->paginate());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TemplateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateRequest $request)
    {
        $template = new Template();

        $data = $request->only([
            'channel_id',
            'name',
            'code',
            'description',
        ]);
        $data['template'] = $request->template;

        $template->fill($data);

        $template->save();

        return [
            'message' => "Template [{$template->name}] berhasil dibuat",
            'data' => $template,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        $this->loadRelationships($template);

        return ['data' => $template];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TemplateRequest  $request
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(TemplateRequest $request, Template $template)
    {
        $name = $template->name;

        $data = $request->only([
            'channel_id',
            'name',
            'code',
            'description',
        ]);
        $data['template'] = $request->template;

        $template->fill($data);

        $template->save();

        return [
            'message' => "Template [{$name}] berhasil diubah",
            'data' => $template,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        $template->delete();

        return [
            'message' => "Template [{$template->name}] berhasil dihapus",
            'data' => $template,
        ];
    }
}
