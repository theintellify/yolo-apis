@extends('layouts.admin')
@section('content')
@can('yolo_api_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.yolo-apis.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.yoloApi.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.yoloApi.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-YoloApi">
                <thead>
                    <tr>
                        <!-- <th width="10">

                        </th> -->
                        <th>
                            {{ trans('cruds.yoloApi.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.yoloApi.fields.api_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.yoloApi.fields.enviroment') }}
                        </th>
                        <th>
                            {{ trans('cruds.yoloApi.fields.api_type') }}
                        </th>
                        <th >
                            {{ trans('cruds.yoloApi.fields.url') }}
                        </th>
                        <th>
                            {{ trans('cruds.yoloApi.fields.message_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.yoloApi.fields.endpoint') }}
                        </th>
                        <!-- <th>
                            {{ trans('cruds.yoloApi.fields.cognito') }}
                        </th> -->
                       <!--  <th>
                            {{ trans('cruds.yoloApi.fields.request_body') }}
                        </th>
                        <th>
                            {{ trans('cruds.yoloApi.fields.response_data') }}
                        </th> -->
                        <th >
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($yoloApis as $key => $yoloApi)
                        <tr data-entry-id="{{ $yoloApi->id }}">
                            <!-- <td>

                            </td> -->
                            <td>
                                {{ $yoloApi->id ?? '' }}
                            </td>
                            <td>
                                {{ $yoloApi->api_name ?? '' }}
                            </td>
                            <td>
                               {{ $yoloApi->enviroment->enviroment ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\YoloApi::API_TYPE_SELECT[$yoloApi->api_type] ?? '' }}
                            </td>
                            <td  >
                                {{ $yoloApi->url ?? '' }}
                            </td>
                            <td>
                                {{ $yoloApi->message_name ?? '' }}
                            </td>
                            <td>
                                {{ $yoloApi->endpoint ?? '' }}
                            </td>
                           <!--  <td>
                                {{ $yoloApi->cognito ?? '' }}
                            </td> -->
                           <!--  <td>
                                {{ $yoloApi->request_body ?? '' }}
                            </td>
                            <td>
                                {{ $yoloApi->response_data ?? '' }}
                            </td> -->
                            <td style="width: 180.662px !important;">
                                @can('yolo_api_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.yolo-apis.show', $yoloApi->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('yolo_api_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.yolo-apis.edit', $yoloApi->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('yolo_api_delete')
                                    <form action="{{ route('admin.yolo-apis.destroy', $yoloApi->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                                <a class="btn btn-xs btn-warning text-white" href="{{ URL::to('admin/yolo-apis/try',$yoloApi->id) }}">Try</a>



                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('yolo_api_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.yolo-apis.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    //order: [[ 0, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-YoloApi:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection