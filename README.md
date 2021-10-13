# agenda-php
Simple aplicación CRUD hecha en PHP y MySQL para gestionar contactos, usando la técnica AJAX.

## Requisitos
- PHP
- MySQL
- Composer.

## Base de datos
Para crear la base de datos ejecuta los scripts del archivo [database.sql](https://github.com/enzogsierra/agenda-php/blob/main/database.sql)

## Iniciar el proyecto
Si abriste el proyecto en VS Code, abre la terminal (CTRL + N) y escribe lo siguiente
```
cd public
```
Esto moverá la terminal a la carpeta "/public" del projecto.<br>

```
php -S localhost:3000
```
Esto iniciará el servidor PHP en <http://localhost:3000/>. El puerto puede ser cualquiera, "3000" en este caso.<br>
Si abres el proyecto en una terminal independiente, recuerda que el servidor PHP siempre tiene que iniciar desde la carpeta "/public", que es donde está el archivo index.php
