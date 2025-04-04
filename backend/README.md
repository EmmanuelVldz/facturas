# Pasos para hacer funcionar el Backend

## Requisitos

- PHP >= 8.2
- Composer

## Instalación y Configuración

### 1. Clonar el repositorio

Primero, clona el repositorio en tu máquina local:

`git clone https://github.com/EmmanuelVldz/facturas.git`

`cd facturas/backend` 

### 2. Instalar dependencias

Ejuta el siguiente comando para instalar todas las dependencias de PHP que requiere el proyecto:

**composer install**

### 3. Configurar las variables de entorno

Copia el archivo contenido del archivo `.env.example` a `.env` para crear el archivo de configuración de variables de entorno:

**cp .env.example .env**

Luego, edita el archivo `.env` y completa las siguientes variables de entorno con los valores correspondientes:

- `FACTURA_API_URL` = La URL sandbox de la API de factura.com.
- `FACTURA_API_KEY` = La clave de API que te proporciona el servicio de facturación.
- `FACTURA_SECRET_KEY` = La clave secreta para autenticarte en el servicio de facturación.
- `FACTURA_PLUGIN` = Este valor venia en la documentacion de la API de factura.com.

### 4. Generar la clave de la aplicación

Para generar la clave de la aplicación, ejecuta el siguiente comando:

php artisan key:generate

### 5. Levantar el servidor de desarrollo

Por último, levanta el servidor de desarrollo utilizando el siguiente comando:

**php artisan serve**

Esto iniciará el servidor en `http://localhost:8000` por defecto.
