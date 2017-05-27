<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Area;
use App\AreaSucursal;
use App\Caso;
use App\Contrato;
use App\Departamento;
use App\DetalleCaso;
use App\DetalleContrato;
use App\DetalleTraslado;
use App\Distrito;
use App\Documento;
use App\Empresa;
use App\Grupo;
use App\Guia;
use App\Marca;
use App\Menu;
use App\Modelo;
use App\MotivoTraslado;
use App\Pais;
use App\Permiso;
use App\Producto;
use App\Proveedor;
use App\Provincia;
use App\Reportes;
use App\Sla;
use App\Sucursal;
use App\Tecnico;
use App\TipoEquipo;
use App\TipoSucursal;
use App\TipoTerritorio;
use App\TipoUsuario;
use App\Traslado;
use App\Usuario;
use App\Zona;
use Datetime;
use Exception;

class ControladorMantenimiento extends Controller
{
    
    private function ComprobarUsuario($usuario){
        if(empty($usuario)){
            return FALSE;
        }
        if(empty($usuario->id)){
            return FALSE;
        }
        if($usuario->id==null){
            return FALSE;
        }
        if($usuario->id==0){
            return FALSE;
        }
        if($usuario->id_tipo_usuario==null){
            return FALSE;
        }
        if($usuario->id_tipo_usuario==0){
            return FALSE;
        }
        return TRUE;
    }
    
