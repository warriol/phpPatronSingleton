# phpPatronSingleton
Incorporación del patrón singleton en php

## Estructura del proyecto

    ```
    phpPatronSingleton/
    │
    ├── backend/
    │   ├── config/
    │   │   ├── Database.php
    │   │   └── cargarEnv.php
    │   ├── controllers/
    │   │   └── UserController.php
    │   ├── models/
    │   │   └── User.php
    │   ├── sql/
    │   │   └── users.sql
    │   ├── index.php
    │   ├── .env
    │   └── .htaccess
    ├── frontend/
    │   ├── css/
    │   │   └── styles.css
    │   ├── js/
    │   │   └── scripts.js
    │   ├── index.html
    │   └── inicio.php
    └── README.md
    ```

## Descripción

Este proyecto implementa una API en PHP utilizando el patrón Singleton para la conexión a la base de datos. La estructura divide el backend del frontend, facilitando el desarrollo y mantenimiento.

### Backend

- `config/Database.php`: Implementación del patrón Singleton para la conexión a la base de datos.
- `controllers/UserController.php`: Controlador para manejar las solicitudes relacionadas con los usuarios.
- `models/User.php`: Modelo de usuario (vacío en este ejemplo, se usa para consultas directas en el controlador).
- `index.php`: Punto de entrada para las solicitudes API.
- `.htaccess`: Archivo de configuración de Apache para redirigir todas las solicitudes al `index.php`.

### Frontend

- `index.html`: Página principal del frontend.
- `css/styles.css`: Archivo CSS para estilos del frontend.
- `js/scripts.js`: Archivo JavaScript para el frontend.

## Cómo Empezar

1. Clona el repositorio.
2. Configura tu entorno de base de datos y actualiza las credenciales en `.env`.
3. Accede al frontend abriendo `frontend/index.html` en tu navegador.
4. Realiza solicitudes a la API a través del endpoint `backend/index.php`.