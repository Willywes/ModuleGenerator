<?php

namespace Willywes\ModuleGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class ModuleGenerator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'modulegenerator';
    }
}
