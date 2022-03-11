<?php

namespace Plank\MediaManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $model = config('media-manager.model');
        $table = (new $model())->getTable();

        return [
            'id' => "required|exists:{$table}",
            'disk' => "string",
            'path' => "string|nullable",
            'rename' => "string|nullable",
            'title' => "required|string"
        ];
    }
}
