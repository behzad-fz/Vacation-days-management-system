<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Data source for application
     |--------------------------------------------------------------------------
     | Supported data sources: "json", "sqlite"
     */
    'data_source' => 'json',

    'json' => [
        'path' => 'database/ottivo.json'
    ],
    'sqlite' => [
        'path' => 'database/ottivo.sqlite'
    ]
];
