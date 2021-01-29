## Descripción

API de Dreamit para el control de acceso de personas en edificios.

## Instalación

	git clone https://github.com/benjaminarteaga/dreamit-api.git
	cd dreamit-api
	cp .env.example .env
	composer install

## Configuración

Dentro del archivo `.env` cambiar los valores de las siguientes variables:

	DB_HOST=(URL Host DB)
	DB_USERNAME=(USER DB)
	DB_PASSWORD=(PASSWORD DB)

## Disponibilizar

En la raíz del proyecto ejecutar el siguiente comando para levantar el server:

	php artisan serve

## Documentación API

Se puede visualizar la documentación de la API en la siguiete URL:

[http://localhost:8000/docs](http://localhost:8000/docs)

O tambien en la URL en que se disponibilice la aplicación, tomar en cuenta el endpoint `/docs`

## Testing

Para correr los test:

	php artisan test

## Postman Collection

Para probar los endpoints desde la API, se puede usar esta colección (importarla como Link):

[https://www.getpostman.com/collections/09eb4f3818261fb3ff75](https://www.getpostman.com/collections/09eb4f3818261fb3ff75)

## Refrescar datos de la BD (opcional)

Si se desean volver al punto inicial de la BD, correr el siguiente comando:

	php artisan migrate:fresh --seed