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
use BlackfyreStudio\CRUD\Exceptions\PlannerException;
use BlackfyreStudio\CRUD\Fields\BaseField;
use Illuminate\Support\Str;
use Closure;

/**
 * Class FormPlanner
 * @package BlackfyreStudio\CRUD\Planner
 */
class FormPlanner extends BasePlanner
{
    protected $tab;

    protected $position = 'left';

    /**
     * @param string $type
     * @param string $name
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

        /** @var BaseField $field */
        $type = '\\BlackfyreStudio\\CRUD\\Fields\\' . Str::studly($type) . 'Field';
        $field = new $type($name, $this->getCRUDMasterInstance());

        $this->fields[$name] = $field;

        if ($this->getTab() !== null) {
            $field->setTab($this->tab);
        }

        $field->setPosition($this->getPosition());

        return $field;
    }

    /**
     * Create a simple string in the index view
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\StringField
     */
    public function string($name = '') {
        return $this->call('string',$name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\BaseField
     */
    public function text($name = '') {
        return $this->call('text',$name);
    }

    public function textarea($name) {
        return $this->call('textarea',$name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\
     */
    public function boolean($name='') {
        return $this->call('boolean',$name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\
     */
    public function image($name='') {
        return $this->call('image',$name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\
     */
    public function select($name='') {
        return $this->call('select',$name);
    }

    /**
     * Check if this mapper has tabs.
     *
     * @access public
     * @return bool
     */
    public function hasTabs()
    {
        return count($this->getTabs()) > 0;
    }
    /**
     * Get the mapper tabs.
     *
     * @access public
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
     * @param  string          $name
     * @param  string|callable $mapper
     *
     * @access public
     * @return void
     */
    public function tab($name, $mapper)
    {
        $this->tab = $name;
        if ($mapper instanceof Closure) {
            $mapper($this);
        }
    }
    public function getTab()
    {
        return $this->tab;
    }
    /**
     * Set the field position. (left|right).
     *
     * @param  string  $position
     * @param  Closure $mapper
     *
     * @access public
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
     * @access public
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * Check for fields on a specific position.
     *
     * @param  string $position
     *
     * @access public
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
