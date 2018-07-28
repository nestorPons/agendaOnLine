SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 1;
SET time_zone = "+00:00";

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `pass`, `tel`, `admin`, `obs`, `idioma`, `dateReg`, `dateBaja`, `status`, `attempts`, `pin`) VALUES
(1, 'Demo', 'demo@demo.es', '$2y$10$x0M3DWJjixt65tjPDBODMeWlPK3ETzBxvrWgeQPieTkth0uSW9jNm', '123456789', 2, 'Usuario administrador', 1, '2018-02-04 15:01:40', NULL, 0, 0, NULL),
(2, 'Admin', 'admin@admin.es', '$2y$10$x0M3DWJjixt65tjPDBODMeWlPK3ETzBxvrWgeQPieTkth0uSW9jNm', '123456789', 1, 'Usuario administrador', 1, '2018-02-10 16:21:13', NULL, 0, 0, NULL),
(3, 'Usuario', 'usuario@usuario.es', '', '123456789', 0, 'Usuario general', 1, '2018-02-10 16:21:13', NULL, 0, 0, NULL);

INSERT INTO `agendas` (`id`, `nombre`, `mostrar`) 
    VALUES (0, 'Principal', 1), (1, 'Secundaria', 1);

INSERT INTO `familias` (`id`, `nombre`, `mostrar`, `baja`) 
    VALUES (0, 'Familia demo', 1, 0);

INSERT INTO `horarios` (`agenda`, `dia_inicio`, `dia_fin`, `hora_inicio`, `hora_fin`) 
    VALUES
    (0, 1, 5, '09:00:00', '20:00:00'),
    (0, 6, 6, '09:00:00', '14:00:00'),
    (1, 1, 5, '10:00:00', '20:00:00'),  
    (1, 6, 6, '10:00:00', '14:00:00'); 

INSERT INTO `config`(`idEmpresa`) VALUES (1); 
INSERT INTO `config_css` VALUES (); 

INSERT INTO `servicios` (`id`, `codigo`, `descripcion`, `precio`, `tiempo`, `idFamilia`, `baja`) VALUES
(0, 'COD001', 'Servicio de prueba', 0, 10, 0, 0),(1, 'COD002', 'Servicio de prueba dos', 0, 30, 0, 0);

INSERT INTO `data` (`id`, `agenda`, `idUsuario`, `fecha`, `hora`, `obs`, `usuarioCogeCita`, `tiempo_servicios`) VALUES
(0, 1, 1, CURRENT_TIMESTAMP, '14:45:00', '', 1, 10),
(1, 1, 2, CURRENT_TIMESTAMP, '11:00:00', '', 2, 30);

INSERT INTO `cita` (`idCita`,`servicio`) 
VALUES (0,0), (1,1);

INSERT INTO `festivos` (`nombre`, `fecha`) 
VALUES ('Año nuevo', '1970-01-01'), ('Reyes', '1970-01-06'), ('Noche vieja', '1970-12-31');