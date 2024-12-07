# Club Deportivo API -- Sandra Montero Sanz

Este proyecto es una API para gestionar un sistema de reservas en un club deportivo. Incluye funcionalidades para usuarios, deportes, pistas, socios y reservas.

---

## **Requisitos previos**

Componentes con los que se ha realizado:

- PHP = 8.2.12
- Composer
- MySQL 
- Laravel 11.34.2
- Servidor web como Apache o Nginx

---

## **Configuración inicial**

1. **Clona el repositorio:**

   git clone https://github.com/saandys/clubDeportivoAPI.git
   cd clubDeportivoAPI

2. **Instalar dependencias de PHP:**
    composer install

3. **Crear archivo .env desde .env.example y configurar las variables de entorno:**
    cp .env.example .env

    ## Configuración BD
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=club_deportivo
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña

    ## Configuración de sanctum
      SANCTUM_STATEFUL_DOMAINS=localhost

    ## Generar clave de aplicación
      php artisan key:generate


4. **Ejecutar migraciones y seeders**
    php artisan migrate
    php artisan db:seed

5. **Ejecutar el proyecto**
    php artisan serve

6. **Acceder al proyecto**
    http://127.0.0.1:8000

## Otras opciones

1. **Generar la documentación de Swagger**
    php artisan l5-swagger:generate

1. **Acceder a la documentación**
    Ir a a la URL: http://127.0.0.1:8000/api/documentation#/
    y poner: http://127.0.0.1:8000/docs/api-docs.json


## ** Anotaciones **
   -  Se utiliza Sanctum para la autenticación por lo que para todas las rutas
        a excepción de register y user, se necesitará añadir al header el token 
        originado al hacer login.
   - También hay que tener en cuenta que se utiliza versionado de API por lo
       que para acceder a las rutas habrá que poner api/v1/

## ** Comandos útiles **

1. **Reiniciar base de datos y seeders**
    php artisan migrate:fresh --seed


1. **Ver rutas disponibles**
    php artisan route:list

