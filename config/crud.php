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
     * You can change admin address with this option, the default is 'throne'
     * @var string
     */
    'uri' => 'throne',

    /*
     * The package main title.
     * @var string
     */
    'title' => 'BlackfyreStudio/CRUD',

    /*
     * Company information in the footer
     */
    'company' => [
        'name' => 'BlackfyreStudio',
        'link' => 'https://github.com/BlackfyreStudio',
    ],

    /*
     * The directory where the crud controllers are located in the app folder.
     * The default is app\Http\Controllers\Crud
     * @var string
     */
    'directory' => 'Crud',


    /*
     * Global date/time formatting.
     * @var array
     */
    'date_format' => [
        'date'     => 'Y-m-d', /* for PHP's date formatting */
        'time'     => 'H:i:s',
        'datetime' => 'Y-m-d H:i:s',
        'js'       => [/* For javascript date formatting, based on moment.js */
            'date'     => 'YYYY-MM-DD',
            'datetime' => 'YYYY-MM-DD HH:mm',
        ],
    ],


    /*
     * Valid types to be exported: json, xml, csv, xls
     * This is still in development
     */
    'export-types' => [
    ],

    /*
     * How to serialize `multiple` fields.
     *  - explode
     *  - json
     *  - serialize
     */
    'multiple-serializer' => 'json',

    /*
     * How many items should be present on a paginated index page
     */
    'items-per-page' => 25,

    /*
     * Additional, custom assets. They will be loaded after the main files, with the asset() helper, so the same rules apply.
     */
    'assets' => [
        'stylesheets' => [],
        'javascript'  => [],
    ],

    /*
     * Allowed file mime-types for uploading
     * A more or less complete list: https://www.sitepoint.com/web-foundations/mime-types-complete-list/
     */
    'allowed-file-types'=>[
        'image' => ['image/jpeg','image/pjpeg','image/png','image/gif'],
        'general' => ['application/pdf']
    ],


    /*
     * The menu items are configured here, please refer to the documentation at https://github.com/BlackfyreStudio/crud/wiki/Creating-a-menu-structure
     *
     * ---------------------------------------------------
     * IMPORTANT: currently only 1 sub-level is supported!
     * ---------------------------------------------------
     *
     */
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
