<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Archivo;
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
use App\TipoCaso;
use App\TipoEquipo;
use App\TipoSolucion;
use App\TipoSucursal;
use App\TipoTerritorio;
use App\TipoUsuario;
use App\Traslado;
use App\Usuario;
use App\Zona;
use Datetime;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;


class ControladorContratos extends Controller
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

    public function Proveedores(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            if($modo=="ajax"){
                try {
                    $proveedores = Proveedor::where('estado','N')->orderBy('razon')->get();
                    return json_encode(["ok"=>true,"obj"=>$proveedores]);
                } catch (Exception $ex) {
                    return json_encode(["ok"=>false,$ex->getMessage()]);
                }
            }else{
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
                            $request->session()->put("mensaje","Guardado correctamente");
                        }
                        DB::commit();
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
    
    public function VerProveedor(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $proveedor = Proveedor::
                    leftJoin("distrito","proveedor.id_distrito","distrito.id")->
                    leftJoin("provincia","distrito.id_provincia","provincia.id")->
                    leftJoin("departamento","provincia.id_departamento","departamento.id")->
                    leftJoin("pais","proveedor.id_pais","pais.id")->
                    select("proveedor.*","distrito.nombre as dinombre","provincia.nombre as prnombre","departamento.nombre as denombre","pais.nombre as panombre")->
                    where("proveedor.id",$request->input("id"))->first();
            return json_encode(["obj"=>$proveedor]);
        }
    }
    
    public function Contratos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            if($modo=="ajax"){
                try {
                    $contratos = Contrato::select("id","numero")->where("id_proveedor",$request->input("id_proveedor"))->get();
                    return json_encode(["ok"=>true,"obj"=>$contratos]);
                } catch (Exception $ex) {
                    return json_encode(["ok"=>false,"error"=>$ex->getMessage()]);
                }
            }else{
                $menuid = 12;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $contratos = Contrato::whereNotNull("id");
                    $proveedores = Proveedor::where('estado','N')->orderBy('razon')->get();

                    $desde = $request->input("desde");
                    $hasta = $request->input("hasta");
                    $idproveedor = $request->input("id_proveedor");
                    $hoy = date('Y-m-d');
                    $anio = date('Y');

                    if($idproveedor>0){
                        $contratos = $contratos->where("id_proveedor",$idproveedor);
                    }
                    if(!empty($desde)){
                        $contratos = $contratos->where(function($query) use($desde){
                            $query->where("inicio",">=",$desde)->orWhere("fin",">=",$desde);
                        });
                    }else{
                        $desde = $anio.'-01-01';
                    }
                    if(!empty($hasta)){
                        $contratos = $contratos->where(function($query) use($hasta){
                            $query->where("inicio","<=",$hasta.' 23:59:59')->orWhere("fin","<=",$hasta.' 23:59:59');
                        });
                    }else{
                        $hasta = $hoy;
                    }
                    $contratos = $contratos->orderBy('numero','desc')->paginate(50);
                    return view('/contratos',[
                        'usuario'=>$usuario,
                        'mensaje'=>$mensaje,
                        'contratos'=>$contratos,
                        'proveedores'=>$proveedores,
                        'desde'=>$desde,
                        'hasta'=>$hasta,
                        'idproveedor'=>$idproveedor,
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
    
    public function ContratoNuevo(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 17;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                
                $proveedores = Proveedor::where('estado','N')->orderBy('razon')->get();
                $modelos = Modelo::join("marca","modelo.id_marca","marca.id")
                        ->select("modelo.*","marca.nombre as nombremarca")
                        ->where("modelo.estado","N")
                        ->orderBy("marca.nombre")->get();
                return view('/contrato-nuevo',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'proveedores'=>$proveedores,
                    'modelos'=>$modelos,
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
    
    public function ContratoPost(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $numero = trim($request->input("numero"));
            $existe = Contrato::where("numero",$numero)->first();
            if($existe==null){
                $idproveedor = $request->input("proveedor");
                $fecha = $request->input("fecha");
                $inicio = $request->input("inicio");
                $fin = $request->input("fin");
                $descripcion = $request->input("descripcion");
                DB::beginTransaction();
                try{
                    $contrato = new Contrato();
                    $contrato->numero = $numero;
                    $contrato->id_proveedor = $idproveedor;
                    $contrato->fecha = $fecha;
                    $contrato->inicio = $inicio;
                    $contrato->fin = $fin;
                    $contrato->descripcion = $descripcion;
                    $contrato->tipo = "C";
                    $contrato->save();
                    DB::commit();
                    $request->session()->put("mensaje","Guardado correctamente");
                    return json_encode(["ok"=>true,"contrato"=>$contrato->id]);
                } 
                catch (Exception $e) {
                    DB::rollback();
                    $error=$e->getMessage();
                    return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
                }
            }else{
                return json_encode(["ok"=>false,"error"=>"El contrato número ".$existe->numero." ya se ha registrado anteriormente"]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function ContratoDetalle(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 17;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                $contrato = Contrato::find($id);
                $modelos = Modelo::join("marca","modelo.id_marca","marca.id")
                        ->join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")
                        ->select("modelo.*","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipo")
                        ->where("modelo.estado","N")
                        ->orderBy("tipo_equipo.nombre")
                        ->orderBy("marca.nombre")
                        ->orderBy("modelo.nombre")
                        ->get();
                return view('/contrato-detalle',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'modelos'=>$modelos,
                    'contrato'=>$contrato,
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
    
    public function ContratoDetallePost(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $id = $request->input("id");
            $idmodelos = $request->input("idmodelos");
            $cantidades = $request->input("cantidades");
            $contrato = Contrato::find($id);
            $tiposequipo = [];
            DB::beginTransaction();
            try{
                if($contrato->estado=="N"){
                    $contrato->estado = "D";
                    $contrato->save();
                    for($i=0;$i<count($idmodelos);$i++){
                        $detalle = new DetalleContrato();
                        $detalle->id_modelo = $idmodelos[$i];
                        $detalle->id_contrato = $contrato->id;
                        $detalle->cantidad = $cantidades[$i];
                        $detalle->save();
                        $modelo = Modelo::find($detalle->id_modelo);
                        $tiposequipo[$modelo->id_tipo_equipo] = 1;
                    }
                    
                    $tiposterritorio = TipoTerritorio::where("estado","N")->orderBy("nombre")->get();
                    
                    foreach($tiposequipo as $idtipoequipo => $valor){
                        foreach($tiposterritorio as $tipoterritorio){
                            $sla = new Sla();
                            $sla->id_contrato = $id;
                            $sla->id_tipo_equipo = $idtipoequipo;
                            $sla->id_tipo_territorio = $tipoterritorio->id;
                            $sla->save();
                        }
                    }
                    DB::commit();
                    $request->session()->put("mensaje","Guardado correctamente");
                    return json_encode(["ok"=>true,"contrato"=>$contrato->id]);
                }else{
                    DB::rollback();
                    $request->session()->put("mensaje","Ya se ha registrado el detalle anteriormente");
                    return json_encode(["ok"=>false,"contrato"=>$contrato->id]);
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
    
    public function ContratoSla(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 17;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                $contrato = Contrato::find($id);
                $slas = Sla::join("tipo_territorio","sla.id_tipo_territorio","tipo_territorio.id")
                        ->join("tipo_equipo","sla.id_tipo_equipo","tipo_equipo.id")
                        ->select("tipo_territorio.nombre as nombrett","sla.id","sla.id_tipo_equipo","sla.horas")
                        ->where("sla.id_contrato",$id)
                        ->orderBy("tipo_equipo.nombre")
                        ->orderBy("tipo_territorio.nombre")
                        ->get();
                $tiposequipo = Sla::join("tipo_equipo","sla.id_tipo_equipo","tipo_equipo.id")
                        ->select("tipo_equipo.nombre","tipo_equipo.id")
                        ->where("sla.id_contrato",$id)
                        ->orderBy("tipo_equipo.nombre")
                        ->groupBy("tipo_equipo.nombre","tipo_equipo.id")
                        ->get();
                return view('/contrato-sla',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'slas'=>$slas,
                    'contrato'=>$contrato,
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
    
    public function ContratoSlaPost(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $id = $request->input("id");
            $ids = $request->input("ids");
            $horas = $request->input("horas");
            $contrato = Contrato::find($id);
            DB::beginTransaction();
            try{
                $contrato->estado = "S";
                $contrato->save();
                for($i=0;$i<count($ids);$i++){
                    $sla = Sla::find($ids[$i]);
                    if($sla->id_contrato==$id){
                        $sla->horas = $horas[$i];
                        $sla->save();
                    }
                }
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return redirect ("/contrato?id=".$id);
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
    
    public function Contrato(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 18;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                $contrato = Contrato::find($id);
                if($contrato->estado=="N"){
                    $request->session()->put("mensaje","Elija los productos del contrato");
                    return redirect("/contrato-detalle?id=".$id);
                }else if($contrato->estado=="D"){
                    $request->session()->put("mensaje","Registre los SLA del contrato");
                    return redirect("/contrato-sla?id=".$id);
                }else{
                    $sucursal = Sucursal::find($contrato->id_sucursal);
                    $proveedor = Proveedor::find($contrato->id_proveedor);
                    $detalles = DetalleContrato::
                            leftJoin("producto","detalle_contrato.id","producto.id_detalle_contrato")->
                            join("modelo","detalle_contrato.id_modelo","modelo.id")->
                            join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                            join("marca","modelo.id_marca","marca.id")->
                            select("modelo.nombre as nombremodelo","tipo_equipo.nombre as nombretipoequipo","marca.nombre as nombremarca","detalle_contrato.cantidad",DB::raw("count(producto.id) as productosguia"))->
                            where("detalle_contrato.id_contrato",$id)->
                            groupBy("modelo.nombre","tipo_equipo.nombre","marca.nombre","detalle_contrato.cantidad")->
                            orderBy("tipo_equipo.nombre")->
                            orderBy("marca.nombre")->
                            orderBy("modelo.nombre")->
                            get();
                    $slas = Sla::join("tipo_territorio","sla.id_tipo_territorio","tipo_territorio.id")
                            ->join("tipo_equipo","sla.id_tipo_equipo","tipo_equipo.id")
                            ->select("sla.id_tipo_equipo","tipo_territorio.nombre as nombrett","tipo_equipo.nombre as nombrete","sla.horas")
                            ->where("sla.id_contrato",$id)
                            ->orderBy("tipo_equipo.nombre")
                            ->orderBy("tipo_territorio.nombre")
                            ->get();
                    $tiposterritorio = Sla::
                            select(DB::raw("count(distinct(sla.id_tipo_territorio)) as total"))
                            ->where("sla.id_contrato",$id)
                            ->first();
                    $guias = Guia::where("id_contrato",$id)->get();
                    $archivo = Archivo::where("numero",$id)->where("tipo","contrato")->where("estado","N")->first();
                    return view('/contrato',[
                        'usuario'=>$usuario,
                        'mensaje'=>$mensaje,
                        'detalles'=>$detalles,
                        'contrato'=>$contrato,
                        'sucursal'=>$sucursal,
                        'proveedor'=>$proveedor,
                        'guias'=>$guias,
                        'slas'=>$slas,
                        'tiposterritorio'=>$tiposterritorio,
                        'archivo'=>$archivo,
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
    
    public function GuiaNueva(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 17;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $modelosguia = [];
                $request->session()->put("modelosguia", $modelosguia);
                
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                $contrato = Contrato::find($id);
                $modelos = DetalleContrato::
                        leftJoin("producto","detalle_contrato.id","producto.id_detalle_contrato")
                        ->join("modelo","detalle_contrato.id_modelo","modelo.id")
                        ->join("marca","modelo.id_marca","marca.id")
                        ->join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")
                        ->select("detalle_contrato.id","tipo_equipo.nombre as nombretipo","marca.nombre as nombremarca","modelo.nombre as nombremodelo","detalle_contrato.cantidad",DB::raw("count(producto.id) as registrados"))
                        ->where("detalle_contrato.id_contrato",$id)
                        ->groupBy("detalle_contrato.id","tipo_equipo.nombre","marca.nombre","modelo.nombre","detalle_contrato.cantidad")
                        ->orderBy("tipo_equipo.nombre")
                        ->orderBy("marca.nombre")
                        ->orderBy("modelo.nombre")
                        ->get();
                $sucursales = Sucursal::where("estado","N")->orderBy("nombre")->get();
                return view('/guia-nueva',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'modelos'=>$modelos,
                    'contrato'=>$contrato,
                    'sucursales'=>$sucursales,
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
    
    public function GuiaDetalle(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            try{
                $tipo = $request->input("tipo");
                $idmodelo = $request->input("modelo");
                $idcontrato = $request->input("contrato");
                $modelos = $request->session()->get("modelosguia");
                $cantidad = $request->input("cantidad");
                if(empty($modelos)){
                    $modelos = [];
                }
                $errores = [];
                if($tipo==1){
                    $ruta =Input::file("excel")->getRealPath();
                    $archivo = \PHPExcel_IOFactory::createReader('Excel2007');
                    $objPHPExcel = $archivo->load($ruta);
                    $sheet = $objPHPExcel->getSheet(0);
                    for ($w = 1; $w <= $sheet->getHighestRow(); $w++) {
                        $serie = $sheet->getCell("A".$w)->getFormattedValue();
                        if(strlen(trim($serie))>0){
                            $existe = Producto::where("serie",$serie)->first();
                            if($existe==null){
                                if(!array_key_exists($idmodelo, $modelos)){
                                    $modelo = DetalleContrato::
                                        join("modelo","detalle_contrato.id_modelo","modelo.id")->
                                        join("marca","modelo.id_marca","marca.id")->
                                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                                        select("modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo")->
                                        where("detalle_contrato.id",$idmodelo)->
                                        where("detalle_contrato.id_contrato",$idcontrato)->first();
                                    $modelos[$idmodelo][0] = [];
                                    $modelos[$idmodelo][1] = $modelo->nombretipoequipo.' '.$modelo->nombremarca.' '.$modelo->nombremodelo;
                                    $modelos[$idmodelo][2] = 0;
                                }
                                $modelos[$idmodelo][3] = $cantidad;
                                if(!array_key_exists($serie, $modelos[$idmodelo][0])){
                                    $modelos[$idmodelo][2] = $modelos[$idmodelo][2]+1;
                                    $modelos[$idmodelo][0][$serie] = 1;
                                }else{
                                    $modelos[$idmodelo][0][$serie] = $modelos[$idmodelo][0][$serie] + 1;
                                }
                            }else{
                                $existe = Producto::
                                    join("modelo","producto.id_modelo","modelo.id")->
                                    join("marca","modelo.id_marca","marca.id")->
                                    join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                                    join("sucursal","producto.id_sucursal","sucursal.id")->
                                    select("modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal")->
                                    where("serie",$serie)->first();
                                $errores[$serie] = "La serie se ha registrado anteriormente en el producto: ".$existe->nombretipoequipo." "."$existe->nombremarca"." ".$existe->nombremodelo." y se encuentra en la sucursal ".$existe->nombresucursal;
                            }
                        }
                    }
                }else if($tipo==2){
                    $serie = $request->input("serie");
                    if(strlen(trim($serie))>0){
                        $existe = Producto::where("serie",$serie)->first();
                        if($existe==null){
                            if(!array_key_exists($idmodelo, $modelos)){
                                $modelo = DetalleContrato::
                                        join("modelo","detalle_contrato.id_modelo","modelo.id")->
                                        join("marca","modelo.id_marca","marca.id")->
                                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                                        select("modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo")->
                                        where("detalle_contrato.id",$idmodelo)->
                                        where("detalle_contrato.id_contrato",$idcontrato)->first();
                                $modelos[$idmodelo][0] = [];
                                $modelos[$idmodelo][1] = $modelo->nombretipoequipo.' '.$modelo->nombremarca.' '.$modelo->nombremodelo;
                                $modelos[$idmodelo][2] = 0;
                            }
                            $modelos[$idmodelo][3] = $cantidad;
                            if(!array_key_exists($serie, $modelos[$idmodelo][0])){
                                $modelos[$idmodelo][2] = $modelos[$idmodelo][2]+1;
                                $modelos[$idmodelo][0][$serie] = 1;
                            }else{
                                $modelos[$idmodelo][0][$serie] = $modelos[$idmodelo][0][$serie] + 1;
                            }
                        }else{
                            $existe = Producto::
                                join("modelo","producto.id_modelo","modelo.id")->
                                join("marca","modelo.id_marca","marca.id")->
                                join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                                join("sucursal","producto.id_sucursal","sucursal.id")->
                                select("modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal")->
                                where("serie",$serie)->first();
                            $errores[$serie] = "La serie se ha registrado anteriormente en el producto: ".$existe->nombretipoequipo." "."$existe->nombremarca"." ".$existe->nombremodelo." y se encuentra en la sucursal ".$existe->nombresucursal;
                        }
                    }else{
                        $errores["-"] = "No ha ingresado ninguna serie";
                    }
                }else if($tipo==4){
                    $modelo = $request->input("modelo");
                    unset($modelos[$modelo]);
                }else if($tipo==5){
                    $modelo = $request->input("modelo");
                    $producto = $request->input("producto");
                    if(array_key_exists($producto, $modelos[$modelo][0])){
                        unset($modelos[$modelo][0][$producto]);
                        $modelos[$modelo][2] = $modelos[$modelo][2]-1;
                    }
                }
                if(count($errores)>0){
                    return json_encode(["ok"=>false,"errores"=>$errores]);
                }else{
                    $request->session()->put("modelosguia", $modelos);
                    return json_encode(["ok"=>true,"lista"=>$modelos]);
                }
            } catch (Exception $ex) {
                return json_encode(["ok"=>false,"error"=>$ex->getMessage()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function GuiaPost(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $numero = $request->input("numero");
            $id = $request->input("id");
            $contrato = Contrato::find($id);
            $existe = Guia::join("contrato","guia.id_contrato","contrato.id")->
                    where("guia.numero",$numero)
                    ->where("contrato.id_proveedor",$contrato->id_proveedor)
                    ->where("contrato.tipo","C")
                    ->first();
            if($existe==null){
                $modelos = $request->session()->get("modelosguia");
                if(empty($modelos)){
                    return json_encode(["ok"=>false,"error"=>"No hay productos ha agregar"]);
                }
                DB::beginTransaction();
                try{
                    if($contrato->estado=="N"){
                        DB::rollback();
                        $request->session()->put("mensaje","Debe registrar el detalle del contrato primero");
                        return json_encode(["ok"=>false,"contrato-detalle"=>$contrato->id]);
                    }if($contrato->estado=="D"){
                        DB::rollback();
                        $request->session()->put("mensaje","Debe registrar el sla de los productos primero");
                        return json_encode(["ok"=>false,"contrato-sla"=>$contrato->id]);
                    }
                    else{
                        $guia = new Guia();
                        $guia->numero = $numero;
                        $guia->comentario = $request->input("comentario");
                        $guia->id_contrato = $contrato->id;
                        $guia->id_sucursal = $request->input("sucursal");
                        $guia->fecha = $request->input("fecha");
                        $guia->save();
                        foreach($modelos as $key => $modelo){
                            $productos = $modelo[0];
                            $detalle = DetalleContrato::find($key);
                            foreach($productos as $serie => $cantidad){
                                $producto = new Producto();
                                $producto->id_modelo = $detalle->id_modelo;
                                $producto->id_detalle_contrato = $detalle->id;
                                $producto->id_sucursal = $guia->id_sucursal;
                                $producto->id_guia = $guia->id;
                                $producto->serie = $serie;
                                $producto->save();
                            }
                        }
                        DB::commit();
                        $modelosguia = [];
                        $request->session()->put("modelosguia", $modelosguia);
                        $request->session()->put("mensaje", "Guardado correctamente");
                        return json_encode(["ok"=>true,"guia"=>$guia->id]);
                    }
                } 
                catch (Exception $e) {
                    DB::rollback();
                    $producto = Producto::
                            join("modelo","producto.id_modelo","modelo.id")->
                            join("marca","modelo.id_marca","marca.id")->
                            join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                            join("detalle_contrato","producto.id_detalle_contrato","detalle_contrato.id")->
                            join("contrato","detalle_contrato.id_contrato","contrato.id")->
                            join("guia","producto.id_guia","guia.id")->
                            select("modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipo","contrato.numero as numerocontrato","guia.numero as numeroguia","guia.fecha as fechaguia")->
                            where("serie",$serie)->first();
                    if($producto!=null){
                        DB::rollback();
                        return json_encode(["ok"=>false,"error"=>"La serie ".$serie." ya se ha registrado anteriormente en el producto: ".$producto->nombretipo." ".$producto->nombremarca." ".$producto->nombremodelo." en el contrato ".$producto->numerocontrato." con guia número ".$producto->numeroguia." registrada en la fecha ".date('d/m/Y',strtotime($producto->fechaguia))]);
                    }else{
                        DB::rollback();
                        $error=$e->getMessage();
                        return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
                    }
                }
            }else{
                DB::rollback();
                $proveedor = Proveedor::find($contrato->id_proveedor);
                return json_encode(["ok"=>false,"error"=>"La guia número ".$existe->numero." del proveedor ".$proveedor->razon." ya se ha registrado anteriormente"]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    
    public function Guia(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 18;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                $guia = Guia::find($id);
                $detalles = Producto::
                        join("modelo","producto.id_modelo","modelo.id")->
                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                        join("marca","modelo.id_marca","marca.id")->
                        select("producto.id_detalle_contrato","modelo.nombre as nombremodelo","tipo_equipo.nombre as nombretipoequipo","marca.nombre as nombremarca",DB::raw("count(*) as cantidad"),DB::raw("count(serie) as series"))->
                        where("producto.id_guia",$id)->
                        groupBy("producto.id_detalle_contrato","modelo.nombre","tipo_equipo.nombre","marca.nombre")->
                        orderBy("tipo_equipo.nombre")->
                        orderBy("marca.nombre")->
                        orderBy("modelo.nombre")->
                        get();
                $archivo = Archivo::where("numero",$id)->where("tipo","guia")->where("estado","N")->first();
                return view('/guia',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'detalles'=>$detalles,
                    'guia'=>$guia,
                    'archivo'=>$archivo,
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
    
    public function GuiaSeries(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 18;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $idguia = $request->input("g");
                $guia = Guia::find($idguia);
                $iddetalle = $request->input("d");
                $detalle = DetalleContrato::
                        join("modelo","detalle_contrato.id_modelo","modelo.id")->
                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                        join("marca","modelo.id_marca","marca.id")->
                        select("modelo.nombre as nombremodelo","tipo_equipo.nombre as nombretipoequipo","marca.nombre as nombremarca")->
                        where("detalle_contrato.id",$iddetalle)->first();
                $productos = Producto::where("id_guia",$idguia)->where("id_detalle_contrato",$iddetalle)->orderBy("serie")->get();
                return view('/guia-series',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'detalle'=>$detalle,
                    'productos'=>$productos,
                    'guia'=>$guia,
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
    
    public function ContratoSeries(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 28;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                $producto = Producto::
                        join("detalle_contrato","producto.id_detalle_contrato","detalle_contrato.id")->
                        join("contrato","detalle_contrato.id_contrato","contrato.id")->
                        join("modelo","producto.id_modelo","modelo.id")->
                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                        join("marca","modelo.id_marca","marca.id")->
                        select("contrato.numero","modelo.nombre as nombremodelo","tipo_equipo.nombre as nombretipoequipo","marca.nombre as nombremarca")->
                        where("producto.id_detalle_contrato",$id)->
                        first();
                $detalles = Producto::where("id_detalle_contrato",$id)->whereNotNull("serie")->orderBy("id")->get();
                $existen = count($detalles);
                return view('/contrato-series',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'producto'=>$producto,
                    'detalles'=>$detalles,
                    'existen'=>$existen,
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
    
    public function AgregarSerie(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            DB::beginTransaction();
            try{
                $producto = Producto::find($request->input("id"));
                if($producto->serie==null){
                    $serie = trim($request->input("serie"));
                    $producto->serie = $serie;
                    $producto->save();
                    DB::commit();
                    return json_encode(["ok"=>true]);
                }else{
                    DB::rollback();
                    return json_encode(["ok"=>false,"error"=>"La serie de este producto ya ha sido registrada anteriormente con serie ".$producto->serie,"serie"=>$producto->serie]);
                }
            } 
            catch (Exception $e) {
                DB::rollback();
                return json_encode(["ok"=>false,"error"=>"La serie ya ha sido registrada anteriormente"]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function CompraNueva(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 17;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $modeloscompra = [];
                $request->session()->put("modeloscompra", $modeloscompra);
                
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $modelos = Modelo::
                        join("marca","modelo.id_marca","marca.id")
                        ->join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")
                        ->select("modelo.id","tipo_equipo.nombre as nombretipo","marca.nombre as nombremarca","modelo.nombre as nombremodelo")
                        ->where("modelo.estado","N")
                        ->where("tipo_equipo.estado","N")
                        ->where("marca.estado","N")
                        ->orderBy("tipo_equipo.nombre")
                        ->orderBy("marca.nombre")
                        ->orderBy("modelo.nombre")
                        ->get();
                $sucursales = Sucursal::where("estado","N")->orderBy("nombre")->get();
                $proveedores = Proveedor::where("estado","N")->orderBy("razon")->get();
                return view('/compra-nueva',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'modelos'=>$modelos,
                    'sucursales'=>$sucursales,
                    'proveedores'=>$proveedores,
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
    
    public function CompraDetalle(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            try{
                $tipo = $request->input("tipo");
                $idmodelo = $request->input("modelo");
                $modelos = $request->session()->get("modeloscompra");
                $cantidad = $request->input("cantidad");
                if(empty($modelos)){
                    $modelos = [];
                }
                $errores = [];
                if($tipo==1){
                    $ruta =Input::file("excel")->getRealPath();
                    $archivo = \PHPExcel_IOFactory::createReader('Excel2007');
                    $objPHPExcel = $archivo->load($ruta);
                    $sheet = $objPHPExcel->getSheet(0);
                    for ($w = 1; $w <= $sheet->getHighestRow(); $w++) {
                        $serie = $sheet->getCell("A".$w)->getFormattedValue();
                        if(strlen(trim($serie))>0){
                            $existe = Producto::where("serie",$serie)->first();
                            if($existe==null){
                                if(!array_key_exists($idmodelo, $modelos)){
                                    $modelo = Modelo::
                                        join("marca","modelo.id_marca","marca.id")->
                                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                                        select("modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo")->
                                        where("modelo.id",$idmodelo)->first();
                                    $modelos[$idmodelo][0] = [];
                                    $modelos[$idmodelo][1] = $modelo->nombretipoequipo.' '.$modelo->nombremarca.' '.$modelo->nombremodelo;
                                    $modelos[$idmodelo][2] = 0;
                                }
                                $modelos[$idmodelo][3] = $cantidad;
                                if(!array_key_exists($serie, $modelos[$idmodelo][0])){
                                    $modelos[$idmodelo][2] = $modelos[$idmodelo][2]+1;
                                    $modelos[$idmodelo][0][$serie] = 1;
                                }else{
                                    $modelos[$idmodelo][0][$serie] = $modelos[$idmodelo][0][$serie] + 1;
                                }
                            }else{
                                $existe = Producto::
                                    join("modelo","producto.id_modelo","modelo.id")->
                                    join("marca","modelo.id_marca","marca.id")->
                                    join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                                    join("sucursal","producto.id_sucursal","sucursal.id")->
                                    select("modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal")->
                                    where("serie",$serie)->first();
                                $errores[$serie] = "La serie se ha registrado anteriormente en el producto: ".$existe->nombretipoequipo." "."$existe->nombremarca"." ".$existe->nombremodelo." y se encuentra en la sucursal ".$existe->nombresucursal;
                            }
                        }
                    }
                }else if($tipo==2){
                    $serie = $request->input("serie");
                    if(strlen(trim($serie))>0){
                        $existe = Producto::where("serie",$serie)->first();
                        if($existe==null){
                            if(!array_key_exists($idmodelo, $modelos)){
                                $modelo = Modelo::
                                        join("marca","modelo.id_marca","marca.id")->
                                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                                        select("modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo")->
                                        where("modelo.id",$idmodelo)->first();
                                $modelos[$idmodelo][0] = [];
                                $modelos[$idmodelo][1] = $modelo->nombretipoequipo.' '.$modelo->nombremarca.' '.$modelo->nombremodelo;
                                $modelos[$idmodelo][2] = 0;
                            }
                            $modelos[$idmodelo][3] = $cantidad;
                            if(!array_key_exists($serie, $modelos[$idmodelo][0])){
                                $modelos[$idmodelo][2] = $modelos[$idmodelo][2]+1;
                                $modelos[$idmodelo][0][$serie] = 1;
                            }else{
                                $modelos[$idmodelo][0][$serie] = $modelos[$idmodelo][0][$serie] + 1;
                            }
                        }else{
                            $existe = Producto::
                                join("modelo","producto.id_modelo","modelo.id")->
                                join("marca","modelo.id_marca","marca.id")->
                                join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                                join("sucursal","producto.id_sucursal","sucursal.id")->
                                select("modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal")->
                                where("serie",$serie)->first();
                            $errores[$serie] = "La serie se ha registrado anteriormente en el producto: ".$existe->nombretipoequipo." "."$existe->nombremarca"." ".$existe->nombremodelo." y se encuentra en la sucursal ".$existe->nombresucursal;
                        }
                    }else{
                        $errores["-"] = "No ha ingresado ninguna serie";
                    }
                }else if($tipo==4){
                    $modelo = $request->input("modelo");
                    unset($modelos[$modelo]);
                }else if($tipo==5){
                    $modelo = $request->input("modelo");
                    $producto = $request->input("producto");
                    if(array_key_exists($producto, $modelos[$modelo][0])){
                        unset($modelos[$modelo][0][$producto]);
                        $modelos[$modelo][2] = $modelos[$modelo][2]-1;
                    }
                }
                if(count($errores)>0){
                    return json_encode(["ok"=>false,"errores"=>$errores]);
                }else{
                    $request->session()->put("modeloscompra", $modelos);
                    return json_encode(["ok"=>true,"lista"=>$modelos]);
                }
            } catch (Exception $ex) {
                return json_encode(["ok"=>false,"error"=>$ex->getMessage()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function CompraPost(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $numero = $request->input("numero");
            $proveedor = $request->input("proveedor");
            DB::beginTransaction();
            $contrato = new Contrato();
            $contrato->numero = "COMPRA";
            $contrato->fecha = $request->input("fecha");
            $contrato->id_proveedor = $proveedor;
            $contrato->tipo = "A";
            $contrato->save();
            
            $modelos = $request->session()->get("modeloscompra");
            if(empty($modelos)){
                return json_encode(["ok"=>false,"error"=>"No hay productos ha agregar"]);
            }
            try{
                $guia = new Guia();
                $guia->numero = $numero;
                $guia->comentario = $request->input("comentario");
                $guia->id_contrato = $contrato->id;
                $guia->id_sucursal = $request->input("sucursal");
                $guia->fecha = $request->input("fecha");
                $guia->save();
                foreach($modelos as $key => $modelo){
                    $productos = $modelo[0];
                    $detalle = new DetalleContrato();
                    $detalle->id_contrato = $contrato->id;
                    $detalle->id_modelo = $key;
                    $detalle->cantidad = count($productos);
                    $detalle->save();
                    foreach($productos as $serie => $cantidad){
                        $producto = new Producto();
                        $producto->id_modelo = $detalle->id_modelo;
                        $producto->id_detalle_contrato = $detalle->id;
                        $producto->id_sucursal = $guia->id_sucursal;
                        $producto->id_guia = $guia->id;
                        $producto->serie = $serie;
                        $producto->save();
                    }
                }
                DB::commit();
                $modelosguia = [];
                $request->session()->put("modeloscompra", $modelosguia);
                $request->session()->put("mensaje", "Guardado correctamente");
                return json_encode(["ok"=>true,"compra"=>$contrato->id]);
            } 
            catch (Exception $e) {
                DB::rollback();
                $producto = Producto::
                        join("modelo","producto.id_modelo","modelo.id")->
                        join("marca","modelo.id_marca","marca.id")->
                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                        join("detalle_contrato","producto.id_detalle_contrato","detalle_contrato.id")->
                        join("contrato","detalle_contrato.id_contrato","contrato.id")->
                        join("guia","producto.id_guia","guia.id")->
                        select("modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipo","contrato.numero as numerocontrato","guia.numero as numeroguia","guia.fecha as fechaguia")->
                        where("serie",$serie)->first();
                if($producto!=null){
                    DB::rollback();
                    return json_encode(["ok"=>false,"error"=>"La serie ".$serie." ya se ha registrado anteriormente en el producto: ".$producto->nombretipo." ".$producto->nombremarca." ".$producto->nombremodelo." en el contrato ".$producto->numerocontrato." con guia número ".$producto->numeroguia." registrada en la fecha ".date('d/m/Y',strtotime($producto->fechaguia))]);
                }else{
                    DB::rollback();
                    $error=$e->getMessage();
                    return json_encode(["ok"=>false,"error"=>$error."-line:".$e->getLine()]);
                }
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function Compra(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 18;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                $guia = Guia::where("id_contrato",$id)->first();
                $detalles = Producto::
                        join("modelo","producto.id_modelo","modelo.id")->
                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                        join("marca","modelo.id_marca","marca.id")->
                        select("modelo.nombre as nombremodelo","tipo_equipo.nombre as nombretipoequipo","marca.nombre as nombremarca",DB::raw("count(*) as cantidad"))->
                        where("producto.id_guia",$guia->id)->
                        groupBy("modelo.nombre","tipo_equipo.nombre","marca.nombre")->
                        orderBy("tipo_equipo.nombre")->
                        orderBy("marca.nombre")->
                        orderBy("modelo.nombre")->
                        get();
                return view('/compra',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'detalles'=>$detalles,
                    'guia'=>$guia,
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
    
    public function Casos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 14;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $casos = Caso::
                        join("producto","caso.id_producto","producto.id")->
                        join("modelo","producto.id_modelo","modelo.id")->
                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                        join("marca","modelo.id_marca","marca.id")->
                        select("caso.*","modelo.nombre as nombremodelo","tipo_equipo.nombre as nombretipoequipo","marca.nombre as nombremarca","producto.serie")->
                        orderBy("fecha","desc")->paginate(50);
                return view('/casos',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'casos'=>$casos,
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
    
    public function CasoNuevo(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 15;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $sucursales = Sucursal::where("estado","N")->orderBy("nombre")->get();
                return view('/caso-nuevo',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'sucursales'=>$sucursales,
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
    
    public function CasoSerie(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            try{
                $serie = $request->input("serie");
                $producto = Producto::
                        leftJoin("area_sucursal","producto.id_area_sucursal","area_sucursal.id")->
                        leftJoin("area","area_sucursal.id_area","area.id")->
                        join("modelo","producto.id_modelo","modelo.id")->
                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                        join("marca","modelo.id_marca","marca.id")->
                        join("sucursal","producto.id_sucursal","sucursal.id")->
                        join("detalle_contrato","producto.id_detalle_contrato","detalle_contrato.id")->
                        join("contrato","detalle_contrato.id_contrato","contrato.id")->
                        leftJoin("proveedor","contrato.id_proveedor","proveedor.id")->
                        select("area.nombre as nombrearea","producto.id","producto.id_detalle_contrato","producto.id_modelo","producto.id_sucursal","modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal","proveedor.razon as nombreproveedor","contrato.numero","contrato.tipo as tipocontrato")->
                        where("serie",$serie)->first();
                if($producto!=null){
                    if($producto->tipocontrato=="C"){
                        $producto->sla = $producto->sla();
                    }
                    return json_encode(["ok"=>true,"obj"=>$producto]);
                }else{
                    return json_encode(["ok"=>false,"error"=>"No se encontró la serie"]);
                }
            } catch (Exception $ex) {
                $error = $ex->getMessage();
                return json_encode(["ok"=>false,"error"=>$error]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function CasoPost(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $id = $request->input("id");
            DB::beginTransaction();
            try{
                $ultimo = Caso::orderBy("id","desc")->first();
                $anio = date("Y");
                $documento = Documento::find(1);
                if($ultimo!=null){
                    $anioanterior = substr($ultimo->numero, 2,4);
                    if($anioanterior!=$anio){
                        $documento->siguiente = 1;
                        $documento->save();
                    }
                }
                
                $siguiente = $documento->siguiente;
                $codigo = strval($siguiente);
                for($i=0;$i<(6-strlen($siguiente));$i++){
                    $codigo = '0'.$codigo;
                }
                
                $producto = Producto::find($id);
                
                $caso = new Caso();
                $caso->sla = $request->input("sla");
                $caso->numero = $documento->codigo.$anio.$codigo;
                $caso->id_producto = $id;
                $caso->id_sucursalorigen = $producto->id_sucursal;
                $caso->problema = $request->input("problema");;
                $caso->usuario = $request->input("usuario");
                $caso->celular = $request->input("celular");
                $caso->anexo = $request->input("anexo");
                $caso->correo = $request->input("correo");
                $caso->save();
                $documento->siguiente = $siguiente+1;
                $documento->save();
                DB::commit();
                $request->session()->put("mensaje", "Guardado correctamente");
                return json_encode(["ok"=>true,"caso"=>$caso->id]);
            } catch (Exception $e) {
                DB::rollback();
                $error = $e->getMessage().'-linea:'.$e->getLine();
                return json_encode(["ok"=>false,"error"=>$error]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function Caso(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 28;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $caso = Caso::find($request->input("id"));
                $producto = Producto::
                    join("modelo","producto.id_modelo","modelo.id")->
                    join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                    join("marca","modelo.id_marca","marca.id")->
                    leftJoin("area_sucursal","producto.id_area_sucursal","area_sucursal.id")->
                    leftJoin("area","area_sucursal.id_area","area.id")->
                    join("sucursal","producto.id_sucursal","sucursal.id")->
                    join("detalle_contrato","producto.id_detalle_contrato","detalle_contrato.id")->
                    join("contrato","detalle_contrato.id_contrato","contrato.id")->
                    leftJoin("proveedor","contrato.id_proveedor","proveedor.id")->
                    select("producto.id","producto.serie","producto.id_detalle_contrato","producto.id_modelo","producto.id_sucursal","modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal","proveedor.razon as nombreproveedor","area.nombre as nombrearea","contrato.numero","contrato.tipo as tipocontrato","modelo.id_tipo_equipo","modelo.id_marca")->
                    where("producto.id",$caso->id_producto)->first();
                $reemplazo = null;
                if($caso->id_reemplazo!=null){
                    $reemplazo = Producto::
                            join("modelo","producto.id_modelo","modelo.id")->
                            join("marca","modelo.id_marca","marca.id")->
                            join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                            select("producto.serie","modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo")->
                            where("producto.id",$caso->id_reemplazo)->first();
                }
                
                $marcas = null;
                $modelos = null;
                $productos = null;
                if($caso->estado=="D"){
                    $marcas = Modelo::join("marca","modelo.id_marca","marca.id")
                            ->join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")
                            ->select("marca.id","marca.nombre")
                            ->where("modelo.id_tipo_equipo",$producto->id_tipo_equipo)
                            ->where("marca.estado","N")
                            ->groupBy("marca.id","marca.nombre")
                            ->orderBy("marca.nombre")->get();

                    $modelos = Modelo::where("id_marca",$producto->id_marca)
                            ->where("id_tipo_equipo",$producto->id_tipo_equipo)
                            ->where("estado","N")
                            ->orderBy("nombre")->get();
                    $productos = Producto::where("estado","N")->where("id_sucursal",$producto->id_sucursal)->where("id_modelo",$producto->id_modelo)->where("id","<>",$producto->id)->get();
                }
                
                $tecnicos = Tecnico::where("estado","N")->get();
                $tiposcaso = TipoCaso::all();
                $tipossolucion= TipoSolucion::all();
                $tipossucursal = TipoSucursal::where("estado","N")->orderBy("nombre")->get();
                return view('/caso',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'caso'=>$caso,
                    'producto'=>$producto,
                    'tecnicos'=>$tecnicos,
                    'tiposcaso'=>$tiposcaso,
                    'tipossucursal'=>$tipossucursal,
                    'tipossolucion'=>$tipossolucion,
                    'reemplazo'=>$reemplazo,
                    'marcas'=>$marcas,
                    'modelos'=>$modelos,
                    'productos'=>$productos,
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
    
    public function CasoAsignarTecnico(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $id = $request->input("id");
            DB::beginTransaction();
            try{
                $caso = Caso::find($id);
                if($caso!=null){
                    if($caso->estado=="N"){
                        $caso->id_tecnico = $request->input("tecnico");
                        $caso->estado = "T";
                        $caso->fechat = date("Y-m-d H:i");
                        $caso->save();
                        DB::commit();
                        $request->session()->put("mensaje", "Guardado correctamente");
                        return json_encode(["ok"=>true,"caso"=>$caso->id]);
                    }else{
                        DB::rollback();
                        return json_encode(["ok"=>false,"error"=>"Ya se ha asignado un técnico anteriormente"]);
                    }
                }else{
                    DB::rollback();
                    return json_encode(["ok"=>false,"error"=>"Caso no encontrado"]);
                }
                    
            } catch (Exception $e) {
                DB::rollback();
                $error = $e->getMessage().'-linea:'.$e->getLine();
                return json_encode(["ok"=>false,"error"=>$error]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function CasoDetalle(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $id = $request->input("id");
            DB::beginTransaction();
            try{
                $caso = Caso::find($id);
                if($caso!=null){
                    if($caso->estado=="T"){
                        $caso->analisis = $request->input("analisis");
                        $caso->conclusion = $request->input("conclusion");
                        $caso->id_tipo_caso = $request->input("tipocaso");
                        $caso->fechad = date("Y-m-d H:i");
                        $tipocaso = TipoCaso::find($request->input("tipocaso"));
                        $tiposolucion = $request->input("tiposolucion");
                        if($tipocaso->modo=="1"){
                            $caso->estado = "F";
                            $caso->fechaf = date("Y-m-d H:i");
                        }else if($tipocaso->modo=="2"){
                            $caso->id_tipo_solucion = $tiposolucion;
                            if($tiposolucion=="1"){
                                $caso->estado = "F";
                                $caso->fechaf = date("Y-m-d H:i");
                            }else if($tiposolucion="2"){
                                $caso->estado = "D";
                                $caso->id_sucursal = $request->input("sucursal");
                            }
                        }
                        $caso->save();
                        DB::commit();
                        $request->session()->put("mensaje", "Guardado correctamente");
                        return json_encode(["ok"=>true,"caso"=>$caso->id]);
                    }else{
                        DB::rollback();
                        $request->session()->put("mensaje","Ha ocurrido un error");
                        return json_encode(["ok"=>false,"url"=>"caso?id=".$caso->id]);
                    }
                }else{
                    DB::rollback();
                    return json_encode(["ok"=>false,"error"=>"Caso no encontrado"]);
                }
                    
            } catch (Exception $e) {
                DB::rollback();
                $error = $e->getMessage().'-linea:'.$e->getLine();
                return json_encode(["ok"=>false,"error"=>$error]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    
    public function Tecnicos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 1;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                if($id!=null){
                    $proveedor = Proveedor::find($id);
                    $tecnicos = Tecnico::where("id_proveedor")->where('estado','N')->orderBy('apellidos')->orderBy('nombre')->paginate(10);
                }else{
                    $proveedor = new Proveedor();
                    $proveedor->razon = Empresa::find(1)->nombre;
                    $tecnicos = Tecnico::whereNull("id_proveedor")->where('estado','N')->orderBy('apellidos')->orderBy('nombre')->paginate(10);
                }
                $tecnicos = Tecnico::where("estado","N")->paginate(10);;
                return view('/tecnicos',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'tecnicos'=>$tecnicos,
                    'proveedor'=>$proveedor,
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
    
    public function Tecnico(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            DB::beginTransaction();
            try{
                $nombre = $request->input("nombre");
                $apellidos = $request->input("apellidos");
                $proveedor = $request->input("proveedor");
                $quitar = array("'",'"');
                $nombre = str_replace($quitar, "", $nombre);
                $apellidos = str_replace($quitar, "", $apellidos);
                if($modo=="agregar"){
                    $tecnico = new Tecnico();
                }else if($modo=="editar"){
                    $tecnico = Tecnico::find($request->input("id"));
                }
                $tecnico->nombre = strtoupper($nombre);
                $tecnico->apellidos = strtoupper($apellidos);
                if($proveedor!=null){
                    $tecnico->id_proveedor = $proveedor;
                }
                $tecnico->save();
                DB::commit();
                $request->session()->put("mensaje", "Guardado correctamente");
                return json_encode(["ok"=>true,"obj"=>$tecnico]);
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
    
    public function CasoTraslado(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 19;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");

                $caso = Caso::
                        join("producto","caso.id_producto","producto.id")->
                        join("modelo","producto.id_modelo","modelo.id")->
                        join("sucursal","producto.id_sucursal","sucursal.id")->
                        select("caso.*","sucursal.nombre as nombresucursal","sucursal.id as sucursal_destino","modelo.id_tipo_equipo","modelo.id_marca","modelo.id as id_modelo")->
                        where("caso.id",$id)->first();
                
                $marcas = Modelo::join("marca","modelo.id_marca","marca.id")
                        ->join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")
                        ->select("marca.id","marca.nombre")
                        ->where("modelo.id_tipo_equipo",$caso->id_tipo_equipo)
                        ->where("marca.estado","N")
                        ->groupBy("marca.id","marca.nombre")
                        ->orderBy("marca.nombre")->get();
                
                $modelos = Modelo::where("id_marca",$caso->id_marca)
                        ->where("id_tipo_equipo",$caso->id_tipo_equipo)
                        ->where("estado","N")
                        ->orderBy("nombre")->get();
                $productos = Producto::where("estado","N")->where("id_sucursal",$caso->id_sucursal)->where("id_modelo",$caso->id_modelo)->get();
                $motivos = MotivoTraslado::where("id","3")->get();
                $sucursales = Sucursal::where("estado","N")->where("id","<>",$caso->sucursal_destino)->get();
                
                $hoy = date('Y-m-d');
                return view('/caso-traslado',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'caso'=>$caso,
                    'motivos'=>$motivos,
                    'sucursales'=>$sucursales,
                    'marcas'=>$marcas,
                    'hoy'=>$hoy,
                    'modelos'=>$modelos,
                    'productos'=>$productos,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO A LA VISTA ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }
        else{
            return redirect("/index");
        }
    }
    
    public function CasoTrasladoPost(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $caso = Caso::find($request->input("caso"));
            $numero = $request->input("numero");
            $idorigen = $request->input('sucursal');
            $iddestino = $request->input('destino');
            $fecha = $request->input("fecha");
            $motivo = $request->input("motivo");
            $descripcion = $request->input("descripcion");
            $idproducto = $request->input("serie");
            DB::beginTransaction();
            try{
                $ultimo = Traslado::orderBy("id","desc")->first();
                $anio = date("Y");
                $documento = Documento::find(2);
                if($ultimo!=null){
                    $anioanterior = substr($ultimo->numero, 2,4);
                    if($anioanterior!=$anio){
                        $documento->siguiente = 1;
                        $documento->save();
                    }
                }

                $siguiente = $documento->siguiente;
                $codigo = strval($siguiente);
                for($i=0;$i<(6-strlen($siguiente));$i++){
                    $codigo = '0'.$codigo;
                }

                $traslado = new Traslado();
                $traslado->remision = $numero;
                $traslado->numero = $documento->codigo.$anio.$codigo;
                $traslado->id_origen = $idorigen;
                $traslado->id_destino = $iddestino;
                $traslado->fecha = $fecha;
                $traslado->id_motivo_traslado = $motivo;
                $traslado->descripcion = $descripcion;
                $traslado->save();
                $caso->id_traslado = $traslado->id;
                $caso->estado = "E";
                $caso->fechae = date("Y-m-d H:i");
                $caso->id_reemplazo = $idproducto;
                $caso->save();
                $producto = Producto::find($idproducto);
                if($producto->id_sucursal==$traslado->id_origen){
                    $detalle = new DetalleTraslado();
                    $detalle->id_producto = $producto->id;
                    $detalle->id_traslado = $traslado->id;
                    $producto->id_sucursal = $traslado->id_destino;
                    $producto->id_area_sucursal = null;
                    $producto->save();
                    $detalle->save();
                }else{
                    DB::rollback();
                    $sucursal = Sucursal::find($producto->id_sucursal);
                    return json_encode(["ok"=>false,"error"=>"La serie se encuentra en otra sucursal: ".$sucursal->nombre]);
                }
                
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return json_encode(["ok"=>true,"traslado"=>$traslado->id]);
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
    
    public function CasoSerieReemplazo(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $caso = Caso::find($request->input("caso"));
            $idproducto = $request->input("serie");
            DB::beginTransaction();
            try{
                $caso->estado = "E";
                $productocaso = Producto::find($caso->id_producto);
                
                $caso->fechae = date("Y-m-d H:i");
                $caso->id_reemplazo = $idproducto;
                $caso->save();
                $producto = Producto::find($idproducto);
                $producto->id_area_sucursal = $productocaso->id_area_sucursal;
                $producto->save();
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return json_encode(["ok"=>true,"caso"=>$caso->id]);
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
    
    public function CasoFin(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $id = $request->input("id");
            DB::beginTransaction();
            try{
                $caso = Caso::find($id);
                if($caso!=null){
                    $caso->comentario = $request->input("comentario");
                    $caso->fechaf = date("Y-m-d H:i");
                    $caso->estado = "F";
                    $caso->save();
                    DB::commit();
                    $request->session()->put("mensaje", "Guardado correctamente");
                    return json_encode(["ok"=>true,"caso"=>$caso->id]);
                }else{
                    DB::rollback();
                    return json_encode(["ok"=>false,"error"=>"Caso no encontrado"]);
                }
                    
            } catch (Exception $e) {
                DB::rollback();
                $error = $e->getMessage().'-linea:'.$e->getLine();
                return json_encode(["ok"=>false,"error"=>$error]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    
}
    