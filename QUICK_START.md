# 🚀 Quick Start - Inazuma Project

## ⚡ Instalación Rápida (5 minutos)

```bash
# 1. Entrar al proyecto
cd inazuma-project

# 2. Instalar dependencias
composer install

# 3. Configurar .env
cp .env.example .env
nano .env  # Editar DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 4. Generar clave
php artisan key:generate

# 5. Crear base de datos en MySQL
mysql -u root -p -e "CREATE DATABASE inazuma_db;"

# 6. Ejecutar migraciones y seeders
php artisan migrate
php artisan db:seed --class=InazumaSeeder

# 7. Enlace de storage para imágenes
php artisan storage:link

# 8. Iniciar servidor
php artisan serve
```

**Listo!** Abre http://localhost:8000

---

## 📦 Archivos Listos para Transportar

### ✅ Migraciones (6 archivos nuevos)
```
database/migrations/2024_01_01_000003_create_elementos_table.php
database/migrations/2024_01_01_000004_create_selecciones_table.php
database/migrations/2024_01_01_000005_create_equipos_table.php
database/migrations/2024_01_01_000006_create_jugadores_table.php
database/migrations/2024_01_01_000007_create_tecnicas_table.php
database/migrations/2024_01_01_000008_create_mi_equipo_table.php
```

### ✅ Modelos (6 archivos nuevos)
```
app/Models/Elemento.php
app/Models/Seleccion.php
app/Models/Equipo.php
app/Models/Jugador.php
app/Models/Tecnica.php
app/Models/MiEquipo.php
```

### ✅ Controladores (1 archivo)
```
app/Http/Controllers/JugadorController.php
```

### ✅ Vistas (3 archivos)
```
resources/views/jugadores/index.blade.php
resources/views/jugadores/create.blade.php
resources/views/jugadores/edit.blade.php
```

### ✅ Rutas
```
routes/web.php
```

### ✅ Seeders
```
database/seeders/InazumaSeeder.php
```

---

## 🎯 Funcionalidades Implementadas

| Funcionalidad | Estado | URL |
|--------------|--------|-----|
| Ver lista de jugadores | ✅ | `/` |
| Crear jugador con imagen | ✅ | `/jugadores/crear` |
| Editar jugador | ✅ | `/jugadores/{id}/editar` |
| Eliminar jugador | ✅ | DELETE `/jugadores/{id}` |
| Fichar jugador | ✅ | POST `/fichar/{id}` |
| Subida de imágenes | ✅ | Automático en crear/editar |

---

## 🗂️ Base de Datos

### Tablas creadas:
1. ✅ `elementos` - Fuego, Aire, Bosque, Tierra
2. ✅ `selecciones` - Países (Japón, etc.)
3. ✅ `equipos` - Raimon, Royal Academy, etc.
4. ✅ `jugadores` - Mark Evans, Axel Blaze, etc.
5. ✅ `tecnicas` - Mano Celestial, Tornado de Fuego, etc.
6. ✅ `mi_equipo` - Tus fichajes

### Datos de prueba incluidos:
- 4 elementos
- 3 selecciones
- 3 equipos
- 6 jugadores
- 5 técnicas

---

## 🔧 Configuración del .env

```env
APP_NAME="Inazuma Project"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inazuma_db        # ⚠️ CAMBIAR
DB_USERNAME=tu_usuario        # ⚠️ CAMBIAR
DB_PASSWORD=tu_password       # ⚠️ CAMBIAR
```

---

## 🐛 Si algo falla...

### Error de permisos
```bash
chmod -R 775 storage bootstrap/cache
```

### Tablas ya existen
```bash
php artisan migrate:fresh --seed  # ⚠️ Borra todos los datos
```

### Imágenes no se ven
```bash
php artisan storage:link
```

### Ver logs de errores
```bash
tail -f storage/logs/laravel.log
```

---

## 📱 Rutas Disponibles

```bash
# Ver todas las rutas
php artisan route:list

# Rutas principales:
GET  /                          Lista de jugadores
GET  /jugadores/crear           Formulario crear
POST /jugadores                 Guardar nuevo
GET  /jugadores/{id}/editar     Formulario editar
PUT  /jugadores/{id}            Actualizar
DELETE /jugadores/{id}          Eliminar
POST /fichar/{id}               Fichar jugador
```

---

## 📚 Documentación Completa

- 📄 `INSTALACION_CASA.md` - Guía detallada de instalación
- 📊 `ESTRUCTURA_BD.md` - Estructura de base de datos completa
- 🖼️ `GUIA_IMAGENES.md` - Sistema de subida de imágenes

---

## ✅ Checklist Pre-Transporte

- [x] Migraciones creadas (6 archivos)
- [x] Modelos creados (6 archivos)
- [x] Controlador con CRUD completo
- [x] Vistas Blade (index, create, edit)
- [x] Rutas configuradas
- [x] Seeder con datos de prueba
- [x] Sistema de imágenes funcional
- [x] Relaciones Eloquent configuradas
- [x] Documentación completa

---

## 🎮 Testing Rápido

Después de instalar, prueba esto:

```bash
# 1. Verificar migraciones
php artisan migrate:status

# 2. Verificar seeders
php artisan db:seed --class=InazumaSeeder

# 3. Abrir en navegador
php artisan serve
# Ir a: http://localhost:8000

# 4. Probar crear jugador
# Ir a: http://localhost:8000/jugadores/crear
```

---

## 💡 Tips

1. **Usa Git** para versionar el proyecto
2. **No subas** el archivo `.env` a Git (ya está en .gitignore)
3. **Haz backups** antes de `migrate:fresh`
4. **Las imágenes** están en `storage/app/public/jugadores/`
5. **Composer install** cada vez que clones el proyecto

---

## 📞 Comandos de Emergencia

```bash
# Limpiar todo y empezar de cero
php artisan migrate:fresh --seed
php artisan storage:link
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Regenerar autoload
composer dump-autoload
```

---

## 🎉 ¡Todo listo!

El proyecto está **100% portable** y listo para continuar en casa.

Solo necesitas:
1. Copiar toda la carpeta del proyecto
2. Ejecutar `composer install`
3. Configurar `.env`
4. Ejecutar `php artisan migrate`
5. Ejecutar `php artisan db:seed`

**¡A disfrutar programando! ⚽🔥**
