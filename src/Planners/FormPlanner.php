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
use Closure;
use Illuminate\Support\Str;

/**
 * Class FormPlanner.
 */
class FormPlanner extends BasePlanner
{
    /**
     * @var
     */
    protected $tab;

    /**
     * @var string
     */
    protected $position = 'left';

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

        if ($this->getTab() !== null) {
            $field->setTab($this->tab);
        }

        $field->setPosition($this->getPosition());

        return $field;
    }

    /**
     * Create a simple string in the index view.
     *
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\StringField
     */
    public function string($name = '')
    {
        return $this->call('string', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\TextField
     */
    public function text($name = '')
    {
        return $this->call('text', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\TextField
     */
    public function email($name = '')
    {
        return $this->call('email', $name);
    }

    /**
     * @param $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\TextareaField
     */
    public function textarea($name)
    {
        return $this->call('textarea', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\BooleanField
     */
    public function boolean($name = '')
    {
        return $this->call('boolean', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\FileField
     */
    public function file($name = '')
    {
        return $this->call('file', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\ImageField
     */
    public function image($name = '')
    {
        return $this->call('image', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\SelectField
     */
    public function select($name = '')
    {
        return $this->call('select', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\BelongsToField
     */
    public function belongsTo($name = '')
    {
        return $this->call('BelongsTo', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\BelongsToManyField
     */
    public function belongsToMany($name = '')
    {
        return $this->call('BelongsToMany', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\MultipleOptionsField
     */
    public function multipleOptions($name = '')
    {
        return $this->call('MultipleOptions', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\MarkdownField
     */
    public function markdown($name = '')
    {
        return $this->call('markdown', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\PasswordField
     */
    public function password($name = '')
    {
        return $this->call('password', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\NumericField
     */
    public function number($name = '')
    {
        return $this->call('numeric', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\TagField
     */
    public function tags($name = '')
    {
        return $this->call('tag', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\DateField
     */
    public function date($name = '')
    {
        return $this->call('date', $name);
    }

    /**
     * @param string $name
     *
     * @return \BlackfyreStudio\CRUD\Fields\DateTimeField
     */
    public function dateTime($name = '')
    {
        return $this->call('dateTime', $name);
    }

    /**
     * Check if this mapper has tabs.
     *
     * @return bool
     */
    public function hasTabs()
    {
        return count($this->getTabs()) > 0;
    }

    /**
     * Get the mapper tabs.
     *
     * @return array
     */
    public function getTabs()
    {
        $tabs = [];
        /** @var BaseField $field */
        foreach ($this->getFields() as $field) {
            if ($field->getTab() === null) {
                continue;
            }
            $tabs[Str::slug($field->getTab())] = $field->getTab();
        }

        return $tabs;
    }

    /**
     * Set the mapper current tab.
     *
     * @param string          $name
     * @param string|callable $mapper
     *
     * @return void
     */
    public function tab($name, $mapper)
    {
        $this->tab = $name;
        if ($mapper instanceof Closure) {
            $mapper($this);
        }
    }

    /**
     * @return mixed
     */
    public function getTab()
    {
        return $this->tab;
    }

    /**
     * Set the field position. (left|right).
     *
     * @param string  $position
     * @param Closure $mapper
     *
     * @return void
     */
    public function position($position, Closure $mapper)
    {
        $this->position = $position;
        $mapper($this);
    }

    /**
     * Get the field position.
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Check for fields on a specific position.
     *
     * @param string $position
     *
     * @return bool
     */
    public function hasFieldsOnPosition($position)
    {
        $fieldsOnPosition = false;
        /** @var BaseField $field */
        foreach ($this->getFields() as $field) {
            if ($field->getPosition() == $position) {
                $fieldsOnPosition = true;
            }
        }

        return $fieldsOnPosition;
    }
}
