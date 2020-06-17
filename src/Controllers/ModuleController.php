<?php

namespace Willywes\ModuleGenerator\Controllers;

use App\Http\Controllers\Intranet\GlobalController;
use Illuminate\Support\Facades\Storage;
use Willywes\ModuleGenerator\Models\Module;
use Willywes\ModuleGenerator\Models\ModuleRoute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class ModuleController extends GlobalController
{
    protected $options = [
        'route' => 'intranet.modules-generator.',
        'folder' => 'willywes::',
        'permissions_base' => 'intranet.modules-generator.',
        'pluralName' => 'Modulos',
        'singularName' => 'Módulo',
        'enableActions' => ['index', 'create', 'edit', 'destroy', 'active'],
        'disableActions' => ['changeStatus', 'show'],
    ];

    public function __construct()
    {
        parent::__construct($this->options);
    }

    public function index()
    {
//        return $this->options;
        $objects = Module::all();
        return view($this->folder . 'index', compact('objects'));
    }


    public function create()
    {
        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('cache:clear');
        return view($this->folder . 'create');
    }


    public function store(Request $request)
    {
        try {

            $object = Module::create($request->all());

            if ($object) {
                if ($request->methods) {
                    foreach ($request->methods as $method) {

                        $item = ModuleRoute::create([
                            'method' => $method['type'],
                            'uri' => $object->base_route . '.' . $method['name'],
                            'name' => $object->base_route_name . '.' . $method['name'],
                            'controller' => $object->controller . '@' . $method['name'],
                            'middleware' => 'web',
                            'has_permission' => $method['permission'] ? 1 : 0,
                            'module_id' => $object->id,
                        ]);

                        if ($method['name'] != 'store') {
                            if ($method['name'] != 'update') {
                                Permission::create($this->getPermissionTemplate($method['name'], $object, $item));
                            }
                        }

                    }
                }
                session()->flash('success', 'Modulo creado correctamente');
                return redirect()->route($this->route . 'edit', ['id' => $object->id]);
            }
            session()->flash('error', 'Modulo no creado, intente nuevamente');
            return redirect()->route($this->route . 'index');
        } catch (\Exception $e) {
            session()->flash('error', 'Modulo no se ha podido crear, ERROR ' . $e->getMessage());
            return redirect()->route($this->route . 'index');
        }

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $object = Module::with('module_routes.permission')->find($id);
        if (!$object) {
            session()->flash('error', 'Modulo no encontrado');
            return redirect()->route($this->route . 'index');
        }
        return view($this->folder . 'edit', compact('object'));
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    private function getPermissionTemplate($name, $object, $item)
    {


        $prefix = '';
        $description = '';

        switch ($name) {
            case 'index':
                $prefix = 'Lista';
                $description = 'Permite ver la lista de';
                break;
            case 'create':
                $prefix = 'Crear';
                $description = 'Permite crear';
                break;
            case 'edit':
                $prefix = 'Editar';
                $description = 'Permite editar';
                break;
            case 'show':
                $prefix = 'Ver';
                $description = 'Permite ver detalles de ';
                break;
            case 'destroy':
                $prefix = 'Eliminar';
                $description = 'Permite eliminar ';
                break;
            case 'active':
                $prefix = 'Activar/desactivar ';
                $description = 'Permite activar y/o desactivar';
                break;
            case 'changeStatus':
                $prefix = 'Cambiar Estado';
                $description = 'Permite cambiar estados de';
                break;
            default:
                break;
        }

        return [
            'name' => $item->name,
            'group' => $object->name,
            'public_group' => $object->plural_name,
            'public_name' => $prefix . ' ' . strtolower($object->plural_name),
            'public_description' => $description . ' ' . strtolower($object->plural_name) . '.',
            'module_route_id' => $item->id,
        ];
    }

    public function storeController(Request $request)
    {

        try {
            $module = Module::find($request->id);
            $data = $request->data;

            $file = app_path() . '/Http/Controllers/Intranet/' . $module->controller . '.php';

            file_put_contents($file, $data);
            session()->flash('success', 'Controlador creado correctamente');
            return redirect()->back();

        } catch (\Exception $exception) {
            session()->flash('error', 'Controlador no creado ' . $exception->getMessage());
            return redirect()->back();
        }
    }

    public function storeClass(Request $request)
    {
        try {
            $module = Module::find($request->id);
            $data = $request->data;

            $file = app_path() . '/Models/' . $module->class . '.php';

            file_put_contents($file, $data);
            session()->flash('success', 'Modelo creado correctamente');
            return redirect()->back();

        } catch (\Exception $exception) {
            session()->flash('error', 'Modelo no creado ' . $exception->getMessage());
            return redirect()->back();
        }
    }
}
