create table marca(
	id serial,
	nombre text,
	abreviatura text,
	estado character default 'N',
	constraint pk_marca primary key (id)
);

create table tipo_equipo(
	id serial,
	nombre text,
	abreviatura text,
	estado character default 'N',
	constraint pk_tipo_equipo primary key (id)
);

create table modelo(
	id serial,
	nombre text,
	estado character default 'N',
	id_marca integer,
	id_tipo_equipo integer,
	constraint pk_modelo primary key (id)
);


create table departamento(
	id serial,
	nombre text,
	constraint pk_departamento primary key (id)
);

create table provincia(
	id serial,
	nombre text,
	id_departamento integer,
	constraint pk_provincia primary key (id)
);

create table distrito(
	id serial,
	nombre text,
	id_provincia integer,
	constraint pk_distrito primary key (id)
);

create table zona(
	id serial,
	nombre text,
	abreviatura text,
	estado character default 'N',
	constraint pk_zona primary key (id)
);

create table tipo_territorio(
	id serial,
	nombre text,
	estado character default 'N',
	constraint pk_tipo_territorio primary key(id)
);

create table tipo_sucursal(
	id serial,
	nombre text,
	estado character default 'N',
	constraint pk_tipo_sucursal primary key(id)
);

create table sucursal(
	id serial,
	nombre text,
	direccion text,
	tipo character,
	telefono1 text,
	telefono2 text,
	id_zona integer,
	id_distrito integer,
	id_tipo_territorio integer,
	id_tipo_sucursal integer,
	estado character default 'N',
	constraint pk_sucursal primary key (id)
);

create table area(
	id serial,
	nombre text,
	abreviatura text,
	estado character default 'N',
	constraint pk_tipo_area primary key (id)
);

create table area_sucursal(
	id serial,
	id_area integer,
	id_sucursal integer,
	estado character default 'N',
	constraint pk_area_sucursal primary key (id)
);


create table tipo_usuario(
	id serial,
	nombre text,
	estado character default 'N',
	constraint pk_tipo_usuario primary key(id)
);

create table usuario(
	id serial,
	nombre text,
	apellidos text,
	correo text,
	password text,
	conectado timestamp without time zone default now(),
	id_tipo_usuario integer,
	id_proveedor integer,
	estado character default 'N',
	constraint pk_usuario primary key(id)
);

create table grupo(
	id serial,
	nombre text,
	orden integer,
	estado character default 'N',
	constraint pk_grupo primary	key(id)
);

create table menu(
	id serial,
	nombre text,
	link text,
	orden integer,
	tipo character,
	id_grupo integer,
	estado character default 'N',
	constraint pk_menu primary key(id)
);

create table permiso(
	id serial,
	id_menu integer,
	id_tipo_usuario integer,
	estado character default 'N',
	constraint pk_permiso primary key(id)
);

create table pais(
	id serial,
	nombre text,
	abreviatura text,
	constraint pk_pais primary key (id)
);

create table proveedor(
	id serial,
	contacto text,
	razon text,
	tipo character,
	direccion text,
	fijo text,
	celular text,
	correo text,
	pagina text,
	ruc text,
	codigopostal text,
	permisotecnicos character,
	permisousuarios character,
	id_distrito integer,
	id_pais integer,
	estado character default 'N',
	constraint pk_proveedor primary key (id)
);

create table tecnico(
	id serial,
	nombre text,
	apellidos text,
	id_proveedor integer,
	estado character default 'N',
	constraint pk_tecnico primary key (id)
);

create table contrato(
	id serial,
	numero text,
	descripcion text,
	fecha date default now(),
	inicio date,
	fin date,
	id_usuario integer,
	id_proveedor integer,
	tipo character,
	estado character default 'N',
	constraint pk_contrato primary key (id)
);

create table detalle_contrato(
	id serial,
	cantidad integer,
	id_contrato integer,
	id_modelo integer,
	constraint pk_detalle_contrato primary key (id)
);

create table sla(
	id serial,
	horas integer,
	id_tipo_equipo integer,
	id_tipo_territorio integer,
	id_contrato integer,
	constraint pk_sla primary key (id)
);

create table guia(
	id serial,
	numero text,
	fecha date,
	comentario text,
	id_contrato integer,
	id_sucursal integer,
	constraint pk_guia primary key (id)
);

create table producto(
	id serial,
	serie text,
	estado character default 'N',
	id_detalle_contrato integer,
	id_modelo integer,
	id_sucursal integer,
	id_area_sucursal integer,
	id_guia integer,
	constraint unq_serie unique (serie),
	constraint pk_producto primary key (id)
);

create table tipo_caso(
	id serial,
	nombre text,
	modo integer,
	constraint pk_tipo_caso primary key(id)
);

create table tipo_solucion(
	id serial,
	nombre text,
	constraint pk_tipo_solucion primary key(id)
);

create table caso(
	id serial,
	numero text,
	problema text,
	fecha timestamp without time zone default now(),
	fechat timestamp without time zone,
	fechad timestamp without time zone,
	fechae timestamp without time zone,
	fechaf timestamp without time zone,
	usuario text,
	celular text,
	anexo text,
	correo text,
	analisis text,
	conclusion text,
	sla integer,
	id_producto integer,
	id_tipo_caso integer,
	id_tipo_solucion integer,
	id_tecnico integer,
	id_sucursal integer,
	id_traslado integer,
	id_reemplazo integer,
	comentario text,
	estado character default 'N',
	constraint pk_caso primary key (id)
);

create table detalle_caso(
	id serial,
	fecha timestamp without time zone default now(),
	tipo character,
	id_producto integer,
	numeroguia text,
	id_caso integer,
	constraint pk_detalle_caso primary key (id)
);

create table motivo_traslado(
	id serial,
	nombre text,
	constraint pk_motivo_traslado primary key (id)
);

create table traslado(
	id serial,
	numero text,
	remision integer,
	fecha timestamp without time zone default now(),
	descripcion text,
	id_origen integer,
	id_destino integer,
	id_motivo_traslado integer,
	numero_caso text,
	estado character default 'N',
	constraint pk_traslado primary key (id)
);

create table detalle_traslado(
	id serial,
	id_traslado integer,
	id_producto integer,
	constraint pk_detalle_traslado primary key(id)
);

create table empresa(
	id serial,
	nombre text,
	ruc text,
	direccion text,
	telefono text,
	domicilio text,
	constraint pk_empresa primary key (id)
);

create table documento(
	id serial,
	nombre text,
	codigo text,
	siguiente integer,
	constraint	pk_documento primary key (id)
);

create table archivo(
	id serial,
	numero integer,
	tipo text,
	extension text,
	fecha timestamp without time zone default now(),
	estado character default 'N',
	constraint pk_archivo primary key (id)
);