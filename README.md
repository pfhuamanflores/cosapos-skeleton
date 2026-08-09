# COSAPOS S.A. — Sistema de gestión de proyectos

Aplicación web full-stack construida con Laravel 12 para publicar y administrar proyectos de ingeniería y construcción.

## Funcionalidades

- Portal público con listado, buscador y ficha de cada proyecto.
- Registro, inicio y cierre de sesión.
- Interacción de usuarios registrados mediante solicitudes de recursos.
- Dashboard y gestión de usuarios exclusivos del administrador.
- CRUD completo de proyectos con validación e imágenes almacenadas localmente.
- Roles especializados para presupuestos, costos, solicitudes, reportes y consolidación.
- Base de datos relacional administrada mediante migraciones de Laravel.

## Instalación local

1. Instalar dependencias con `composer install` y `npm install`.
2. Copiar `.env.example` como `.env` y configurar la base de datos.
3. Ejecutar `php artisan key:generate`.
4. Ejecutar `php artisan migrate --seed`.
5. Crear el enlace público de imágenes con `php artisan storage:link`.
6. Iniciar con `composer run dev`.

El seeder crea el administrador `admin@cosapos.com` con contraseña `password` para fines de demostración. Debe cambiarse en un entorno real.

## Verificación

Ejecutar las pruebas automáticas con `php artisan test`.

## Equipo

Proyecto académico desarrollado por un equipo de tres integrantes y versionado con Git.
