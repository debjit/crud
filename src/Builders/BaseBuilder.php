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

namespace BlackfyreStudio\CRUD\Builders;

use BlackfyreStudio\CRUD\Planner\FormPlanner;
use BlackfyreStudio\CRUD\Planner\IndexPlanner;
use BlackfyreStudio\CRUD\Planner\ScopePlanner;
use BlackfyreStudio\CRUD\Planner\FilterPlanner;
use Input;

/**
 * Class BaseBuilder
 * @package BlackfyreStudio\CRUD\Builders
 */
abstract class BaseBuilder
{

    /**
     * Holds the mapper object.
     * @var IndexPlanner|FormPlanner|ScopePlanner|FilterPlanner
     */
    protected $planner;
    /**
     * Holds the model name.
     * @var string
     */
    protected $model;
    /**
     * Holds the input.
     * @var Input
     */
    protected $input;

    /**
     * @param IndexPlanner|FormPlanner|ScopePlanner|FilterPlanner $planner
     */
    public function __construct($planner)
    {
        $this->setPlanner($planner);
    }

    /**
     * @return mixed
     */
    abstract public function build();

    /**
     * @return FilterPlanner|FormPlanner|IndexPlanner|ScopePlanner
     */
    public function getPlanner()
    {
        return $this->planner;
    }

    /**
     * @param $planner
     * @return $this
     */
    public function setPlanner($planner)
    {
        $this->planner = $planner;
        return $this;
    }

    /**
     * Get the model name.
     *
     * @access public
     * @return string|\Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the model name.
     *
     * @param  string $model
     *
     * @access public
     * @return BaseBuilder
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Get the input array.
     *
     * @access public
     * @return array
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set the input for the builder from the Laravel input object.
     *
     * @param array $input
     * @return BaseBuilder
     * @access public
     */
    public function setInput($input)
    {
        $this->input = $input;
        return $this;
    }

    /**
     * Set an specific input variable.
     *
     * @param  string $key
     * @param  mixed $value
     *
     * @access public
     * @return BaseBuilder
     */
    public function setInputVariable($key, $value)
    {
        $this->input[$key] = $value;
        return $this;
    }

    /**
     * Get a specific input variable.
     *
     * @param  string $key
     *
     * @access public
     * @return mixed
     */
    public function getInputVariable($key)
    {
        return $this->input[$key];
    }

    /**
     * Unset a specific input variable.
     *
     * @param  string $key
     *
     * @access public
     * @return BaseBuilder
     */
    public function unsetInputVariable($key)
    {
        unset($this->input[$key]);
        return $this;
    }
}
