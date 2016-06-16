<?php
/**
 *  This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@blackfyre.ninja>.
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
namespace BlackfyreStudio\CRUD\Controllers;

use BlackfyreStudio\CRUD\Master;
use Config;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as OriginController;
use Input;
use Redirect;
use Session;

/**
 * Class CRUDController.
 */
class CRUDController extends OriginController
{
    use DispatchesJobs, ValidatesRequests, AppNamespaceDetectorTrait;

    /**
     * @var string
     */
    private $nameSpace;
    /**
     * @var string
     */
    private $nameSpaceRoot;

    /**
     * CRUDController constructor.
     */
    public function __construct()
    {
        $this->nameSpaceRoot = $this->getAppNamespace();
        $this->nameSpace = $this->nameSpaceRoot.'Http\\Controllers\\'.Config::get('crud.directory').'\\';
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $modelName
     *
     * @return \Illuminate\View\View
     */
    public function index($modelName = '')
    {
        if (!\Auth::user()->hasPermission($modelName.'.read')) {
            return view('crud::errors.403');
        }

        $modelNameWithNamespace = $this->setModelNamespace($modelName);

        $master = Master::getInstance($modelNameWithNamespace)->buildList()->buildFilters()->buildScopes();


        return view($master->getViewIndex(), [
            'ModelName'      => $modelName,
            'MasterInstance' => $master,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $modelName
     *
     * @return \Illuminate\View\View
     */
    public function create($modelName = '')
    {
        if (!\Auth::user()->hasPermission($modelName.'.create')) {
            return view('crud::errors.403');
        }

        $modelNameWithNamespace = $this->setModelNamespace($modelName);

        $master = Master::getInstance($modelNameWithNamespace)->buildForm();

        return view($master->getViewCreate(), [
            'ModelName'      => $modelName,
            'MasterInstance' => $master,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param string  $modelName
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $modelName = '')
    {
        if (!\Auth::user()->hasPermission($modelName.'.create')) {
            return view('crud::errors.403');
        }

        $modelNameWithNamespace = $this->setModelNamespace($modelName);
        $master = Master::getInstance($modelNameWithNamespace);
        $result = $master->buildForm()->getFormBuilder()->create($request);

        // Check validation errors
        if (get_class($result) === 'Illuminate\Validation\Validator') {
            Session::flash('message.error', trans('crud::messages.error.validation-errors'));

            return Redirect::route('crud.create', [$modelName])
                ->withInput()
                ->withErrors($result);
        }
        // Set the flash message
        Session::flash('message.success', trans('crud::messages.success.model-created', [
            'model' => $master->getModelSingularName(),
        ]));
        // afterStore hook
        if (method_exists($modelNameWithNamespace, 'afterStore')) {
            return $modelNameWithNamespace->afterStore(Redirect::route('admin.model.index', $modelName));
        }

        return Redirect::route('crud.index', [$modelName]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $modelName
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($modelName, $id)
    {
        if (!\Auth::user()->hasPermission($modelName.'.update')) {
            return view('crud::errors.403');
        }

        $modelNameWithNamespace = $this->setModelNamespace($modelName);
        $master = Master::getInstance($modelNameWithNamespace)->buildForm($id);

        return view($master->getViewUpdate(), [
            'ModelName'      => $modelName,
            'MasterInstance' => $master,
            'id'             => $id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string  $modelName
     * @param int     $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $modelName, $id)
    {
        if (!\Auth::user()->hasPermission($modelName.'.update')) {
            return view('crud::errors.403');
        }

        $modelNameWithNamespace = $this->setModelNamespace($modelName);
        $model = Master::getInstance($modelNameWithNamespace);
        $result = $model->buildForm($id)
            ->getFormBuilder()
            ->update(Input::all());
        // Check validation errors
        if (get_class($result) === 'Illuminate\Validation\Validator') {
            Session::flash('message.error', trans('crud::messages.error.validation-errors'));

            return Redirect::route('crud.edit', [$modelName, $id])
                ->withInput()
                ->withErrors($result);
        }
        // Set the flash message
        Session::flash('message.success', trans('crud::messages.success.model-updated', [
            'model' => $model->getModelSingularName(),
        ]));

        return Redirect::route('crud.index', $modelName);
    }

    /**
     * Remove the specified resources from storage.
     *
     *
     * @param $modelName
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiDestroy($modelName)
    {
        if (!\Auth::user()->hasPermission($modelName.'.delete')) {
            abort(403);
        }

        $items = Input::get('delete');
        $controllerName = $this->setModelNamespace($modelName);
        $modelDescriptor = Master::getInstance($controllerName);
        $modelNameWithNamespace = $modelDescriptor->getModelFullName();


        if (count($items) === 0) {
            return response()->json(['result' => false]);
        }

        foreach ($items as $id) {

            /** @var Model $model */
            $model = $modelNameWithNamespace::find($id);
            $model->delete();
        }

        /*
        foreach ($items as $id => $item) {
            $model->buildForm($id)
                ->getFormBuilder()
                ->destroy();
        }
        */


        // afterMultiDestroy hook
        if (method_exists($modelDescriptor, 'afterMultiDestroy')) {
            return $modelDescriptor->afterMultiDestroy(Redirect::route('crud.index', $modelName));
        }

        return response()->json([
            'result' => true,
            'count'  => (count($items) > 1 ? 'multiple' : 'one'),
            'model'  => $modelDescriptor->getModelPluralName(),
        ]);
    }

    /**
     * @param $name
     * @param $type
     */
    public function export($name, $type)
    {
    }

    /**
     * @param string $modelName
     *
     * @return string
     */
    private function setModelNamespace($modelName = '')
    {
        $modelNameWithNamespace = sprintf($this->nameSpace.'%sController', $modelName);

        return $modelNameWithNamespace;
    }
}
