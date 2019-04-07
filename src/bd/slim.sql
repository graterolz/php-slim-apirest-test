-- usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
	`idusu` int(10) AUTO_INCREMENT NOT NULL,
	`idrol` varchar(4) NOT NULL,
	`user` varchar(50) NOT NULL,
	`pass` varchar(50) NOT NULL,
	`fecha_registro` datetime NOT NULL,
	`fecha_edicion` datetime NOT NULL,
	`estado_registro` int(1) NOT NULL,
	PRIMARY KEY (`idusu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `usuario`
(`idusu`,`idrol`,`user`,`pass`,`fecha_registro`,`fecha_edicion`,`estado_registro`) VALUES
(NULL,'ADM','admin','admin',NOW(),NOW(),1),
(NULL,'COOR','user1','user1',NOW(),NOW(),1),
(NULL,'VEND','user2','user2',NOW(),NOW(),1),
(NULL,'DESP','user3','user3',NOW(),NOW(),1);