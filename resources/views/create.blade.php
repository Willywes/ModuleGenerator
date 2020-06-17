@extends('intranet.template.base')
@section('title', $config['blade']['viewTitle'])

@if ($config['blade']['showBreadcrumb'])
@section('breadcrumb')
    @php(array_push($config['breadcrumb'], ['link'=>'', 'name' => $config['blade']['viewCreate']]))
    @foreach($config['breadcrumb'] as $key => $data)
        <li><a href="{{ $data['link'] }}"
               class="{{ count($config['breadcrumb']) == $key + 1 ? 'active' : '' }}">{{ $data['name'] }}</a></li>
    @endforeach
@endsection
@endif

@section('toolbar-buttons')
    <a href="{{route($config['route'] . 'index')}}" class="btn btn-default"><i
            class="fa fa-chevron-left"></i> {{ $config['blade']['btnBack']}}</a>
    <button class="btn btn-primary" type="button" onclick="doSubmit('form-create')"><i
            class="fa fa-save"></i> {{ $config['blade']['btnSave']}}</button>
@endsection

@section('content')

    <form id="form-create" action="{{ route($config['route'] . 'store') }}" enctype="multipart/form-data" method="POST">
        <button type="submit" class="hide"></button>
        @csrf()
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        @include('intranet.template.components._alerts')
                        <div class="row">
                            <div class="col-md-4">
                                <h4>
                                    Detalles del Componente
                                </h4>
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nombre Modulo(*)</label>
                                            <input type="text" id="name" name="name" class="form-control" required
                                                   value="{{ old('name') }}">
                                            <small class="form-text text-muted">users</small>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="gender">Genero(*)</label>
                                            <select type="text" id="gender" name="gender" class="form-control" required>
                                                <option value="male" {{ old('name') == 'male' ? 'selected' : '' }}>
                                                    Male
                                                </option>
                                                <option value="female" {{ old('name') == 'female' ? 'selected' : '' }}>
                                                    Female
                                                </option>
                                            </select>
                                            <small class="form-text text-muted">male or female</small>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="singular_name">Nombre Singular(*)</label>
                                            <input type="text" id="singular_name" name="singular_name"
                                                   class="form-control"
                                                   required
                                                   value="{{ old('singular_name') }}">
                                            <small class="form-text text-muted">Usuario</small>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="plural_name">Nombre Plural(*)</label>
                                            <input type="text" id="plural_name" name="plural_name" class="form-control"
                                                   required
                                                   value="{{ old('plural_name') }}">
                                            <small class="form-text text-muted">Usuarios</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Descripción(*)</label>
                                            <textarea type="text" id="description" rows="7" name="description"
                                                      class="form-control"
                                                      required>{{ old('description') }}</textarea>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4>
                                    Fuente
                                </h4>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="base_route_name">Ruta Names (*)</label>
                                            <input type="text" id="base_route_name" name="base_route_name"
                                                   class="form-control"
                                                   required
                                                   value="{{ old('base_route_name') }}">
                                            <small class="form-text text-muted">intranet.users</small>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="base_route">Ruta Base (*)</label>
                                            <input type="text" id="base_route" name="base_route" class="form-control"
                                                   required
                                                   value="{{ old('base_route') }}">
                                            <small class="form-text text-muted">intranet.modules.users</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="base_folder">Carpeta Base (*)</label>
                                            <input type="text" id="base_folder" name="base_folder" class="form-control"
                                                   required
                                                   value="{{ old('base_folder') }}">
                                            <small class="form-text text-muted">intranet.modules.users</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="class">Clase (*)</label>
                                            <input type="text" id="class" name="class" class="form-control" required
                                                   value="{{ old('class') }}">
                                            <small class="form-text text-muted">User</small>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="controller">Controllador (*)</label>
                                            <input type="text" id="controller" name="controller" class="form-control"
                                                   required
                                                   value="{{ old('controller') }}">
                                            <small class="form-text text-muted">UserController</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h4>
                                    Detalles de Permisos y Grupos
                                </h4>

                                <div class="row">
                                    <div class="col-md-12">

                                        <table class="table table">
                                            <thead>
                                            <tr>
                                                <th>
                                                    type
                                                </th>
                                                <th>
                                                    Method
                                                </th>
                                                <th>
                                                    Permission Name
                                                </th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="methodList">

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="{{route($config['route'] . 'index')}}" class="btn btn-default"><i
                                        class="fa fa-chevron-left"></i> {{ $config['blade']['btnBack']}}</a>
                            </div>
                            <div class="col-xs-6 text-right">
                                <button class="btn btn-primary" type="submit"><i
                                        class="fa fa-save"></i> {{ $config['blade']['btnSave']}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('styles')

@endsection

@section('scripts')
    <script>

        let list = [
            {
                type: 'get',
                name: 'index'
            },
            {
                type: 'get',
                name: 'create'
            },
            {
                type: 'post',
                name: 'store'
            }, {
                type: 'get',
                name: 'show'
            }
            , {
                type: 'get',
                name: 'edit'
            }
            , {
                type: 'put',
                name: 'update'
            }
            , {
                type: 'delete',
                name: 'destroy'
            }
            , {
                type: 'post',
                name: 'active'
            }
            , {
                type: 'post',
                name: 'changeStatus'
            }
        ];
        $(() => {
            $('#plural_name').change(() => {
                $('#description').html('Módulo de ' + $('#plural_name').val());
            });

            $('#class').change(() => {
                $('#controller').val($('#class').val() + 'Controller');
            });

            $('#name').change(() => {
                $('#base_route_name').val('intranet.' + $('#name').val());
                $('#base_route').val('intranet.' + $('#name').val());
                $('#base_folder').val('intranet.modules.' + $('#name').val());
            });

            let html = '';
            list.forEach(function (item, index) {
                html += '<tr class="l-' + index + '">\n' +
                    '    <td>\n' +
                    '        <input readonly type="text" class="form-control "\n' +
                    '               name="methods['+ index +'][type]"\n' +
                    '               value="' + item.type + '">\n' +
                    '    </td>\n' +
                    '    <td>\n' +
                    '        <input readonly type="text" class="form-control "\n' +
                    '               name="methods['+ index +'][name]"\n' +
                    '               value="' + item.name + '">\n' +
                    '    </td>\n' +
                    '    <td>\n' +
                    '        <input readonly type="text" class="form-control "\n' +
                    '               name="methods['+ index +'][permission]"\n' +
                    '               value="' + item.name + '">\n' +
                    '    </td>\n' +
                    '    <td>\n' +
                    '        <button class="btn btn-danger" onclick="$(\'.l-' + index +'\').remove()"><i\n' +
                    '                class="fa fa-remove"></i>\n' +
                    '        </button>\n' +
                    '    </td>\n' +
                    '</tr>'
            });

            $('#methodList').html(html);
        })
    </script>
@endsection
