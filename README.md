# Sistema de Gestión de Agencia

Este proyecto es un sistema de gestión web diseñado para una agencia, permitiendo la administración de usuarios, tiempos, ascensos, ventas y requisitos semanales.

## Tecnologías y Herramientas Utilizadas

*   **Backend:** PHP
*   **Base de Datos:** MySQL
*   **Frontend:** HTML, CSS, JavaScript
*   **Framework CSS:** Bootstrap
*   **Validación de Formularios:** JustValidate (visto en `index_registro.js`)
*   **Alertas/Notificaciones:** SweetAlert2 (visto en `VTM.php`, `index_registro.js`)
*   **Tablas Dinámicas:** simple-datatables (visto en `VTM.php`)
*   **Contenedores:** Docker, Docker Compose
*   **Servidor Web:** Apache (configurado en `Dockerfile`)
*   **Proxy Inverso/Servidor Web Adicional:** Nginx (configurado en `nginx.conf` y `docker-compose.yml`)
*   **Control de Versiones:** Git (implícito por la estructura de GitHub)

## Estructura del Proyecto

La estructura del proyecto sigue una organización lógica para separar la lógica de negocio, la presentación y los recursos públicos:

*   `base-datos/`: Contiene el script SQL para la base de datos.
*   `config.php`: Archivo de configuración principal.
*   `docker-compose.yml`: Configuración para Docker Compose, definiendo los servicios (web, db, phpmyadmin, nginx).
*   `Dockerfile`: Define la imagen de Docker para el servicio web (PHP con Apache).
*   `nginx.conf`: Configuración para el servidor Nginx.
*   `private/`: Contiene archivos sensibles y lógica de negocio.
    *   `conexion/`: Archivos de conexión a la base de datos (`bd.php`).
    *   `menus/`: Archivos para diferentes menús de navegación según el rango.
    *   `modal/`: Archivos para modales (gestión de ventas, ascensos, tiempos, etc.).
    *   `plantilla/`: Archivos de plantilla (header, footer, home).
    *   `procesos/`: Scripts PHP para manejar la lógica de las diferentes funcionalidades (gestión de tiempos, ascensos, usuarios, ventas, etc.).
    *   `radio/`: Archivos relacionados con la radio (?).
*   `public/`: Contiene archivos accesibles públicamente.
    *   `assets/`: Recursos estáticos (CSS, JS, imágenes).
        *   `custom_general/`: Estilos y scripts personalizados.
        *   `framework/`: Frameworks como Bootstrap.
        *   `img/`: Imágenes generales.
*   `usuario/`: Archivos relacionados con la interfaz y lógica del usuario.
    *   Archivos PHP para diferentes secciones del usuario (`USR.php`, `VTM.php`, `GSTM.php`, etc.).
    *   `rangos/`: Archivos específicos para cada rango de usuario, incluyendo sus requisitos y pagas.
*   Archivos raíz como `index.php`, `login.php`, `registrar.php`, `rangos.php`.

## Configuración e Instalación (Usando Docker Compose)

1.  Clona este repositorio.
2.  Asegúrate de tener Docker y Docker Compose instalados en tu sistema.
3.  Navega hasta el directorio raíz del proyecto en tu terminal.
4.  Ejecuta el siguiente comando para construir las imágenes y levantar los contenedores:
    ```bash
    docker-compose up --build -d
    ```
5.  Importa la base de datos. Puedes usar phpMyAdmin (accesible en `http://localhost:8081` por defecto) o el cliente MySQL. El archivo SQL se encuentra en `base-datos/sistema_agencia (4).sql`. Los detalles de conexión están en `docker-compose.yml`.
6.  El sistema web debería estar accesible en `http://localhost:8082` (configurado por Nginx) o `http://localhost:8080` (directamente desde el contenedor web).

## Uso

*   Accede al sistema a través de la URL configurada (por defecto `http://localhost:8082`).
*   Regístrate como nuevo usuario o inicia sesión si ya tienes una cuenta.
*   Explora las diferentes secciones según tu rango (perfil, gestión de tiempos, gestión de ventas, etc.).

## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.
