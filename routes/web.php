<?php

Route::get('/', function (){
    return redirect("/index");
});

//CONTROLADOR
Route::get('/index','Controlador@index');
Route::post('/login','Controlador@login');
Route::get('/logout','Controlador@logout');
Route::get('/inicio','Controlador@inicio');
Route::get('/subir-archivo','Controlador@SubirArchivo');
Route::get('/descargar-archivo','Controlador@DescargarArchivo');

//CONTROLADOR MANTENIMIENTO
Route::get('/usuarios','ControladorMantenimiento@Usuarios');
Route::post('/mantenimiento/usuarios','ControladorMantenimiento@MantenimientoUsuarios');
Route::get('/cuentas','ControladorMantenimiento@Cuentas');
Route::post('/mantenimiento/cuentas','ControladorMantenimiento@MantenimientoCuentas');
Route::get('/ciclos','ControladorMantenimiento@Ciclos');
Route::post('/mantenimiento/ciclos','ControladorMantenimiento@MantenimientoCiclos');
Route::get('/universidades','ControladorMantenimiento@Universidades');
Route::post('/mantenimiento/universidades','ControladorMantenimiento@MantenimientoUniversidades');
Route::get('/carreras','ControladorMantenimiento@Carreras');
Route::post('/mantenimiento/carreras','ControladorMantenimiento@MantenimientoCarreras');
Route::get('/tipos','ControladorMantenimiento@Tipos');
//Route::get('/mantenimiento/tipos','ControladorMantenimiento@MantenimientoTipos');
Route::post('/mantenimiento/tipos','ControladorMantenimiento@MantenimientoTipos');
Route::get('/permisos','ControladorMantenimiento@Permisos');
Route::post('/mantenimiento/permisos','ControladorMantenimiento@MantenimientoPermisos');
Route::get('/sedes','ControladorMantenimiento@Sedes');
Route::post('/mantenimiento/sedes','ControladorMantenimiento@MantenimientoSedes');
Route::get('/contenido','ControladorMantenimiento@Contenido');
Route::post('/mantenimiento/contenidos','ControladorMantenimiento@MantenimientoContenidos');
Route::get('/staff','ControladorMantenimiento@Staffs');
Route::post('/mantenimiento/staffs','ControladorMantenimiento@MantenimientoStaff');
Route::get('/perfil','ControladorMantenimiento@Perfil');
Route::get('/mantenimiento','ControladorMantenimiento@Mantenimiento');

//CONTROLADOR PROYECTO
Route::get('/contactos','Controlador@Contactos');


Route::get('/ciclo-carreras','ControladorProyecto@CicloCarreras');
Route::get('/ciclo-carrera-usuarios','ControladorProyecto@CicloCarreraUsuarios');
Route::get('/pagos','ControladorProyecto@Pagos');
Route::post('/mantenimiento/pagos','ControladorProyecto@MantenimientoPago');
Route::get('/cuotas','ControladorProyecto@cuotas'); 
Route::post('/mantenimiento/cuotas','ControladorProyecto@Mantenimientocuotas'); 
Route::get('/proyectos','ControladorProyecto@Proyectos');
Route::post('/mantenimiento/proyectos','ControladorProyecto@MantenimientoProyectos');
Route::get('/mensajes','ControladorProyecto@Mensajes');
Route::post('/mantenimiento/mensajes','ControladorProyecto@MantenimientoMensajes');
Route::get('/archivos','ControladorProyecto@Archivos');
Route::post('/mantenimiento/archivo','ControladorProyecto@MantenimientoArchivo');

Route::post('/contacto','Controlador@Contacto');


//CONTROLADOR AJAX
Route::get('/ajax/listartiposusuario','ControladorAjax@ListarTipoUsuario');
Route::get('/ajax/listarsedes','ControladorAjax@ListarSedes');
Route::get('/ajax/listarcarreras','ControladorAjax@ListarCarreras');
Route::get('/ajax/listaruniversidades','ControladorAjax@ListarUniversidades');
Route::get('/ajax/listarcuentas','ControladorAjax@ListarCuentas');
Route::get('/ajax/listarcontenidos','ControladorAjax@ListarContenidos');
Route::get('/ajax/listarusuarios','ControladorAjax@ListarUsuarios');
Route::get('/ajax/listarciclos','ControladorAjax@ListarCiclos');
Route::get('/ajax/listarproyectos','ControladorAjax@ListarProyectos');
Route::get('/ajax/listarmensajes','ControladorAjax@ListarMensajes');
Route::get('/ajax/listarpagos','ControladorAjax@ListarPagos');
Route::get('/ajax/listarcuotas','ControladorAjax@Listarcuotas');
Route::get('/ajax/listarcontactos','ControladorAjax@ListarContactos');
Route::get('/ajax/listarstaffs','ControladorAjax@ListarStaffs');


Route::get('/download/archivo','ControladorAjax@DescargarArchivo');

//CONTROLADOR REPORTES 
Route::get('/reportes','ControladorReporte@Reportes'); 
Route::get('/reporte','ControladorReporte@Reporte'); 
Route::get('/exportar','ControladorReporte@Exportar'); 
 