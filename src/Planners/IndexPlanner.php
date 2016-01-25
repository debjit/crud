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

namespace BlackfyreStudio\CRUD\Planner;

/**
 * Class IndexPlanner
 * @package BlackfyreStudio\CRUD\Planner
 */
class IndexPlanner extends BasePlanner
{
    /**
     * Create an identifier column in the index view. It's usually the record ID
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\IdentifierField
     */
    public function identifier($name = '')
    {
        return $this->call('identifier', $name);
    }

    /**
     * Create a simple string in the index view
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\StringField
     */
    public function string($name = '')
    {
        return $this->call('string', $name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\BooleanField
     */
    public function boolean($name = '')
    {
        return $this->call('boolean', $name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\BaseField
     */
    public function image($name = '')
    {
        return $this->call('image', $name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\SelectField
     */
    public function select($name = '')
    {
        return $this->call('select', $name);
    }

    /**
     * @param string $name
     * @return \BlackfyreStudio\CRUD\Fields\BelongsToManyField
     */
    public function belongsToMany($name = '')
    {
        return $this->call('BelongsToMany', $name);
    }
}
