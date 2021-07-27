<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom REST Language Response Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | corresponding the API endpoints.
    |
    */

    'error' => 'Error',
    
    'success' => 'Exito',

    'http' => [
        'method_not_allowed' => 'Método Http no permitido ó no se encuentra',
        'not_found' => 'No encontrado',
    ],

    'model' => [
        'found' => 'Registros encontrados exitosamente.',
        'not_found' => 'No se han encontrado registros asociados al modelo.',
        'create' => [
            'success' => "Creación de :name exitosa!",
            'failed' => "Ha ocurrido un error en la creación de :name",
        ],
        'edit' => [
            'success' => "Edición de :name exitosa!",
            'failed' => "Ha ocurrido un error en la edición de :name",  
        ],
        'already_exists' => 'Ya posee una :name creada.'
    ],
    
    'service' => [
        'response' => [
            'not_found' => "No se encuentran datos en el servicio",
        ],
        'connection' => [
            'failed' => 'Error intentando conectarse al servicio. Intente mas tarde' 
        ]
    ]

];
