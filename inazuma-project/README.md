# ⚽ Inazuma Eleven - Proyecto de Gestión de Jugadores

Aplicación web desarrollada con Laravel para gestionar jugadores, equipos y fichajes del universo Inazuma Eleven.

## 🚀 Instalación Rápida

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=InazumaSeeder
php artisan storage:link
php artisan serve
```

Accede a: **http://localhost:8000**

📖 **Documentación completa:** Ver `QUICK_START.md`

---

## ✨ Características

- ✅ CRUD completo de jugadores con imágenes
- ✅ Sistema de fichajes (Mi Equipo)
- ✅ Gestión de equipos y selecciones
- ✅ Sistema de elementos/afinidades
- ✅ Base de datos completamente relacional
- ✅ Interfaz responsive con Bootstrap 5

## 📊 Estructura del Proyecto

### Modelos Eloquent
- `Elemento` - Fuego, Aire, Bosque, Tierra
- `Seleccion` - Selecciones nacionales
- `Equipo` - Equipos de fútbol
- `Jugador` - Jugadores con imágenes
- `Tecnica` - Técnicas especiales
- `MiEquipo` - Sistema de fichajes

### Migraciones
6 migraciones personalizadas para las tablas del proyecto + 3 de Laravel por defecto.

### Rutas Disponibles
```
GET  /                          Lista de jugadores
GET  /jugadores/crear           Crear jugador
POST /jugadores                 Guardar jugador
GET  /jugadores/{id}/editar     Editar jugador
PUT  /jugadores/{id}            Actualizar jugador
DELETE /jugadores/{id}          Eliminar jugador
POST /fichar/{id}               Fichar jugador
```

## 🗂️ Base de Datos

### Relaciones
```
elementos (1) ──┬─→ (N) jugadores
                └─→ (N) tecnicas

selecciones (1) ──→ (N) equipos
equipos (1) ──→ (N) jugadores
jugadores (1) ──→ (1) mi_equipo
```

## 📚 Documentación

- 📄 `QUICK_START.md` - Inicio rápido (5 minutos)
- 📖 `INSTALACION_CASA.md` - Guía completa de instalación
- 📊 `ESTRUCTURA_BD.md` - Estructura de base de datos
- 🖼️ `GUIA_IMAGENES.md` - Sistema de subida de imágenes

## 🛠️ Tecnologías

- **Framework:** Laravel 11.x
- **Base de datos:** MySQL 8.0
- **Frontend:** Blade + Bootstrap 5
- **PHP:** >= 8.1

## 🔧 Configuración

### Requisitos
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Extensiones PHP: PDO, Mbstring, OpenSSL, Tokenizer, XML, Ctype, JSON

### Variables de entorno (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inazuma_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

## 📦 Datos de Prueba

El seeder `InazumaSeeder` incluye:
- 4 Elementos (Fuego, Aire, Bosque, Tierra)
- 1 Selección (Japón)
- 1 Equipo (Raimon)
- 3 Jugadores (Mark Evans, Axel Blaze, Nathan Swift)

```bash
php artisan db:seed --class=InazumaSeeder
```

## 🖼️ Sistema de Imágenes

Las imágenes se almacenan en `storage/app/public/jugadores/` y son accesibles públicamente a través del enlace simbólico en `public/storage/`.

```bash
php artisan storage:link
```

## 🐛 Troubleshooting

### Resetear base de datos
```bash
php artisan migrate:fresh --seed
```

### Limpiar caché
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Ver estado de migraciones
```bash
php artisan migrate:status
```

### Ver rutas disponibles
```bash
php artisan route:list
```

## 📝 Comandos Útiles

```bash
# Crear nueva migración
php artisan make:migration create_nombre_table

# Crear nuevo modelo
php artisan make:model NombreModelo

# Crear controlador
php artisan make:controller NombreController

# Crear seeder
php artisan make:seeder NombreSeeder

# Ver información de modelo
php artisan model:show Jugador
```

## 🎯 Próximas Funcionalidades

- [ ] Autenticación de usuarios
- [ ] CRUD de equipos
- [ ] CRUD de técnicas
- [ ] Página "Mi Equipo"
- [ ] Sistema de búsqueda y filtros
- [ ] Estadísticas de jugadores
- [ ] API REST
- [ ] Paginación

## 👤 Autor

Efren - Proyecto Inazuma Eleven

## 📄 Licencia

Este proyecto es de código abierto para fines educativos.

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.


## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
