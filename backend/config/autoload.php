<?php
// autoload.php

spl_autoload_register(function ($controllerName) {
    // lista de directorios
    $dirs = [
        'class/',
        'controllers/',
        'models/',
        'utils/'
    ];

    // iterar sobre los directorios
    foreach ($dirs as $dir) {
        // Define la ruta de la clase basada en su nombre y ubicación relativa
        $classPath = __DIR__ . '/../' . $dir . $controllerName . '.php';

        // Verifica si el archivo de la clase existe y lo incluye
        if (file_exists($classPath)) {
            require_once $classPath;
        }
    }

    // Define la ruta de la clase basada en su nombre y ubicación relativa
    $controllerPath = __DIR__ . '/../controllers/' . $controllerName . '.php';

    // Verifica si el archivo de la clase existe y lo incluye
    if (file_exists($controllerPath)) {
        require_once $controllerPath;
    }
});
