# Project Manager Backend (Laravel)

Este proyecto es el backend de un gestor de proyectos desarrollado en Laravel 10.

## Requisitos

- PHP 8.1+
- Composer
- SQLite (o MySQL si lo configuras)

## Instalación

```bash
cd project-api
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
```

## Levantar en modo desarrollo

```bash
php artisan serve
```

El backend estará disponible en `http://localhost:8000`.

## Endpoints principales

- `/api/register` — Registro de usuario (admin o developer)
- `/api/login` — Login y obtención de token
- `/api/projects` — CRUD de proyectos
- `/api/tasks` — CRUD de tareas
- `/api/users` — Listado de usuarios (solo admin)
- `/api/logout` — Cierre de sesión

## Scripts útiles

- `php artisan migrate` — Ejecuta migraciones
- `php artisan db:seed` — Pobla la base de datos con datos de ejemplo
- `php artisan serve` — Levanta el backend en modo desarrollo

## Notas

- El sistema usa autenticación con tokens (Laravel Sanctum).
- Puedes cambiar la base de datos en el archivo `.env`.
- Asegúrate de que el frontend use la URL correcta del backend para evitar problemas de CORS.

---
