create table ciclo(
	id serial,
	nombre text,
	estado character default 'N',
	constraint pk_ciclo primary key (id)
);

create table universidad(
	id serial,
	nombre text,
	estado character default 'N',
	constraint pk_universidad primary key (id)
);

create table carrera(
	id serial,
	nombre text,
	estado character default 'N',
	constraint pk_carrera primary key (id)
);

create table menu(
	id serial,
	nombre text,
	estado character default 'N',
	orden integer,
	link text,
	constraint pk_menu primary key (id)
);

create table tipo(
	id serial,
	nombre text,
	estado character default 'N',
	constraint pk_tipo primary key (id)
);

create table permiso(
	id serial,
	id_tipo integer,
	id_menu integer,
	estado character default 'N',
	constraint pk_permiso primary key (id)
);

create table sede(
	id serial,
	nombre text,
	direccion text,
	telefono text,
	correo text,
	estado character default 'N',
	constraint pk_sede primary key (id)
);

create table cuenta(
	id serial,
	nombre text,
	numero text,
	estado character default 'N',
	constraint pk_cuenta primary key (id)
);

create table contenido(
	id serial,
	nombre text,
	valor text,
	tipo text,
	constraint pk_contenido primary key (id)
);

create table usuario(
	id serial,
	nombres text,
	apellidos text,
	correo text,
	password text,
	celular text,
	ciudad text,
	id_sede integer,
	id_tipo integer,
	id_ciclo integer,
	id_universidad integer,
	id_carrera integer,
	estado character default 'N',
	constraint pk_usuario primary key (id)
);

create table proyecto(
	id serial,
	nombre text,
	tipo character,
	estado character,
	id_usuario integer,
	constraint pk_proyecto primary key (id)
);

create table mensaje(
	id serial,
	titulo text,
	contenido text,
	fecha timestamp without time zone default now(),
	id_proyecto integer,
	id_usuario integer,
	constraint pk_mensaje primary key (id)
);

create table archivo(
	id serial,
	nombre text,
	extension text,
	id_mensaje integer,
	peso numeric,
	estado character default 'N',
	constraint pk_archivo primary key (id)
);

create table pago(
	id serial,
	monto1 numeric,
	monto2 numeric,
	fecha1 timestamp without time zone,
	fecha2 timestamp without time zone,
	estado character,
	id_cuenta integer,
	constraint pk_pago primary key (id)
);

insert into menu (nombre) values ('Cuentas Bancarias'),('Ciclos'),('Universidades'),('Carreras'),('Pagos'),('Usuarios'),('Tipos de Usuario'),('Permisos'),('Proyectos'),('Sedes'),('Mensajes'),('Archivos'),('Contenido');