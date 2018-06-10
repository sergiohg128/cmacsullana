<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Cuenta;
use App\Ciclo;
use App\Universidad;
use App\Carrera;
use App\Pago;
use App\Usuario;
use App\Tipo;
use App\Permiso;
use App\Menu;
use App\Proyecto;
use App\Sede;
use App\Mensaje;
use App\Archivo;
use App\Contenido;
use App\Cuota;
use Datetime;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class ControladorProyecto extends Controller
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
        if($usuario->id_tipo==null){
            return FALSE;
        }
        if($usuario->id_tipo==0){
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

    public function CicloCarreras(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 2;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                $carreras = Carrera::where("estado","N")->orderBy("nombre")->get();
                return view('/ciclo-carreras',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'carreras'=>$carreras,
                    'idciclo'=>$id,
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

    public function CicloCarreraUsuarios(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 2;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id_ciclo = $request->input("ciclo");
                $id_carrera = $request->input("carrera");
                //$usuarios = Usuario::where("id_ciclo",$idciclo)->where("id_carrera",$idcarrera)->orderBy("paterno")->orderBy("materno")->orderBy("nombres")->get();
                return view('/ciclo-carrera-usuarios',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'id_ciclo'=>$id_ciclo,
                    'id_carrera'=>$id_carrera,
                    //'usuarios'=>$usuarios,
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

    

    public function Proyectos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 9;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id_usuario = $request->input("id");
                return view('/proyectos',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'id_usuario'=>$id_usuario,
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

    public function MantenimientoProyectos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 9;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $nombre = request()->input("nombre", "");
                    $tipo = request()->input("tipo", "");
                    $id_usuario = request()->input("id_usuario", "");
                    if($modo=="N"){
                        $proyecto = new Proyecto();
                        $proyecto->nombre = $nombre;
                        $proyecto->tipo = $tipo;
                        $proyecto->id_usuario = $id_usuario;
                        $proyecto->save();
                    }elseif($modo=="E"){
                        $proyecto = Proyecto::find($id);
                        $proyecto->nombre = $nombre;
                        $proyecto->tipo = $tipo;
                        $proyecto->id_usuario = $id_usuario;
                        $proyecto->save();
                    }elseif($modo=="A"){
                        $proyecto = Proyecto::find($id);
                        $proyecto->estado = "A";
                        $proyecto->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalProyectos').modal('hide');buscar();",
                    ));
                }else{
                    throw new Exception("NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                }
            }else{
                throw new Exception("INICIA SESION PRIMERO");
            }
        } catch (Exception $e){
            DB::rollback();
            return json_encode(array(
                "correcto"=>false,
                "error"=>$e->getMessage(),
                "file"=>$e->getFile(),
                "line"=>$e->getLine(),
            ));
        }
    }

    public function Mensajes(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 11;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id_proyecto = $request->input("id");
                return view('/mensajes',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'id_proyecto'=>$id_proyecto,
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

    public function MantenimientoMensajes(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 11;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $titulo = request()->input("titulo", "");
                    $contenido = request()->input("contenido", "");
                    $estado = request()->input("estado", "");
                    $id_proyecto = request()->input("id_proyecto", "");
                    $archivos = $request->file("archivos");
                    if($modo=="A"){
                        $mensaje = Mensaje::find($id);
                        $mensaje->estado = "A";
                        $mensaje->save();

                        $archivos = Archivo::where("id_mensaje",$id)->get();
                        foreach($archivos as $archivo){
                            \Storage::disk('archivo')->delete($archivo->id.".".$archivo->extension);
                            $archivo->estado = "A";
                            $archivo->save();
                        }
                    }else{
                        if($modo=="N"){
                            $mensaje = new Mensaje();
                            $mensaje->titulo = $titulo;
                            $mensaje->contenido = $contenido;
                            $mensaje->id_proyecto = $id_proyecto;
                            $mensaje->id_usuario = $usuario->id;
                            $mensaje->save();
                        }elseif($modo=="E"){
                            $mensaje = Mensaje::find($id);
                            $mensaje->titulo = $titulo;
                            $mensaje->contenido = $contenido;
                            $mensaje->save();
                        }elseif($modo=="ES"){
                            $mensaje = Mensaje::find($id);
                            $mensaje->estado = $estado;
                            $mensaje->save();
                        }
                        if(!empty($archivos)){
                            foreach($archivos as $archivo){
                                $archivoObj = new Archivo();
                                $ext = $archivo->getClientOriginalExtension();
                                $archivoObj->nombre = $archivo->getClientOriginalName();
                                $archivoObj->peso = $archivo->getSize();
                                $archivoObj->extension = $ext;
                                $archivoObj->id_mensaje = $mensaje->id;
                                $archivoObj->save();
                                \Storage::disk('archivo')->put($archivoObj->id.".".$ext,  \File::get($archivo));
                            }
                        }
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "vista"=>"",
                        "ejecutar"=>"$('#modalMensajes').modal('hide');buscar();",
                    ));
                }else{
                    throw new Exception("NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                }
            }else{
                throw new Exception("INICIA SESION PRIMERO");
            }
        } catch (Exception $e){
            DB::rollback();
            return json_encode(array(
                "correcto"=>false,
                "error"=>$e->getMessage(),
                "file"=>$e->getFile(),
                "line"=>$e->getLine(),
            ));
        }
    }
    
    public function Archivos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 12;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id_mensaje = $request->input("m");
                $id_proyecto = $request->input("p");
                $archivos = null;
                $tipo = "M";
                if($id_mensaje!=null){
                    $archivos = Archivo::where("estado","N")->where("id_mensaje",$id_mensaje)->orderBy("nombre")->get();
                }else{
                    $tipo = "P";
                    $archivos = Archivo::select("archivo.*","m.titulo","m.fecha")->join("mensaje as m","archivo.id_mensaje","m.id")->where("archivo.estado","N")->where("m.id_proyecto",$id_proyecto)->orderBy("fecha")->orderBy("nombre")->get();
                }
                return view('/archivos',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'archivos'=>$archivos,
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

    public function MantenimientoArchivo(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 12;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    
                    $archivo = Archivo::find($id);
                    \Storage::disk('archivo')->delete($archivo->id.".".$archivo->extension);
                    $archivo->estado = "A";
                    $archivo->save();
                    
                    DB::commit();
                    
                    if($modo=="M"){
                        return redirect ("/archivos?m=".$archivo->id_mensaje);
                    }else{
                        $mensaje = Mensaje::find($archivo->id_mensaje);
                        return redirect ("/archivos?p=".$mensaje->id_proyecto);
                    }
                }else{
                    throw new Exception("NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                }
            }else{
                throw new Exception("INICIA SESION PRIMERO");
            }
        } catch (Exception $e){
            DB::rollback();
            return json_encode(array(
                "correcto"=>false,
                "error"=>$e->getMessage(),
                "file"=>$e->getFile(),
                "line"=>$e->getLine(),
            ));
        }
    }

    public function Pagos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 5;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id_cuota = $request->input("cuota");
                return view('/pagos',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'id_cuota'=>$id_cuota,
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

    public function MantenimientoPago(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 5;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $monto = request()->input("monto", "");
                    $fecha = request()->input("fecha", "");
                    $id_cuenta = request()->input("id_cuenta", "");
                    $id_cuota = request()->input("id_cuota", "");
                    $operacion = request()->input("operacion", "");
                    $cuota = Cuota::find($id_cuota);
                    if($modo=="N"){
                        $pago = new Pago();
                        $pago->id_proyecto = $cuota->id_proyecto;
                        $pago->monto = $monto;
                        $pago->fecha = $fecha;
                        $pago->operacion = $operacion;
                        $pago->id_cuenta = $id_cuenta;
                        $pago->id_cuota = $id_cuota;
                        $pago->save();
                    }elseif($modo=="E"){
                        $pago = Pago::find($id);
                        $pago->monto = $monto;
                        $pago->fecha = $fecha;
                        $pago->operacion = $operacion;
                        $pago->id_cuenta = $id_cuenta;
                        $pago->id_cuota = $id_cuota;
                        $pago->save();
                    }elseif($modo=="A"){
                        $pago = Pago::find($id);
                        $pago->estado = "A";
                        $pago->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalPagos').modal('hide');buscar();",
                    ));
                }else{
                    throw new Exception("NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                }
            }else{
                throw new Exception("INICIA SESION PRIMERO");
            }
        } catch (Exception $e){
            DB::rollback();
            return json_encode(array(
                "correcto"=>false,
                "error"=>$e->getMessage(),
                "file"=>$e->getFile(),
                "line"=>$e->getLine(),
            ));
        }
    }
    
    public function Cuotas(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 17;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id_proyecto = $request->input("id");
                return view('/cuotas',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'id_proyecto'=>$id_proyecto,
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

    public function MantenimientoCuotas(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 17;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $monto = request()->input("monto", "");
                    $fecha = request()->input("fecha", "");
                    $detalle = request()->input("detalle", "");
                    $id_proyecto = request()->input("id_proyecto", "");
                    if($modo=="N"){
                        $cuota = new Cuota();
                        $cuota->monto = $monto;
                        $cuota->fecha = $fecha;
                        $cuota->detalle = $detalle;
                        $cuota->id_proyecto = $id_proyecto;
                        $cuota->save();
                    }elseif($modo=="E"){
                        $cuota = Cuota::find($id);
                        $cuota->monto = $monto;
                        $cuota->fecha = $fecha;
                        $cuota->detalle = $detalle;
                        $cuota->save();
                    }elseif($modo=="A"){
                        $cuota = Cuota::find($id);
                        $cuota->estado = "A";
                        $cuota->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalCuotas').modal('hide');buscar();",
                    ));
                }else{
                    throw new Exception("NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                }
            }else{
                throw new Exception("INICIA SESION PRIMERO");
            }
        } catch (Exception $e){
            DB::rollback();
            return json_encode(array(
                "correcto"=>false,
                "error"=>$e->getMessage(),
                "file"=>$e->getFile(),
                "line"=>$e->getLine(),
            ));
        }
    }

}