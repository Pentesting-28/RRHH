<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Estas credenciales no coinciden con nuestros registros.',
    'throttle' => 'Demasiados intentos fallidos. Por favor intenta de nuevo en un par de segundos.',
    'unauthenticated' => 'No autenticado.',
    'login' => 'Inicio de sesión satisfactorio.',
    'logout' => 'Cierre de sesión satisfactorio.',
    'not_validated' => 'Debe validar el correo electrónico. Revise su bandeja de entrada',
    'info' => 'Informacion de usuario logueado.',
    'register' => [
        'success'   => 'Usuario registrado exitosamente.' ,
        'failed'    => 'Ha ocurrido un error al registrar al usuario.',
        'mail_sent' => 'Se ha enviado un correo electrónico para validar su registro.',
        'code_not_found' => 'No se encuentra el código de verificación.',
    ],
    'profile' => [
        'update' => [
            'success' => "El usuario ha sido editado exitosamente.",
            'failed' => "Ha ocurrido un error al editar el usuario.",
        ]
    ]
];
