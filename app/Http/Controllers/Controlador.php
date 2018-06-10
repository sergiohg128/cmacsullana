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
use App\Contacto;
use App\Staff;
use Datetime;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
class Controlador extends Controller
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

    //SISTEMA
    
    public function Index(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        $mensaje = $request->session()->get('mensaje');
        $request->session()->forget('mensaje');

        $contenidos = Contenido::all();

        $lista = [];
        foreach($contenidos as $contenido){
            $lista[$contenido->id] = $contenido;
        }

        $sedes = Sede::where("estado","N")->orderBy("nombre")->get();
        $staffs = Staff::where("estado","N")->orderBy("orden")->get();

        if(!empty($usuario)){
            return redirect("/inicio");
        }else{
            return view('index',[
                'empresa'=>null,
                'mensaje'=>$mensaje,
                'contenidos'=>$lista,
                'sedes'=>$sedes,
                'staffs'=>$staffs
            ]);
        }
    }
    
    public function Login(Request $request,  Response $response) {
        $correo = $request->input('correo');
        $password = $request->input('password');
        $usuario = Usuario::where('correo',$correo)->first();
        if(!empty($usuario)){
            if($usuario->password==$password){
                if($usuario->estado=="N"){
                        $idtipousuario = $usuario->id_tipo;
                        $menus = Menu::
                        select("menu.*")
                        ->whereIn("menu.id",function($query) use ($idtipousuario){
                            $query->select("id_menu")->from("permiso")->where("id_tipo",$idtipousuario)->where("estado","N");
                        })->orderBy("menu.orden")->get();
                        $usuario->menus =$menus;
                        $request->session()->put('usuario', $usuario);
                        $request->session()->put('mensaje', "Bienvenido ".$usuario->nombre);
                        return redirect("/inicio");
                }else if($usuario->estado=="D"){
                    $request->session()->put('mensaje', "EL USUARIO HA SIDO DESACTIVADO");
                    return redirect("/index");
                }else{
                    $request->session()->put('mensaje', "EL USUARIO HA SIDO ELIMINADO");
                    return redirect("/index");
                }
            }else{
                $request->session()->put('mensaje', "LA CONTRASEÑA ES INCORRECTA");
            return redirect("/index");
            }
        }else{
            $request->session()->put('mensaje', "EL USUARIO ES INCORRECTO");
            return redirect("/index");
        }   
    }
    
    public function Logout(Request $request,  Response $response) {
        $request->session()->invalidate();
        return redirect("/index");
    } 
    
    public function Inicio(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $mensaje = $request->session()->get('mensaje');
            $request->session()->forget('mensaje');

            return view('/inicio',[
                'mensaje'=>$mensaje,
                'usuario'=>$usuario
            ]);
        }else{
            return redirect("/index");
            
        }
    }
    
    public function SubirArchivo(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $id = $request->input("id");
            $nombre = $request->input("nombre");
                DB::beginTransaction();
                try{
                    $file = Input::file("archivo");
                    if($file!=null){
                        $extension = $file->getClientOriginalExtension();
                        $archivo = new Archivo();
                        $archivo->id_mensaje = $id;
                        $archivo->nombre = $nombre;
                        $archivo->extension = $extension;
                        $archivo->save();

                        $nombre = $id.'.'.$archivo->extension;
                        Storage::disk('archivo')->put($nombre,\File::get($file));
                        DB::commit();
                        $request->session()->put("mensaje","Guardado correctamente");
                    }
                    else{
                        $request->session()->put("mensaje","No ha ingresado ningun archivo");
                    }
                } 
                catch (Exception $e) {
                    DB::rollback();
                    $error=$e->getMessage();
                    $request->session()->put("mensaje",$error."-line:".$e->getLine());
                }

            return redirect("/".$tipo."?id=".$id);
        }
        else{
            return redirect("/index");
        }
    }
    
    public function DescargarArchivo(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $archivo = Archivo::find($request->input("id"));
            
            $storage_path = storage_path();
            $url = $storage_path.'/app/archivo/'.$archivo->id.'.'.$archivo->extension;
            //verificamos si el archivo existe y lo retornamos
            if (Storage::disk('archivo')->exists($archivo->id.'.'.$archivo->extension))
            {
              $nombre = $archivo->nombre.'.'.$archivo->extension;
              return response()->download($url,$nombre);
            }
            //si no se encuentra lanzamos un error 404.
            abort(404);
        }else{
            return redirect("/index");
        }
    }


    public function Contacto(Request $request,  Response $response) {
        DB::beginTransaction();
        try{
            
            $nombre = request()->input("nombre", "");
            $correo = request()->input("correo", "");
            $telefono = request()->input("telefono", "");
            $universidad = request()->input("universidad", "");
            $carrera = request()->input("carrera", "");
            $skype = request()->input("skype", "");
            $fecha = request()->input("fecha", "");
            $hora = request()->input("hora", "");

            $tipo = request()->input("tipo", "C");

            $contacto = new Contacto();
            $contacto->nombre = $nombre;
            $contacto->correo = $correo;
            $contacto->telefono = $telefono;
            $contacto->universidad = $universidad;
            $contacto->carrera = $carrera;
            $contacto->tipo = $tipo;
            if($tipo=="S"){
                $contacto->skype = $skype;
                $contacto->fecha = $fecha;
                $contacto->hora = $hora;
            }
            $contacto->save();
            DB::commit();

            return redirect("/index?id=1");
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function Contactos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 16;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $contactos = Contacto::where("estado","N")->orderBy("id","desc")->get();
                return view('/contactos',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'contactos'=>$contactos,
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
}
    