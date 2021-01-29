## Descripción

API de Dreamit para el control de acceso de personas en edificios.

## Instalación

	git clone https://github.com/benjaminarteaga/dreamit-api.git
	cd dreamit-api
	cp .env-example .env
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

	http://localhost:8000/docs