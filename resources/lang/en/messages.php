<?php

/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    'success' => [
        'title'         => 'Success!',
        'model-created' => 'Created a new :model',
        'model-updated' => 'Updated a :model',
        'model-deleted' => 'Deleted :count :model',
        'messages'      => [
            'sign-in' => [
                'user-signed-in' => 'User logged in.',
            ],
            'sign-out' => [
                'user-signed-out' => 'Signed out.',
            ],
        ],
    ],

    'warning' => [
        'title' => 'Warning!',
    ],

    'error' => [
        'title'             => 'Whoops!',
        'validation-errors' => 'Validation errors',
        'messages'          => [
            'sign-in' => [
                'validation-error' => 'Validation error.',
                'user-not-found'   => 'User not found',
            ],
        ],
    ],

];
