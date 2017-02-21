INSERT  INTO `asistencia_evento`(`id`,`evento_id`,`persona_id`,`fecha_creacion`,`asistio`,`estado`,`usuario_id`,`fecha_modificacion`,`anio`) VALUES (1,3,1,'2017-02-20 08:33:12',1,1,1,'2017-02-20 08:33:12','2017'),(2,4,1,'2017-02-21 13:24:44',1,1,1,'2017-02-21 13:24:54','2017');
INSERT  INTO `cargo`(`id`,`nombre`,`descripcion`,`estado`) VALUES (1,'Morador',NULL,1),(2,'Dirigente',NULL,1);
INSERT  INTO `control_acceso`(`id`,`usuario_id`,`fecha_acceso`,`ip`,`anio`) VALUES (8,1,'2017-02-20 18:04:56','200.200.200.200','2017'),(9,1,'2017-02-21 12:37:46','200.200.200.200','2017');
INSERT  INTO `menu`(`id`,`nombre`,`padre`,`enlace`,`css_icono`,`estado`,`nivel`,`tiene_hijo`) VALUES (1,'Evento',0,'mibarrio/web/app_dev.php/evento','fa-calendar',1,0,0),(2,'Registrar Asistencia',0,'mibarrio/web/app_dev.php/asistenciaevento','fa-laptop',1,0,0);
INSERT  INTO `menu_x_rol`(`id`,`rol_id`,`menu_id`,`condicion`,`fecha_creacion`) VALUES (1,1,1,1,'2017-02-21 12:48:19'),(2,1,2,1,'2017-02-21 12:48:28');
INSERT  INTO `persona`(`id`,`lote_id`,`cargo_id`,`dni`,`nombre`,`apellido_paterno`,`apellido_materno`,`estado_civil`,`es_dirigente`,`numero`,`anio`) VALUES (1,1,1,'45678963','Richard','Checnes','Quispe','Soltero',0,4,'2017');
INSERT  INTO `rol`(`id`,`nombre`,`condicion`) VALUES (1,'ROLE_ADMIN',1),(2,'ROLE_ASOC_ADMIN',1),(3,'ROLE_ASOC_TESORERIA',1),(4,'ROLE_ASOC_SECRETARIO',1);
INSERT  INTO `tipo_actividad`(`id`,`nombre`,`descripcion`,`estado`) VALUES (1,'Reunion','ff',1),(2,'Faena','gg',1);
INSERT  INTO `usuario`(`id`,`rol_id`,`persona_id`,`usuario`,`password`,`salt`,`fecha_creacion`,`ultimo_acceso`,`condicion`,`anio`) VALUES (1,1,1,'rchecnes','123456','e10adc3949ba59abbe56e057f20f883e','2017-02-20 08:26:53','2017-02-20 08:26:56',1,'2017');
