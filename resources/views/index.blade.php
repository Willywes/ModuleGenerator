@extends('intranet.template.base')
@section('title', $config['blade']['viewTitle'])

@if ($config['blade']['showBreadcrumb'])
@section('breadcrumb')
    @foreach($config['breadcrumb'] as $key => $data)
        <li><a href="{{ $data['link'] }}"
               class="{{ count($config['breadcrumb']) == $key + 1 ? 'active' : '' }}">{{ $data['name'] }}</a></li>
    @endforeach
@endsection
@endif

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
{{--                <div class="panel-heading">--}}
{{--                    <h3 class="panel-title"></h3>--}}
{{--                </div>--}}
                <div class="panel-body">
                    @include('intranet.template.components._alerts')
                    <div id="toolbar">
                        @if($config['action']['create'])
                            <a href="{{ route($config['route'] . 'create') }}" class="btn btn-success"><i
                                    class="ti-plus"></i> {{$config['blade']['btnNew']}}</a>
                        @endif
                    </div>

                    <table id="table-bs"
                           data-toolbar="#toolbar"
                           data-cookie="true"
                           data-cookie-id-table="{{$config['tableCookie']}}"
                           data-search="true"
                           data-show-refresh="false"
                           data-show-export="false"
                           data-show-toggle="false"
                           data-show-columns="true"
                           data-sort-name="id"
                           data-page-list="[5, 10, 20]"
                           data-page-size="10"
                           data-pagination="true"
                           data-show-pagination-switch="true">
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')

@endsection

@section('scripts')

    <script>
        $(document).ready(function () {

            let columns = [

                {
                    title: 'Nombre',
                    field: 'name',
                    sortable: true,
                    cellStyle: midAling,
                },
                {
                    title: 'F. Registro',
                    field: 'created_at',
                    sortable: true,
                    formatter: function (value, row, index) {
                        return moment(row.created_at).format('DD-MM-YYYY HH:mm:ss');
                    }
                }
            ];

            @if($config['action']['changeStatus'] and \Route::has($config['route']  . 'changeStatus'))
            columns.push({
                title: 'Cambiar Estado',
                field: 'changeStatus',
                align: 'center',
                cellStyle: cellStyle,
                clickToSelect: false,
                formatter: function (value, row, index) {

                }
            });
            @endif

            @if($config['action']['active'] and \Route::has($config['route'] . 'active'))
            columns.push({
                title: 'Activo',
                field: 'active',
                align: 'center',
                cellStyle: cellStyle,
                clickToSelect: false,
                formatter: function (value, row, index) {
                    return getActiveButton(row.id, row.active);
                }
            });
            @endif

            @if($config['blade']['showActions'] and $config['any_action'])

            columns.push({
                title: 'Acciones',
                field: 'active',
                align: 'center',
                cellStyle: cellStyle,
                clickToSelect: false,
                formatter: function (value, row, index) {
                    let append = '';
                    let prepend = '';
                    return getShowActionButtons(row, prepend, append);

                }
            });

            @endif

            $('#table-bs').bootstrapTable({
                data: @json($objects),
                columns: columns,
            });

            runActiveControl()
        });
    </script>

    @include('intranet.template.components._crud_script_actions_buttons')
    @include('intranet.template.components._crud_script_active')
    @include('intranet.template.components._crud_script_change_status')
    @include('intranet.template.components._crud_script_delete')


@endsection

