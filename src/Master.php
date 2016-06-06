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
namespace BlackfyreStudio\CRUD;

use BlackfyreStudio\CRUD\Builders\ExportBuilder;
use BlackfyreStudio\CRUD\Builders\FilterBuilder;
use BlackfyreStudio\CRUD\Builders\FormBuilder;
use BlackfyreStudio\CRUD\Builders\IndexBuilder;
use BlackfyreStudio\CRUD\Builders\ScopeBuilder;
use BlackfyreStudio\CRUD\Planner\FilterPlanner;
use BlackfyreStudio\CRUD\Planner\FormPlanner;
use BlackfyreStudio\CRUD\Planner\IndexPlanner;
use BlackfyreStudio\CRUD\Planner\ScopePlanner;
use Config;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Support\Str;

/**
 * Class Master.
 */
class Master
{
    use AppNamespaceDetectorTrait;

    /**
     * @var
     */
    protected $modelBaseName;
    /**
     * @var
     */
    protected $modelFullName;
    /**
     * @var
     */
    protected $modelNameSpace;
    /**
     * @var string
     */
    protected $viewLayout = 'crud::master';
    /**
     * @var string
     */
    protected $viewIndex = 'crud::layouts.index';
    /**
     * @var string
     */
    protected $viewCreate = 'crud::layouts.create';
    /**
     * @var string
     */
    protected $viewUpdate = 'crud::layouts.edit';
    /**
     * @var
     */
    protected $modelSingularName;
    /**
     * @var
     */
    protected $modelPluralName;
    /**
     * @var
     */
    protected $indexPlanner;
    /**
     * @var
     */
    protected $indexBuilder;
    /**
     * Holds the number of items per page.
     *
     * @var int
     */
    protected $perPage = 25;
    /**
     * @var
     */
    protected $filterPlanner;
    /**
     * @var
     */
    protected $filterBuilder;
    /**
     * @var
     */
    protected $scopePlanner;
    /**
     * @var
     */
    protected $scopeBuilder;
    /**
     * @var
     */
    protected $exportTypes;

    /**
     * Holds the FormPlanner class.
     *
     * @var FormPlanner
     */
    protected $formPlanner;

    /**
     * Holds the FormBuilder class.
     *
     * @var FormBuilder
     */
    protected $formBuilder;

