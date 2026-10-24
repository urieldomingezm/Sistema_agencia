-- Cambios de contraseña y autenticación de usuarios (basado en mysql.user)
ALTER USER 'root'@'%' IDENTIFIED WITH caching_sha2_password AS '$A$005$64("YCEo2pv=Nu^MO7WKh5h7ye1Kn4jU2fQI2MQs5QDcen01XabHqQTx.8';
ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password AS '$A$005$Gek"6`1o<0_h!
                                                                 YD<HDa6/6CdIvj5SWZF2.CNz0qmwv.VQSTzc3qLytRAKcE7';

ALTER USER 'admin_app'@'%' IDENTIFIED WITH caching_sha2_password AS 
'$A$005$!i\r%fw?\x1d'w 4Cxw\x05o\x08W\x01EhHCZY8/EMWjgC8u3xTseOzzNYkj/vueiMEmHOcgWay7';

ALTER USER 'agencia_user'@'%' IDENTIFIED WITH caching_sha2_password AS 
'$A$005\x083\x19S+\x0c3\x01\x17b\x1d6zAQ!JRI9poVly2d10FTP5XyPpIJUO3svwpRhqe9DPbJfGVFUD';

ALTER USER 'fundador_app'@'%' IDENTIFIED WITH caching_sha2_password AS 
'$A$005\'Sk\x03~S=8~s\x0f\t#qF\'6J6?FPCJ6VXoHjf0qA3WtIIxmrgO BZRTCaTs0YwZTDmtjR0';

ALTER USER 'manager_app'@'%' IDENTIFIED WITH caching_sha2_password AS 
'$A$005>bzh\x15h\t?>P\x16N\x16\x1c]}P\x02\n\x0c*hkv4s4eN9mJwpuotFrMVf4gaF3nvj8qESv6cmej77V5';

ALTER USER 'usuarios_basicos'@'%' IDENTIFIED WITH caching_sha2_password AS 
'$A$005a|\t]\\_2IB\x10?1d%d\x0f\x1ed!fGJqBcpG59OqJOblAI.G7aOihhxZooFlpTiBpavyepe4';


-- Privilegios para usuarios_basicos
GRANT USAGE ON *.* TO `usuarios_basicos`@`%`;
GRANT SELECT ON `sistema_agencia`.* TO `usuarios_basicos`@`%`;
GRANT SELECT, INSERT, UPDATE ON `sistema_agencia`.`ascensos` TO `usuarios_basicos`@`%`;
GRANT SELECT ON `sistema_agencia`.`auditoria_ascensos` TO `usuarios_basicos`@`%`;
GRANT SELECT ON `sistema_agencia`.`auditoria_passwords` TO `usuarios_basicos`@`%`;
GRANT SELECT ON `sistema_agencia`.`gestion_notificaciones` TO `usuarios_basicos`@`%`;
GRANT SELECT, INSERT, UPDATE ON `sistema_agencia`.`gestion_pagas` TO `usuarios_basicos`@`%`;
GRANT SELECT ON `sistema_agencia`.`gestion_quejas` TO `usuarios_basicos`@`%`;
GRANT SELECT ON `sistema_agencia`.`gestion_rangos` TO `usuarios_basicos`@`%`;
GRANT SELECT, INSERT, UPDATE ON `sistema_agencia`.`gestion_requisitos` TO `usuarios_basicos`@`%`;
GRANT SELECT, INSERT, UPDATE ON `sistema_agencia`.`gestion_tiempo` TO `usuarios_basicos`@`%`;
GRANT SELECT, INSERT, UPDATE ON `sistema_agencia`.`gestion_ventas` TO `usuarios_basicos`@`%`;
GRANT SELECT, UPDATE ON `sistema_agencia`.`historial_ascensos` TO `usuarios_basicos`@`%`;
GRANT SELECT, UPDATE ON `sistema_agencia`.`historial_tiempos` TO `usuarios_basicos`@`%`;
GRANT SELECT, UPDATE ON `sistema_agencia`.`permisos_tablas` TO `usuarios_basicos`@`%`;
GRANT SELECT, INSERT ON `sistema_agencia`.`registro_usuario` TO `usuarios_basicos`@`%`;
GRANT SELECT, UPDATE ON `sistema_agencia`.`roles` TO `usuarios_basicos`@`%`;

-- Privilegios para admin_app (Ejemplo, ajusta según sea necesario)
GRANT ALL PRIVILEGES ON `sistema_agencia`.* TO `admin_app`@`%`;

-- Privilegios para agencia_user
GRANT SELECT, INSERT, UPDATE ON `sistema_agencia`.* TO `agencia_user`@`%` WHERE `table_name` NOT IN ('auditoria_passwords', 'historial_ascensos', 'historial_tiempos');

-- Privilegios para fundador_app
GRANT SELECT, INSERT, UPDATE, DELETE ON `sistema_agencia`.* TO `fundador_app`@`%`;

-- Privilegios para manager_app
GRANT SELECT, UPDATE ON `sistema_agencia`.* TO `manager_app`@`%`;

-- Asegúrate de ejecutar FLUSH PRIVILEGES para aplicar cambios
FLUSH PRIVILEGES;
