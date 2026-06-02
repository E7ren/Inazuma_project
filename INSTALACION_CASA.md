# 🏠 Guía de Instalación del Proyecto Inazuma en Casa

## 📋 Requisitos Previos
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js y npm (opcional, para frontend)

## 🚀 Pasos de Instalación

### 1. Clonar el proyecto (si está en Git)
```bash
git clone <tu-repositorio>
cd inazuma-project
```

### 2. Instalar dependencias de Composer
```bash
composer install
```

### 3. Configurar el archivo .env
```bash
# Copiar el archivo de ejemplo
cp .env.example .env

# Editar el archivo .env con tus credenciales locales
nano .env
```

Configuración importante en `.env`:
```env
APP_NAME="Inazuma Project"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inazuma_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 4. Generar la clave de aplicación
```bash
php artisan key:generate
```

### 5. Crear la base de datos
Accede a MySQL y crea la base de datos:
```bash
mysql -u root -p
```

```sql
CREATE DATABASE inazuma_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 6. Ejecutar las migraciones
```bash
# Ejecutar todas las migraciones (crear tablas)
php artisan migrate
```

**IMPORTANTE:** Si las tablas ya existen y quieres empezar de cero:
```bash
# CUIDADO: Esto eliminará todos los datos
php artisan migrate:fresh
```

### 7. Ejecutar los seeders (datos de prueba)
```bash
php artisan db:seed --class=InazumaSeeder
```

### 8. Crear enlace simbólico para storage
```bash
php artisan storage:link
```

### 9. Permisos de carpetas (Linux/Mac)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 10. Iniciar el servidor de desarrollo
```bash
php artisan serve
```

El proyecto estará disponible en: **http://localhost:8000**

---

## 📁 Estructura de Migraciones Creadas

Las siguientes migraciones se ejecutarán en este orden:

1. ✅ `create_users_table` (Laravel default)
2. ✅ `create_cache_table` (Laravel default)
3. ✅ `create_jobs_table` (Laravel default)
4. 🆕 `create_elementos_table` - Elementos (Fuego, Aire, Bosque, Tierra)
5. 🆕 `create_selecciones_table` - Selecciones nacionales
6. 🆕 `create_equipos_table` - Equipos (depende de selecciones)
7. 🆕 `create_jugadores_table` - Jugadores (depende de elementos y equipos)
8. 🆕 `create_tecnicas_table` - Técnicas especiales (depende de elementos)
9. 🆕 `create_mi_equipo_table` - Tus fichajes (depende de jugadores)

---

## 🗂️ Modelos Eloquent Creados

Los siguientes modelos están listos para usar:

- ✅ `Elemento.php` - Gestión de elementos/afinidades
- ✅ `Seleccion.php` - Selecciones nacionales
- ✅ `Equipo.php` - Equipos de fútbol
- ✅ `Jugador.php` - Jugadores con imágenes
- ✅ `Tecnica.php` - Técnicas especiales
- ✅ `MiEquipo.php` - Sistema de fichajes

Todos los modelos incluyen:
- Relaciones Eloquent configuradas
- Campos fillable
- timestamps = false (según tu BD)

---

## 🖼️ Sistema de Imágenes

### Carpetas importantes:
```
storage/
└── app/
    └── public/
        └── jugadores/          ← Aquí se guardan las imágenes de jugadores

public/
└── storage/                    ← Enlace simbólico (creado con storage:link)
```

### Rutas disponibles:
- `GET /` - Lista de jugadores
- `GET /jugadores/crear` - Formulario crear jugador
- `POST /jugadores` - Guardar jugador nuevo
- `GET /jugadores/{id}/editar` - Formulario editar
- `PUT /jugadores/{id}` - Actualizar jugador
- `DELETE /jugadores/{id}` - Eliminar jugador
- `POST /fichar/{id}` - Fichar jugador a tu equipo

---

## 🐛 Solución de Problemas Comunes

### Error: "Access denied for user"
- Verifica las credenciales en `.env`
- Asegúrate de que el usuario tenga permisos en la BD

### Error: "Base table or view already exists"
- Las tablas ya existen, usa `php artisan migrate:fresh` (elimina datos)
- O ejecuta manualmente: `php artisan migrate:reset` y luego `php artisan migrate`

### Error: "No such file or directory (storage/logs/laravel.log)"
```bash
mkdir -p storage/logs
chmod -R 775 storage
```

### Las imágenes no se muestran
```bash
# Re-crear el enlace simbólico
php artisan storage:link
```

### Error de permisos en Linux
```bash
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## 📊 Verificar el Estado

### Ver estado de migraciones
```bash
php artisan migrate:status
```

### Ver rutas disponibles
```bash
php artisan route:list
```

### Ver modelos y relaciones
```bash
php artisan model:show Jugador
```

### Limpiar caché
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 🎮 Datos de Prueba (Seeder)

El seeder `InazumaSeeder` crea:
- 4 Elementos: Aire, Bosque, Fuego, Tierra
- 1 Selección: Japón
- 1 Equipo: Raimon
- 3 Jugadores: Mark Evans, Axel Blaze, Nathan Swift

---

## 📝 Notas Adicionales

### Si necesitas recrear todo desde cero:
```bash
# 1. Eliminar todo y empezar de nuevo
php artisan migrate:fresh

# 2. Ejecutar seeders
php artisan db:seed --class=InazumaSeeder

# 3. Recrear enlace de storage
php artisan storage:link
```

### Exportar/Importar datos:
```bash
# Exportar (desde el ordenador actual)
mysqldump -u root -p inazuma_db > inazuma_backup.sql

# Importar (en casa)
mysql -u root -p inazuma_db < inazuma_backup.sql
```

---

## ✅ Checklist de Instalación

- [ ] Composer instalado
- [ ] PHP >= 8.1
- [ ] MySQL/MariaDB corriendo
- [ ] Base de datos `inazuma_db` creada
- [ ] Archivo `.env` configurado
- [ ] `composer install` ejecutado
- [ ] `php artisan key:generate` ejecutado
- [ ] `php artisan migrate` ejecutado
- [ ] `php artisan db:seed` ejecutado
- [ ] `php artisan storage:link` ejecutado
- [ ] Permisos de carpetas configurados
- [ ] `php artisan serve` iniciado
- [ ] Acceso a http://localhost:8000 funcional

---

## 🆘 Ayuda

Si encuentras problemas, revisa:
1. Los logs en `storage/logs/laravel.log`
2. El estado de migraciones con `php artisan migrate:status`
3. Las credenciales de BD en `.env`
4. Los permisos de las carpetas storage y bootstrap/cache

**¡Listo para continuar el proyecto en casa! 🏠⚽**
