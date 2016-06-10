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
 * Class SelectField.
 */
class TagField extends BaseField
{
    /**
     * Holds the select options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Set the select options.
     *
     * @param array $options
     *
     * @return SelectField
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get the select options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Render the field.
     *
     * @return mixed|string
     */
    public function render()
    {
        $this->setAttribute('multiple', true);
        $this->setAttribute('class', 'form-control');
        $this->setAttribute('data-provide','tags');

        switch ($this->getContext()) {
            default:
            case $this::CONTEXT_INDEX:
            case $this::CONTEXT_FILTER:
                return $this->getValue();
                break;
            case $this::CONTEXT_FORM:
                return view('crud::fields.select', [
                    'field' => $this,
                ]);
                break;
        }
    }
}
