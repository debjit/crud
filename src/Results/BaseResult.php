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
namespace BlackfyreStudio\CRUD\Results;

/**
 * Class BaseResult.
 */
abstract class BaseResult
{
    /**
     * Holds the item identifier (normally the id).
     *
     * @var int
     */
    protected $identifier;
    /**
     * Holds the resources fields.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Set the identifier.
     *
     * @param int $identifier
     *
     * @return BaseResult
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get the identifier.
     *
     * @return int
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Add a field to the result.
     *
     * @param string $key
     * @param string $field
     *
     * @return BaseResult
     */
    public function addField($key, $field)
    {
        $this->fields[$key] = $field;

        return $this;
    }

    /**
     * Get the fields.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get a field.
     *
     * @param $key
     *
     * @return string
     */
    public function getField($key)
    {
        return $this->fields[$key];
    }
}
