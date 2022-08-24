<?php

namespace App\Http\Requests;

use App\Models\YoloApi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreYoloApiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('yolo_api_create');
    }

    public function rules()
    {
        return [
            'enviroment_id' => [
                'required',
                'integer',
            ],
            'api_type' => [
                'required',
            ],
            'url' => [
                'string',
                'required',
            ],
            'endpoint' => [
                'string',
                'required',
            ],
            'cognito' => [
                'string',
                'required',
            ],
            'request_body' => [
                'required',
            ],
        ];
    }
}
