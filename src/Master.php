<?php
/**
 * User: mgalicz
 * Date: 2015.06.18.
 * Time: 15:57
 * Project: crud-tester
 */

namespace BlackfyreStudio\CRUD;

use App\Http\Controllers\Crud\GalleryItemController;


/**
 * Class Master
 * @package BlackfyreStudio\CRUD
 */
class Master
{
    /**
     * @var null
     */
    protected $model;

    /**
     * @return null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param null $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    public function __construct() {
        if ($this->getModel() === null) {
            $modelName = preg_replace('/Controller$/','',get_called_class());
            $this->setModel($modelName);
        }
    }

    /**
     * Get a model instance
     *
     * @param string $namespace The namespace of the class to be called
     * @param string $modelName
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function getInstance($modelName = '')
    {


        $model = new $modelName;

        new GalleryItemController();

        return $model;
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