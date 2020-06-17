<?php

namespace Willywes\ModuleGenerator\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'id',
        'gender',
        'name',
        'base_folder',
        'base_route',
        'base_route_name',
        'class',
        'controller',
        'singular_name',
        'plural_name',
        'description',
        'created_at',
        'updated_at'
    ];

    public function module_routes(){
        return $this->hasMany(ModuleRoute::class);
    }
}
