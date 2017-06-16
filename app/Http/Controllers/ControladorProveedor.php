<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Area;
use App\AreaSucursal;
use App\Bitacora;
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
use Illuminate\Support\Facades\Input;


class ControladorProveedor extends Controller
{
    
    private function ComprobarUsuario($proveedor){
        if(empty($proveedor)){
            return FALSE;
        }
        if(empty($proveedor->id)){
            return FALSE;
        }
        if($proveedor->id==null){
            return FALSE;
        }
        if($proveedor->id==0){
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

    public function Proveedores(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 10;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $proveedores = Proveedor::where('estado','N')->orderBy('razon')->paginate(10);
                $departamentos = Departamento::orderBy("nombre")->get();
                $paises = Pais::orderBy("nombre")->get();
                return view('/proveedores',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'proveedores'=>$proveedores,
                    'departamentos'=>$departamentos,
                    'paises'=>$paises,
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
    
    public function Proveedor(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            DB::beginTransaction();
            try{
                $razon = $request->input("razon");
                $ruc = $request->input("ruc");
                $contacto = $request->input("contacto");
                $direccion = $request->input("direccion");
                $fijo = $request->input("fijo");
                $celular = $request->input("celular");
                $correo = $request->input("correo");
                $pagina = $request->input("pagina");
                $tipo = $request->input("tipo");
                $pais = $request->input("pais");
                $distrito = $request->input("distrito");
                $codigopostal = $request->input("codigopostal");
                
                $existe = Proveedor::where("correo",$correo)->first();
                if($existe==null){
                    $existe = Usuario::where("correo",$correo)->first();
                    if($existe==null){
                        if($modo=="agregar"){
                            $proveedor = new Proveedor();
                            $proveedor->razon = $razon;
                            $proveedor->ruc = $ruc;
                            $proveedor->contacto = $contacto;
                            $proveedor->direccion = $direccion;
                            $proveedor->fijo= $fijo;
                            $proveedor->celular = $celular;
                            $proveedor->correo = $correo;
                            $proveedor->pagina = $pagina;
                            $proveedor->tipo = $tipo;
                            $proveedor->id_pais = $pais;
                            $proveedor->id_distrito = $distrito;
                            $proveedor->codigopostal = $codigopostal;
                            $proveedor->save();
                            new Bitacora("proveedor","nuevo",$razon,$usuario->id);
                        }
                        DB::commit();
                        $request->session()->put("mensaje","Guardado correctamente");
                        return json_encode(["ok"=>true,"obj"=>$proveedor]);
                    }else{
                        return json_encode(["ok"=>false,"error"=>"Existe un usuario con el correo ingresado"]);
                    }
                }else{
                    return json_encode(["ok"=>false,"error"=>"Existe un proveedor con el correo ingresado"]);
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
}
    