    public function __construct()
    {
        if ($this->getModelBaseName() === null) {
            $re = '/^(.*)\\\\(\\w*)Controller$/';
            $modelName = preg_replace($re, '$2', get_called_class());
            $this->setModelBaseName($modelName);
        }

        if ($this->getModelSingularName() === null) {
            $this->setModelSingularName(Str::singular($this->getModelBaseName()));
        }

        if ($this->getModelPluralName() === null) {
            $this->setModelPluralName(Str::plural($this->getModelBaseName()));
        }


        if ($this->getModelNameSpace() === null) {
            $this->setModelNameSpace($this->getAppNamespace());
        }


        if ($this->getModelFullName() === null) {
            $this->setModelFullName($this->getModelNameSpace().$this->getModelBaseName());
        }

        $this->setPerPage(\Config::get('crud.items-per-page', 25));
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

        if ($this->getModelSingularName() === null) {
            $this->setModelSingularName(Str::singular($this->getModelBaseName()));
        }

        if ($this->getModelPluralName() === null) {
            $this->setModelPluralName(Str::plural($this->getModelBaseName()));
        }
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
     * Get a CRUD instance.
     *
     * @param string $modelName
     *
     * @return \BlackfyreStudio\CRUD\Master
     */
    public static function getInstance($modelName = '')
    {
        $model = new $modelName();

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
     *
     * @param IndexPlanner $planner
     */
    public function indexView(IndexPlanner $planner)
    {
    }

    /**
     * Configures the list fields and builds the list data from that.
     *
     * @return $this
     */
    public function buildList()
    {
        $this->setIndexPlanner(new IndexPlanner());
        $this->indexView($this->getIndexPlanner());

        $this->setIndexBuilder(new IndexBuilder($this->getIndexPlanner()));

        $this->getIndexBuilder()
            ->setModel($this->getModelFullName())
            ->build();

        return $this;
    }

    /**
     * Set the ListPlanner object.
     *
     * @param IndexPlanner $planner
     *
     * @return IndexPlanner
     *
     * @internal param IndexPlanner $mapper
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
     * @return IndexPlanner
     */
    public function getIndexPlanner()
    {
        return $this->indexPlanner;
    }

    /**
     * @param IndexBuilder $builder
     *
     * @return $this
     */
    public function setIndexBuilder(IndexBuilder $builder)
    {
        $this->indexBuilder = $builder;

        return $this;
    }

    /**
     * @return IndexBuilder
     */
    public function getIndexBuilder()
    {
        return $this->indexBuilder;
    }

    /**
     * This function is called when configuring the form view.
     *
     * @param FormPlanner $planner
     */
    public function formView(FormPlanner $planner)
    {
    }

    /**
     * This function is called when configuring the filter view.
     *
     * @param FilterPlanner $planner
     */
    public function filters(FilterPlanner $planner)
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
     *
     * @return $this
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * Configures the filter fields and builds the filter data from that.
     *
     * @return Master
     */
    public function buildFilters()
    {
        $this->setFilterPlanner(new FilterPlanner());
        $this->filters($this->getFilterPlanner());
        $this->setFilterBuilder(new FilterBuilder($this->getFilterPlanner()));
        $this->getFilterBuilder()->build();

        return $this;
    }

    /**
     * Set the ListPlanner object.
     *
     * @param FilterPlanner $mapper
     *
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
     * @return FilterPlanner
     */
    public function getFilterPlanner()
    {
        return $this->filterPlanner;
    }

    /**
     * Set the FilterBuilder object.
     *
     * @param FilterBuilder $filterBuilder
     *
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
     * @return FilterBuilder
     */
    public function getFilterBuilder()
    {
        return $this->filterBuilder;
    }

    /**
     * This function is called when configuring the scopes view.
     *
     * @param ScopePlanner $planner
     */
    public function scopes(ScopePlanner $planner)
    {
        // intentionally left blank
    }

    /**
     * Configures the scopes and builds the scope data from that.
     *
     * @return Master
     */
    public function buildScopes()
    {
        $this->setScopePlanner(new ScopePlanner());
        $this->scopes($this->getScopePlanner());
        $this->setScopeBuilder(new FilterBuilder($this->getScopePlanner()));
        $this->getScopeBuilder()->build();

        return $this;
    }

    /**
     * Set the ScopePlanner object.
     *
     * @param ScopePlanner $mapper
     *
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
     * @return ScopePlanner
     */
    public function getScopePlanner()
    {
        return $this->scopePlanner;
    }

    /**
     * Set the ScopeBuilder object.
     *
     * @param FilterBuilder $scopeBuilder
     *
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
     * @return FilterBuilder
     */
    public function getScopeBuilder()
    {
        return $this->scopeBuilder;
    }

    /**
     * Set the export types array.
     *
     * @param array $exportTypes
     *
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
     * @return ExportBuilder
     */
    public function getExportBuilder()
    {
        return (new ExportBuilder())->setIndexBuilder($this->getIndexBuilder());
    }

    /**
     * Configures the list fields and builds the list data from that.
     *
     * @param null $identifier
     *
     * @return $this
     */
    public function buildForm($identifier = null)
    {
        $this->setFormPlanner(new FormPlanner());
        $this->formView($this->getFormPlanner());

        $this->setFormBuilder(new FormBuilder($this->getFormPlanner()));
        $this->getFormBuilder()
            ->setModel($this->getModelFullName())
            ->setIdentifier($identifier)
            ->setContext($identifier === null ? FormBuilder::CONTEXT_CREATE : FormBuilder::CONTEXT_EDIT)
            ->build();

        return $this;
    }

    /**
     * Set the FormMapper object.
     *
     * @param FormPlanner $mapper
     *
     * @return $this
     */
    public function setFormPlanner(FormPlanner $mapper)
    {
        $this->formPlanner = $mapper;
        $mapper->setCRUDMasterInstance($this);

        return $this;
    }

    /**
     * Get the FormPlanner object.
     *
     * @return FormPlanner
     */
    public function getFormPlanner()
    {
        return $this->formPlanner;
    }

    /**
     * Set the FormBuilder object.
     *
     * @param FormBuilder $builder
     *
     * @return Master
     */
    public function setFormBuilder(FormBuilder $builder)
    {
        $this->formBuilder = $builder;

        return $this;
    }

    /**
     * Get the FormBuilder object.
     *
     * @return FormBuilder
     */
    public function getFormBuilder()
    {
        return $this->formBuilder;
    }

    /**
     * Get the model table name.
     *
     * @return mixed
     */
    public function getTable()
    {
        $model = $this->getModelFullName();

        return (new $model())->getTable();
    }

    /**
     * @return string
     */
    public function getModelNameSpace()
    {
        return $this->modelNameSpace;
    }

    /**
     * @param string $modelNameSpace
     */
    public function setModelNameSpace($modelNameSpace)
    {
        $this->modelNameSpace = $modelNameSpace;
    }

    /**
     * @return mixed
     */
    public function getModelFullName()
    {
        return $this->modelFullName;
    }

    /**
     * @param mixed $modelFullName
     */
    public function setModelFullName($modelFullName)
    {
        $this->modelFullName = $modelFullName;
    }
}
