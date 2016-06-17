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
 * Class BooleanField.
 */
class BooleanField extends BaseField
{
    /**
     * Render the field.
     *
     * @return mixed|string
     */
    public function render()
    {
        $this->setAttribute('data-provide', 'toggle');

        return view('crud::fields.boolean', [
            'field' => $this,
        ]);
    }

    /**
     * The field should always have a value, either true or false.
     */
    public function preSubmitHook()
    {
        $request = $this->getMasterInstance()->getFormBuilder()->getRequest();

        if (! $request->has($this->getName())) {
            $request->offsetSet($this->getName(), 0);
        }

        /*
        if (!array_key_exists($this->getName(), $input)) {
            $input[$this->getName()] = 0;
        }

        return $input;
        */
    }
}
