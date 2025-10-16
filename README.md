# Prueba Técnica - Sistema de Gestión de Proyectos COTECMAR

Sistema web desarrollado con Laravel y Vue.js para la gestión de proyectos, bloques y piezas de construcción naval.

## 📋 Requisitos del Sistema

-   **PHP** >= 8.2
-   **Composer** >= 2.0
-   **Node.js** >= 16.0
-   **NPM**
-   **MySQL** >= 8.0 o **PostgreSQL** >= 13
-   **Git**

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/DJAYI/prueba-tecnica-cotecmar.git
cd prueba-tecnica-cotecmar
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Configurar variables de entorno

```bash
# Copiar el archivo de configuración
copy .env.example .env

# Generar la clave de aplicación
php artisan key:generate
```

### 5. Configurar la base de datos

Edita el archivo `.env` con tus credenciales de base de datos:

```env
DB_CONNECTION=sqlite
```

Crear el archivo database.sqlite

### 6. Ejecutar migraciones junto con Seeders

```bash
# Crear las tablas en la base de datos y llenarlas
php artisan migrate --seed

```

### 7. Configurar storage

```bash
# Crear enlace simbólico para archivos públicos
php artisan storage:link
```

### 8. Compilar / Generar build del frontend

```bash
# Para desarrollo
npm run dev

# Para producción
npm run build
```

## 🏃‍♂️ Ejecutar el Proyecto (Despues de correr migraciones)

### Desarrollo

```bash
# Terminal 1: Servidor Laravel
php artisan serve # o Herd

# Terminal 2: Correr frontend en servidor de desarrollo local
npm run dev

# Terminal 3: Optimizador
php artisan optimize:clear
```

Usuario Prueba:
correo: test@example.com
contraseña: password

La aplicación estará disponible en: `http://localhost:8000`

## 📁 Estructura del Proyecto

```plaintext
prueba-tecnica-cotecmar/
├── app/
│   ├── Http/Controllers/     # Controladores HTTP
│   ├── Models/              # Modelos Eloquent
|   |-- Exports/            # Clases exports para reportes PDF
|   |-- Services/           # Servicios que proporcionan logica compleja
|   |-- Enums/               # Enumeraciones
|   |
│   └── ...
├── database/
|   |-- factories/              # Generadores automaticos de datos de prueba
│   ├── migrations/          # Migraciones de BD
│   └── seeders/            # Seeders
├── resources/
│   ├── js/
│   │   ├── Pages/         # Páginas
|   |   |   |
|   |   |   |-- Admin       # Paginas / Modulos de Administrador
|   |   |   |-- Auth        # Paginas / Modulos de Autenticación
|   |   |
│   │   └── Layouts/       # Plantillas basicas de las pagians
│   └── views/             # Vistas Blade
|       |-- reports/        # Plantillas de generacion de reportes PDF
|
├── routes/
│   ├── web.php            # Rutas web
│   └── api.php            # Rutas API
└── public/               # Archivos públicos
```

## 🎨 Tecnologías Utilizadas

-   **Backend**: Laravel 11
-   **Frontend**: Vue.js 3 + Inertia.js
-   **CSS**: Tailwind CSS
-   **Base de Datos**: SQLite

## 🗄️ Esquema de Base de Datos

El sistema utiliza un esquema relacional jerárquico con las siguientes tablas:

### **Proyectos (projects)**

Tabla principal que agrupa los proyectos de construcción naval.

