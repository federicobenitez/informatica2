CREATE DATABASE IF NOT EXISTS sistema_cargas;
USE sistema_cargas;	

CREATE TABLE usuarios(
	id 		int(255) auto_increment not null,
	role		varchar(20),
	nombre		varchar(180),
	apellido 	varchar(255),
	email		varchar(255),
	password 	varchar(255),
	created_at      datetime,
	CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE tareas(
	id 		int(255) auto_increment not null,
	usuario_id	int(255) not null,
	n_registro	varchar(255),
	solicitante	varchar(255),
	s_reparacion	varchar(255),
	s_redes		varchar(255),
	s_telefonico	varchar(255),
	s_asesoramiento	text,
	marca		varchar(255),
	modelo		varchar(255),
	n_inventario	varchar(255),
	rrev_tecnica	text,
	falla_hard	varchar(255),
	falla_soft      varchar(255),
	recomendaciones	varchar(255),
	destino         varchar(255),
	fecha_dest      varchar(255),
	hora_dest       varchar(255),
	motivo		text,
	fallas_det      text,
	medidas_tom     text,
	created_at  datetime,
	updated_at  datetime,
	CONSTRAINT pk_tarea PRIMARY KEY(id),
	CONSTRAINT fk_tarea_usuarios FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
)ENGINE=InnoDb;
