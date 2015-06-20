<?php
/**
 * Created by IntelliJ IDEA.
 * User: mgalicz
 * Date: 3/31/2015
 * Time: 5:21 PM
 */


\Route::group([
    'prefix' => \Config::get('crud.uri')
], function() {
    \Route::get('/',[
        'as'=>'crud.home',
        'uses'=>'BlackfyreStudio\CRUD\Controllers\DashboardController@index'
    ]);

    \Route::get('index/{model}',[
        'as'=>'crud.index',
        'uses'=>'BlackfyreStudio\CRUD\Controllers\CRUDController@index'
    ]);

    \Route::get('index/{model}/edit/{id}',[
        'as'=>'crud.edit',
        'uses'=>'BlackfyreStudio\CRUD\Controllers\CRUDController@edit'
    ]);

    \Route::get('index/{model}/create', [
        'as'=>'crud.create',
        'uses'=>'BlackfyreStudio\CRUD\Controllers\CRUDController@create'
    ]);

    \Route::post('destroy', [
        'as'=>'crud.multi-destroy',
        'uses'=>'BlackfyreStudio\CRUD\Controllers\CRUDController@multiDestroy'
    ]);

    \Route::get('/export/{model}/{type}',[
        'as'=>'crud.export',
        'uses'=>'BlackfyreStudio\CRUD\Controllers\CRUDController@export'
    ])->where('type',implode('|',Config::get('crud.export-types')));

    \Route::post('slugger',[
        'as'=>'crud.slugger',
        function() {
            return \Response::json(['response'=>\Illuminate\Support\Str::slug(\Input::get('toSlug'))]);
        }
    ]);

    \Route::group([
        'prefix'=>'modal'
    ], function() {
        \Route::get('modal/belongs_to/{model}/create', [
            'as'   => 'crud.modal.belongs_to.create',
            'uses' => 'KraftHaus\Bauhaus\Modal\FieldBelongsToController@create'
        ]);
        \Route::get('modal/delete/{model}', [
            'as'   => 'crud.modal.delete',
            'uses' => 'BlackfyreStudio\CRUD\Controllers\ModalController@delete'
        ]);
    });
});