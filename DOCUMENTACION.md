# Documentación del Proyecto Inazuma Eleven

## Índice

1. [Descripción general](#descripción-general)
2. [Tecnologías utilizadas](#tecnologías-utilizadas)
3. [Estructura del proyecto](#estructura-del-proyecto)
4. [Base de datos](#base-de-datos)
5. [Modelos](#modelos)
6. [Controladores](#controladores)
7. [Rutas](#rutas)
8. [API REST](#api-rest)
9. [Autenticación y roles](#autenticación-y-roles)
10. [Vistas](#vistas)
11. [Seeders / Datos iniciales](#seeders--datos-iniciales)
12. [Instalación y puesta en marcha](#instalación-y-puesta-en-marcha)

---

## Descripción general

Aplicación web basada en el universo de **Inazuma Eleven** desarrollada con Laravel. Permite gestionar jugadores, equipos y técnicas especiales del anime/videojuego. Dispone de un sistema de autenticación con dos roles: **administrador** y **usuario**.

---

## Tecnologías utilizadas

| Tecnología | Versión |
|---|---|
| PHP | ^8.3 |
| Laravel Framework | ^13.0 |
| Bootstrap | 5.3.8 |
| MySQL | - |
| Vite | (bundler de assets) |
| PHPUnit | ^12.5 |

---

## Estructura del proyecto

```
inazuma-project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php        # Login, registro, logout
│   │   │   ├── JugadorController.php     # CRUD de jugadores
│   │   │   ├── EquipoController.php      # CRUD de equipos
│   │   │   ├── TecnicaController.php     # CRUD de técnicas
│   │   │   └── Api/
│   │   │       └── JugadorApiController.php  # Endpoints JSON
│   │   └── Middleware/
│   │       └── CheckRole.php             # Control de acceso por rol
│   └── Models/
│       ├── Usuario.php     # Usuarios de la aplicación
│       ├── Jugador.php     # Jugadores del universo Inazuma
│       ├── Equipo.php      # Equipos de fútbol
│       ├── Tecnica.php     # Técnicas especiales
│       ├── Elemento.php    # Elementos (Fuego, Aire, Bosque, Tierra)
│       ├── Seleccion.php   # Selecciones nacionales
│       └── MiEquipo.php    # Jugadores fichados por el usuario
├── database/
│   ├── migrations/         # Definición del esquema de tablas
│   └── seeders/
│       ├── InazumaSeeder.php   # Datos del universo Inazuma
│       └── UsuarioSeeder.php   # Usuarios predefinidos
├── resources/views/
│   ├── auth/               # Login y registro
│   ├── jugadores/          # Vistas de jugadores
│   ├── equipos/            # Vistas de equipos
│   └── tecnicas/           # Vistas de técnicas
└── routes/
    ├── web.php             # Rutas web
    └── api.php             # Rutas API
```

---

## Base de datos

### Diagrama de tablas

```
users ──────────────────────────────────────────────
  id, name, email, password, rol

elementos ──────────────────────────────────────────
  id, nombre, icono_url

selecciones ────────────────────────────────────────
  id, nombre, descripcion, bandera_url

equipos ────────────────────────────────────────────
  id, nombre, descripcion, escudo_url, id_seleccion → selecciones.id

jugadores ──────────────────────────────────────────
  id, nombre, descripcion, imagen_url
  id_elemento → elementos.id
  id_equipo   → equipos.id

tecnicas ───────────────────────────────────────────
  id, nombre, descripcion, poder, id_elemento → elementos.id

jugador_tecnica (tabla pivote N:M) ─────────────────
  id_jugador → jugadores.id
  id_tecnica → tecnicas.id

mi_equipo ──────────────────────────────────────────
  id, id_jugador → jugadores.id, fecha_fichaje
```

### Relaciones

| Relación | Tipo | Descripción |
|---|---|---|
| `Jugador` → `Elemento` | belongsTo | Un jugador tiene un elemento de afinidad |
| `Jugador` → `Equipo` | belongsTo | Un jugador pertenece a un equipo |
| `Jugador` ↔ `Tecnica` | belongsToMany | Un jugador puede aprender varias técnicas |
| `Equipo` → `Seleccion` | belongsTo | Un equipo pertenece a una selección nacional |
| `Equipo` → `Jugadores` | hasMany | Un equipo tiene muchos jugadores |
| `Tecnica` → `Elemento` | belongsTo | Una técnica tiene un elemento asociado |
| `Seleccion` → `Equipos` | hasMany | Una selección tiene varios equipos |

---

## Modelos

### `Usuario` (`app/Models/Usuario.php`)

Extiende `Authenticatable`. Mapeado sobre la tabla `users`.

| Atributo | Tipo | Descripción |
|---|---|---|
| `name` | string | Nombre del usuario |
| `email` | string | Correo electrónico (único) |
| `password` | string | Contraseña (hash) |
| `rol` | string | `admin` o `usuario` |

**Métodos:**
- `esAdmin()` — devuelve `true` si el rol es `admin`
- `esUsuario()` — devuelve `true` si el rol es `usuario`
- `getNombreAttribute()` — accessor que expone el campo `name` como `nombre`

---

### `Jugador` (`app/Models/Jugador.php`)

Tabla: `jugadores`. Sin timestamps.

| Atributo | Tipo | Descripción |
|---|---|---|
| `nombre` | string(100) | Nombre del jugador |
| `descripcion` | text | Descripción opcional |
| `imagen_url` | string(255) | Ruta de la imagen |
| `id_elemento` | FK | Elemento de afinidad |
| `id_equipo` | FK | Equipo al que pertenece |

**Relaciones:** `elemento()`, `equipo()`, `tecnicas()`

---

### `Equipo` (`app/Models/Equipo.php`)

Tabla: `equipos`. Sin timestamps.

| Atributo | Tipo | Descripción |
|---|---|---|
| `nombre` | string(100) | Nombre del equipo |
| `descripcion` | text | Descripción opcional |
| `escudo_url` | string | Ruta del escudo |
| `id_seleccion` | FK | Selección nacional asociada |

**Relaciones:** `seleccion()`, `jugadores()`

---

### `Tecnica` (`app/Models/Tecnica.php`)

Tabla: `tecnicas`. Sin timestamps.

| Atributo | Tipo | Descripción |
|---|---|---|
| `nombre` | string(100) | Nombre de la técnica |
| `descripcion` | text | Descripción opcional |
| `poder` | integer | Poder de la técnica (1–9999) |
| `id_elemento` | FK | Elemento asociado |

**Relaciones:** `elemento()`, `jugadores()`

---

### `Elemento` (`app/Models/Elemento.php`)

Tabla: `elementos`. Sin timestamps.

| Atributo | Tipo |
|---|---|
| `nombre` | string |
| `icono_url` | string |

Valores predefinidos: **Aire, Bosque, Fuego, Tierra**

---

### `Seleccion` (`app/Models/Seleccion.php`)

Tabla: `selecciones`. Sin timestamps.

| Atributo | Tipo |
|---|---|
| `nombre` | string |
| `descripcion` | text |
| `bandera_url` | string |

**Relaciones:** `equipos()`

---

### `MiEquipo` (`app/Models/MiEquipo.php`)

Tabla: `mi_equipo`. Sin timestamps.

| Atributo | Tipo | Descripción |
|---|---|---|
| `id_jugador` | FK | Jugador fichado |
| `fecha_fichaje` | date | Fecha del fichaje |

**Relaciones:** `jugador()`

---

## Controladores

### `AuthController`

Gestiona la autenticación de usuarios.

| Método | Descripción |
|---|---|
| `showLogin()` | Muestra el formulario de login |
| `login(Request)` | Procesa el login (soporta password plano y hash) |
| `logout()` | Cierra la sesión |
| `showRegister()` | Muestra el formulario de registro |
| `register(Request)` | Crea un nuevo usuario con rol `usuario` |

---

### `JugadorController`

CRUD completo de jugadores.

| Método | Descripción |
|---|---|
| `index()` | Lista todos los jugadores con equipo y elemento |
| `create()` | Formulario de creación |
| `store(Request)` | Guarda el jugador (sube imagen si la hay) |
| `edit($id)` | Formulario de edición |
| `update(Request, $id)` | Actualiza el jugador (gestiona cambio de imagen) |
| `destroy($id)` | Elimina el jugador y su imagen |
| `fichar(Request, $id)` | Añade el jugador a `mi_equipo` si no estaba ya |

---

### `EquipoController`

CRUD completo de equipos + gestión de plantilla.

| Método | Descripción |
|---|---|
| `index()` | Lista todos los equipos |
| `create()` | Formulario de creación |
| `store(Request)` | Guarda el equipo (sube escudo si lo hay) |
| `show($id)` | Detalle del equipo con jugadores asignados |
| `edit($id)` | Formulario de edición |
| `update(Request, $id)` | Actualiza el equipo (gestiona cambio de escudo) |
| `destroy($id)` | Elimina el equipo y desasigna sus jugadores |
| `addJugador(Request, $id)` | Asigna un jugador al equipo |
| `removeJugador($id, $jugadorId)` | Desasigna un jugador del equipo |

---

### `TecnicaController`

CRUD completo de técnicas + gestión de jugadores.

| Método | Descripción |
|---|---|
| `index()` | Lista todas las técnicas |
| `create()` | Formulario de creación |
| `store(Request)` | Guarda la técnica |
| `show($id)` | Detalle de la técnica con jugadores asignados |
| `edit($id)` | Formulario de edición |
| `update(Request, $id)` | Actualiza la técnica |
| `destroy($id)` | Elimina la técnica (desvincula jugadores primero) |
| `addJugador(Request, $id)` | Vincula un jugador a la técnica (sin duplicados) |
| `removeJugador($id, $jugadorId)` | Desvincula un jugador de la técnica |

---

## Rutas

### Rutas públicas (sin autenticación)

| Método | URL | Nombre | Descripción |
|---|---|---|---|
| GET | `/login` | `login` | Formulario de login |
| POST | `/login` | `login.post` | Procesar login |
| GET | `/register` | `register` | Formulario de registro |
| POST | `/register` | `register.post` | Procesar registro |
| POST | `/logout` | `logout` | Cerrar sesión |

### Rutas de usuario autenticado

| Método | URL | Nombre | Descripción |
|---|---|---|---|
| GET | `/` | `jugadores.index` | Listado de jugadores |
| GET | `/equipos` | `equipos.index` | Listado de equipos |
| GET | `/tecnicas` | `tecnicas.index` | Listado de técnicas |

### Rutas exclusivas de administrador

#### Jugadores

| Método | URL | Nombre | Descripción |
|---|---|---|---|
| GET | `/jugadores/crear` | `jugadores.create` | Formulario crear jugador |
| POST | `/jugadores` | `jugadores.store` | Guardar jugador |
| GET | `/jugadores/{id}/editar` | `jugadores.edit` | Formulario editar jugador |
| PUT | `/jugadores/{id}` | `jugadores.update` | Actualizar jugador |
| DELETE | `/jugadores/{id}` | `jugadores.destroy` | Eliminar jugador |

#### Equipos

| Método | URL | Nombre | Descripción |
|---|---|---|---|
| GET | `/equipos/crear` | `equipos.create` | Formulario crear equipo |
| POST | `/equipos` | `equipos.store` | Guardar equipo |
| GET | `/equipos/{id}` | `equipos.show` | Ver detalle del equipo |
| GET | `/equipos/{id}/editar` | `equipos.edit` | Formulario editar equipo |
| PUT | `/equipos/{id}` | `equipos.update` | Actualizar equipo |
| DELETE | `/equipos/{id}` | `equipos.destroy` | Eliminar equipo |
| POST | `/equipos/{id}/jugadores` | `equipos.addJugador` | Añadir jugador al equipo |
| DELETE | `/equipos/{id}/jugadores/{jugadorId}` | `equipos.removeJugador` | Quitar jugador del equipo |

#### Técnicas

| Método | URL | Nombre | Descripción |
|---|---|---|---|
| GET | `/tecnicas/crear` | `tecnicas.create` | Formulario crear técnica |
| POST | `/tecnicas` | `tecnicas.store` | Guardar técnica |
| GET | `/tecnicas/{id}` | `tecnicas.show` | Ver detalle de la técnica |
| GET | `/tecnicas/{id}/editar` | `tecnicas.edit` | Formulario editar técnica |
| PUT | `/tecnicas/{id}` | `tecnicas.update` | Actualizar técnica |
| DELETE | `/tecnicas/{id}` | `tecnicas.destroy` | Eliminar técnica |
| POST | `/tecnicas/{id}/jugadores` | `tecnicas.addJugador` | Añadir jugador a la técnica |
| DELETE | `/tecnicas/{id}/jugadores/{jugadorId}` | `tecnicas.removeJugador` | Quitar jugador de la técnica |

---

## API REST

Base URL: `/api`  
No requiere autenticación. Responde en JSON.

### Endpoints

#### `GET /api/jugadores`

Devuelve todos los jugadores con su equipo, selección y técnicas.

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "nombre": "Mark Evans",
      "descripcion": "Capitán y portero legendario.",
      "imagen_url": null,
      "elemento": "Bosque",
      "equipo": {
        "id": 1,
        "nombre": "Raimon",
        "seleccion": "Japón"
      },
      "tecnicas": [
        { "id": 1, "nombre": "...", "poder": 500, "elemento": "Bosque" }
      ]
    }
  ]
}
```

#### `GET /api/jugadores/{id}`

Devuelve un jugador concreto con el mismo formato que el listado.

#### `GET /api/equipos`

Devuelve todos los equipos (implementado en `JugadorApiController@equipos`).

#### `GET /api/tecnicas`

Devuelve todas las técnicas (implementado en `JugadorApiController@tecnicas`).

---

## Autenticación y roles

### Middleware `CheckRole` (`app/Http/Middleware/CheckRole.php`)

Verifica que el usuario autenticado tenga el rol requerido. Si no lo tiene, redirige a `jugadores.index` con un mensaje de error.

**Uso en rutas:**
```php
Route::middleware(['role:admin'])->group(function () {
    // Rutas solo para admin
});
```

### Roles disponibles

| Rol | Descripción | Permisos |
|---|---|---|
| `admin` | Administrador | Lectura + escritura (crear, editar, eliminar) en todo |
| `usuario` | Usuario normal | Solo lectura de jugadores, equipos y técnicas |

### Flujo de autenticación

1. El usuario accede a `/login`
2. `AuthController@login` busca al usuario por email
3. Comprueba la contraseña (soporta texto plano y bcrypt)
4. Laravel establece la sesión con `Auth::login()`
5. Al cerrar sesión, `Auth::logout()` destruye la sesión

---

## Vistas

Todas las vistas usan **Bootstrap 5.3.8** vía CDN y comparten la misma barra de navegación con los enlaces a Jugadores, Equipos y Técnicas, además del nombre del usuario, su badge de rol y el botón de cerrar sesión.

| Vista | Descripción |
|---|---|
| `auth/login.blade.php` | Formulario de login |
| `auth/register.blade.php` | Formulario de registro |
| `jugadores/index.blade.php` | Tabla de jugadores con acciones (admin: editar/eliminar) |
| `jugadores/create.blade.php` | Formulario para crear jugador |
| `jugadores/edit.blade.php` | Formulario para editar jugador |
| `equipos/index.blade.php` | Grid de tarjetas de equipos |
| `equipos/show.blade.php` | Detalle del equipo con plantilla de jugadores |
| `equipos/create.blade.php` | Formulario para crear equipo |
| `equipos/edit.blade.php` | Formulario para editar equipo |
| `tecnicas/index.blade.php` | Listado de técnicas |
| `tecnicas/show.blade.php` | Detalle de la técnica con jugadores vinculados |
| `tecnicas/create.blade.php` | Formulario para crear técnica |
| `tecnicas/edit.blade.php` | Formulario para editar técnica |

---

## Seeders / Datos iniciales

### `InazumaSeeder`

Crea los datos del universo Inazuma Eleven:

- **Elementos:** Aire, Bosque, Fuego, Tierra
- **Selección:** Japón
- **Equipo:** Raimon
- **Jugadores iniciales:** Mark Evans (Bosque), Axel Blaze (Fuego)

### `UsuarioSeeder`

Crea los usuarios predefinidos:

| Nombre | Email | Contraseña | Rol |
|---|---|---|---|
| Efren Andres | Efren@IesEnricValor.com | `admin123` | admin |
| Juan Pérez | juan@correo.com | `juan123` | usuario |
| María García | maria@correo.com | `maria123` | usuario |
| Super Admin | superadmin@empresa.com | `super123` | admin |

> **Nota:** La contraseña del primer admin (`admin123`) se almacena en texto plano. El `AuthController` detecta esto y lo admite. Para el resto se usa bcrypt.

---

## Instalación y puesta en marcha

### Requisitos

- PHP >= 8.3
- Composer
- MySQL
- Node.js y npm

### Pasos

```bash
# 1. Clonar / situar el proyecto
cd inazuma-project

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JS
npm install

# 4. Copiar el archivo de entorno
copy .env.example .env   # Windows
# cp .env.example .env   # Linux/Mac

# 5. Generar clave de la aplicación
php artisan key:generate

# 6. Configurar la base de datos en .env
# DB_DATABASE=inazuma_db
# DB_USERNAME=tu_usuario
# DB_PASSWORD=tu_contraseña

# 7. Ejecutar migraciones y seeders
php artisan migrate --seed

# 8. Crear enlace simbólico para el almacenamiento de imágenes
php artisan storage:link

# 9. Levantar el servidor de desarrollo
php artisan serve

# 10. (Opcional) Compilar assets con Vite
npm run dev
```

La aplicación estará disponible en `http://127.0.0.1:8000`.

### Acceso rápido

- **Admin:** `Efren@IesEnricValor.com` / `admin123`
- **Usuario:** `juan@correo.com` / `juan123`
