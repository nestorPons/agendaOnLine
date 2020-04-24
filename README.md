# agendaOnLine
Agenda onLine para Pymes del sector servicios. 
Pequeña agenda online para la reserva de citas, control de servios y usuarios.
Zona administrador y zona usuarios para que los propios clientes se puedan coger sus citas y quitar carga de trabajo a las pequeñas empresas que no puedan costearse una recepcionista.

## Instalación
1. Clonar el repositorio 
  * git clone https://github.com/nestorPons/agendaOnLine.git
2. Editar el arcivo de configuración a la base de datos:
  * app/core/BaseClass.php
Añadir nombre de la base de datos y logo en archivo configuración:
  * app/conf/config.php
Añadir datos de cuenta email en: 
  * app/conf/mail.php

## Iniciar
1. Acceda al directorio .server
2. Inicia el contenedor docker
  * sudo docker-compose up -d
3. Cree con phpmyadmin su base de datos en:
  * localhost:8080.server
4. Acceda a su aplicación:.server
  * localhost/agenda


