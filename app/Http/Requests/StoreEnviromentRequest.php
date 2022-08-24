<?php

namespace App\Http\Requests;

use App\Models\Enviroment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEnviromentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('enviroment_create');
    }

    public function rules()
    {
        return [
            'enviroment' => [
                'string',
                'required',
            ],
            'baseurl' => [
                'string',
                'required',
            ],
        ];
    }
}
