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
            'pwd-change' => [
                'changed' => 'Password updated!',
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
            'pwd-change' => [
                'validation-error' => 'Validation error.',
                'fields-missing'   => 'User not found',
                'invalid-original'   => 'Supplied original password doesn\'t match the current one!',
                'no-match'   => 'The supplied new passwords don\'t match!',
            ],
        ],
    ],

];
