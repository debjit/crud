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
namespace BlackfyreStudio\CRUD\Util;

/**
 * Class Value.
 */
class Value
{
    /**
     * Encode a value based on the strategy.
     *
     * @param string $strategy
     * @param string $value
     *
     * @return string
     */
    public static function encode($strategy, $value)
    {
        switch ($strategy) {
            case 'explode':
                return implode(',', $value);
            case 'json':
                return json_encode($value);
            case 'serialize':
                return serialize($value);
        }

        return $value;
    }

    /**
     * Decode a value based on the strategy.
     *
     * @param string $strategy
     * @param string $value
     *
     * @return array|mixed
     */
    public static function decode($strategy, $value)
    {
        switch ($strategy) {
            case 'explode':
                return explode(',', $value);
            case 'json':
                return json_decode($value);
            case 'serialize':
                return unserialize($value);
        }

        return $value;
    }
}
