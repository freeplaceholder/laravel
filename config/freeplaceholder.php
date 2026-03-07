<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the FreePlaceholder service. Override this if you are
    | running a self-hosted instance.
    |
    */

    'base_url' => env('FREEPLACEHOLDER_BASE_URL', 'https://freeplaceholder.com'),

    /*
    |--------------------------------------------------------------------------
    | Default Placeholder Options
    |--------------------------------------------------------------------------
    |
    | Default options applied to all placeholder images when not explicitly
    | overridden.
    |
    */

    'defaults' => [
        'width' => 300,
        'height' => 300,
        'format' => 'svg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Avatar Options
    |--------------------------------------------------------------------------
    |
    | Default options applied to all avatar images when not explicitly
    | overridden.
    |
    */

    'avatar_defaults' => [
        'size' => 128,
        'format' => 'svg',
    ],

];
