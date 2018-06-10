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
use App\Staff;
use Datetime;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

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

    public function Usuarios(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 6;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                return view('/usuarios',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
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

    public function MantenimientoUsuarios(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 6;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $nombres = request()->input("nombres", "");
                    $paterno = request()->input("paterno", "");
                    $materno = request()->input("materno", "");
                    $celular = request()->input("celular", "");
                    $password = request()->input("password", "");
                    $correo = request()->input("correo", "");
                    $id_sede = request()->input("id_sede", "");
                    $id_tipo = request()->input("id_tipo", "");
                    $id_universidad = request()->input("id_universidad", "");
                    $id_carrera = request()->input("id_carrera", "");
                    $id_ciclo = request()->input("id_ciclo", "");
                    if($modo=="N"){
                        $usuario = new Usuario();
                        $usuario->nombres = $nombres;
                        $usuario->paterno = $paterno;
                        $usuario->materno = $materno;
                        $usuario->celular = $celular;
                        $usuario->password = $password;
                        $usuario->correo = $correo;
                        $usuario->id_sede = $id_sede;
                        $usuario->id_tipo = $id_tipo;
                        if($id_tipo==2){
                            $usuario->id_universidad = $id_universidad;
                            $usuario->id_carrera = $id_carrera;
                            $usuario->id_ciclo = $id_ciclo;
                        }
                        $usuario->save();
                    }elseif($modo=="E"){
                        $usuario = Usuario::find($id);
                        $usuario->nombres = $nombres;
                        $usuario->paterno = $paterno;
                        $usuario->materno = $materno;
                        $usuario->celular = $celular;
                        $usuario->password = $password;
                        $usuario->correo = $correo;
                        $usuario->id_sede = $id_sede;
                        $usuario->id_tipo = $id_tipo;
                        if($id_tipo==2){
                            $usuario->id_universidad = $id_universidad;
                            $usuario->id_carrera = $id_carrera;
                            $usuario->id_ciclo = $id_ciclo;
                        }
                        $usuario->save();
                    }elseif($modo=="P"){
                        $usuario = Usuario::find($usuario->id);
                        $usuario->nombres = $nombres;
                        $usuario->paterno = $paterno;
                        $usuario->materno = $materno;
                        $usuario->password = $password;
                        $usuario->correo = $correo;
                        $usuario->save();
                    }elseif($modo=="A"){
                        $usuario = Usuario::find($id);
                        $usuario->estado = "A";
                        $usuario->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalUsuarios').modal('hide');buscar();",
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

    public function Mantenimiento(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 15;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');

                return view('/mantenimiento',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
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

    public function Cuentas(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 1;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                return view('/cuentas',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
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

    public function MantenimientoCuentas(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 1;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $nombre = request()->input("nombre", "");
                    $numero = request()->input("numero", "");
                    if($modo=="N"){
                        $cuenta = new Cuenta();
                        $cuenta->nombre = $nombre;
                        $cuenta->numero = $numero;
                        $cuenta->save();
                    }elseif($modo=="E"){
                        $cuenta = Cuenta::find($id);
                        $cuenta->nombre = $nombre;
                        $cuenta->numero = $numero;
                        $cuenta->save();
                    }elseif($modo=="A"){
                        $cuenta = Cuenta::find($id);
                        $cuenta->estado = "A";
                        $cuenta->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalCuentas').modal('hide');buscar();",
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

    public function Ciclos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 2;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $ciclos = Ciclo::where("estado","N")->orderBy("nombre")->get();
                return view('/ciclos',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'ciclos'=>$ciclos,
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

    public function MantenimientoCiclos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 2;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $nombre = request()->input("nombre", "");
                    if($modo=="N"){
                        $ciclo = new Ciclo();
                        $ciclo->nombre = $nombre;
                        $ciclo->save();
                    }elseif($modo=="E"){
                        $ciclo = Ciclo::find($id);
                        $ciclo->nombre = $nombre;
                        $ciclo->save();
                    }elseif($modo=="A"){
                        $ciclo = Ciclo::find($id);
                        $ciclo->estado = "A";
                        $ciclo->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalCiclos').modal('hide');buscar();",
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

    public function Universidades(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 3;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                return view('/universidades',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
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

    public function MantenimientoUniversidades(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 3;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $nombre = request()->input("nombre", "");
                    if($modo=="N"){
                        $universidad = new Universidad();
                        $universidad->nombre = $nombre;
                        $universidad->save();
                    }elseif($modo=="E"){
                        $universidad = Universidad::find($id);
                        $universidad->nombre = $nombre;
                        $universidad->save();
                    }elseif($modo=="A"){
                        $universidad = Universidad::find($id);
                        $universidad->estado = "A";
                        $universidad->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalUniversidades').modal('hide');buscar();",
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

    public function Carreras(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 4;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                return view('/carreras',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
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

    public function MantenimientoCarreras(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 4;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $nombre = request()->input("nombre", "");
                    if($modo=="N"){
                        $carrera = new Carrera();
                        $carrera->nombre = $nombre;
                        $carrera->save();
                    }elseif($modo=="E"){
                        $carrera = Carrera::find($id);
                        $carrera->nombre = $nombre;
                        $carrera->save();
                    }elseif($modo=="A"){
                        $carrera = Carrera::find($id);
                        $carrera->estado = "A";
                        $carrera->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalCarreras').modal('hide');buscar();",
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

    public function Tipos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 7;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                return view('/tipos',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
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
    
    public function MantenimientoTipos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 7;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $nombre = request()->input("nombre", "");
                    if($modo=="N"){
                        $tipo = new Tipo();
                        $tipo->nombre = $nombre;
                        $tipo->save();
                    }elseif($modo=="E"){
                        $tipo = Tipo::find($id);
                        $tipo->nombre = $nombre;
                        $tipo->save();
                    }elseif($modo=="A"){
                        $tipo = Tipo::find($id);
                        $tipo->estado = "A";
                        $tipo->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalTipoUsuario').modal('hide');buscar();",
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

    public function Permisos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 8;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id_tipo = request()->input("id_tipo");
                $tipo = Tipo::find($id_tipo);
                $menus = Menu::where("estado","<>","A")
                        ->select("*")
                        ->selectRaw("(SELECT pe.id as id_permiso FROM permiso pe WHERE pe.estado<>'A' AND pe.id_menu = menu.id AND pe.id_tipo = $id_tipo)")
                        ->get();
                return view('/permisos',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'tipo'=>$tipo,
                    'menus'=>$menus,
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

    public function MantenimientoPermisos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 8;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id_tipo = request()->input("id_tipo", "");
                    $id = request()->input("id", "");
                    if($modo=="N"){
                        $permiso = new Permiso();
                        $permiso->id_tipo = $id_tipo;
                        $permiso->id_menu = $id;
                        $permiso->save();
                    }elseif($modo=="E"){
                        $permiso = Permiso::find($id);
                        $permiso->id_tipo = $id_tipo;
                        $permiso->save();
                    }elseif($modo=="A"){
                        $permiso = Permiso::find($id);
                        $permiso->estado = "A";
                        $permiso->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"location.reload();",
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

    public function Sedes(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 10;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                return view('/sedes',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
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

    public function MantenimientoSedes(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 10;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $nombre = request()->input("nombre", "");
                    $direccion = request()->input("direccion", "");
                    $telefono = request()->input("telefono", "");
                    $correo = request()->input("correo", "");
                    if($modo=="N"){
                        $sede = new Sede();
                        $sede->nombre = $nombre;
                        $sede->direccion = $direccion;
                        $sede->correo = $correo;
                        $sede->telefono = $telefono;
                        $sede->save();
                    }elseif($modo=="E"){
                        $sede = Sede::find($id);
                        $sede->nombre = $nombre;
                        $sede->direccion = $direccion;
                        $sede->correo = $correo;
                        $sede->telefono = $telefono;
                        $sede->save();
                    }elseif($modo=="A"){
                        $sede = Sede::find($id);
                        $sede->estado = "A";
                        $sede->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalSede').modal('hide');buscar();",
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

    public function Contenido(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 13;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                return view('/contenido',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
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

    public function MantenimientoContenidos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 13;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $nombre = request()->input("nombre", "");
                    $valor = request()->input("valor", "");
                    $valor3 = request()->input("valor3", "");
                    $tipo = request()->input("tipo", "");
                    $archivo = $request->file("archivo");
                    if($modo=="N"){
                        $contenido = new Contenido();
                        $contenido->nombre = $nombre;
                        $contenido->valor = $valor;
                        $contenido->tipo = $tipo;
                        $contenido->save();
                    }elseif($modo=="E"){
                        $contenido = Contenido::find($id);
                        $contenido->nombre = $nombre;
                        if($tipo=="1"){
                            $contenido->valor = $valor;
                        }else if($tipo=="2"){
                            $ext = $archivo->getClientOriginalExtension();
                            \Storage::disk('contenidos')->put("contenido_".$contenido->id.".".$ext,  \File::get($archivo));
                            $contenido->valor = "contenido_".$contenido->id.".".$ext;
                        }else{
                            $contenido->valor = $valor3;
                        }
                        $contenido->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalContenidos').modal('hide');buscar();",
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

    public function Perfil(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 14;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                return view('/perfil',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
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


    public function Staffs(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 17;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                return view('/staff',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
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

    public function MantenimientoStaff(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        DB::beginTransaction();
        try{
            if($this->ComprobarUsuario($usuario)){
                $menuid = 10;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $modo = request()->input("modo", "");
                    $id = request()->input("id", "");
                    $nombre = request()->input("nombre", "");
                    $cargo = request()->input("cargo", "");
                    $orden = request()->input("orden", "");
                    $archivo = $request->file("archivo");
                    if($modo=="N"){
                        $staff = new Staff();
                        $staff->nombre = $nombre;
                        $staff->cargo = $cargo;
                        $staff->orden = $orden;
                        $staff->save();
                        if($archivo!=null){
                            $ext = $archivo->getClientOriginalExtension();
                            \Storage::disk('staff')->put($staff->id.".".$ext,  \File::get($archivo));
                            $staff->extension = $ext;
                        }
                        $staff->save();
                    }elseif($modo=="E"){
                        $staff = Staff::find($id);
                        $staff->nombre = $nombre;
                        $staff->cargo = $cargo;
                        $staff->orden = $orden;
                        if($archivo!=null){
                            $ext = $archivo->getClientOriginalExtension();
                            \Storage::disk('staff')->put($id.".".$ext,  \File::get($archivo));
                            $staff->extension = $ext;
                        }
                        
                        $staff->save();
                    }elseif($modo=="A"){
                        $staff = Staff::find($id);
                        $staff->estado = "A";
                        $staff->save();
                    }
                    DB::commit();
                    return json_encode(array(
                        "correcto"=>true,
                        "url"=>"",
                        "ejecutar"=>"$('#modalStaffs').modal('hide');buscar();",
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
    