```sql
CREATE TABLE projects (
    id VARCHAR(4) PRIMARY KEY,          # Código de proyecto (4 caracteres)
    name VARCHAR(255) NOT NULL,         # Nombre descriptivo del proyecto
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Características**:

-   **ID personalizado**: Código alfanumérico de 4 caracteres (ej: "ARC1", "P001")
-   **Nomenclatura naval**: Permite códigos estándar de la industria naval

### **Bloques (blocks)**

Subdivisiones estructurales de cada proyecto que representan secciones del buque.

```sql
CREATE TABLE blocks (
    id VARCHAR(8) PRIMARY KEY,          # Código de bloque (8 caracteres)
    name CHAR(4) NOT NULL,             # Nombre corto del bloque
    project_id VARCHAR(4) NOT NULL,     # FK hacia projects
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);
```

**Características**:

-   **ID extendido**: 8 caracteres para códigos compuestos (ej: "ARC1-B01")
-   **Nombre fijo**: Campo `CHAR(4)` para nomenclatura estandarizada
-   **Cascada**: Eliminación automática de bloques al eliminar proyectos

### **Piezas (pieces)**

Componentes individuales fabricados que conforman cada bloque.

```sql
CREATE TABLE pieces (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,  # ID secuencial automático
    name CHAR(3) NOT NULL,             # Código de pieza (3 caracteres)
    theorical_weight DECIMAL(10,2) NOT NULL,  # Peso teórico en kg
    real_weight DECIMAL(10,2) NULL,    # Peso real medido (nullable)
    status ENUM('manufactured', 'pending') DEFAULT 'pending',
    block_id VARCHAR(8) NOT NULL,      # FK hacia blocks
    user_id BIGINT NULL,               # FK hacia users (nullable)
    manufactured_at TIMESTAMP NULL,    # Fecha de fabricación
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    FOREIGN KEY (block_id) REFERENCES blocks(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

**Características**:

-   **Trazabilidad completa**: Registro de usuario y fecha de fabricación
-   **Precisión decimal**: Pesos con 2 decimales para exactitud industrial
-   **Estados controlados**: Enum para garantizar integridad de estados
-   **Auditoría**: Campo `manufactured_at` para seguimiento temporal

### **Decisiones de Diseño del Esquema**

#### 1. **Identificadores Jerárquicos Personalizados**

Se implementó un sistema mixto de identificadores según el nivel jerárquico:

```text
Proyecto: "BICM" (string) → Buque Oceanográfico
  └── Bloque: "130-1110" (string) → Sección 1110 del proyecto 130
      └── Pieza: 1, 2, 3... (int auto) + name: "B01", "A02", "H12" (código)
```

**Ejemplos reales del sistema**:

-   **Proyectos**: BICM (Oceanográfico), BALC (Buque DA), OPV (Offshore), BRF (Refluvial)
-   **Bloques**: "130-1110", "135-1110", "130-3510" (formato: sector-subsección)
-   **Piezas**: ID secuencial (1, 2, 3...) + name alfanumérico ("B01", "A02", "H12")

**Justificación**:

-   **Nomenclatura naval real**: Proyectos y bloques usan códigos de COTECMAR
-   **Eficiencia en piezas**: ID int para performance en gran volumen de piezas
-   **Doble identificación**: ID secuencial + código alfanumérico (name) para flexibilidad
-   **Trazabilidad completa**: Relaciones FK proporcionan la jerarquía completa
-   **Optimización de consultas**: IDs int más eficientes para JOINs masivos

#### 2. **Campos de Longitud Fija vs Variable**

```sql
-- Campos fijos para códigos estandarizados
name CHAR(4) -- Bloques: siempre 4 caracteres
name CHAR(3) -- Piezas: siempre 3 caracteres

-- Campos variables para descripciones
name VARCHAR(255) -- Proyectos: nombres descriptivos
```

**Justificación**:

-   **Consistencia**: Códigos de longitud uniforme en reportes
-   **Validación**: Fuerza nomenclatura estandarizada
-   **Optimización**: `CHAR` más eficiente que `VARCHAR` para datos fijos

#### 3. **Precisión Decimal en Pesos**

```sql
theorical_weight DECIMAL(10,2)  -- Hasta 99,999,999.99 kg
real_weight DECIMAL(10,2)       -- Precisión de 2 decimales
```

**Justificación**:

-   **Precisión industrial**: 2 decimales suficientes para básculas industriales
-   **Rango amplio**: Hasta 99 toneladas por pieza individual
-   **Evitar errores de punto flotante**: `DECIMAL` garantiza exactitud

#### 4. **Estados Controlados por Enum**

```sql
status ENUM('manufactured', 'pending') DEFAULT 'pending'
```

**Justificación**:

-   **Integridad de datos**: Solo valores válidos en base de datos
-   **Performance**: Más eficiente que VARCHAR con validación en aplicación
-   **Orden lógico**: 'manufactured' antes que 'pending' en orden alfabético
-   **Expansibilidad**: Fácil agregar estados como 'in_progress', 'quality_check'

#### 5. **Sistema de Auditoría Completo**

```sql
user_id BIGINT NULL,               -- Quién fabricó la pieza
manufactured_at TIMESTAMP NULL,    -- Cuándo se fabricó
created_at TIMESTAMP,              -- Cuándo se registró
updated_at TIMESTAMP               -- Última modificación
```

**Justificación**:

-   **Trazabilidad ISO**: Cumple estándares de calidad naval
-   **Nullable**: `user_id` permite piezas sin asignar
-   **SET NULL**: Preserva historial aunque se elimine el usuario
-   **Auditoría temporal**: Diferencia entre registro y fabricación real

#### 6. **Relaciones en Cascada Estratégicas**

```sql
-- Cascada completa: Proyecto → Bloques → Piezas
projects CASCADE blocks CASCADE pieces

-- Preservación de historial: Usuario → Piezas
users SET NULL pieces
```

**Justificación**:

-   **Integridad referencial**: Eliminar proyecto limpia todo
-   **Preservar trazabilidad**: Mantener registro de piezas aunque usuario se elimine
-   **Simplicidad operativa**: No requiere limpieza manual de datos huérfanos
-   **Seguridad de datos**: Previene eliminaciones accidentales por FK constraints

#### 7. **Optimización de Consultas Frecuentes**

Las foreign keys crean índices automáticos para:

-   `blocks.project_id`: Listar bloques por proyecto
-   `pieces.block_id`: Listar piezas por bloque
-   `pieces.user_id`: Consultar trabajo por usuario

**Consultas optimizadas**:

```sql
-- Dashboard principal: piezas agrupadas por estado
SELECT status, COUNT(*) FROM pieces GROUP BY status;

-- Reporte completo con trazabilidad (usado en el PDF)
SELECT
    p.name AS proyecto,
    b.name AS bloque,
    pi.name AS pieza,
    pi.theorical_weight,
    pi.real_weight,
    pi.status,
    u.name AS fabricado_por,
    pi.manufactured_at
FROM projects p
JOIN blocks b ON p.id = b.project_id
JOIN pieces pi ON b.id = pi.block_id
LEFT JOIN users u ON pi.user_id = u.id
ORDER BY p.name, b.name, pi.name;

-- Piezas pendientes por bloque (para manufacturing)
SELECT pi.* FROM pieces pi
JOIN blocks b ON pi.block_id = b.id
WHERE pi.status = 'pending' AND b.project_id = ?;
```

### **Modelos Eloquent y Relaciones**

#### **Configuración de Modelos**

Los modelos usan identificadores mixtos según su propósito:

```php
// Project.php y Block.php - IDs string personalizados
protected $primaryKey = 'id';
public $incrementing = false;
protected $keyType = 'string';

// Piece.php - ID int auto-incremental (configuración por defecto de Laravel)
// protected $primaryKey = 'id';     // Por defecto
// public $incrementing = true;      // Por defecto
// protected $keyType = 'int';       // Por defecto
```

#### **Relaciones Implementadas**

```php
// Project.php - Un proyecto tiene muchos bloques
public function blocks() {
    return $this->hasMany(Block::class, 'project_id', 'id');
}

// Block.php - Un bloque pertenece a un proyecto y tiene muchas piezas
public function project() {
    return $this->belongsTo(Project::class, 'project_id', 'id');
}
public function pieces() {
    return $this->hasMany(Piece::class, 'block_id', 'id');
}

// Piece.php - Una pieza pertenece a un bloque y opcionalmente a un usuario
public function block() {
    return $this->belongsTo(Block::class, 'block_id', 'id');
}
public function user() {
    return $this->belongsTo(User::class, 'user_id', 'id');
}
```

#### **Lógica de Negocio Implementada**

**Enum de Estados**:

```php
enum PieceStatusEnum: string {
    case PENDING = 'pending';
    case MANUFACTURED = 'manufactured';
}
```

**Accessor para Diferencia de Peso**:

```php
public function getDifferenceAttribute() {
    if ($this->real_weight && $this->theorical_weight) {
        return round($this->real_weight - $this->theorical_weight, 2);
    }
    return null;
}
```

**Casting Automático**:

```php
protected function casts(): array {
    return [
        'status' => PieceStatusEnum::class,
        'manufactured_at' => 'datetime',
    ];
}
```
