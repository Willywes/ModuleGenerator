@extends('intranet.template.base')
@section('title', $config['blade']['viewTitle'])

@if ($config['blade']['showBreadcrumb'])
@section('breadcrumb')
    @php(array_push($config['breadcrumb'], ['link'=>'', 'name' =>  $config['blade']['viewEdit']]))
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
                <div class="panel-body">
                    @include('intranet.template.components._alerts')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="25%" class="bold">
                                            Nombre
                                        </td>
                                        <td width="25%">
                                            {{ $object->name }}
                                        </td>
                                        <td width="25%" class="bold">
                                            Clase
                                        </td>
                                        <td width="25%">
                                            {{ $object->class }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%" class="bold">
                                            Carpeta Base
                                        </td>
                                        <td width="25%">
                                            {{ $object->base_folder }}
                                        </td>
                                        <td width="25%" class="bold">
                                            Controlador
                                        </td>
                                        <td width="25%">
                                            {{ $object->controller }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%" class="bold">
                                            Nombre Ruta
                                        </td>
                                        <td width="25%">
                                            {{ $object->base_route_name }}
                                        </td>
                                        <td width="25%" class="bold">
                                            Singular
                                        </td>
                                        <td width="25%">
                                            {{ $object->singular_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%" class="bold">
                                            Nombre Ruta Base
                                        </td>
                                        <td width="25%">
                                            {{ $object->base_route }}
                                            ({{ '/'. str_replace('.','/', $object->base_route) .'/'}})
                                        </td>
                                        <td width="25%" class="bold">
                                            Pural
                                        </td>
                                        <td width="25%">
                                            {{ $object->plural_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%" class="bold">
                                            Descripción
                                        </td>
                                        <td width="25%" colspan="3">
                                            {{ $object->description }}
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="tab-base">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab-model" data-toggle="tab" aria-expanded="true">Modelo</a>
                    </li>
                    <li class="">
                        <a href="#tab-controller" data-toggle="tab" aria-expanded="false">Controlador</a>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab-model">
                        @include('willywes::model.html')
                    </div>

                    <div class="tab-pane fade" id="tab-controller">
                        @include('willywes::controller.html')
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('styles')

@endsection

@section('scripts')

    <script>
        let data = @json($object);

        let defaultMethods = [
            '', // for bug
            'index',
            'create',
            'store',
            'update',
            'edit',
            'show',
            'destroy',
            'active',
            'changeStatus',
        ];


        $(() => {
            createClass();
            createController();
        })
    </script>

    @include('willywes::model.scripts')

    @include('willywes::controller.scripts')

@endsection
