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


namespace BlackfyreStudio\CRUD\Fields;

/**
 * Class BelongsToField
 * @package BlackfyreStudio\CRUD\Fields
 */
class BelongsToField extends RelationField
{

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