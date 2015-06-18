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

    \Route::post('slugger',[
        'as'=>'crud.slugger',
        function() {
            return \Response::json(['response'=>\Illuminate\Support\Str::slug(\Input::get('toSlug'))]);
        }
    ]);
});