<?php


namespace Plank\MediaManager\Http\Controllers;


use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Plank\MediaManager\Actions\DiscoverMediables;

class MediaAttachController extends BaseController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // If no models are configured as mediable attempt auto-discovery
        // Note: it's highly recommended to register models as Mediable in the config file.
        $allowedModels = config('media-manager.mediable_models') ?: DiscoverMediables::execute();
        $table = app($request->get('model'))->getTable();
        $mediaTable = app(config('media-manager.model'))->getTable();
        $validated = $request->validate([
            'model' => [Rule::in($allowedModels), 'required'],
            'model_id' => "required|exists:{$table},id",
            'media' => "required|exists:{$mediaTable},id",
            'tag' => "required|array",
            'sync' => "nullable|boolean"
        ]);

        $model = $validated['model'];
        $attach = $model::find($validated['model_id']);
        $method = $validated['sync'] ? "syncMedia" : "attachMedia";

        return response([
            'success' => true,
            'data' => $attach->$method($validated['media'], $validated['tags'])
        ]);
    }
}
