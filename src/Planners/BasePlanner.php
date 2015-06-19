<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackfyreStudio\CRUD\Planner;

use Illuminate\Support\Str;

/**
 * Class BasePlanner
 * @package BlackfyreStudio\CRUD\Planner
 */
class BasePlanner
{
    /**
     * @var
     */
    protected $CRUDMasterInstance;
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param mixed $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @param string $type
     * @param array $arguments
     * @return $this
     */
    public function __call($type = '', array $arguments)
    {
        $name = array_shift($arguments);
        $type = '\\BlackfyreStudio\\CRUD\\Fields\\' . Str::studly($type);
        $field = new $type($name, $this->getCRUDMasterInstance());

        $this->fields[$name] = $field;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCRUDMasterInstance()
    {
        return $this->CRUDMasterInstance;
    }

    /**
     * @param mixed $CRUDMasterInstance
     * @return $this
     */
    public function setCRUDMasterInstance($CRUDMasterInstance)
    {
        $this->CRUDMasterInstance = $CRUDMasterInstance;
        return $this;
    }

    /**
     * @param string $fieldName
     * @return bool
     */
    public function hasField($fieldName = '')
    {
        return isset($this->fields[$fieldName]);
    }
}