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
    'title'=>[
        'long'=>'BlackfyreStudio/CRUD',
        'short'=>'CRUD'
    ],

    /**
     * Company information in the footer
     */
    'company'=>[
        'name'=>'BlacfyreStudio',
        'link'=>'https://github.com/BlackfyreStudio'
    ],

    /**
     * Set the template skin
     * @var string
     */
    'template-skin'=>'skin-black',

    /**
     * The directory where the crud controllers are located.
     * @var string
     */
    'directory'=>'Crud',


    /**
     * Global date/time formatting.
     * @var array
     */
    'date_format' => [
        'date'     => 'Y-m-d',
        'time'     => 'H:i:s',
        'datetime' => 'Y-m-d H:i:s'
    ],

    'export-types' => [
        'json',
        'xml',
        'csv',
        'xls'
    ],
    /**
     * How to serialize `multiple` fields.
     *  - explode
     *  - json
     *  - serialize
     */
    'multiple-serializer' => 'json',

    /**
     * Additional, custom assets. They will be loaded after the main files, with the asset() helper, so the same rules apply.
     */
    'assets' => [
        'stylesheets' => [],
        'javascript' => []
    ],
    'menu'=>[
        [
            'title'=>'Settings',
            'icon'=>'gear',
            'children'=>[
                [
                    'title'=>'User management',
                    'class'=>'User',
                    'icon'=>'user'
                ],
                [
                    'title'=>'Access Control',
                    'class'=>'Role',
                    'icon'=>'key'
                ],
            ]
        ]
    ]
];