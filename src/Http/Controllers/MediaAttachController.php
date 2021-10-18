<?php


namespace Plank\MediaManager\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Plank\MediaManager\Actions\DiscoverMediables;
use Plank\MediaManager\Models\Media;

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
        $model = ucfirst($request->get('model'));
        $table = app("App\\Model\\{$model}")->getTable();
        $mediaTable = app(config('media-manager.model'))->getTable();
        $validated = $request->validate(array_merge([
            'model' => [Rule::in($allowedModels), 'required'],
            'model_id' => "required|exists:{$table},id",
            'tag' => "required|array",
            'sync' => "nullable|boolean",
        ], is_array($request->get('media')) ? ['media' => 'required|array'] : ['media' => "required|exists:{$mediaTable},id"]));

        $model = $validated['model'];
        $attach = $model::find($validated['model_id']);
        $sync = $validated['sync'] ?? false;
        try {
            $method = $sync ? "syncMedia" : "attachMedia";
        } catch (QueryException $e) {
            return response([
                'success' => false,
                'message' => "That media is already attached with that tag."
            ]);
        }
        $attach->$method($validated['media'], $validated['tag']);

        return response([
            'success' => true,
            'data' => $attach->loadMedia($validated['tag'])->media
        ]);
    }
}
