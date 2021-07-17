#Directorio modelo para clonado en otros subdominios
#
#Instrucciones
#
#   1   Crear un Subdominio y hacer que el directorio raíz apunte a: subdominio.nmspanama.com/public
#   2   Crear una base de datos para dicho subdominio
#   2.3 Clonar la base de datos modelo_demo_xx a la nueva base de datos
#   3   Con el administrador de archivos copiar el archivo comprimido nmspanama.com.xx.zip en el folder del subdominio
#   4   una vez copiado, descomprimirlo y editar el archivo .env 
#   4.1 En el archivo .env cambiar APP_NAME y APP_SHORT que son el nombre de la tienda y el nombre que tendrá la aplicacion instalada en el teléfono
#   4.2 En el apartado de base de datos poner la información de conexion: nombre de base de datos, usuario, contraseña (y de ser necesario la direccion del host)
#   5 En el apartado de SMTP (y de ser necesario) cambiar la configuración establecida para el envío de correos electrónicos
#   Configurar la tienda con el acceso de administrador y listo
####################################################################
#
#   Acceso de administrador:
#   usuario por defecto: admin@demo.com
#   contraseña por defecto: 123456789
#
#   Para que el PWA funcione correctamente el navegador debe estar actualizado
#   a su última versión y tener instalado en el dominio o subdominio un certificado SSL