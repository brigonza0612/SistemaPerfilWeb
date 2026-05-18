# SistemaPerfilWeb

## Descripción
Este es un sistema web desarrollado en PHP y MySQL que permite registrar usuarios, iniciar sesión, ver un perfil privado, actualizar datos personales, cambiar contraseña y cerrar sesión de forma segura.

## Funcionalidades
- Registro de usuarios
- Inicio de sesión con validación
- Uso de sesiones para proteger el perfil
- Actualización de datos personales
- Cambio de contraseña con verificación
- Cierre de sesión seguro

## Requisitos
- PHP
- MySQL
- XAMPP
- Navegador web

## Pasos para instalar y probar localmente.
1. Descargar el repositorio:
   https://github.com/
   
3. Copiar la carpeta del proyecto dentro de:
   C:\xampp\htdocs\
   
5. Iniciar los servicios en XAMPP:
- Activar Apache
- Activar MySQL

4. Crear la base de datos:
- Abrir phpMyAdmin
- Crear base de datos llamada: SistemaPerfilWeb
- Importar el archivo .sql si está disponible

5. Configurar la conexión a la base de datos:
- Abrir el archivo conexion.php
- Verificar:
  - host
  - usuario
  - contraseña
  - nombre de la base de datos

6. Ejecutar el sistema en el navegador:
   http://localhost/SistemaPerfilWeb/login.php
   
8. Usar el sistema:
- Registrarse
- Iniciar sesión
- Acceder al perfil
- Actualizar datos
- Cambiar contraseña
- Cerrar sesión
