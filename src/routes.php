<?php
/**
 *  This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

\Route::get(\Config::get('crud.uri') . '/login', [
    'as' => 'crud.login',
    'uses' => 'BlackfyreStudio\CRUD\Controllers\Auth\AuthController@loginPage'
]);

\Route::post(\Config::get('crud.uri') . '/login', [
    'as' => 'crud.session-start',
    'uses' => 'BlackfyreStudio\CRUD\Controllers\Auth\AuthController@startSession'
]);

\Route::group([
    'prefix' => \Config::get('crud.uri'),
    'middleware' => ['crudAuth']
], function () {
    \Route::get('/', [
        'as' => 'crud.home',
        'uses' => 'BlackfyreStudio\CRUD\Controllers\DashboardController@index'
    ]);

    /* TODO: visit again if it could be done with dynamic resource routes */

    \Route::get('index/{model}', [
        'as' => 'crud.index',
        'uses' => 'BlackfyreStudio\CRUD\Controllers\CRUDController@index'
    ]);

    \Route::get('index/{model}/edit/{id}', [
        'as' => 'crud.edit',
        'uses' => 'BlackfyreStudio\CRUD\Controllers\CRUDController@edit'
    ]);

    \Route::put('index/{model}/update/{id}', [
        'as' => 'crud.update',
        'uses' => 'BlackfyreStudio\CRUD\Controllers\CRUDController@update'
    ]);

    \Route::get('index/{model}/create', [
        'as' => 'crud.create',
        'uses' => 'BlackfyreStudio\CRUD\Controllers\CRUDController@create'
    ]);

    \Route::post('index/{model}/store', [
        'as' => 'crud.store',
        'uses' => 'BlackfyreStudio\CRUD\Controllers\CRUDController@store'
    ]);

    \Route::post('destroy/{model}', [
        'as' => 'crud.multi-destroy',
        'uses' => 'BlackfyreStudio\CRUD\Controllers\CRUDController@multiDestroy'
    ]);

    \Route::get('/export/{model}/{type}', [
        'as' => 'crud.export',
        'uses' => 'BlackfyreStudio\CRUD\Controllers\CRUDController@export'
    ])->where('type', implode('|', Config::get('crud.export-types')));

    \Route::post('slugger', [
        'as' => 'crud.slugger',
        function () {
            return \Response::json(['response' => \Illuminate\Support\Str::slug(\Input::get('toSlug'))]);
        }
    ]);

    \Route::group([
        'prefix' => 'modal'
    ], function () {
        \Route::get('modal/belongs_to/{model}/create', [
            'as' => 'crud.modal.belongs_to.create',
            'uses' => 'KraftHaus\Bauhaus\Modal\FieldBelongsToController@create'
        ]);
        \Route::get('modal/delete/{model}', [
            'as' => 'crud.modal.delete',
            'uses' => 'BlackfyreStudio\CRUD\Controllers\ModalController@delete'
        ]);
    });
});