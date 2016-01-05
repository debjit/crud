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

use Illuminate\Console\AppNamespaceDetectorTrait;

class BelongsToManyField extends RelationField
{

    use AppNamespaceDetectorTrait;

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
            case BaseField::CONTEXT_INDEX:
                $baseModel = $this->getAppNamespace() . $this->getMasterInstance()->getModelBaseName();
                $baseModel    = new $baseModel;
                $relatedModel = $baseModel->{$this->getName()}()->getRelated();
                $primaryKey   = $relatedModel->getKeyName();
                $values = [];
                foreach ($this->getValue() as $item) {
                    $values[$item->{$primaryKey}] = $item->{$this->getDisplayField()};
                }
                return implode(', ', $values);
                break;
            case BaseField::CONTEXT_FORM:
                $baseModel = $this->getAppNamespace() . $this->getMasterInstance()->getModelBaseName();
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
                return view('crud::fields.belongs_to_many')
                    ->with('field',  $this)
                    ->with('items',  $items)
                    ->with('values', $values);
            break;
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
}