<?php

return [

    /*-------------------------------------------------------------------------
    | UiAvatars Base URL
    |--------------------------------------------------------------------------
    |
    | This value is the base URL used by the package to generate the requests
    | to the UiAvatars API.
    |
    */

    'base_url' => env('UI_AVATARS_BASE_URL', 'https://ui-avatars.com/api/'),

    /*-------------------------------------------------------------------------
    | Default Input Values
    |--------------------------------------------------------------------------
    |
    | The default values loaded by the package when creating a new UiAvatars
    | instance.
    |
    */

    'defaults' => [
        'name' => null,
        'background' => 'random',
        'color' => '8b5d5d',
        'size' => 64,
        'font-size' => 0.5,
        'length' => 2,
        'rounded' => false,
        'bold' => false,
        'uppercase' => true,
        'format' => 'png',
    ],

    /*-------------------------------------------------------------------------
    | Default API Values
    |--------------------------------------------------------------------------
    |
    | The default values used by the UiAvatars API.
    | Those are the default values used by the UiAvatars API and are used to
    | determinate if a parameter can be omitted from the request and should be
    | changed only if you know what you are doing.
    |
    */

    'api-defaults' => [
        'background' => 'random',
        'color' => '8b5d5d',
        'size' => 64,
        'font-size' => 0.5,
        'length' => 2,
        'rounded' => false,
        'bold' => false,
        'uppercase' => true,
        'format' => 'png',
    ],
];
