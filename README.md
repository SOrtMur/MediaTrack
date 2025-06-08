# MediaTrack

MediaTrack es una aplicación que permite a los usuarios registrarse y gestionar sus medios favoritos. Los usuarios pueden almacenar información sobre películas, anime, manga y juegos, así como crear y organizar listas de seguimiento personalizadas para cada tipo de contenido.

- Registro y autenticación de usuarios.
- Almacenamiento y gestión de películas, anime, manga y juegos.
- Creación de listas de seguimiento para organizar tus medios.
- Interfaz intuitiva y fácil de usar.

¡Lleva el control de todo lo que ves, lees y juegas con MediaTrack! 


# Información básica

En aplicación existen 3 roles diferentes: admin, gestor de contenido y usuario.

- El admin puede crear, borrar y consultar datos basicos de usuarios, además de poder ver el contenido subido por usuarios. También puede asignar distintos roles.
- El gestor de contenido se encarga de supervisar el contenido, de forma que si hay algún contenido que no cumple las politicas puede eliminarlo.
- El usuario, y el resto de roles, puede crear el contenido especificado arriba, entrar y cambiar su información de usuario.

# Requisitos
- Como requisito base se necesita tener instalado docker. Puedes aprender a instalarlo aquí: https://docs.docker.com/engine/install/
- Debes estar registrado en TMDB para poder usar 2 funcionalidades de la aplicación.
- Debes tener instalado un gestor de versiones, como git.

# Instalación

La instalación se realiza a través de un contenedor Sail, un entorno sobre el que se ejecuta Laravel. Esto junto a docker compose crea el entorno de ejecución de MediaTrack.

Pasos de instalación.

1. Abrir una terminal de git y hacer git clone https://github.com/SOrtMur/MediaTrack.git
2. En la terminal, acceder al directorio de la aplicación.
3. Instalar las dependencias usando docker, para eso debemos ejecutar el siguiente comando: 
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```
4. Debes crear el archivo de variables de entorno .env.
   ```
    cp .env.example .env
   ```
4. 1. Cambiar la información necesaria en .env con respecto a la base de datos.
   ``
    - DB_CONNECTION=mysql
    - DB_HOST=mysql
    - DB_PORT=3306
    - DB_DATABASE=laravel
    - DB_USERNAME=sail
    - DB_PASSWORD=password
   ``
   
5. Levanta los contenedores con Sail usando este comando en la terminal.
```
./sail up -d
```

1. Una vez instaladas las dependencias, necesitarás generar la clave de la aplicación. Este paso se realiza después de iniciar Sail:
```
./sail artisan key:generate
```

1. Realiza las migraciones, lo cual hace que se cree toda la base de datos de forma automatica.
```
./sail artisan migrate
```

Hecho esto, ya puedes utilizar la aplicación accediendo a http://localhost

# Muy importante

La busqueda en TMDB requiere de una clave de acceso a la API. Debes introducir esta clave en tu fichero .env, junto con la ruta base de la API de esta forma.
```
TMDB_API_KEY=*Tu clave*
TMDB_ENDPOINT=https://api.themoviedb.org/3/
```

Al hacer la migración de la base de datos, se crea automáticamente un usuario administrador. Te dejo las credenciales de acceso por defecto.
```
email: admin@example.com
contraseña: password
```

Aseguraté de entrar en el perfil y cambiar la contraseña a una más segura.
**Gracias por descargar la aplicación, espero que te sea util**