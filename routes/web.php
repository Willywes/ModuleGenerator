<?php

function getResourceRoutesForNameHelperTwo($name)
{
    return [
        'index' => $name . ".index",
        'create' => $name . ".create",
        'store' => $name . ".store",
        'show' => $name . ".show",
        'edit' => $name . ".edit",
        'update' => $name . ".update",
        'destroy' => $name . ".destroy",
    ];
}

Route::namespace('Willywes\ModuleGenerator\Controllers')
    ->name('intranet.')
//    ->prefix('intranet')
    ->group(function () {
        Route::group(['middleware' => ['web']], function () {
            //SETTINGS

            Route::resource('modules-generator', 'ModuleController', ['names' => getResourceRoutesForNameHelperTwo('modules-generator')]);


            Route::post('modules-generator/store-controller', 'ModuleController@storeController')->name('modules-generator.storeController');
            Route::post('modules-generator/store-class', 'ModuleController@storeClass')->name('modules-generator.storeClass');
        });

    });