    private function ComprobarPermiso($usuario,$idmenu){
        foreach ($usuario->menus as $menu) {
            if($menu->id==$idmenu){
                return true;
            }
        }
        return false;
    }
    
    
    //MANTENIMIENTO
    public function EliminarPost(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            DB::beginTransaction();
            try{
                $id = $request->input("id");
                $tabla = $request->input("tabla");
                if($tabla=="marca"){
                    $dependiente = Modelo::select(DB::raw("count(id) as total"))->where("id_marca",$id)->where("estado","!=","A")->first();
                    if($dependiente->total>0){
                        $error = "No es posible eliminar. Hay ".$dependiente->total." modelos de esta marca";
                    }else{
                        $obj = Marca::find($id);
                    }
                }else if($tabla=="tipoequipo"){
                    $dependiente = Modelo::select(DB::raw("count(id) as total"))->where("id_tipo_equipo",$id)->where("estado","!=","A")->first();
                    if($dependiente->total>0){
                        $error = "No es posible eliminar. Hay ".$dependiente->total." modelos de este tipo";
                    }else{
                        $obj = TipoEquipo::find($id);
                    }
                }else if($tabla=="modelo"){
                    $dependiente = Producto::select(DB::raw("count(id) as total"))->where("id_modelo",$id)->where("estado","!=","A")->first();    
                    if($dependiente->total>0){
                        $error = "No es posible eliminar. Hay ".$dependiente->total." productos de esta modelo";
                    }else{
                        $obj = Modelo::find($id);
                    }
                }else if($tabla=="tipousuario"){
                    $dependiente = Usuario::select(DB::raw("count(id) as total"))->where("id_tipo_usuario",$id)->where("estado","!=","A")->first();
                    if($dependiente->total>0){
                        $error = "No es posible eliminar. Hay ".$dependiente->total." usuarios de esta tipo";
                    }else{
                        $obj = TipoUsuario::find($id);
                    }
                }else if($tabla=="zona"){
                    $dependiente = Sucursal::select(DB::raw("count(id) as total"))->where("id_zona",$id)->where("estado","!=","A")->first();
                    if($dependiente->total>0){
                        $error = "No es posible eliminar. Hay ".$dependiente->total." sucursales de esta zona";
                    }else{
                        $obj = Zona::find($id);
                    }
                }else if($tabla=="tipoterritorio"){
                    $dependiente = Sucursal::select(DB::raw("count(id) as total"))->where("id_tipo_territorio",$id)->where("estado","!=","A")->first();
                    if($dependiente->total>0){
                        $error = "No es posible eliminar. Hay ".$dependiente->total." sucursales de esta zona";
                    }else{
                        $obj = TipoTerritorio::find($id);
                    }
                }else if($tabla=="tiposucursal"){
                    $dependiente = Sucursal::select(DB::raw("count(id) as total"))->where("id_tipo_sucursal",$id)->where("estado","!=","A")->first();
                    if($dependiente->total>0){
                        $error = "No es posible eliminar. Hay ".$dependiente->total." sucursales de esta zona";
                    }else{
                        $obj = TipoSucursal::find($id);
                    }
                }else if($tabla=="motivotraslado"){
                    $obj = MotivoTraslado::find($id);
                }else if($tabla=="permiso"){
                    $obj = Permiso::find($id);
                }else if($tabla=="area"){
                    $dependiente = AreaSucursal::select(DB::raw("count(id) as total"))->where("id_area",$id)->where("estado","!=","A")->first();
                    if($dependiente->total>0){
                        $error = "No es posible eliminar. Hay ".$dependiente->total." sucursales asignadas a esta area";
                    }else{
                        $obj = Area::find($id);
                    }
                }else if($tabla=="tecnico"){
                    $dependiente = Caso::select(DB::raw("count(id) as total"))->where("id_tecnico",$id)->where("estado","!=","F")->first();
                    if($dependiente->total>0){
                        $error = "No es posible eliminar. Hay ".$dependiente->total." casos asignadas a esta técnico pendientes";
                    }else{
                        $obj = Tecnico::find($id);
                    }
                }
                if($dependiente->total>0){
                    return json_encode(["ok"=>false,"error"=>$error]);
                }else{
                    if($tabla=="tipousuario"){
                        if($id==1 || $id == 2){
                            return json_encode(["ok"=>false,"error"=>"No se puede eliminar este tipo de usuario"]);
                        }
                    }
                    $obj->estado = "A";
                    $obj->save();
                    DB::commit();
                    $request->session()->put("mensaje", "Eliminado correctamente");
                    return json_encode(["ok"=>true]);
                }
            } 
            catch (Exception $e) {
                DB::rollback();
                $error=$e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    
    public function Marcas(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 1;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $marcas = Marca::where('estado','N')->orderBy('nombre')->paginate(10);
                return view('/marcas',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'marcas'=>$marcas,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function Marca(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            DB::beginTransaction();
            try{
                $nombre = $request->input("nombre");
                $abreviatura = $request->input("abreviatura");
                
                $quitar = array("'",'"');
                $nombre = str_replace($quitar, "", $nombre);
                $abreviatura = str_replace($quitar, "", $abreviatura);
                if($modo=="agregar"){
                    $marca = new Marca();
                }else if($modo=="editar"){
                    $marca = Marca::find($request->input("id"));
                }
                $marca->nombre = strtoupper($nombre);
                $marca->abreviatura = strtoupper($abreviatura);
                $marca->save();
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return json_encode(["ok"=>true,"obj"=>$marca]);
            } 
            catch (Exception $e) {
                DB::rollback();
                $error=$e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function TiposEquipo(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 3;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $tiposequipo = TipoEquipo::where('estado','N')->orderBy('nombre')->paginate(10);
                return view('/tiposequipo',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'tiposequipo'=>$tiposequipo,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function TipoEquipo(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            DB::beginTransaction();
            try{
                $nombre = $request->input("nombre");
                $abreviatura = $request->input("abreviatura");
                
                $quitar = array("'",'"');
                $nombre = str_replace($quitar, "", $nombre);
                $abreviatura = str_replace($quitar, "", $abreviatura);
                
                if($modo=="agregar"){
                    $tipoequipo = new TipoEquipo();
                }else if($modo=="editar"){
                    $tipoequipo = TipoEquipo::find($request->input("id"));
                }
                $tipoequipo->nombre = strtoupper($nombre);
                $tipoequipo->abreviatura = strtoupper($abreviatura);
                $tipoequipo->save();
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return json_encode(["ok"=>true,"obj"=>$tipoequipo]);
            } 
            catch (Exception $e) {
                DB::rollback();
                $error=$e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function TiposUsuario(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 7;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $tiposusuario = TipoUsuario::where('estado','N')->orderBy('nombre')->paginate(10);
                return view('/tiposusuario',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'tiposusuario'=>$tiposusuario,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function TipoUsuario(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            DB::beginTransaction();
            try{
                $nombre = $request->input("nombre");
                $abreviatura = $request->input("abreviatura");
                
                $quitar = array("'",'"');
                $nombre = str_replace($quitar, "", $nombre);
                $abreviatura = str_replace($quitar, "", $abreviatura);
                
                if($modo=="agregar"){
                    $tipousuario = new TipoUsuario();
                }else if($modo=="editar"){
                    $tipousuario = TipoUsuario::find($request->input("id"));
                }
                $tipousuario->nombre = strtoupper($nombre);
                $tipousuario->save();
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return json_encode(["ok"=>true,"obj"=>$tipousuario]);
            } 
            catch (Exception $e) {
                DB::rollback();
                $error=$e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function Permisos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 9;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->Input("id");
                $tipo = TipoUsuario::find($id);
                $permisos = Permiso::join("menu","permiso.id_menu","menu.id")
                        ->join("grupo","menu.id_grupo","grupo.id")
                        ->select("permiso.*","menu.nombre as nombremenu","grupo.nombre as nombregrupo")
                        ->where('id_tipo_usuario',$id)->where('permiso.estado','=','N')->orderBy("menu.nombre")->get();
                $otros = Menu::where('menu.estado','=','N')
                        ->join("grupo","menu.id_grupo","grupo.id")
                        ->select("menu.*","grupo.nombre as nombregrupo")
                        ->whereNotIn('menu.id', function($query) use ($id){
                    $query->select('id_menu')->from('permiso')->where('id_tipo_usuario','=',$id)->where('estado','N');
                })->orderBy("menu.nombre")->get();
                return view('/permisos',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'permisos'=>$permisos,
                    'otros'=>$otros,
                    'tipo'=>$tipo,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function Permiso(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $id = $request->input("id");
            $tipo = $request->input("tipo");
            $accion = $request->input("accion");
            DB::beginTransaction();
            try{
                if($accion=="agregar"){
                    $permiso = new Permiso();
                    $permiso->id_tipo_usuario = $tipo;
                    $permiso->id_menu = $id;
                    $permiso->save();
                }else{
                    $permiso = Permiso::find($id);
                    $permiso->estado = "A";
                    $permiso->save();
                }
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return redirect("/permisos?id=".$tipo);
            } 
            catch (Exception $e) {
                DB::rollback();
                $error=$e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function Usuarios(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 8;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->Input("id");
                $tipousuario = TipoUsuario::find($id);
                $tiposusuario = TipoUsuario::where("estado","N")->whereNotIn("id",[$id,2])->get();
                $usuarios = Usuario::where("estado","N")->where("id_tipo_usuario",$id)->orderBy("apellidos")->orderBy("nombre")->paginate(10);
                if($id==2){
                    $proveedores = Proveedor::where("estado","N")->orderBy("razon")->get();
                    return view('/usuarios2',[
                        'usuario'=>$usuario,
                        'mensaje'=>$mensaje,
                        'usuarios'=>$usuarios,
                        'tipousuario'=>$tipousuario,
                        'tiposusuario'=>$tiposusuario,
                        'proveedores'=>$proveedores,
                        'w'=>0
                    ]);
                }else{
                    return view('/usuarios',[
                        'usuario'=>$usuario,
                        'mensaje'=>$mensaje,
                        'usuarios'=>$usuarios,
                        'tipousuario'=>$tipousuario,
                        'tiposusuario'=>$tiposusuario,
                        'w'=>0
                    ]);
                }
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function Usuario(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            $mensaje = "";
            DB::beginTransaction();
            try{
                if($modo=="agregar"){
                    $correo = $request->input("correo");
                    $anterior = Usuario::where("correo",$correo)->first();
                    if(empty($anterior)){
                        $obj = new Usuario();
                        $obj->id_tipo_usuario = $request->input("tipo");
                        if($obj->id_tipo_usuario==2){
                            $obj->id_proveedor = $request->input("id_proveedor");
                        }
                        $nombre = $request->input("nombre");
                        $obj->nombre = $nombre;
                        $apellidos =$request->input("apellidos");
                        $obj->apellidos = $apellidos;
                        $obj->correo = $correo;
                        $obj->password = "123";
                        $obj->save();
                        $mensaje = "Guardado correctamente";
                    }else{
                        DB::rollback();
                        return json_encode(["ok"=>false,"error"=>"La cuenta ya existe, ingrese otra"]);
                    }
                }else if($modo=="pass"){
                    $pass = $request->input("pass");
                    $pass2 = $request->input("pass2");
                    $pass3 = $request->input("pass3");
                    if($usuario->password==$pass){
                        if($pass2==$pass3){
                            $obj = Usuario::find($usuario->id);
                            $obj->password = $pass2;
                            $usuario->password = $pass2;
                            $obj->save();
                            DB::commit();
                            $request->session()->put("usuario",$usuario);
                            $request->session()->put("mensaje","CONTRASEÑA CAMBIADA");
                        }else{
                            $request->session()->put("mensaje","LAS CONTRASEÑAS NUEVAS NO COINCIDEN");
                        }
                    }else{
                        $request->session()->put("mensaje","CONTRASEÑA ACTUAL INCORRECTA");
                    }
                    return redirect("/password");
                }else{
                    $id = $request->input("id");
                    $obj = Usuario::find($id);
                    if($modo=="editar"){
                        $obj->id_tipo_usuario = $request->input("tipo");
                        $mensaje = "Guardado correctamente";
                    }else if($modo=="eliminar"){
                        $obj->estado = "A";
                        $mensaje = "Eliminado correctamente";
                    }else if($modo=="restablecer"){
                        $obj->password = "123";
                        $mensaje = "Contraseña restablecida";
                    }
                    $obj->save();
                }
                DB::commit();
                $request->session()->put("mensaje",$mensaje);
                return json_encode(["ok"=>true,"obj"=>$obj]);
            } 
            catch (Exception $e) {
                DB::rollback();
                $error=$e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function Zonas(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 4;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $zonas = Zona::where("estado","N")->orderBy('nombre')->paginate(10);
                return view('/zonas',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'zonas'=>$zonas,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function Zona(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            DB::beginTransaction();
            try{
                $nombre = $request->input("nombre");
                $descripcion = $request->input("descripcion");
                
                $quitar = array("'",'"');
                $nombre = str_replace($quitar, "", $nombre);
                $descripcion = str_replace($quitar, "", $descripcion);
                if($modo=="agregar"){
                    $zona = new Zona();
                }else if($modo=="editar"){
                    $zona = Zona::find($request->input("id"));
                }
                $zona->nombre = strtoupper($nombre);
                $zona->abreviatura = strtoupper($descripcion);
                $zona->save();
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return json_encode(["ok"=>true,"obj"=>$zona]);
            } 
            catch (Exception $e) {
                DB::rollback();
                $error=$e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function Modelos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            if($modo=="ajax"){
                $idmarca = $request->input("id_marca");
                $idtipo = $request->input("id_tipo_equipo");
                $modelos = Modelo::where('estado','N');
                if($idmarca>0){
                    $modelos = $modelos->where("id_marca",$idmarca);
                }
                if($idtipo>0){
                    $modelos = $modelos->where("id_tipo_equipo",$idtipo);
                }
                $modelos = $modelos->orderBy('nombre')->get();
                return json_encode(["obj"=>$modelos]);
            }else{
                $menuid = 2;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $idmarca = $request->input("id_marca");
                    $idtipoequipo = $request->input("id_tipoequipo");
                    $modelos = Modelo::where('estado','N');
                    if($idmarca>0){
                        $modelos = $modelos->where("id_marca",$idmarca);
                    }else{
                        $idmarca = 0;
                    }

                    if($idtipoequipo>0){
                        $modelos = $modelos->where("id_tipo_equipo",$idtipoequipo);
                    }else{
                        $idtipoequipo = 0;
                    }
                    $modelos = $modelos->orderBy('nombre')->paginate(10);
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $tiposequipo = TipoEquipo::where("estado","N")->orderBy("nombre")->get();
                    $marcas = Marca::where("estado","N")->orderBy("nombre")->get();
                    return view('/modelos',[
                        'usuario'=>$usuario,
                        'mensaje'=>$mensaje,
                        'modelos'=>$modelos,
                        'tiposequipo'=>$tiposequipo,
                        'marcas'=>$marcas,
                        'idmarca'=>$idmarca,
                        'idtipoequipo'=>$idtipoequipo,
                        'w'=>0
                    ]);
                }else{
                    $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                    return redirect ("/inicio");
                }   
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function Modelo(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            DB::beginTransaction();
            try{
                $nombre = $request->input("nombre");
                
                $quitar = array("'",'"');
                $nombre = str_replace($quitar, "", $nombre);
                
                if($modo=="agregar"){
                    $modelo = new Modelo();
                    $modelo->id_marca = $request->input("marca");
                }else if($modo=="editar"){
                    $modelo = Modelo::find($request->input("id"));    
                }
                $modelo->nombre = strtoupper($nombre);
                $modelo->id_tipo_equipo = $request->input("tipo");
                $modelo->save();
                DB::commit();
                if($modo=="agregar"){
                    $tipo = TipoEquipo::find($modelo->id_tipo_equipo);
                    $modelo->nombretipo = $tipo->nombre;
                }
                $request->session()->put("mensaje","Guardado correctamente");
                return json_encode(["ok"=>true,"obj"=>$modelo]);
            } 
            catch (Exception $e) {
                DB::rollback();
                $error=$e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function Areas(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 6;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                $areas = Area::where('estado','N')->orderBy('nombre')->paginate(10);
                return view('/areas',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'areas'=>$areas,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function Area(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            DB::beginTransaction();
            try{
                $nombre = $request->input("nombre");
                $abreviatura = $request->input("abreviatura");
                if($modo=="agregar"){
                    $area = new Area();
                }else if($modo=="editar"){
                    $area = Area::find($request->input("id"));    
                }
                $area->nombre = $nombre;
                $area->abreviatura = $abreviatura;
                $area->save();
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return json_encode(["ok"=>true,"obj"=>$area]);
            } 
            catch (Exception $e) {
                DB::rollback();
                $error=$e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function TiposSucursal(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 4;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $tipossucursal = TipoSucursal::where("estado","N")->orderBy('nombre')->paginate(10);
                return view('/tipossucursal',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'tipossucursal'=>$tipossucursal,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function TipoSucursal(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            DB::beginTransaction();
            try{
                $nombre = $request->input("nombre");
                
                $quitar = array("'",'"');
                $nombre = str_replace($quitar, "", $nombre);
                if($modo=="agregar"){
                    $tiposucursal = new TipoSucursal();
                }else if($modo=="editar"){
                    $tiposucursal = TipoSucursal::find($request->input("id"));
                }
                $tiposucursal->nombre = strtoupper($nombre);
                $tiposucursal->save();
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return json_encode(["ok"=>true,"obj"=>$tiposucursal]);
            } 
            catch (Exception $e) {
                DB::rollback();
                $error=$e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function TiposTerritorio(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 4;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $tiposterritorio = TipoTerritorio::where("estado","N")->orderBy('nombre')->paginate(10);
                return view('/tiposterritorio',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'tiposterritorio'=>$tiposterritorio,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function TipoTerritorio(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            DB::beginTransaction();
            try{
                $nombre = $request->input("nombre");
                
                $quitar = array("'",'"');
                $nombre = str_replace($quitar, "", $nombre);
                if($modo=="agregar"){
                    $tipoterritorio = new TipoTerritorio();
                }else if($modo=="editar"){
                    $tipoterritorio = TipoTerritorio::find($request->input("id"));
                }
                $tipoterritorio->nombre = strtoupper($nombre);
                $tipoterritorio->save();
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return json_encode(["ok"=>true,"obj"=>$tipoterritorio]);
            } 
            catch (Exception $e) {
                DB::rollback();
                $error=$e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
}
    