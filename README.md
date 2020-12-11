# laminas-mvc-skeleton Publicación de Artículos

## Introduction

Es un proyecto demo de evaluación.

## Instalación

Primero clonar el proyecto en su máquina local con el siguiente comando
```bash
$ git clone https://github.com/alfonso1010/articulos.git
```
Clonado el proyecto dirigirse a la carpeta del mismo:
```bash
$ cd articulos
```
Dentro del proyecto ejecutar el comando:
```bash
$ composer update
```
Procedemos a importar la base de datos, el scrpit sql se encuentra en la carpeta db con el nombre: ecommerce.sql, asegurese de que en su gestor de base de datos exista la tabla ecommerce, de lo contrario hay que crearla 
```bash
$ mysql -u <username> -p ecommerce < db/ecommerce.sql
```
Una vez que se tiene la base de datos importada, procedemos a configurar el usuario y password de mysql en el proyecto Lamminas para un correcto CRUD,
dirigirse al archivo /articulos/config/autoload/development.local.php.dist y renonmbrarlo, quitando el .dist de tal forma que el archivo tenga 
el nombre: /articulos/config/autoload/development.local.php, realizado este paso editar el archivo y poner nuestro usuario y password de mysql en las lineas
```bash
'db' => [
    	'username' => 'root',  # change this to match your database's username 
    	'password' => 'root'       # change this to match your database's password
    ]
```
Posteriormente ejecutar el comando:
```bash
$ composer serve
```
Listo ahora podrá ver el proyecto ingresando a la url:
http://localhost:8080/



