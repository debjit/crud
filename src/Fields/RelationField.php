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
namespace BlackfyreStudio\CRUD\Fields;

/**
 * Class RelationField.
 */
abstract class RelationField extends BaseField
{
    /**
     * Holds the display field name.
     *
     * @var string
     */
    protected $displayField = null;
    /**
     * Whether or not to render actions next to this field.
     *
     * @var bool
     */
    protected $inline = true;

    /**
     * Set the display field name.
     *
     * @param string $displayField
     *
     * @return BelongsToField
     */
    public function display($displayField)
    {
        $this->displayField = $displayField;

        return $this;
    }

    /**
     * Get the display field name.
     *
     * @return string
     */
    public function getDisplayField()
    {
        return $this->displayField;
    }

    /**
     * Set inline rendering.
     *
     * @param bool $inline
     *
     * @return BelongsToField
     */
    public function setInline($inline)
    {
        $this->inline = (bool) $inline;

        return $this;
    }

    /**
     * Get inline rendering.
     *
     * @return BelongsToField
     */
    public function getInline()
    {
        return $this;
    }

    /**
     * @param $input
     * @param \Illuminate\Database\Eloquent\Model $baseModel
     */
    public function postSubmitHook($input, $baseModel)
    {
        $model = $baseModel::find($this->getMasterInstance()->getFormBuilder()->getIdentifier());
        $pivot = $this->getName();

        if (isset($input[$pivot])) {
            $model->{$pivot}()->sync($input[$pivot]);
        } else {
            $model->{$pivot}()->sync([]);
        }
    }
}
