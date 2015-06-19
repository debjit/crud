<?php
/**
 * User: mgalicz
 * Date: 2015.06.18.
 * Time: 15:57
 * Project: crud-tester
 */

namespace BlackfyreStudio\CRUD;

use App\Http\Controllers\Crud\GalleryItemController;
use Illuminate\Support\Str;


/**
 * Class Master
 * @package BlackfyreStudio\CRUD
 */
class Master
{
    protected $modelBaseName;
    protected $viewLayout = 'crud::master';
    protected $viewIndex = 'crud::layouts.index';
    protected $viewCreate = 'crud::layouts.create';
    protected $viewUpdate = 'crud::layouts.edit';
    protected $modelSingularName;
    protected $modelPluralName;

    /**
     *
     */
    public function __construct() {
        if ($this->getModelBaseName() === null) {
            $re = "/^(.*)\\\\(\\w*)Controller$/";
            $modelName = preg_replace($re,'$2',get_called_class());
            $this->setModelBaseName($modelName);
        }

        if ($this->getModelSingularName() === null) {
            $this->setModelSingularName(Str::singular($this->getModelBaseName()));
        }

        if ($this->getModelPluralName() === null) {
            $this->setModelPluralName(Str::plural($this->getModelBaseName()));
        }
    }

    /**
     * @return null
     */
    public function getModelBaseName()
    {
        return $this->modelBaseName;
    }

    /**
     * @param null $modelBaseName
     */
    public function setModelBaseName($modelBaseName)
    {
        $this->modelBaseName = $modelBaseName;
    }

    /**
     * @return mixed
     */
    public function getModelSingularName()
    {
        return $this->modelSingularName;
    }

    /**
     * @param mixed $modelSingularName
     */
    public function setModelSingularName($modelSingularName)
    {
        $this->modelSingularName = $modelSingularName;
    }

    /**
     * @return mixed
     */
    public function getModelPluralName()
    {
        return $this->modelPluralName;
    }

    /**
     * @param mixed $modelPluralName
     */
    public function setModelPluralName($modelPluralName)
    {
        $this->modelPluralName = $modelPluralName;
    }

    /**
     * Get a CRUD instance
     *
     * @param string $modelName
     * @return \BlackfyreStudio\CRUD\Master
     */
    public static function getInstance($modelName = '')
    {
        $model = new $modelName;

        return $model;
    }

    /**
     * @return string
     */
    public function getViewLayout()
    {
        return $this->viewLayout;
    }

    /**
     * @param string $viewLayout
     */
    public function setViewLayout($viewLayout)
    {
        $this->viewLayout = $viewLayout;
    }

    /**
     * @return string
     */
    public function getViewIndex()
    {
        return $this->viewIndex;
    }

    /**
     * @param string $viewIndex
     */
    public function setViewIndex($viewIndex)
    {
        $this->viewIndex = $viewIndex;
    }

    /**
     * @return string
     */
    public function getViewCreate()
    {
        return $this->viewCreate;
    }

    /**
     * @param string $viewCreate
     */
    public function setViewCreate($viewCreate)
    {
        $this->viewCreate = $viewCreate;
    }

    /**
     * @return string
     */
    public function getViewUpdate()
    {
        return $this->viewUpdate;
    }

    /**
     * @param string $viewUpdate
     */
    public function setViewUpdate($viewUpdate)
    {
        $this->viewUpdate = $viewUpdate;
    }

    /**
     * This function is called when configuring the list view.
     * @return void
     */
    public function listView()
    {

    }

    /**
     * This function is called when configuring the form view.
     * @return void
     */
    public function formView()
    {

    }

    /**
     * This function is called when configuring the filter view.
     * @return void
     */
    public function filters()
    {

    }
}