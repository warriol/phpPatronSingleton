<?php

function load_env($file)
{
    if (!file_exists($file)) {
        throw new Exception("El archivo .env no se encuentra: $file");
    }

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorar comentarios
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Dividir la línea en clave y valor
        list($key, $value) = explode('=', $line, 2);

        // Quitar espacios en blanco
        $key = trim($key);
        $value = trim($value);

        // Establecer la variable de entorno
        putenv(sprintf('%s=%s', $key, $value));
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// Cargar el archivo .env
load_env(__DIR__ . '/../.env');