<?php

namespace Willywes\ModuleGenerator\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ModuleRoute extends Model
{
    protected $fillable = [
        'id',
        'method',
        'uri',
        'name',
        'controller',
        'middleware',
        'has_permission',
        'module_id',
        'fields',
        'created_at',
        'updated_at'
    ];

    public function permission(){
        return $this->hasOne(Permission::class);
    }
}
