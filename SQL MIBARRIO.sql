SELECT * FROM `cargo`
SELECT * FROM lote
SELECT * FROM `rol`
SELECT * FROM lote
SELECT * FROM `tipo_actividad`
SELECT * FROM persona
SELECT * FROM usuario
SELECT * FROM menu

INSERT  INTO `menu`(`nombre`,`padre`,`nivel`,`enlace`,`css_icono`,`estado`,`tiene_hijo`) VALUES
('Evento',0,0,'evento','fa-calendar',1,0),(2,'Cargo',0,0,'cargo','fa-calendar',1,0),
('Tipo de Actividad',0,0,'tipoactividad','fa-calendar',1,0),
('Lote',0,0,'lote','fa-calendar',1,0),
('Rol',0,0,'rol','fa-calendar',1,0),
('Persona',0,0,'persona','fa-calendar',1,0),
('Asistencia Evento',0,0,'asistenciaevento','fa-pencil-square-o',1,0),
('Menú',0,0,'menu','fa-pencil-square-o',1,0),
('Menú Por Rol',0,0,'menuxrol','fa-pencil-square-o',1,0);