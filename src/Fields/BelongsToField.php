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

class BelongsToField extends RelationField
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
            throw new \InvalidArgumentException(sprintf('Please provide a display field for the `%s` relation via the display(); method.', $this->getName()));
        }
        switch ($this->getContext()) {
            case BaseField::CONTEXT_INDEX:
                $value = $this->getValue();
                return $value->{$this->getDisplayField()};
                break;
            case BaseField::CONTEXT_FILTER:
                /** @var \Illuminate\Database\Eloquent\Model $baseModel */
                /** @var \Illuminate\Database\Eloquent\Model $relatedModel */
                $baseModel = $this->getMasterInstance()->getModelFullName();
                $baseModel = new $baseModel;
                $primaryKey = $baseModel->getKeyName();
                $relatedModel = $baseModel->{$this->getName()}()->getRelated();
                $itemsCollector = [];
                foreach ($relatedModel::all() as $item) {
                    $itemsCollector[$item->{$primaryKey}] = $item->{$this->getDisplayField()};
                }
                $column = str_singular($relatedModel->getTable()) . '_id';
                if (Input::has($column)) {
                    $this->setValue(Input::get($column));
                }
                return view('crud::fields.belongs_to')
                    ->with('field', $this)
                    ->with('items', $itemsCollector);
                break;
            case BaseField::CONTEXT_FORM:
                /** @var \Illuminate\Database\Eloquent\Model $baseModel */
                /** @var \Illuminate\Database\Eloquent\Model $relatedModel */
                $baseModel = $this->getMasterInstance()->getModelFullName();
                $baseModel = new $baseModel;
                $primaryKey = $baseModel->getKeyName();
                $relatedModel = $baseModel->{$this->getName()}()->getRelated();

                $itemsCollector = [];

                foreach ($relatedModel->all() as $item) {
                    $itemsCollector[$item->{$primaryKey}] = $item->{$this->getDisplayField()};
                }


                if ($this->getValue() !== null) {
                    $this->setValue($this->getValue()[0]->{$primaryKey});
                }

                return view('crud::fields.belongs_to')
                    ->with('field', $this)
                    ->with('items', $itemsCollector);
                break;
        }
        return $this->getValue();
    }
}