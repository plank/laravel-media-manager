<?php

namespace Plank\MediaManager\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MediaStoreRequest extends FormRequest
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
            'file' => ['required', 'file_array'],
            'title' => ['sometimes', 'string'],
            'alt' => ['sometimes', 'string'],
            'caption' => ['sometimes', 'string'],
            'credit' => ['sometimes', 'string'],
        ];
    }

//    public function messages()
//    {
//        return [
//            'title.required_without' => 'A title is required',
//        ];
//    }
}
