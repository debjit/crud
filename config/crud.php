<?php
/**
 * Created by IntelliJ IDEA.
 * User: Meki
 * Date: 2015.03.30.
 * Time: 21:39
 */

return [
    /**
     * Package URI.
     * @var string
     */
    'uri'=>'throne',

    /**
     * The package main title.
     * @var string
     */
    'title'=>'BlackfyreStudio/CRUD',

    /**
     * The directory where the crud models are located.
     * @var string
     */
    'directory'=>'crud',

    /**
     * Global date/time formatting.
     * @var array
     */
    'date_format' => [
        'date'     => 'Y-m-d',
        'time'     => 'H:i:s',
        'datetime' => 'Y-m-d H:i:s'
    ],

    /**
     * Additional, custom assets. They will be loaded after the main files, with the asset() helper, so the same rules apply.
     */
    'assets' => [
        'stylesheets' => [],
        'javascript' => []
    ],
    'menu'=>[]
];