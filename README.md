<div align="center">

# 🏢 Sistema de Gestión de Agencia

Plataforma web para administrar una agencia de Habbo: usuarios, rangos, tiempos, ascensos, ventas y pagos.

![PHP](https://img.shields.io/badge/PHP_8.2-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL_8-4479A1?style=flat-square&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=flat-square&logo=bootstrap&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat-square&logo=docker&logoColor=white)
![Nginx](https://img.shields.io/badge/Nginx-009639?style=flat-square&logo=nginx&logoColor=white)
![License](https://img.shields.io/badge/licencia-MIT-green?style=flat-square)

</div>

> Existe una versión más reciente migrada a Python + Flask: [sistema-agencia-v2](https://github.com/urieldomingezm/sistema-agencia-v2).

## ✨ Funcionalidades

- **Usuarios y roles**: registro, inicio de sesión y menús distintos según el rango del usuario.
- **Control de tiempos**: inicio, pausa y cierre de turnos con historial automático.
- **Ascensos**: flujo de ascensos con auditoría de cada cambio.
- **Ventas y pagos**: registro de ventas de rangos y control de pagas.
- **Requisitos semanales** y **quejas** por usuario.
- **Auditoría en base de datos**: triggers que registran cambios en ascensos, tiempos y contraseñas.
- **Permisos por tabla**: cada rol tiene permisos de lectura, escritura y eliminación definidos.

## 🛠️ Stack

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.2 (PDO) |
| Base de datos | MySQL 8 con triggers |
| Frontend | HTML, CSS, JavaScript, Bootstrap |
| Librerías | JustValidate, SweetAlert2, simple-datatables |
| Infraestructura | Docker Compose, Apache, Nginx (proxy inverso + SSL) |

## 📁 Estructura

```
.
├── base-datos/
│   ├── tablas/          # Esquema de la BD (sin datos reales)
│   └── permisos/        # Grants del usuario de la aplicación
├── private/             # Lógica que no se expone al navegador
│   ├── conexion/        # Conexión PDO a MySQL
│   ├── menus/           # Menús por rango
│   ├── modal/           # Modales (ventas, tiempos, ascensos)
│   ├── plantilla/       # Header, footer y layout
│   ├── procesos/        # Lógica de negocio y seguridad
│   └── tabs/
├── public/assets/       # CSS, JS e imágenes
├── usuario/             # Vistas del panel por sección
│   ├── administrativo/
│   ├── app/
│   └── rangos/
├── config.php           # Rutas globales del proyecto
├── docker-compose.yml
├── Dockerfile
└── nginx.conf
```

## 🚀 Instalación

**Requisitos:** Docker y Docker Compose.

```bash
git clone https://github.com/urieldomingezm/sistema_agencia.git
cd sistema_agencia
cp .env.example .env        # edita las contraseñas
docker compose up --build -d
```

La base de datos se crea sola al primer arranque con el esquema de `base-datos/tablas/`.

| Servicio | URL |
|---|---|
| App vía Nginx | http://localhost:8082 |
| App directa (Apache) | http://localhost:8080 |

## 🔐 Variables de entorno

| Variable | Descripción |
|---|---|
| `MYSQL_HOST` | Host de MySQL (`db` dentro de Docker) |
| `MYSQL_DATABASE` | Nombre de la base de datos |
| `MYSQL_USER` | Usuario de la aplicación |
| `MYSQL_PASSWORD` | Contraseña del usuario |
| `MYSQL_ROOT_PASSWORD` | Contraseña de root de MySQL |

## 👤 Autor

**Angel Uriel Domínguez Medina** · [GitHub](https://github.com/urieldomingezm) · [Portafolio](https://cv-uriel-nine.vercel.app/)

## 📄 Licencia

Distribuido bajo la licencia MIT. Consulta [LICENSE](LICENSE).
