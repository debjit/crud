<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
