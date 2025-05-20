## 🚀 Sistema de Gestión de Agencia

Este proyecto es un **sistema de gestión web** diseñado para una agencia, que permite administrar:
👤 Usuarios | ⏱️ Tiempos | 📈 Ascensos | 💰 Ventas | 📋 Requisitos semanales

## 🛠️ Tecnologías y Herramientas Utilizadas

* 🔧 **Backend:** PHP
* 🗄️ **Base de Datos:** MySQL
* 🎨 **Frontend:** HTML, CSS, JavaScript
* 🎯 **Framework CSS:** Bootstrap
* ✅ **Validación de Formularios:** JustValidate (`index_registro.js`)
* 🛎️ **Alertas/Notificaciones:** SweetAlert2 (`VTM.php`, `index_registro.js`)
* 📊 **Tablas Dinámicas:** simple-datatables (`VTM.php`)
* 🐳 **Contenedores:** Docker, Docker Compose
* 🌐 **Servidor Web:** Apache (`Dockerfile`)
* 🔁 **Proxy Inverso / Servidor Adicional:** Nginx (`nginx.conf`, `docker-compose.yml`)
* 📁 **Control de Versiones:** Git (estructura en GitHub)

## 🗂️ Estructura del Proyecto

```
📁 base-datos/
  └── Script SQL de la base de datos
📄 config.php
📄 docker-compose.yml
📄 Dockerfile
📄 nginx.conf

📁 private/
├── conexion/          → Conexión BD (`bd.php`)
├── menus/             → Menús según rango
├── modal/             → Modales de ventas, tiempos, ascensos
├── plantilla/         → Header, Footer, Home
├── procesos/          → Scripts de lógica PHP
└── radio/             → Archivos de radio (en desarrollo)

📁 public/
└── assets/
    ├── custom_general/ → Estilos y scripts personalizados
    ├── framework/      → Bootstrap y otros frameworks
    └── img/            → Imágenes generales

📁 usuario/
├── Archivos por sección (`USR.php`, `VTM.php`, etc.)
└── rangos/             → Requisitos y pagos por rango

📄 index.php | login.php | registrar.php | rangos.php
```

## ⚙️ Configuración e Instalación (con Docker Compose)

1. Clona el repositorio:

   ```bash
   git clone https://github.com/tu-usuario/sistema-agencia.git
   ```
2. Asegúrate de tener **Docker** y **Docker Compose** instalados.
3. Navega al directorio del proyecto:

   ```bash
   cd sistema-agencia
   ```
4. Ejecuta:

   ```bash
   docker-compose up --build -d
   ```
5. Importa la base de datos desde `base-datos/sistema_agencia (4).sql` usando **phpMyAdmin** (`http://localhost:8081`) o el cliente MySQL.
6. Accede al sistema:

   * `http://localhost:8082` (via Nginx)
   * `http://localhost:8080` (directo por Apache)

## 🧭 Uso

1. Accede a la URL del sistema
2. Regístrate o inicia sesión
3. Navega por las secciones habilitadas según tu rango:

   * 📄 Perfil
   * ⏱️ Gestión de tiempos
   * 💼 Gestión de ventas
   * 🧍 Gestión de ascensos

## 📄 Licencia

Este proyecto está bajo la **Licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más detalles.
