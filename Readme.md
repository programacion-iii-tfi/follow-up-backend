# follow-up-backend

API REST desarrollada con Laravel 11 siguiendo arquitectura hexagonal, como proyecto universitario para ProgramaciónIII — UTN.

## Stack

- **PHP 8.2+**
- **Laravel 11**
- **PostgreSQL** (Supabase)
- **Laravel Sanctum** — autenticación stateless via tokens
- **ramsey/uuid** — UUIDs como primary keys

---

## Estructura del proyecto

```
app/
├── Application/          # Casos de uso y DTOs
│   └── User/
│       ├── DTOs/
│       └── UseCases/
├── Domain/               # Entidades, interfaces, value objects
│   └── User/
│       ├── Entities/
│       ├── Repositories/
│       └── ValueObjects/
├── Infrastructure/       # Implementaciones Eloquent, providers
│   └── User/
│       └── Persistence/
└── Interfaces/           # Controllers, Requests, Resources
    └── Http/
        └── User/
            ├── Controllers/
            ├── Requests/
            └── Resources/
```

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone <repo-url>
cd follow-up-backend
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar variables de entorno

```bash
cp .env.example .env
```

Editá `.env` con tus credenciales de Supabase:

```env
APP_NAME=follow-up-backend
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=db.<tu-proyecto>.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=<tu-password>

SANCTUM_STATEFUL_DOMAINS=localhost
```

### 4. Generar clave de aplicación

```bash
php artisan key:generate
```

### 5. Ejecutar migraciones

```bash
php artisan migrate
```

Esto crea las tablas:
- `users`
- `personal_access_tokens`

### 6. Levantar el servidor

```bash
php artisan serve
```

La API queda disponible en `http://127.0.0.1:8000`.

---

## Extensiones PHP requeridas

Verificá que estén habilitadas en `php.ini`:

```
extension=pdo_pgsql
extension=fileinfo
extension=zip
```

---

## Roles disponibles

Los roles se manejan con un PHP Enum (`UserRole`) ubicado en el Domain layer.

| Value (enviar en requests) | Label |
|---|---|
| `alumno` | Alumno |
| `docente` | Docente |
| `tutor` | Tutor |
| `administrador` | Administrador |

---

## Endpoints

### Autenticación

#### `POST /api/v1/login`

Inicia sesión y devuelve un token Bearer.

**Body:**
```json
{
    "email": "pablo@mail.com",
    "password": "12345678"
}
```

**Respuesta exitosa `200`:**
```json
{
    "token": "1|abc123...",
    "role": "alumno"
}
```

---

#### `POST /api/v1/logout` 🔒

Cierra la sesión eliminando el token actual.

**Headers:**
```
Authorization: Bearer <token>
```

**Respuesta exitosa `200`:**
```json
{
    "message": "Sesión cerrada correctamente."
}
```

---

### Usuarios

#### `POST /api/v1/users`

Registra un nuevo usuario.

**Body:**
```json
{
    "name": "Pablo Ramirez",
    "email": "pablo@mail.com",
    "password": "12345678",
    "role": "alumno"
}
```

**Respuesta exitosa `201`:**
```json
{
    "id": "aa758b77-0f8d-42a8-973d-4aa1a5a40384",
    "name": "Pablo Ramirez",
    "email": "pablo@mail.com",
    "role": "Alumno"
}
```

---

#### `GET /api/v1/users` 🔒

Lista todos los usuarios registrados.

**Headers:**
```
Authorization: Bearer <token>
```

**Respuesta exitosa `200`:**
```json
[
    {
        "id": "aa758b77-0f8d-42a8-973d-4aa1a5a40384",
        "name": "Pablo Ramirez",
        "email": "pablo@mail.com",
        "role": "Alumno"
    }
]
```

---

#### `GET /api/v1/users/{id}` 🔒

Obtiene un usuario por ID. *(pendiente de implementar)*

#### `PUT /api/v1/users/{id}` 🔒

Actualiza un usuario. *(pendiente de implementar)*

#### `DELETE /api/v1/users/{id}` 🔒

Elimina un usuario. *(pendiente de implementar)*

---

## Usar el token en Postman

1. Realizá el `POST /api/v1/login`
2. Copiá el `token` de la respuesta
3. En los requests protegidos 🔒, agregá el header:
   - Key: `Authorization`
   - Value: `Bearer <token>`

---

## Expiración de tokens

Configurable en `config/sanctum.php`:

```php
'expiration' => 60, // 1 horas (en minutos)
```

`null` significa que el token nunca expira.