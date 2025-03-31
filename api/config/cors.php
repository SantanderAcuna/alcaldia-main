<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Esta configuración permite solicitudes desde cualquier origen para 
    | las rutas de la API de Laravel y otras rutas necesarias.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],  // Permite todos los métodos HTTP (GET, POST, PUT, DELETE, etc.)

    'allowed_origins' => ['*'],  // Permite solicitudes desde cualquier dominio

    'allowed_origins_patterns' => [],  // No se necesitan patrones específicos

    'allowed_headers' => ['*'],  // Permite todos los encabezados

    'exposed_headers' => [],  // No se exponen encabezados adicionales

    'max_age' => 0,  // No hay tiempo máximo de almacenamiento en caché de la respuesta

    'supports_credentials' => false,  // No requiere autenticación con credenciales (cookies)
];