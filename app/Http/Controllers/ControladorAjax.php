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
use App\Cuota; 
use Datetime;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

define("MAX_ITEM_LIST", 15);

class ControladorAjax extends Controller
{
    
    public function ListarTipoUsuario(){
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $nombre = request()->input("nombre", "");
        $estado = request()->input("estado", array());
        $tipos = Tipo::where("estado","<>","A");
        if($id>0){
            $tipos = $tipos->where("id",$id);
        }
        if(strlen($nombre)>0){
            $tipos = $tipos->where("nombre","ilike","%$nombre%");
        }
        if(count($estado)>0){
            $tipos = $tipos->whereIn("estado",$estado);
        }
        $tipos = $tipos->orderBy("nombre");
        if($modo == "tabla"){
            $tipos = $tipos->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $tipos->firstItem();
            foreach($tipos as $tipo){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = $tipo->nombre;
                $datos[$w][] = '<a href="permisos?id_tipo='.$tipo->id.'"><img class="icon-t" src="img/iconos/editar.svg" alt="Descargar"></a>';
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$tipo->id.');">';
                if($tipo->id>2){
                    $datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$tipo->id.');">';
                }
                $w++;
                $i++;
            }
            $tipos->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$tipos->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
                /*"currentPage"=>$tipos->currentPage(),
                "lastPage"=>$tipos->lastPage(),
                "perPage"=>$tipos->perPage(),
                "hasMorePages"=>$tipos->hasMorePages(),
                "nextPageUrl"=>$tipos->nextPageUrl(),
                "firstItem"=>$tipos->firstItem(),
                "lastItem"=>$tipos->lastItem(),
                "total"=>$tipos->total(),
                "count"=>$tipos->count(),*/
            ));
        }else{
            $tipos = $tipos->get();
            return json_encode($tipos);
        }
    }

    public function ListarSedes(){
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $nombre = request()->input("nombre", "");
        $direccion = request()->input("direccion", "");
        $telefono = request()->input("telefono", "");
        $correo = request()->input("correo", "");
        $estado = request()->input("estado", array());
        $sedes = Sede::where("estado","<>","A");
        if($id>0){
            $sedes = $sedes->where("id",$id);
        }
        if(strlen($nombre)>0){
            $sedes = $sedes->where("nombre","ilike","%$nombre%");
        }
        if(strlen($direccion)>0){
            $sedes = $sedes->where("direccion","ilike","%$direccion%");
        }
        if(strlen($telefono)>0){
            $sedes = $sedes->where("telefono","ilike","%$telefono%");
        }
        if(strlen($correo)>0){
            $sedes = $sedes->where("correo","ilike","%$correo%");
        }
        if(count($estado)>0){
            $sedes = $sedes->whereIn("estado",$estado);
        }
        $sedes = $sedes->orderBy("nombre");
        if($modo == "tabla"){
            $sedes = $sedes->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $sedes->firstItem();
            foreach($sedes as $sede){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = $sede->nombre;
                $datos[$w][] = $sede->direccion;
                $datos[$w][] = $sede->telefono;
                $datos[$w][] = $sede->correo;
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$sede->id.');">';
                $datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$sede->id.');">';
                $w++;
                $i++;
            }
            $sedes->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$sedes->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else{
            $sedes = $sedes->get();
            return json_encode($sedes);
        }
    }

    public function ListarCarreras(){
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $nombre = request()->input("nombre", "");
        $estado = request()->input("estado", array());
        $carreras = Carrera::where("estado","<>","A");
        if($id>0){
            $carreras = $carreras->where("id",$id);
        }
        if(strlen($nombre)>0){
            $carreras = $carreras->where("nombre","ilike","%$nombre%");
        }
        if(count($estado)>0){
            $carreras = $carreras->whereIn("estado",$estado);
        }
        $carreras = $carreras->orderBy("nombre");
        if($modo == "tabla"){
            $carreras = $carreras->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $carreras->firstItem();
            foreach($carreras as $carrera){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = $carrera->nombre;
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$carrera->id.');">';
                $datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$carrera->id.');">';
                $w++;
                $i++;
            }
            $carreras->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$carreras->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }elseif($modo == "tabla2"){
            $id_ciclo = request()->input("id_ciclo");
            $carreras = $carreras->select("*"); 
            $carreras = $carreras->selectRaw("(SELECT count(us.id) FROM usuario us WHERE us.estado = 'N' AND us.id_carrera = carrera.id AND us.id_ciclo = $id_ciclo) as alumnos"); 
            $carreras = $carreras->selectRaw("(SELECT count(py.id) FROM proyecto py INNER JOIN usuario us ON py.id_usuario = us.id WHERE py.estado='N' AND us.estado = 'N' AND us.id_carrera = carrera.id AND us.id_ciclo = $id_ciclo) as proyectos"); 
            $carreras = $carreras->selectRaw("(SELECT count(mg.id) FROM mensaje mg INNER JOIN proyecto py ON mg.id_proyecto = py.id INNER JOIN usuario us ON py.id_usuario = us.id WHERE mg.estado='N' AND py.estado='N' AND us.estado = 'N' AND us.id_carrera = carrera.id AND us.id_ciclo = $id_ciclo) as mensajes"); 
           
            $carreras = $carreras->get();
            $datos = array();
            $w = 0;
            $i = 1;
            foreach($carreras as $carrera){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = '<a href="ciclo-carrera-usuarios?ciclo='.$id_ciclo.'&carrera='.$carrera->id.'">'.$carrera->nombre.'</a>';
                $datos[$w][] = $carrera->alumnos; 
                $datos[$w][] = $carrera->proyectos; 
                $datos[$w][] = $carrera->mensajes;
                $w++;
                $i++;
            }
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>1,
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else{
            $carreras = $carreras->get();
            return json_encode($carreras);
        }
    }

    public function ListarUniversidades(){
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $nombre = request()->input("nombre", "");
        $estado = request()->input("estado", array());
        $universidades = Universidad::where("estado","N");
        if($id>0){
            $universidades = $universidades->where("id",$id);
        }
        if(strlen($nombre)>0){
            $universidades = $universidades->where("nombre","ilike","%$nombre%");
        }
        if(count($estado)>0){
            $universidades = $universidades->whereIn("estado",$estado);
        }
        $universidades = $universidades->orderBy("nombre");
        if($modo == "tabla"){
            $universidades = $universidades->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $universidades->firstItem();
            foreach($universidades as $universidad){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = $universidad->nombre;
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$universidad->id.');">';
                $datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$universidad->id.');">';
                $w++;
                $i++;
            }
            $universidades->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$universidades->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else{
            $universidades = $universidades->get();
            return json_encode($universidades);
        }
    }

    public function ListarCuentas(){
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $nombre = request()->input("nombre", "");
        $numero = request()->input("numero", "");
        $estado = request()->input("estado", array());
        $cuentas = Cuenta::where("estado","<>","A");
        if($id>0){
            $cuentas = $cuentas->where("id",$id);
        }
        if(strlen($nombre)>0){
            $cuentas = $cuentas->where("nombre","ilike","%$nombre%");
        }
        if(strlen($numero)>0){
            $cuentas = $cuentas->where("numero","ilike","%$numero%");
        }
        if(count($estado)>0){
            $cuentas = $cuentas->whereIn("estado",$estado);
        }
        $cuentas = $cuentas->orderBy("nombre");
        if($modo == "tabla"){
            $cuentas = $cuentas->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $cuentas->firstItem();
            foreach($cuentas as $cuenta){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = $cuenta->nombre;
                $datos[$w][] = $cuenta->numero;
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$cuenta->id.');">';
                $datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$cuenta->id.');">';
                $w++;
                $i++;
            }
            $cuentas->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$cuentas->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else{
            $cuentas = $cuentas->get();
            return json_encode($cuentas);
        }
    }

    public function ListarCuotas(){ 
        $modo = request()->input("modo", ""); 
        $id = request()->input("id", 0); 
        $detalle = request()->input("detalle", ""); 
        $monto = request()->input("monto", ""); 
        $fecha = request()->input("fecha", ""); 
        $id_proyecto = request()->input("id_proyecto", ""); 
        $estado = request()->input("estado", array()); 
        $cuotas = Cuota::where("estado","<>","A"); 
        if($id>0){ 
            $cuotas = $cuotas->where("id",$id); 
        } 
        if(strlen($detalle)>0){ 
            $cuotas = $cuotas->where("detalle","ilike","%$detalle%"); 
        } 
        if(strlen($monto)>0){ 
            $cuotas = $cuotas->where("monto",$monto); 
        } 
        if(strlen($fecha)>0){ 
            $cuotas = $cuotas->where("fecha",$fecha); 
        } 
        if($id_proyecto>0){ 
            $cuotas = $cuotas->where("id_proyecto",$id_proyecto); 
        } 
        if(count($estado)>0){ 
            $cuotas = $cuotas->whereIn("estado",$estado); 
        } 
        $cuotas = $cuotas->orderBy("fecha","DESC"); 
        if($modo == "tabla"){ 
            $cuotas = $cuotas->select("*"); 
            $cuotas = $cuotas->selectRaw("(SELECT sum(pg.monto) FROM pago pg WHERE pg.estado<>'A' AND pg.id_cuota = cuota.id) as pagos"); 
            $cuotas = $cuotas->paginate(MAX_ITEM_LIST); 
            $datos = array(); 
            $w = 0; 
            $i = $cuotas->firstItem(); 
            foreach($cuotas as $cuota){ 
                $datos[$w] = array(); 
                $datos[$w][] = $i; 
                $datos[$w][] = $cuota->detalle; 
                $datos[$w][] = "S/ ".number_format($cuota->monto,2); 
                $datos[$w][] = date_format(date_create($cuota->fecha), "d/m/Y"); 
                $datos[$w][] = "S/ ".((empty($cuota->pagos)?"0.00": number_format($cuota->pagos,2))); 
                $datos[$w][] = '<a href="pagos?cuota='.$cuota->id.'"><img class="icon-t" src="img/iconos/editar.svg" alt="Descargar"></a>';
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$cuota->id.');">'; 
                $datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$cuota->id.');">'; 
                $w++; 
                $i++; 
            } 
            $cuotas->setPath(request()->fullUrl()); 
            return json_encode(array( 
                "datos"=>$datos, 
                "Npaginas"=>$cuotas->lastPage(), 
                "href"=> request()->fullUrl()."&", 
                "Npaginacion"=>10, 
            )); 
        }elseif($modo == "cuotapendiente"){
            $fecini = request()->input("fecini"); 
            $fecfin = request()->input("fecfin"); 
            $cuotas = $cuotas->where(function($query){ 
                $query->whereRaw("monto > (SELECT sum(pg.monto) FROM pago pg WHERE pg.estado<>'A' AND pg.id_cuota = cuota.id)") 
                        ->orWhereRaw("(SELECT count(pg2.id) FROM pago pg2 WHERE pg2.estado<>'A' AND pg2.id_cuota = cuota.id) = 0"); 
            }); 
            if(strlen($fecini)>0){ 
                $cuotas = $cuotas->where("fecha",">=",$fecini); 
            } 
            if(strlen($fecfin)>0){ 
                $cuotas = $cuotas->where("fecha","<=",$fecfin); 
            } 
            $cuotas = $cuotas->select("*"); 
            $cuotas = $cuotas->selectRaw("(SELECT sum(pg.monto) FROM pago pg WHERE pg.estado<>'A' AND pg.id_cuota = cuota.id) as pagos"); 
            $cuotas = $cuotas->get(); 
            $datos = array(); 
            $w = 0; 
            $i = 1; 
            foreach($cuotas as $cuota){ 
                $datos[$w] = array(); 
                $datos[$w][] = $i; 
                $datos[$w][] = $cuota->proyecto->usuario->nombres." ".$cuota->proyecto->usuario->paterno." ".$cuota->proyecto->usuario->materno; 
                $datos[$w][] = $cuota->detalle; 
                $datos[$w][] = date_format(date_create($cuota->fecha), "d/m/Y"); 
                $datos[$w][] = "S/ ".$cuota->monto; 
                $datos[$w][] = "S/ ".((empty($cuota->pagos)?"0.00": number_format($cuota->pagos,2)));
                if($cuota->pagos>0){
                    $datos[$w][] = "S/ ".($cuota->monto-$cuota->pagos);     
                }else{
                    $datos[$w][] = "S/ ".$cuota->monto; 
                }
                $w++; 
                $i++; 
            } 
            return json_encode(array( 
                "datos"=>$datos, 
                "Npaginas"=>1000, 
                "href"=> "&", 
                "Npaginacion"=>10, 
            )); 
        }
        else{ 
            $cuotas = $cuotas->get(); 
            return json_encode($cuotas); 
        } 
    } 

    public function ListarContenidos(){
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $nombre = request()->input("nombre", "");
        $valor = request()->input("valor", "");
        $tipo = request()->input("tipo", "");
        $contenidos = Contenido::query();
        if($id>0){
            $contenidos = $contenidos->where("id",$id);
        }
        if(strlen($nombre)>0){
            $contenidos = $contenidos->where("nombre","ilike","%$nombre%");
        }
        if(strlen($valor)>0){
            $contenidos = $contenidos->where("valor","ilike","%$valor%");
        }
        if(strlen($tipo)>0){
            $contenidos = $contenidos->where("tipo",$tipo);
        }
        $contenidos = $contenidos->orderBy("id");
        if($modo == "tabla"){
            $contenidos = $contenidos->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $contenidos->firstItem();
            foreach($contenidos as $contenido){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = $contenido->nombre;
                if($contenido->tipo==1){
                    $datos[$w][] = empty($contenido->valor)?"":$contenido->valor;
                }else if($contenido->tipo==2){
                    $datos[$w][] = "SUBIR ARCHIVO";
                }else{
                    $datos[$w][] = empty($contenido->valor)?"":$contenido->valor;
                }
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$contenido->id.');">';
                //$datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$contenido->id.');">';
                $w++;
                $i++;
            }
            $contenidos->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$contenidos->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else{
            $contenidos = $contenidos->get();
            return json_encode($contenidos);
        }
    }

    public function ListarUsuarios(){
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $nombre = request()->input("nombre", "");
        $paterno = request()->input("paterno", "");
        $materno = request()->input("materno", "");
        $correo = request()->input("correo", "");
        $password = request()->input("password", "");
        $celular = request()->input("celular", "");
        $ciudad = request()->input("ciudad", "");
        $id_sede = request()->input("id_sede", "0");
        $id_tipo = request()->input("id_tipo", "0");
        $id_ciclo = request()->input("id_ciclo", "0");
        $id_universidad = request()->input("id_universidad", "0");
        $id_carrera = request()->input("id_carrera", "0");
        $estado = request()->input("estado", array());
        $usuarios = Usuario::where("estado","<>","A");
        if($id>0){
            $usuarios = $usuarios->where("id",$id);
        }
        if(strlen($nombre)>0){
            $usuarios = $usuarios->where("nombres","ilike","%$nombre%");
        }
        if(strlen($paterno)>0){
            $usuarios = $usuarios->where("paterno","ilike","%$paterno%");
        }
        if(strlen($materno)>0){
            $usuarios = $usuarios->where("materno","ilike","%$materno%");
        }
        if(strlen($correo)>0){
            $usuarios = $usuarios->where("correo","ilike","%$correo%");
        }
        if(strlen($password)>0){
            $usuarios = $usuarios->where("password",$password);
        }
        if(strlen($celular)>0){
            $usuarios = $usuarios->where("celular","ilike","%$celular%");
        }
        if(strlen($ciudad)>0){
            $usuarios = $usuarios->where("ciudad","ilike","%$ciudad%");
        }
        if($id_sede>0){
            $usuarios = $usuarios->where("id_sede",$id_sede);
        }
        if($id_tipo>0){
            $usuarios = $usuarios->where("id_tipo",$id_tipo);
        }
        if($id_ciclo>0){
            $usuarios = $usuarios->where("id_ciclo",$id_ciclo);
        }
        if($id_universidad>0){
            $usuarios = $usuarios->where("id_universidad",$id_universidad);
        }
        if($id_carrera>0){
            $usuarios = $usuarios->where("id_carrera",$id_carrera);
        }
        $usuarios = $usuarios->orderBy("paterno")->orderBy("materno")->orderBy("nombres");
        if($modo == "tabla"){
            $usuarios = $usuarios->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $usuarios->firstItem();
            foreach($usuarios as $usuario){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = $usuario->completo();
                $datos[$w][] = $usuario->correo;
                $datos[$w][] = $usuario->celular;
                $datos[$w][] = $usuario->tipousuario->nombre;
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$usuario->id.');">';
                if($usuario->id>1){
                    $datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$usuario->id.');">';
                }
                $w++;
                $i++;
            }
            $usuarios->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$usuarios->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }elseif($modo == "tabla2"){
            $id_ciclo = request()->input("id_ciclo");
            $id_carrera = request()->input("id_carrera");
            $usuarios = $usuarios->where("id_ciclo",$id_ciclo)->where("id_carrera",$id_carrera);
            $usuarios = $usuarios->select("*"); 
            $usuarios = $usuarios->selectRaw("(SELECT count(py.id) FROM proyecto py WHERE py.id_usuario = usuario.id AND py.estado='N' AND usuario.id_carrera = $id_carrera AND usuario.id_ciclo = $id_ciclo) as proyectos"); 
            $usuarios = $usuarios->selectRaw("(SELECT count(mg.id) FROM mensaje mg INNER JOIN proyecto py ON mg.id_proyecto = py.id WHERE py.id_usuario = usuario.id AND mg.estado='N' AND py.estado='N' AND usuario.id_carrera = $id_carrera AND usuario.id_ciclo = $id_ciclo) as mensajes"); 
            
            $usuarios = $usuarios->get();
            $datos = array();
            $w = 0;
            $i = 1;
            foreach($usuarios as $usuario){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = '<a href="proyectos?id='.$usuario->id.'">'.$usuario->completo().'</a>';
                $datos[$w][] = $usuario->correo;
                $datos[$w][] = $usuario->celular;
                $datos[$w][] = $usuario->proyectos; 
                $datos[$w][] = $usuario->mensajes; 
                $w++;
                $i++;
            }
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>1,
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else{
            $usuarios = $usuarios->get();
            return json_encode($usuarios);
        }
    }

    public function ListarCiclos(){
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $nombre = request()->input("nombre", "");
        $estado = request()->input("estado", array());
        $ciclos = Ciclo::where("estado","<>","A");
        if($id>0){
            $ciclos = $ciclos->where("id",$id);
        }
        if(strlen($nombre)>0){
            $ciclos = $ciclos->where("nombre","ilike","%$nombre%");
        }
        if(count($estado)>0){
            $ciclos = $ciclos->whereIn("estado",$estado);
        }
        $ciclos = $ciclos->orderBy("nombre");
        if($modo == "tabla"){
            $ciclos = $ciclos->select("*"); 
            $ciclos = $ciclos->selectRaw("(SELECT count(us.id) FROM usuario us WHERE us.estado = 'N' AND us.id_ciclo = ciclo.id) as alumnos"); 
            $ciclos = $ciclos->selectRaw("(SELECT count(py.id) FROM proyecto py INNER JOIN usuario us ON py.id_usuario = us.id WHERE py.estado='N' AND us.estado = 'N' AND us.id_ciclo = ciclo.id) as proyectos"); 
            $ciclos = $ciclos->selectRaw("(SELECT count(mg.id) FROM mensaje mg INNER JOIN proyecto py ON mg.id_proyecto = py.id INNER JOIN usuario us ON py.id_usuario = us.id WHERE mg.estado='N' AND py.estado='N' AND us.estado = 'N' AND us.id_ciclo = ciclo.id) as mensajes"); 
            
            $ciclos = $ciclos->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $ciclos->firstItem();
            foreach($ciclos as $ciclo){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = '<a href="ciclo-carreras?id='.$ciclo->id.'">'.$ciclo->nombre.'</a></td>';
                $datos[$w][] = $ciclo->alumnos; 
                $datos[$w][] = $ciclo->proyectos; 
                $datos[$w][] = $ciclo->mensajes; 
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$ciclo->id.');">';
                $datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$ciclo->id.');">';
                $w++;
                $i++;
            }
            $ciclos->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$ciclos->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else{
            $ciclos = $ciclos->get();
            return json_encode($ciclos);
        }
    }

    public function ListarProyectos(){
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $nombre = request()->input("nombre", "");
        $tipo = request()->input("tipo", "");
        $id_usuario = request()->input("id_usuario", "0");
        $estado = request()->input("estado", array());
        $proyectos = Proyecto::where("estado","<>","A");
        if($id>0){
            $proyectos = $proyectos->where("id",$id);
        }
        if(strlen($nombre)>0){
            $proyectos = $proyectos->where("nombre","ilike","%$nombre%");
        }
        if(strlen($tipo)>0){
            $proyectos = $proyectos->where("tipo",$tipo);
        }
        if($id_usuario>0){
            $proyectos = $proyectos->where("id_usuario",$id_usuario);
        }
        if(count($estado)>0){
            $proyectos = $proyectos->whereIn("estado",$estado);
        }
        $proyectos = $proyectos->orderBy("nombre");
        if($modo == "tabla"){
            $proyectos = $proyectos->select("*"); 
            $proyectos = $proyectos->selectRaw("(SELECT count(mg.id) FROM mensaje mg WHERE mg.id_proyecto = proyecto.id AND mg.estado='N') as mensajes"); 
           
            $proyectos = $proyectos->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $proyectos->firstItem();
            foreach($proyectos as $proyecto){
                $datos[$w] = array();
                $datos[$w][] = $i;
                //$datos[$w][] = $proyecto->nombre;
                if($proyecto->tipo==1){
                    $datos[$w][] = "PROYECTO";
                }else{
                    $datos[$w][] = "INFORME";
                }
                $datos[$w][] = '<a href="mensajes?id='.$proyecto->id.'"><img class="icon-t" src="img/iconos/editar.svg" alt="Descargar"></a> ('.$proyecto->mensajes.')'; 
                $datos[$w][] = '<a href="archivos?p='.$proyecto->id.'"><img class="icon-t" src="img/iconos/editar.svg" alt="Descargar"></a>';
                $datos[$w][] = '<a href="cuotas?id='.$proyecto->id.'"><img class="icon-t" src="img/iconos/editar.svg" alt="Descargar"></a>'; 
                //$datos[$w][] = '<a href="pagos?id='.$proyecto->id.'"><img class="icon-t" src="img/iconos/editar.svg" alt="Descargar"></a>';
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$proyecto->id.');">';
                //$datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$proyecto->id.');">';
                $w++;
                $i++;
            }
            $proyectos->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$proyectos->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else{
            $proyectos = $proyectos->get();
            return json_encode($proyectos);
        }
    }

    public function ListarMensajes(Request $request,  Response $response){
        $usuario = $request->session()->get('usuario');
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $titulo = request()->input("titulo", "");
        $contenido = request()->input("contenido", "");
        $fecini = request()->input("fecini", "");
        $fecfin = request()->input("fecfin", "");
        $id_proyecto = request()->input("id_proyecto", "0");
        $id_usuario = request()->input("id_usuario", "0");
        //$estado = request()->input("estado", array());
        $mensajes = Mensaje::query();
        if($id>0){
            $mensajes = $mensajes->where("id",$id);
        }
        if(strlen($titulo)>0){
            $mensajes = $mensajes->where("nombre","ilike","%$titulo%");
        }
        if(strlen($contenido)>0){
            $mensajes = $mensajes->where("tipo","ilike","%$contenido%");
        }
        if(strlen($fecini)>0){
            $mensajes = $mensajes->where("fecha",">=",$fecini);
        }
        if(strlen($fecfin)>0){
            $mensajes = $mensajes->where("fecha","<=",$fecfin);
        }
        if($id_proyecto>0){
            $mensajes = $mensajes->where("id_proyecto",$id_proyecto);
        }
        if($id_usuario>0){
            $mensajes = $mensajes->where("id_usuario",$id_usuario);
        }
        $mensajes = $mensajes->whereIn("estado",array("N","V")); 
        $mensajes = $mensajes->orderBy("fecha");
        if($modo == "tabla"){
            $mensajes = $mensajes->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $mensajes->firstItem();
            foreach($mensajes as $mensaje){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = $mensaje->titulo;
                $datos[$w][] = $mensaje->contenido;
                if($mensaje->estado == "N"){ 
                    $datos[$w][] = '<input type="checkbox" name="" readonly="" onchange="AlertaEliminar(\'¿MARCAR COMO LEIDO?\',\'mantenimiento/mensajes\',\'_token='.session("_token").'&modo=ES&estado=V&id='.$mensaje->id.'\',\'buscar();\');console.log($(this));$(this).prop(\'checked\',false);">'; 
                }else{ 
                    $datos[$w][] = '<input type="checkbox" name="" readonly="" onchange="AlertaEliminar(\'¿MARCAR COMO PENDIENTE?\',\'mantenimiento/mensajes\',\'_token='.session("_token").'&modo=ES&estado=N&id='.$mensaje->id.'\',\'buscar();\');console.log($(this));$(this).prop(\'checked\',true);" checked="">'; 
                } 
                $datos[$w][] = date_format(date_create($mensaje->fecha), "d/m/Y h:i A");
                $datos[$w][] = $mensaje->usuario->completo();
                if(!empty($mensaje->archivo())){
//                    $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="archivo('.$mensaje->archivo->id.');">';
                    $datos[$w][] = '<a href="archivos?m='.$mensaje->id.'"><img class="icon-t" src="img/iconos/editar.svg" alt="Descargar"></a>';
                }else{
                    $datos[$w][] = '';
                }
//                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$mensaje->id.');">';
                if($usuario->id_tipo==1){
                    $datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$mensaje->id.');">';
                }
                $w++;
                $i++;
            }
            $mensajes->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$mensajes->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else{
            $mensajes = $mensajes->get();
            return json_encode($mensajes);
        }
    }

    public function DescargarArchivo(){
        $id_archivo = request()->input("id");
        $archivo = Archivo::find($id_archivo);
        
        $storage_path = storage_path();
        $url = $storage_path.'/app/archivo/'.$archivo->id.'.'.$archivo->extension;
        
        if (Storage::disk('archivo')->exists($archivo->id.'.'.$archivo->extension))
        {
          $nombre = $archivo->nombre;
          return response()->download($url,$nombre);
        }
        
        abort(404);
    }

    public function ListarPagos(Request $request,  Response $response){
        $usuario = $request->session()->get('usuario');
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $id_cuota = request()->input("id_cuota", 0);
        $pagos = Pago::query();
        if($id!=null){
            $pagos = $pagos->where("pago.id",$id);
        }
        if($id_cuota!=null){
            $pagos = $pagos->where("id_cuota",$id_cuota);
        }
        $pagos = $pagos->where("pago.estado","<>","A"); 
        $pagos = $pagos->orderBy("fecha");
        if($modo == "tabla"){
            $pagos = $pagos->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $pagos->firstItem();
            foreach($pagos as $pago){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = 'S/ '.$pago->monto; 
                $datos[$w][] = date('d/m/Y',strtotime($pago->fecha)); 
                if($pago->cuota==null){ 
                    $datos[$w][] = "-"; 
                }else{ 
                    $datos[$w][] = $pago->cuota->detalle; 
                } 
                if($pago->cuenta==null){
                    $datos[$w][] = "-";
                }else{
                    $datos[$w][] = $pago->cuenta->nombre;
                }
                $datos[$w][] = $pago->operacion;
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$pago->id.');">';
                if($usuario->id_tipo==1){
                    $datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$pago->id.');">';
                }
                $w++;
                $i++;
            }
            $pagos->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$pagos->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else if($modo=="pagorealizado"){
            $fecini = request()->input("fecini"); 
            $fecfin = request()->input("fecfin"); 
            if(strlen($fecini)>0){ 
                $pagos = $pagos->where("fecha",">=",$fecini); 
            } 
            if(strlen($fecfin)>0){ 
                $pagos = $pagos->where("fecha","<=",$fecfin); 
            }
            $pagos = $pagos->get(); 
            $datos = array(); 
            $w = 0; 
            $i = 1; 
            foreach($pagos as $pago){ 
                $datos[$w] = array(); 
                $datos[$w][] = $i; 
                $datos[$w][] = $pago->cuota->proyecto->usuario->nombres." ".$pago->cuota->proyecto->usuario->paterno." ".$pago->cuota->proyecto->usuario->materno; 
                $datos[$w][] = date_format(date_create($pago->fecha), "d/m/Y");
                $datos[$w][] = "S/ ".$pago->monto; 
                $datos[$w][] = $pago->operacion; 
                $w++; 
                $i++; 
            } 
            return json_encode(array( 
                "datos"=>$datos, 
                "Npaginas"=>1000, 
                "href"=> "&", 
                "Npaginacion"=>10, 
            )); 
        }else{
            $pagos = $pagos->get();
            return json_encode($pagos);
        }
    }

    public function ListarContactos(){
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $contactos = Contacto::where("estado","<>","A");
        if($id!=null){
            $contactos = $contactos->where("id",$id);
        }
        $contactos = $contactos->orderBy("id","desc");
        if($modo == "tabla"){
            $contactos = $contactos->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $contactos->firstItem();
            foreach($contactos as $contacto){
                $datos[$w] = array();
                $datos[$w][] = $i;
                if($contacto->tipo=="C"){
                    $datos[$w][] = "Correo";
                }else{
                    $datos[$w][] = "Skype";
                }
                $datos[$w][] = $contacto->nombre;
                $datos[$w][] = $contacto->correo;
                $datos[$w][] = $contacto->telefono;
                $datos[$w][] = $contacto->universidad;
                $datos[$w][] = $contacto->carrera;
                if($contacto->skype==null){
                    $datos[$w][] = "";
                }else{
                    $datos[$w][] = $contacto->skype;
                }
                if($contacto->fecha!=null){
                    $datos[$w][] = date('d/m/Y',strtotime($contacto->fecha)).' '.date('H:i',strtotime($contacto->hora));
                }else{
                    $datos[$w][] = "";
                }
                $datos[$w][] = date('d/m/Y H:i',strtotime($contacto->registro));
                $w++;
                $i++;
            }
            $contactos->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$contactos->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else{
            $contactos = $contactos->get();
            return json_encode($contactos);
        }
    }
    
    public function ListarStaffs(){
        $modo = request()->input("modo", "");
        $id = request()->input("id", 0);
        $staffs = Staff::where("estado","<>","A");
        if($id!=null){
            $staffs = $staffs->where("id",$id);
        }
        $staffs = $staffs->orderBy("nombre");
        if($modo == "tabla"){
            $staffs = $staffs->paginate(MAX_ITEM_LIST);
            $datos = array();
            $w = 0;
            $i = $staffs->firstItem();
            foreach($staffs as $staff){
                $datos[$w] = array();
                $datos[$w][] = $i;
                $datos[$w][] = $staff->nombre;
                $datos[$w][] = $staff->cargo;
                $datos[$w][] = $staff->orden;
                $datos[$w][] = '<img class="icon-t" src="img/iconos/editar.svg" alt="Editar" onclick="editar('.$staff->id.');">';
                $datos[$w][] = '<img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar('.$staff->id.');">';
                $w++;
                $i++;
            }
            $staffs->setPath(request()->fullUrl());
            return json_encode(array(
                "datos"=>$datos,
                "Npaginas"=>$staffs->lastPage(),
                "href"=> request()->fullUrl()."&",
                "Npaginacion"=>10,
            ));
        }else{
            $staffs = $staffs->get();
            return json_encode($staffs);
        }
    }
}