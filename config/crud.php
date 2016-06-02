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

return [
    /*
     * Package URI.
     * @var string
     */
    'uri' => 'throne',

    /*
     * The package main title.
     * @var string
     */
    'title' => [
        'long'  => 'BlackfyreStudio/CRUD',
        'short' => 'CRUD',
    ],

    /*
     * Company information in the footer
     */
    'company' => [
        'name' => 'BlackfyreStudio',
        'link' => 'https://github.com/BlackfyreStudio',
    ],

    /*
     * Set the template skin
     * @var string
     */
    'template-skin' => 'skin-black',

    /*
     * The directory where the crud controllers are located.
     * @var string
     */
    'directory' => 'Crud',


    /*
     * Global date/time formatting.
     * @var array
     */
    'date_format' => [
        'date'     => 'Y-m-d',
        'time'     => 'H:i:s',
        'datetime' => 'Y-m-d H:i:s',
        'js'       => [
            'date' => 'yyyy-mm-dd',
        ],
    ],

    'export-types' => [
        'json',
        'xml',
        'csv',
        'xls',
    ],
    /*
     * How to serialize `multiple` fields.
     *  - explode
     *  - json
     *  - serialize
     */
    'multiple-serializer' => 'json',

    /*
     * Additional, custom assets. They will be loaded after the main files, with the asset() helper, so the same rules apply.
     */
    'assets' => [
        'stylesheets' => [],
        'javascript'  => [],
    ],
    'menu' => [
        [
            'title'    => 'Settings',
            'icon'     => 'gear',
            'children' => [
                [
                    'title' => 'User management',
                    'class' => 'User',
                    'icon'  => 'user',
                ],
                [
                    'title' => 'Access Control',
                    'class' => 'Role',
                    'icon'  => 'key',
                ],
            ],
        ],
    ],
];
