# 📊 Estructura de Base de Datos - Inazuma Project

## Tablas Creadas

### 1️⃣ elementos
```sql
- id (PK)
- nombre (VARCHAR 50)
- icono_url (VARCHAR 255, nullable)
```
**Datos iniciales:** Fuego, Aire, Bosque, Tierra

---

### 2️⃣ selecciones
```sql
- id (PK)
- nombre (VARCHAR 100)
- descripcion (TEXT, nullable)
- bandera_url (VARCHAR 255, nullable)
```
**Datos iniciales:** Japón, EE.UU., Italia

---

### 3️⃣ equipos
```sql
- id (PK)
- nombre (VARCHAR 100)
- descripcion (TEXT, nullable)
- escudo_url (VARCHAR 255, nullable)
- id_seleccion (FK → selecciones.id, ON DELETE SET NULL)
```
**Datos iniciales:** Raimon, Royal Academy, Inazuma Japón

---

### 4️⃣ jugadores
```sql
- id (PK)
- nombre (VARCHAR 100)
- descripcion (TEXT, nullable)
- imagen_url (VARCHAR 255, nullable)
- id_elemento (FK → elementos.id, ON DELETE RESTRICT)
- id_equipo (FK → equipos.id, ON DELETE CASCADE)
```
**Datos iniciales:** Mark Evans, Axel Blaze, Jude Sharp, Nathan Swift, Shawn Froste, Xavier Foster

---

### 5️⃣ tecnicas
```sql
- id (PK)
- nombre (VARCHAR 100)
- descripcion (TEXT, nullable)
- poder (INT, nullable)
- id_elemento (FK → elementos.id, ON DELETE RESTRICT)
```
**Datos iniciales:** Mano Celestial, Tornado de Fuego, Ventisca Eterna, Pingüino Emperador Nº2, Mano Mágica

---

### 6️⃣ mi_equipo
```sql
- id (PK)
- id_jugador (FK → jugadores.id, UNIQUE, ON DELETE CASCADE)
- fecha_fichaje (TIMESTAMP, default CURRENT_TIMESTAMP)
```
**Uso:** Almacena los jugadores fichados por el usuario

---

## 🔗 Relaciones

```
elementos (1) ──┬─→ (N) jugadores
                └─→ (N) tecnicas

selecciones (1) ──→ (N) equipos

equipos (1) ──→ (N) jugadores

jugadores (1) ──→ (1) mi_equipo
```

---

## 📋 Orden de Ejecución de Migraciones

1. `create_elementos_table`
2. `create_selecciones_table`
3. `create_equipos_table` (depende de selecciones)
4. `create_jugadores_table` (depende de elementos y equipos)
5. `create_tecnicas_table` (depende de elementos)
6. `create_mi_equipo_table` (depende de jugadores)

---

## 🎯 Comandos Útiles

```bash
# Ver estado de migraciones
php artisan migrate:status

# Ejecutar migraciones pendientes
php artisan migrate

# Resetear y ejecutar todo de nuevo (BORRA DATOS)
php artisan migrate:fresh

# Ejecutar migraciones + seeders
php artisan migrate:fresh --seed

# Ejecutar solo el seeder de Inazuma
php artisan db:seed --class=InazumaSeeder

# Rollback última migración
php artisan migrate:rollback

# Ver información de un modelo
php artisan model:show Jugador
```

---

## 🗄️ Archivos de Migración Creados

```
database/migrations/
├── 0001_01_01_000000_create_users_table.php (Laravel)
├── 0001_01_01_000001_create_cache_table.php (Laravel)
├── 0001_01_01_000002_create_jobs_table.php (Laravel)
├── 2024_01_01_000003_create_elementos_table.php ✨
├── 2024_01_01_000004_create_selecciones_table.php ✨
├── 2024_01_01_000005_create_equipos_table.php ✨
├── 2024_01_01_000006_create_jugadores_table.php ✨
├── 2024_01_01_000007_create_tecnicas_table.php ✨
└── 2024_01_01_000008_create_mi_equipo_table.php ✨
```

---

## 📦 Modelos Eloquent Creados

```
app/Models/
├── User.php (Laravel)
├── Elemento.php ✨
├── Seleccion.php ✨
├── Equipo.php ✨
├── Jugador.php ✨
├── Tecnica.php ✨
└── MiEquipo.php ✨
```

Todos con:
- ✅ Relaciones configuradas
- ✅ Fillable fields
- ✅ Table name customizado
- ✅ Timestamps desactivados

---

## 🔍 Ejemplo de Consultas con Eloquent

```php
// Obtener todos los jugadores con sus relaciones
$jugadores = Jugador::with(['equipo', 'elemento'])->get();

// Obtener jugadores de fuego
$jugadoresFuego = Jugador::whereHas('elemento', function($query) {
    $query->where('nombre', 'Fuego');
})->get();

// Obtener equipos de una selección
$equiposJapon = Equipo::where('id_seleccion', 1)->get();

// Obtener jugadores fichados
$miFichajes = MiEquipo::with('jugador')->get();

// Fichar un jugador
MiEquipo::create(['id_jugador' => 1]);

// Buscar jugador por nombre
$mark = Jugador::where('nombre', 'like', '%Mark%')->first();

// Técnicas de un elemento
$tecnicasFuego = Tecnica::whereHas('elemento', function($query) {
    $query->where('nombre', 'Fuego');
})->get();
```

---

## 💾 Backup y Restauración

### Backup completo
```bash
# Exportar todo
mysqldump -u root -p inazuma_db > backup_inazuma_$(date +%Y%m%d).sql

# Exportar solo estructura
mysqldump -u root -p --no-data inazuma_db > estructura_inazuma.sql

# Exportar solo datos
mysqldump -u root -p --no-create-info inazuma_db > datos_inazuma.sql
```

### Restaurar
```bash
# Restaurar desde backup
mysql -u root -p inazuma_db < backup_inazuma.sql
```

---

## 🎨 Características Implementadas

- ✅ CRUD completo de jugadores
- ✅ Sistema de subida de imágenes
- ✅ Sistema de fichajes (mi_equipo)
- ✅ Relaciones entre todas las entidades
- ✅ Validaciones en controladores
- ✅ Vistas Blade con Bootstrap
- ✅ Seeders con datos de prueba
- ✅ Migraciones portables

---

## 🚀 Próximos Pasos Sugeridos

1. [ ] CRUD para equipos
2. [ ] CRUD para técnicas
3. [ ] Sistema de búsqueda y filtros
4. [ ] Página "Mi Equipo" para ver fichajes
5. [ ] Sistema de autenticación
6. [ ] API REST para mobile
7. [ ] Paginación en listados
8. [ ] Importar imágenes reales
9. [ ] Estadísticas de jugadores
10. [ ] Sistema de combates/partidos
