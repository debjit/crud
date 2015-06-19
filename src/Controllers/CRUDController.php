<?php
/**
 * User: mgalicz
 * Date: 2015.06.18.
 * Time: 12:01
 * Project: crud-tester
 */

namespace BlackfyreStudio\CRUD\Controllers;

use BlackfyreStudio\CRUD\Master;
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

    public function __construct() {
        $this->nameSpaceRoot = $this->getAppNamespace();
        $this->nameSpace = $this->nameSpaceRoot . 'Http\\Controllers\\' . \Config::get('crud.directory') . '\\';
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $modelName
     * @return \Illuminate\View\View
     */
    public function index($modelName = '')
    {
        $modelNameWithNamespace = sprintf($this->nameSpace . '%sController', $modelName);;

        $master = Master::getInstance($modelNameWithNamespace)->buildList()->buildFilters()->buildScopes();


        return view($master->getViewIndex(),[
            'ModelName'=>$modelName,
            'MasterInstance'=>$master
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resources from storage.
     *
     * @access public
     *
     * @param $name
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiDestroy($name)
    {
        $items = Input::get('delete');
        $model = Master::getInstance($name);
        if (count($items) === 0) {
            return Redirect::route('admin.model.index', $name);
        }
        foreach ($items as $id => $item) {
            $model->buildForm($id)
            ->getFormBuilder()
            ->destroy();
        }
        // Set the flash message
        Session::flash('message.success', trans('bauhaus::messages.success.model-deleted', [
            'count' => (count($items) > 1 ? 'multiple' : 'one'),
            'model' => $model->getPluralName()
        ]));
        // afterMultiDestroy hook
        if (method_exists($model, 'afterMultiDestroy')) {
            return $model->afterMultiDestroy(Redirect::route('admin.model.index', $name));
        }
        return Redirect::route('admin.model.index', $name);
    }

    public function export($name, $type) {

    }

}