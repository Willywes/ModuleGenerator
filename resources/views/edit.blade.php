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
                    <li class="active"><a href="#tab-controller" data-toggle="tab" aria-expanded="true">Controlador</a>
                    </li>
                    <li class=""><a href="#tab-cosa" data-toggle="tab" aria-expanded="false">Address</a></li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab-controller">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary" onclick="createController();">Create Controller</button>
                                <button class="btn btn-info" title="Copiar" onclick="copyContentController();"><i
                                        class="fa fa-copy"></i></button>
                            </div>
                        </div>
                        <div class="row py-4">
                            <div class="col-md-12">
                                <textarea id="contentController" class="form-control" rows="30"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-cosa">

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
        console.log(data);
    </script>
    <script>

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

        function copyContentController() {
            $('#contentController').select();
            document.execCommand('copy');
        }

        function getCleanRouteName(name) {
            return (name).replace(data.base_route + '.', '');
        }

        function checkInArrayMethods(name) {
            console.log(jQuery.inArray(name, defaultMethods));
            console.log(jQuery.inArray(name, defaultMethods) > 0);
            return jQuery.inArray(name, defaultMethods) > 0;

        }

        function getEnableActions() {
            let str = '';
            data.module_routes.forEach((item) => {
                if (item.has_permission == 1) {
                    let temp = getCleanRouteName(item.name);
                    if (!checkInArrayMethods(temp)) {
                        str += '\'' + temp + '\'' + ','
                    }
                }

            });
            return str;
        }

        function getDisableActions() {
            let str = '';
            data.module_routes.forEach((item) => {
                if (item.has_permission == 0) {
                    let temp = getCleanRouteName(item.name);
                    if (checkInArrayMethods(temp)) {
                        str += '\'' + temp + '\'' + ','
                    }
                }
            });

            return str;
        }


        function createController() {


            let header = 'namespace App\\Http\\Controllers\\Intranet\\Config;\n' +
                'use App\\Http\\Controllers\\Intranet\\GlobalController;\n' +
                'use App\\Models\\' + data.class + ';\n' +
                'use Illuminate\\Http\\Request;\n' +
                'use Illuminate\\Support\\Facades\\Validator;\n\n';

            let body = '';

            // options
            body += '   protected $options = [\n' +
                '        \'route\' => \'' + data.base_route + '.' + '\',\n' +
                '        \'folder\' => \'' + data.base_folder + '.' + '\',\n' +
                '        \'pluralName\' => \'' + data.plural_name + '\',\n' +
                '        \'singularName\' => \'' + data.singular_name + '\',\n' +
                '        \'disableActions\' => [' + getDisableActions() + '],\n' +
                '        \'enableActions\' => [' + getEnableActions() + '],\n' +
                '        \'gender\' => \'' + data.gender + '\'\n' +
                ' ];\n\n';

            // constructor
            body += '   public function __construct()\n' +
                '    {\n' +
                '        parent::__construct($this->options);\n' +
                '    }\n';

            data.module_routes.forEach((item) => {

                if (item.has_permission == 1) {
                    body += getDefaultFunctionsController(getCleanRouteName(item.name));
                    // if (checkInArrayMethods(getCleanRouteName(item.name))) {
                    //
                    // } else {
                    //     body += '   public function ' + getCleanRouteName(item.name) + '()\n' +
                    //         '    {\n' +
                    //         '    }\n';
                    //
                    // }
                    body += '\n';
                }
            });


            let classBuild = '<' + '?php\n\n' + header;
            classBuild += 'class ' + data.controller + ' extends GlobalController\n' +
                '{\n' + body + '\n' +
                '}\n';

            $('#contentController').html(classBuild);
        }

        function getDefaultFunctionsController(name) {

            let art_singular = data.gender == 'male' ? 'el' : 'la';
            let art_plural = data.gender == 'male' ? 'los' : 'las';
            let createMessage = data.singular_name + ' ' + (data.gender == 'male' ? 'creado' : 'creada') + ' correctamente.';
            let updateMessage = data.singular_name + ' ' + (data.gender == 'male' ? 'actualizado' : 'actualizada') + ' correctamente.';
            let destroyMessage = data.singular_name + ' ' + (data.gender == 'male' ? 'eliminado' : 'eliminada') + ' correctamente.';
            let activeMessage = data.singular_name + ' ' + (data.gender == 'male' ? 'activada' : 'activada') + ' correctamente.';
            let disableMessage = data.singular_name + ' ' + (data.gender == 'male' ? 'desactivado' : 'desactivada') + ' correctamente.';
            let notFoundMessage = data.singular_name + ' no ' + (data.gender == 'male' ? 'encontrado' : 'encontrada') + '.';

            let body = '';

            if (name == 'index') {

                body += '   public function index()\n' +
                    '    {\n' +
                    '        $objects = ' + data.class + '::all();\n' +
                    '        return view($this->route . \'index\', compact(\'objects\'));\n' +
                    '    }\n';

            } else if (name == 'create') {

                body += '   public function create()\n' +
                    '    {\n' +
                    '        return view($this->route . \'create\');\n' +
                    '    }\n';

            } else if (name == 'store') {

                body += '   public function store()\n' +
                    '    {\n' +
                    '        $rules = [\n' +
                    '            \'name\' => \'required|string|unique:' + data.name + ',name\',\n' +
                    '        ];\n' +
                    '\n' +
                    '        $messages = [];\n' +
                    '\n' +
                    '        $validator = Validator::make($request->all(), $rules, $messages);\n' +
                    '\n' +
                    '        if ($validator->passes()) {\n' +
                    '            $object = ' + data.class + '::create($request->all());\n' +
                    '\n' +
                    '            if ($object) {\n' +
                    '                session()->flash(\'success\', \'' + createMessage + '\');\n' +
                    '                return redirect()->route($this->route . \'index\');\n' +
                    '            }\n' +
                    '            return redirect()->back()->withErrors([\'mensaje\' => \'Error inesperado al crear ' + art_singular + ' ' + (data.singular_name).toLowerCase() + '.\'])->withInput();\n' +
                    '        } else {\n' +
                    '            return redirect()->back()->withErrors($validator)->withInput();\n' +
                    '        }\n' +
                    '    }\n';

            } else if (name == 'show') {

                body += '   public function show($id)\n' +
                    '    {\n' +
                    '        $object = ' + data.class + '::find($id);\n' +
                    '        if (!$object) {\n' +
                    '            session()->flash(\'warning\', \'' + notFoundMessage + '\');\n' +
                    '            return redirect()->route($this->route . \'index\');\n' +
                    '        }\n' +
                    '        return view($this->folder . \'show\', compact(\'object\'));\n' +
                    '    }\n';

            } else if (name == 'edit') {

                body += '   public function edit($id)\n' +
                    '    {\n' +
                    '        $object = ' + data.class + '::find($id);\n' +
                    '        if (!$object) {\n' +
                    '            session()->flash(\'warning\', \'' + notFoundMessage + '\');\n' +
                    '            return redirect()->route($this->route . \'index\');\n' +
                    '        }\n' +
                    '        return view($this->folder . \'edit\', compact(\'object\'));\n' +
                    '    }\n';

            } else if (name == 'update') {

                body += '   public function update(Request $request, $id)\n' +
                    '    {\n' +
                    '        $rules = [\n' +
                    '            \'name\' => \'required|string|unique:' + data.name + ',name,\' . $id,\n' +
                    '        ];\n' +
                    '\n' +
                    '        $messages = [];\n' +
                    '\n' +
                    '        $validator = Validator::make($request->all(), $rules, $messages);\n' +
                    '\n' +
                    '        if ($validator->passes()) {\n' +
                    '\n' +
                    '            $object = ' + data.class + '::find($id);\n' +
                    '            $object->update($request->all());\n' +
                    '\n' +
                    '            if ($object) {\n' +
                    '                session()->flash(\'success\', \'' + updateMessage + '\');\n' +
                    '                return redirect()->route($this->route . \'index\');\n' +
                    '            }\n' +
                    '            return redirect()->back()->withErrors([\'mensaje\' => \'Error inesperada al modificar ' + art_singular + ' ' + (data.singular_name).toLowerCase() + '.\'])->withInput();\n' +
                    '        } else {\n' +
                    '            return redirect()->back()->withErrors($validator)->withInput();\n' +
                    '        }\n' +
                    '    }\n';

            } else if (name == 'destroy') {

                body += 'public function destroy($id)\n' +
                    '    {\n' +
                    '        $object = ' + data.class + '::find($id);\n' +
                    '\n' +
                    '        if (!$object) {\n' +
                    '            session()->flash(\'warning\', \'' + notFoundMessage + '\');\n' +
                    '            return redirect()->route($this->route . \'index\');\n' +
                    '        }\n' +
                    '        if ($object->delete()) {\n' +
                    '            session()->flash(\'success\', \'' + destroyMessage + '\');\n' +
                    '            return redirect()->route($this->route . \'index\');\n' +
                    '        }\n' +
                    '        session()->flash(\'error\', \'No se ha podido eliminar ' + art_singular + ' ' + (data.singular_name).toLowerCase() + '.\');\n' +
                    '        return redirect()->route($this->route . \'index\');\n' +
                    '    }\n';

            } else if (name == 'active') {

                body += '   public function active(Request $request)\n' +
                    '    {\n' +
                    '        try {\n' +
                    '\n' +
                    '            $object = ' + data.class + '::find($request->id);\n' +
                    '\n' +
                    '            if ($object) {\n' +
                    '\n' +
                    '                $object->active = $request->active == \'true\' ? 1 : 0;\n' +
                    '                $object->save();\n' +
                    '\n' +
                    '                return response()->json([\n' +
                    '                    \'status\' => \'success\',\n' +
                    '                    \'message\' => $object->active == 1 ? \'' + activeMessage + '\' : \'' + disableMessage + '\',\n' +
                    '                    \'object\' => $object\n' +
                    '                ]);\n' +
                    '\n' +
                    '            } else {\n' +
                    '                return response()->json([\n' +
                    '                    \'status\' => \'error\',\n' +
                    '                    \'message\' => \'' + notFoundMessage + '\'\n' +
                    '                ]);\n' +
                    '            }\n' +
                    '\n' +
                    '        } catch (\\Exception $e) {\n' +
                    '\n' +
                    '            return response()->json([\n' +
                    '                \'status\' => \'error\',\n' +
                    '                \'message\' => \'Ha ocurrido un error inesperado, inténtelo denuevo más tarde.\' . $e->getMessage()\n' +
                    '            ]);\n' +
                    '        }\n' +
                    '\n' +
                    '    }';

            } else {

                body += '   public function ' + name + '()\n' +
                    '    {\n' +
                    '    }\n';

            }

            return body;
        }

    </script>

@endsection
