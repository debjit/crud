<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace BlackfyreStudio\CRUD\Fields;

/**
 * Class MultipleOptionsField
 * @package BlackfyreStudio\CRUD\Fields
 */
class MultipleOptionsField extends RelationField
{
    /**
     * Grid item width
     * @var array
     */
    protected $GridWidth = [
        'xs'=>6,
        'sm'=>3,
    ];



    /**
     * Render the field.
     *
     * @access public
     * @return mixed|string
     */
    public function render()
    {
        if ($this->getDisplayField() === null) {
            throw new \InvalidArgumentException(sprintf('Please provide a display field for the `%s` relation.', $this->getName()));
        }
        switch ($this->getContext()) {
            case BaseField::CONTEXT_FORM:
                $baseModel = $this->getMasterInstance()->getModelFullName();
                $baseModel  = new $baseModel;
                $primaryKey = $baseModel->getKeyName();
                $relatedModel = $baseModel->{$this->getName()}()->getRelated();
                $items = [];
                foreach ($relatedModel::all() as $item) {
                    $items[$item->{$primaryKey}] = $item->{$this->getDisplayField()};
                }
                $id = $this->getMasterInstance()->getFormBuilder()->getIdentifier();
                $values = [];
                if ($id !== null) {
                    foreach ($baseModel::find($id)->{$relatedModel->getTable()} as $item) {
                        $values[$item->{$primaryKey}] = $item->{$primaryKey};
                    }
                }
                return view('crud::fields.multiple_options')
                    ->with('field',  $this)
                    ->with('items',  $items)
                    ->with('values', $values)
                    ->with('cell', $this->compileGridClasses());
                break;
            case BaseField::CONTEXT_INDEX:
            case BaseField::CONTEXT_FILTER:
            default:
                return null;
                break;
        }
    }

    /**
     * Override the getAttributes method to add the multiple attribute.
     *
     * @access public
     * @return array
     */
    public function getAttributes()
    {
        $this->setAttribute('multiple', true);
        return $this->attributes;
    }

    /**
     * Get grid item width
     * @return array
     */
    public function getGridWidth()
    {
        return $this->GridWidth;
    }

    /**
     * Set grid item width
     * @param array $GridWidth
     */
    public function setGridWidth($GridWidth)
    {
        $this->GridWidth = $GridWidth;
    }

    protected function compileGridClasses() {
        $collector = [];

        foreach ($this->GridWidth as $view=>$size) {
            $collector[] = 'col-' . $view . '-' . $size;
        }

        return implode(' ',$collector);
    }
}