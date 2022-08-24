<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEnviromentRequest;
use App\Http\Requests\StoreEnviromentRequest;
use App\Http\Requests\UpdateEnviromentRequest;
use App\Models\Enviroment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnviromentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('enviroment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enviroments = Enviroment::all();

        return view('admin.enviroments.index', compact('enviroments'));
    }

    public function create()
    {
        abort_if(Gate::denies('enviroment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.enviroments.create');
    }

    public function store(StoreEnviromentRequest $request)
    {
        $enviroment = Enviroment::create($request->all());

        return redirect()->route('admin.enviroments.index');
    }

    public function edit(Enviroment $enviroment)
    {
        abort_if(Gate::denies('enviroment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.enviroments.edit', compact('enviroment'));
    }

    public function update(UpdateEnviromentRequest $request, Enviroment $enviroment)
    {
        $enviroment->update($request->all());

        return redirect()->route('admin.enviroments.index');
    }

    public function show(Enviroment $enviroment)
    {
        abort_if(Gate::denies('enviroment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.enviroments.show', compact('enviroment'));
    }

    public function destroy(Enviroment $enviroment)
    {
        abort_if(Gate::denies('enviroment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enviroment->delete();

        return back();
    }

    public function massDestroy(MassDestroyEnviromentRequest $request)
    {
        Enviroment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getenviromentUrl(Request $request,$id)
    {
        $getUrl = Enviroment::find($id);
        return response(['data'=>$getUrl],Response::HTTP_OK);
        
    }
}
