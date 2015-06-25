<?php
/**
 * User: mgalicz
 * Date: 2015.06.18.
 * Time: 12:01
 * Project: crud-tester
 */

namespace BlackfyreStudio\CRUD\Controllers;

use BlackfyreStudio\CRUD\Master;
use Config;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as OriginController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Input;
use Redirect;
use Session;

class CRUDController extends OriginController
{
    use DispatchesJobs, ValidatesRequests, AppNamespaceDetectorTrait;

    private $nameSpace;
    private $nameSpaceRoot;

    public function __construct()
    {
        $this->nameSpaceRoot = $this->getAppNamespace();
        $this->nameSpace = $this->nameSpaceRoot . 'Http\\Controllers\\' . Config::get('crud.directory') . '\\';
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $modelName
     * @return \Illuminate\View\View
     */
    public function index($modelName = '')
    {
        $modelNameWithNamespace = $this->namespaceModel($modelName);

        $master = Master::getInstance($modelNameWithNamespace)->buildList()->buildFilters()->buildScopes();


        return view($master->getViewIndex(), [
            'ModelName' => $modelName,
            'MasterInstance' => $master
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $modelName
     * @return \Illuminate\View\View
     */
    public function create($modelName = '')
    {
        $modelNameWithNamespace = $this->namespaceModel($modelName);

        $master = Master::getInstance($modelNameWithNamespace)->buildForm();

        return view($master->getViewCreate(), [
            'ModelName' => $modelName,
            'MasterInstance' => $master
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $modelName
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($modelName = '')
    {
        $modelNameWithNamespace = $this->namespaceModel($modelName);
        $master = Master::getInstance($modelNameWithNamespace);
        $result = $master->buildForm()->getFormBuilder()->create(Input::all());

        // Check validation errors
        if (get_class($result) === 'Illuminate\Validation\Validator') {
            Session::flash('message.error', trans('crud::messages.error.validation-errors'));
            return Redirect::route('crud.create', [$modelName])
                ->withInput()
                ->withErrors($result);
        }
        // Set the flash message
        Session::flash('message.success', trans('crud::messages.success.model-created', [
            'model' => $master->getModelSingularName()
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
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function edit($modelName, $id)
    {
        $modelNameWithNamespace = $this->namespaceModel($modelName);
        $master = Master::getInstance($modelNameWithNamespace)->buildForm($id);

        return view($master->getViewUpdate(), [
            'ModelName' => $modelName,
            'MasterInstance' => $master,
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $modelName
     * @param  int $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($modelName, $id)
    {
        $modelNameWithNamespace = $this->namespaceModel($modelName);
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
            'model' => $model->getModelSingularName()
        ]));
        // afterUpdate hook
        if (method_exists($model, 'afterUpdate')) {
            return $model->afterUpdate(Redirect::route('crud.index', $modelName));
        }

        return Redirect::route('crud.index', $modelName);
    }

    /**
     * Remove the specified resources from storage.
     *
     * @access public
     *
     * @param $modelName
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiDestroy($modelName)
    {
        $items = Input::get('delete');
        $modelNameWithNamespace = $this->namespaceModel($modelName);
        $model = Master::getInstance($modelNameWithNamespace);

        if (count($items) === 0) {
            return Redirect::route('crud.index', $modelName);
        }

        foreach ($items as $id => $item) {
            $model->buildForm($id)
                ->getFormBuilder()
                ->destroy();
        }

        // Set the flash message
        Session::flash('message.success', trans('crud::messages.success.model-deleted', [
            'count' => (count($items) > 1 ? 'multiple' : 'one'),
            'model' => $model->getModelPluralName()
        ]));
        // afterMultiDestroy hook
        if (method_exists($model, 'afterMultiDestroy')) {
            return $model->afterMultiDestroy(Redirect::route('crud.index', $modelName));
        }
        return Redirect::route('crud.index', $modelName);
    }

    public function export($name, $type)
    {

    }

    private function namespaceModel($modelName = '')
    {
        $modelNameWithNamespace = sprintf($this->nameSpace . '%sController', $modelName);

        return $modelNameWithNamespace;
    }

}