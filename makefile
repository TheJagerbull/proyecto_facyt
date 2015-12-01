#makefile
Permisos:
	sudo chmod -R 0755 assets/up
	ps -ef | grep apache
	sudo chown www-data:www-data /var/www/proyecto_facyt/uploads
	sudo chmod 755 /var/www/proyecto_facyt/uploads
