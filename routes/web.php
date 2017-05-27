<?php

Route::get('/', function (){
    return redirect("/index");
});
Route::get('/index','Controlador@index');
Route::get('/inicio','Controlador@inicio');

//SESION
Route::post('/login','Controlador@login');
Route::get('/logout','Controlador@logout');
Route::get('/password','Controlador@password');


Route::get('/provincias','Controlador@provincias');
Route::get('/distritos','Controlador@distritos');

//MANTENIMIENTO
Route::post('/eliminarpost','ControladorMantenimiento@eliminarpost');

Route::get('/marcas','ControladorMantenimiento@marcas');
Route::post('/marca','ControladorMantenimiento@marca');

Route::get('/modelos','ControladorMantenimiento@modelos');
Route::post('/modelo','ControladorMantenimiento@modelo');

Route::get('/tiposequipo','ControladorMantenimiento@tiposequipo');
Route::post('/tipoequipo','ControladorMantenimiento@tipoequipo');

Route::get('/zonas','ControladorMantenimiento@zonas');
Route::post('/zona','ControladorMantenimiento@zona');

Route::get('/tiposusuario','ControladorMantenimiento@tiposusuario');
Route::post('/tipousuario','ControladorMantenimiento@tipousuario');

Route::get('/usuarios','ControladorMantenimiento@usuarios');
Route::post('/usuario','ControladorMantenimiento@usuario');

Route::get('/permisos','ControladorMantenimiento@permisos');
Route::post('/permiso','ControladorMantenimiento@permiso');

Route::get('/motivostraslado','ControladorMantenimiento@motivostraslado');
Route::post('/motivotraslado','ControladorMantenimiento@motivotraslado');

Route::get('/areas','ControladorMantenimiento@areas');
Route::post('/area','ControladorMantenimiento@area');

Route::get('/tipossucursal','ControladorMantenimiento@tipossucursal');
Route::post('/tiposucursal','ControladorMantenimiento@tiposucursal');

Route::get('/tiposterritorio','ControladorMantenimiento@tiposterritorio');
Route::post('/tipoterritorio','ControladorMantenimiento@tipoterritorio');

//EMPRESA
Route::get('/cliente','ControladorEmpresa@cliente');
Route::post('/cliente','ControladorEmpresa@clientepost');

Route::get('/sucursales','ControladorEmpresa@sucursales');
Route::get('/sucursal','ControladorEmpresa@sucursal');
Route::post('/sucursal','ControladorEmpresa@sucursalpost');

Route::get('/stock','ControladorEmpresa@stock');
Route::get('/series','ControladorEmpresa@series');


Route::get('/asignar-area','ControladorEmpresa@asignararea');

Route::get('/areas-sucursal','ControladorEmpresa@areassucursal');
Route::post('/area-sucursal','ControladorEmpresa@areasucursal');

Route::get('/productos','ControladorEmpresa@productos');

Route::get('/traslados','ControladorEmpresa@traslados');
Route::get('/traslado-nuevo','ControladorEmpresa@trasladonuevo');
Route::post('/traslado','ControladorEmpresa@trasladopost');
Route::get('/traslado','ControladorEmpresa@traslado');
Route::get('/traslado-sinseries','ControladorEmpresa@trasladosinseries');
Route::get('/traslado-series','ControladorEmpresa@trasladoseries');
Route::get('/trasladar-serie','ControladorEmpresa@transladarserie');

Route::post('/traslado-detalle','ControladorEmpresa@TrasladoDetalle');

//CONTRATOS

Route::get('/proveedores','ControladorContratos@proveedores');
Route::post('/proveedor','ControladorContratos@proveedor');
Route::get('/verproveedor','ControladorContratos@verproveedor');

Route::get('/tecnicos','ControladorContratos@tecnicos');
Route::post('/tecnico','ControladorContratos@tecnico');

Route::get('/contratos','ControladorContratos@contratos');
Route::get('/contrato-nuevo','ControladorContratos@contratonuevo');
Route::get('/contrato-detalle','ControladorContratos@contratodetalle');
Route::post('/contrato-detalle','ControladorContratos@contratodetallepost');
Route::get('/contrato-sla','ControladorContratos@contratosla');
Route::post('/contrato-sla','ControladorContratos@contratoslapost');
Route::get('/contratopost','ControladorContratos@contratopost');
Route::get('/contrato','ControladorContratos@contrato');
Route::get('/contrato-sinseries','ControladorContratos@contratosinseries');
Route::get('/contrato-series','ControladorContratos@contratoseries');

Route::get('/guia-nueva','ControladorContratos@guianueva');
Route::get('/guiapost','ControladorContratos@guiapost');
Route::get('/guia','ControladorContratos@guia');
Route::get('/guia-series','ControladorContratos@guiaseries');
Route::post('/guia-detalle','ControladorContratos@guiadetalle');

Route::get('/agregar-serie','ControladorContratos@agregarserie');

Route::get('/casos','ControladorContratos@casos');
Route::get('/caso-nuevo','ControladorContratos@casonuevo');
Route::post('/caso','ControladorContratos@casopost');
Route::get('/caso','ControladorContratos@caso');
Route::get('/caso-serie','ControladorContratos@casoserie');
Route::post('/caso-asignartecnico','ControladorContratos@casoasignartecnico');
Route::post('/caso-detalle','ControladorContratos@casodetalle');
Route::get('/caso-traslado','ControladorContratos@casotraslado');
Route::post('/caso-traslado','ControladorContratos@casotrasladopost');
Route::get('/caso-serie-reemplazo','ControladorContratos@casoseriereemplazo');
Route::post('/caso-fin','ControladorContratos@casofin');

Route::get('/compra-nueva','ControladorContratos@compranueva');
Route::get('/comprapost','ControladorContratos@comprapost');
Route::get('/compra','ControladorContratos@compra');
Route::post('/compra-detalle','ControladorContratos@compradetalle');


//ARCHIVOS
Route::get('/descargar-archivo','Controlador@descargararchivo');
Route::post('/subir-archivo','Controlador@subirarchivo');

//REPORTES
Route::get('/reportes','Controlador@reportes');
Route::get('/reporte','Controlador@reporte');


//IMPORTAR
Route::get('/importar-sucursales','Controlador@importarsucursales');
Route::get('/importar-productos','Controlador@importarproductos');
Route::get('/importar-sla','Controlador@importarsla');
Route::get('/importar-base-productos','Controlador@importarbaseproductos');