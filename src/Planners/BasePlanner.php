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
namespace BlackfyreStudio\CRUD\Planner;

use BlackfyreStudio\CRUD\Exceptions\PlannerException;
use BlackfyreStudio\CRUD\Fields\BaseField;
use Illuminate\Support\Str;

/**
 * Class BasePlanner.
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
     * @param string $name
     *
     * @return BaseField
     */
    protected function call($type = '', $name = '')
    {
        if (empty($type)) {
            throw new PlannerException('The field type is missing');
        }

        if (empty($name)) {
            throw new PlannerException('The field name reference is missing');
        }

        /* @var BaseField $field */
        $type = '\\BlackfyreStudio\\CRUD\\Fields\\'.Str::studly($type).'Field';
        $field = new $type($name, $this->getCRUDMasterInstance());

        $this->fields[$name] = $field;

        return $field;
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
     *
     * @return $this
     */
    public function setCRUDMasterInstance($CRUDMasterInstance)
    {
        $this->CRUDMasterInstance = $CRUDMasterInstance;

        return $this;
    }

    /**
     * @param string $fieldName
     *
     * @return bool
     */
    public function hasField($fieldName = '')
    {
        return isset($this->fields[$fieldName]);
    }
}
