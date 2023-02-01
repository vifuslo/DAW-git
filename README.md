# **PHPDocumentator**

*PhpDocumentor* es un generador de documentación de código abierto escrito en PHP. Automáticamente analiza el código fuente PHP y produce la API de lectura y genera la documentación en base al estándar formal PHPDoc, además es capaz de crear documentos HTML, PDF, CHM y formatos Docbook. Se puede utilizar desde la línea de comandos o mediante una interfaz web. 

Tiene soporte para:
* La vinculación entre la documentación.
* La incorporación de documentos a nivel de usuario, como tutoriales.
* La creación de código fuente resaltado con referencias cruzadas a la documentación en general de PHP. 

### **Definición de la documentación**

*PhpDocumentor* proporciona un conjunto de etiquetas que se pueden incluir en los comentarios de nuestro código fuente, que ayudan a la correcta comprensión por parte de otros programadores de que se quiere realizar.
Los elementos susceptibles de ser documentados obedecen a la siguiente lista:
* Sentencias define [_once].
* Sentencias include [_once].
* Funciones.
* Clases.
* Métodos y atributos.
* Variables globales.

---

## **Instalación**

[Guía de instalación de la web oficial](https://docs.phpdoc.org/guide/getting-started/installing.html)

### Instalación PHP
Para poder utilizar *PHPDocumentator* hace falta tener instalado los paquetes de softwaree PHP 7.4.0 o más y su extension mbstring.

Abrimos la terminal y escribimos los siguientes comandos.

>`apt install php-cli`

>`apt install php8.1-mbstring`

### Instalación Apache
Para utilizar PHPDocumentator desde la interfaz web, deberemos instalar el servidor Apache.

Abrimos la terminal y escribimos los siguientes comandos.

>`apt-get update`

>`apt-get install apache2`

Para arrancar el servicio.

>`service apache2 start`

Y comprobar su estado.

>`service apache2 status`

Las aplicaciones las colocaremos en el directorio que tiene Apache por defecto. La ruta es: /var/www/html  

---

## **Generar la documentación**

Lo primero es descargar el archivo phpDocumentator.phar del siguiente enlace: https://phpdoc.org/phpDocumentor.phar

Y lo colocamos en la carpeta del proyecto que vamos a utilizar.

Para crear la documentación de este proyecto, debemos ejecutar el siguiente comando:

>`php phpDocumentor.phar -d [carpeta_proyecto_php] -t [carpeta_volcado_documentacion]`

Por ejemplo:

>`php phpDocumentor.phar -d ./ejercici/ -t docs/`
