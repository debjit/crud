<?php
/**
 * User: mgalicz
 * Date: 2015.06.18.
 * Time: 15:57
 * Project: crud-tester
 */

namespace BlackfyreStudio\CRUD;

use BlackfyreStudio\CRUD\Builders\FilterBuilder;
use BlackfyreStudio\CRUD\Builders\IndexBuilder;
use BlackfyreStudio\CRUD\Builders\ScopeBuilder;
use BlackfyreStudio\CRUD\Planner\FilterPlanner;
use BlackfyreStudio\CRUD\Planner\IndexPlanner;
use BlackfyreStudio\CRUD\Planner\ScopePlanner;
use Config;
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
    protected $indexPlanner;
    protected $indexBuilder;
    /**
     * Holds the number of items per page.
     * @var int
     */
    protected $perPage = 25;
    protected $filterPlanner;
    protected $filterBuilder;
    protected $scopePlanner;
    protected $scopeBuilder;
    protected $exportTypes;

    /**
     *
     */
    public function __construct()
    {
        if ($this->getModelBaseName() === null) {
            $re = "/^(.*)\\\\(\\w*)Controller$/";
            $modelName = preg_replace($re, '$2', get_called_class());
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
     * @param IndexPlanner $planner
     */
    public function indexView(IndexPlanner $planner)
    {

    }

    /**
     * Configures the list fields and builds the list data from that.
     *
     * @access public
     * @return $this
     */
    public function buildList()
    {
        $this->setIndexPlanner(new IndexPlanner());
        $this->indexView($this->getIndexPlanner());
        $this->setIndexBuilder(new IndexBuilder($this->getIndexPlanner()));
        $this->getIndexBuilder()
        ->setModel($this->getModelBaseName())
        ->build();
        return $this;
    }

    /**
     * Set the ListPlanner object.
     *
     * @param IndexPlanner $planner
     * @return IndexPlanner
     * @internal param IndexPlanner $mapper
     *
     * @access public
     */
    public function setIndexPlanner(IndexPlanner $planner)
    {
        $this->indexPlanner = $planner;
        $planner->setCRUDMasterInstance($this);
        return $this;
    }

    /**
     * Returns the ListPlanner object.
     *
     * @access public
     * @return IndexPlanner
     */
    public function getIndexPlanner()
    {
        return $this->indexPlanner;
    }

    public function setIndexBuilder(IndexBuilder $builder)
    {
        $this->indexBuilder = $builder;
        return $this;
    }

    public function getIndexBuilder()
    {
        return $this->indexBuilder;
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

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     * @return $this
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * This function is called when configuring the filter view.
     *
     * @param  FilterPlanner $mapper
     *
     * @access public
     * @return void
     */
    public function configureFilters($mapper)
    {
        // intentionally left blank
    }

    /**
     * Configures the filter fields and builds the filter data from that.
     *
     * @access public
     * @return Master
     */
    public function buildFilters()
    {
        $this->setFilterPlanner(new FilterPlanner());
        $this->configureFilters($this->getFilterPlanner());
        $this->setFilterBuilder(new FilterBuilder($this->getFilterPlanner()));
        $this->getFilterBuilder()->build();
        return $this;
    }

    /**
     * Set the ListPlanner object.
     *
     * @param  FilterPlanner $mapper
     *
     * @access public
     * @return Master
     */
    public function setFilterPlanner(FilterPlanner $mapper)
    {
        $this->filterPlanner = $mapper;
        $mapper->setCRUDMasterInstance($this);
        return $this;
    }

    /**
     * Get the ListPlanner object.
     *
     * @access public
     * @return FilterPlanner
     */
    public function getFilterPlanner()
    {
        return $this->filterPlanner;
    }

    /**
     * Set the FilterBuilder object.
     *
     * @param  FilterBuilder $filterBuilder
     *
     * @access public
     * @return Master
     */
    public function setFilterBuilder($filterBuilder)
    {
        $this->filterBuilder = $filterBuilder;
        return $this;
    }

    /**
     * Get the FilterBuilder object.
     *
     * @access public
     * @return Master
     */
    public function getFilterBuilder()
    {
        return $this->filterBuilder;
    }

    /**
     * This function is called when configuring the scopes view.
     *
     * @param  ScopePlanner $mapper
     *
     * @access public
     * @return void
     */
    public function configureScopes($mapper)
    {
        // intentionally left blank
    }
    /**
     * Configures the scopes and builds the scope data from that.
     *
     * @access public
     * @return Master
     */
    public function buildScopes()
    {
        $this->setScopePlanner(new ScopePlanner());
        $this->configureScopes($this->getScopePlanner());
        $this->setScopeBuilder(new FilterBuilder($this->getScopePlanner()));
        $this->getScopeBuilder()->build();
        return $this;
    }
    /**
     * Set the ScopePlanner object.
     *
     * @param  ScopePlanner $mapper
     *
     * @access public
     * @return Master
     */
    public function setScopePlanner($mapper)
    {
        $this->scopePlanner = $mapper;
        $mapper->setCRUDMasterInstance($this);
        return $this;
    }
    /**
     * Get the ScopePlanner object.
     *
     * @access public
     * @return ScopePlanner
     */
    public function getScopePlanner()
    {
        return $this->scopePlanner;
    }
    /**
     * Set the ScopeBuilder object.
     *
     * @param  FilterBuilder $scopeBuilder
     *
     * @access public
     * @return Master
     */
    public function setScopeBuilder($scopeBuilder)
    {
        $this->scopeBuilder = $scopeBuilder;
        return $this;
    }
    /**
     * Get the ScopeBuilder object.
     *
     * @access public
     * @return FilterBuilder
     */
    public function getScopeBuilder()
    {
        return $this->scopeBuilder;
    }

    /**
     * Set the export types array.
     *
     * @param  array $exportTypes
     *
     * @access public
     * @return Master
     */
    public function setExportTypes(array $exportTypes)
    {
        $this->exportTypes = $exportTypes;
        return $this;
    }
    /**
     * Get the export types array.
     *
     * @access public
     * @return array
     */
    public function getExportTypes()
    {
        if (isset($this->exportTypes)) {
            return $this->exportTypes;
        }
        return Config::get('crud.export-types');
    }
    /**
     * Get a new export builder instance.
     *
     * @access public
     * @return ExportBuilder
     */
    public function getExportBuilder()
    {
        return (new ExportBuilder())
        ->setListBuilder($this->getListBuilder());
    }
}