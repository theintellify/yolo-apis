<?php

namespace App\Http\Requests;

use App\Models\YoloApi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyYoloApiRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('yolo_api_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:yolo_apis,id',
        ];
    }
}
