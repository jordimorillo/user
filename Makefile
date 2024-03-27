SHELL := /usr/bin/bash

# Nuevo comando para lanzar el archivo PHP
install-structure:
	@echo "Executing install-database.php inside Docker container..."
	@docker exec -it user-app-1 make install-structure
	@echo "Command executed successfully in container."

.PHONY: load-db install-structure