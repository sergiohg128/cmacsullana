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

class ControladorEmpresa extends Controller
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
    
    public function Sucursales(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            if($modo=="ajax"){
                try {
                    $tiposucursal = $request->input("tipo");
                    $tipoterritorio = $request->input("territorio");
                    $sucursales = Sucursal::where('estado','N');
                    if($tiposucursal>0){
                        $sucursales = $sucursales->where("id_tipo_sucursal",$tiposucursal);
                    }
                    if($tipoterritorio>0){
                        $sucursales = $sucursales->where("id_tipo_territorio",$tipoterritorio);
                    }
                    $sucursales = $sucursales->orderBy('nombre')->get();
                    return json_encode(["ok"=>true,"obj"=>$sucursales]);
                } catch (Exception $ex) {
                    return json_encode(["ok"=>false,$ex->getMessage()]);
                }
            }else{
                $menuid = 5;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    $sucursales = Sucursal::where('estado','N')->orderBy('nombre')->paginate(10);
                    $zonas = Zona::where('estado','N')->orderBy('nombre')->get();
                    $tiposterritorio = TipoTerritorio::where("estado","N")->orderBy("nombre")->get();
                    $tipossucursal = TipoSucursal::where("estado","N")->orderBy("nombre")->get();
                    $departamentos = Departamento::orderBy('nombre')->get();
                    return view('/sucursales',[
                        'usuario'=>$usuario,
                        'mensaje'=>$mensaje,
                        'sucursales'=>$sucursales,
                        'zonas'=>$zonas,
                        'departamentos'=>$departamentos,
                        'tiposterritorio'=>$tiposterritorio,
                        'tipossucursal'=>$tipossucursal,
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
    
    public function SucursalPost(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input('modo');
            DB::beginTransaction();
            try{
                if($modo=='agregar'){
                    $obj = new Sucursal();
                    $obj->nombre = $request->input('nombre');
                    $obj->direccion = $request->input('direccion');
                    $obj->telefono1 = $request->input('telefono1');
                    $obj->telefono2 = $request->input('telefono2');
                    $obj->id_zona = $request->input('zona');
                    $obj->id_distrito = $request->input('distrito');
                    $obj->id_tipo_territorio = $request->input("tipoterritorio");
                    $obj->id_tipo_sucursal = $request->input("tiposucursal");
                    $obj->save();
                    $request->session()->put("mensaje","Guardado correctamente");
                }
                DB::commit();
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
    
    public function Sucursal(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 22;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $id = $request->input('id');
                $sucursal = Sucursal::find($id);
                $productos = Producto::join('modelo','producto.id_modelo','modelo.id')
                        ->join('marca','modelo.id_marca','marca.id')
                        ->join('tipo_equipo',"modelo.id_tipo_equipo","tipo_equipo.id")
                        ->select('producto.id_modelo',DB::raw('count(producto.id) as total'),"modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo")
                        ->where('producto.id_sucursal',$id)
                        ->where('producto.estado','N')
                        ->orderBy('marca.nombre')
                        ->orderBy('modelo.nombre')
                        ->orderBy('tipo_equipo.nombre')
                        ->groupBy('producto.id_modelo',"modelo.nombre","marca.nombre","tipo_equipo.nombre")
                        ->paginate(10);
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                return view('/sucursal',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'productos'=>$productos,
                    'sucursal' =>$sucursal,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO A LA VISTA ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function Stock(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 23;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $modeloid = $request->input('m');
                $sucursalid = $request->input('s');
                $sucursal = Sucursal::find($sucursalid);
                $modelo = Modelo::join('marca','modelo.id_marca','marca.id')
                        ->join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")
                        ->select("modelo.nombre","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo")
                        ->where("modelo.id",$modeloid)->first();
                $productos = Producto::join('detalle_contrato','producto.id_detalle_contrato','detalle_contrato.id')
                        ->join('contrato','detalle_contrato.id_contrato','contrato.id')
                        ->leftJoin('proveedor','contrato.id_proveedor','proveedor.id')
                        ->select('producto.id_detalle_contrato','producto.id_sucursal','producto.id_modelo','proveedor.razon','contrato.numero','contrato.fecha','contrato.inicio','contrato.fin','contrato.tipo as tipocontrato',DB::raw('count(producto.id) as total'))
                        ->where('producto.id_modelo',$modeloid)
                        ->where('producto.id_sucursal',$sucursalid)
                        ->groupBy('producto.id_detalle_contrato','producto.id_sucursal','producto.id_modelo','detalle_contrato.id','proveedor.razon','contrato.numero','contrato.fecha','contrato.inicio','contrato.fin','contrato.tipo')
                        ->get();
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                return view('/stock',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'productos'=>$productos,
                    'sucursal' =>$sucursal,
                    'modelo'=>$modelo,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO A LA VISTA ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
        }
    }
    
    public function Series(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("modo");
            if($modo=="ajax"){
                try {
                    $tipo = $request->input("id_tipo_equipo");
                    $marca = $request->input("id_marca");
                    $modelo = $request->input("id_modelo");
                    $sucursal = $request->input("id_origen");
                        
                    $productos = Producto::
                            join("modelo","producto.id_modelo","modelo.id")->
                            select("producto.id","producto.serie")->
                            where("producto.estado","N");
                    
                    $ocasion = $request->input("ocasion");
                    if($ocasion=="caso"){
                        $productos = Producto::
                            join("modelo","producto.id_modelo","modelo.id")->
                            join("marca","modelo.id_marca","marca.id")->
                            leftJoin("area_sucursal","producto.id_area_sucursal","area_sucursal.id")->
                            leftJoin("area","area_sucursal.id_area","area.id")->
                            select("producto.serie","area.nombre as nombrearea","modelo.nombre as nombremodelo","marca.nombre as nombremarca")->
                            where("producto.estado","N");
                        $idcontrato = $request->input("contrato");
                        $caso = Caso::find($idcontrato);
                        $producto = Producto::find($caso->id_producto);
                        
                        $tipomodelo = $request->input("tipomodelo");
                        if($tipomodelo=="1"){
                            $productos = $productos->where("producto.id_modelo",$producto->id_modelo);
                        }else if($tipomodelo=="2"){
                            $modeloigual = Modelo::find($producto->id_modelo);
                            $productos = $productos->where("modelo.id_tipo_equipo",$modeloigual->id_tipo_equipo);
                        }
                    }
                    
                    if($sucursal>0){
                        $productos = $productos->where("producto.id_sucursal",$sucursal);
                    }
                    if($tipo>0){
                        $productos = $productos->where("modelo.id_tipo_equipo",$tipo);
                    }

                    if($marca>0){
                        $productos = $productos->where("modelo.id_marca",$marca);
                    }

                    if($modelo>0){
                        $productos = $productos->where("producto.id_modelo",$modelo);
                    }
                    if($ocasion=="caso"){
                        $productos=$productos->orderBy("id_area_sucursal","desc")->orderBy("marca.nombre")->orderBy("modelo.nombre")->get();
                    }else{
                        $productos=$productos->orderBy("serie")->get();
                    }
                        
                    return json_encode(["ok"=>true,"obj"=>$productos]);
                } catch (Exception $ex) {
                    return json_encode(["ok"=>false,"error"=>$ex->getMessage()]);
                }
            }else{
                $menuid = 24;
                if($this->ComprobarPermiso($usuario, $menuid)){
                    $detalleid = $request->input('d');
                    $sucursalid = $request->input('s');
                    $sucursal = Sucursal::find($sucursalid);
                    $detalle = DetalleContrato::
                            join('contrato','detalle_contrato.id_contrato','contrato.id')
                            ->leftJoin('proveedor','contrato.id_proveedor','proveedor.id')
                            ->join("modelo","detalle_contrato.id_modelo","modelo.id")
                            ->join('marca','modelo.id_marca','marca.id')
                            ->join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")
                            ->select("detalle_contrato.id","detalle_contrato.id_modelo","proveedor.razon","modelo.nombre","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo","contrato.numero","contrato.tipo as tipocontrato")
                            ->where("detalle_contrato.id",$detalleid)->first();
                    $producto = new Producto();
                    $producto->id_detalle_contrato = $detalleid;
                    $producto->id_sucursal = $sucursalid;
                    $producto->id_modelo = $detalle->id_modelo;
                    if($detalle->tipocontrato=="C"){
                        $detalle->sla = $producto->sla();
                    }
                    $productos = Producto::
                            where('producto.id_detalle_contrato',$detalleid)
                            ->where('producto.id_sucursal',$sucursalid)
                            ->orderBy("serie")
                            ->get();

                    $detalles = Producto::
                            select(DB::raw("count(*) as restantes"))
                            ->where('producto.id_detalle_contrato',$detalleid)
                            ->whereNull("serie")
                            ->first();
                    $areas = AreaSucursal::
                            join("area","area_sucursal.id_area","area.id")->
                            select("area_sucursal.id","area.nombre")->
                            where("area_sucursal.id_sucursal",$sucursalid)->where("area_sucursal.estado","N")->get();
                    $mensaje = $request->session()->get('mensaje');
                    $request->session()->forget('mensaje');
                    return view('/series',[
                        'usuario'=>$usuario,
                        'mensaje'=>$mensaje,
                        'productos'=>$productos,
                        'sucursal' =>$sucursal,
                        'detalle'=>$detalle,
                        'areas'=>$areas,
                        'detalles'=>$detalles,
                        'w'=>0
                    ]);
                }else{
                    $request->session()->put("mensaje","NO TIENE ACCESO A LA VISTA ".Menu::find($menuid)->nombre);
                    return redirect ("/inicio");
                }
            }
        }else{
            return redirect("/index");
        }
    }
    
    
    public function Traslados(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 16;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $idsucursal = $request->input("sucursal");
                $desde = $request->input("desde");
                $hasta = $request->input("hasta");
                $traslados = Traslado::whereNotNull("id");
                $hoy = date('Y-m-d');
                $sucursales = Sucursal::where('estado','N')->orderBy('nombre')->get();
                if(empty($idsucursal)){
                    $idsucursal = "0";
                }
                if($idsucursal!="0"){
                    $traslados = $traslados->where("id_origen",$idsucursal)->orWhere("id_destino",$idsucursal);
                }
                if(!empty($desde)){
                    $traslados = $traslados->where("traslado.fecha",">=",$desde);
                }else{
                    $desde = new DateTime('-1 week');
                    $desde = $desde->format('Y-m-d');
                }
                if(!empty($hasta)){
                    $traslados = $traslados->where("traslado.fecha","<=",$hasta.' 23:59:59');
                }else{
                    $hasta = $hoy;
                }
                $traslados = $traslados->orderBy("traslado.fecha","desc")->get();
                return view('/traslados',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'traslados'=>$traslados,
                    'desde'=>$desde,
                    'hasta'=>$hasta,
                    'idsucursal'=>$idsucursal,
                    'sucursales'=>$sucursales,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }
        else{
            return redirect("/index");
        }
    }
    
    public function TrasladoNuevo(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 19;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");

                $sucursal = Sucursal::find($id);
                
                $tiposequipo = TipoEquipo::where("estado","N")->orderBy("nombre")->get();
                $marcas = Marca::where("estado","N")->orderBy("nombre")->get();

                $motivos = MotivoTraslado::all();
                $sucursales = Sucursal::where("estado","N")->where("id","<>",$id)->get();
                $hoy = date('Y-m-d');
                $modelos = [];
                $request->session()->put("seriestraslado", $modelos);
                return view('/traslado-nuevo',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'sucursal'=>$sucursal,
                    'sucursales'=>$sucursales,
                    'marcas'=>$marcas,
                    'tiposequipo'=>$tiposequipo,
                    'motivos'=>$motivos,
                    'hoy'=>$hoy,
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
    
    public function TrasladoDetalle(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            try{
                $idorigen = $request->input("origen");
                $tipo = $request->input("tipo");
                $modelos = $request->session()->get("seriestraslado");
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
                            $existe = Producto::
                                    join("modelo","producto.id_modelo","modelo.id")->
                                    join("marca","modelo.id_marca","marca.id")->
                                    join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                                    join("sucursal","producto.id_sucursal","sucursal.id")->
                                    select("producto.id","producto.id_modelo","producto.id_sucursal","modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal")->
                                    where("serie",$serie)->first();
                            if($existe!=null){
                                if($existe->id_sucursal==$idorigen){
                                    if(!array_key_exists($existe->id_modelo, $modelos)){
                                        $modelos[$existe->id_modelo][0] = [];
                                        $modelos[$existe->id_modelo][1] = $existe->nombretipoequipo.' '.$existe->nombremarca.' '.$existe->nombremodelo;
                                        $modelos[$existe->id_modelo][2] = 0;
                                    }
                                    if(!array_key_exists($existe->id, $modelos[$existe->id_modelo][0])){
                                        $modelos[$existe->id_modelo][2] = $modelos[$existe->id_modelo][2]+1;
                                    }
                                    $modelos[$existe->id_modelo][0][$existe->id] = $serie;
                                }else{
                                    $errores[$serie] = "La serie se encuentra en la sucursal: ".$existe->nombresucursal;
                                }
                            }else{
                                $errores[$serie] = "La serie no se ha registrado en ninguna sucursal";
                            }
                        }
                    }
                }else if($tipo==2){
                    $serie = $request->input("serie");
                    $existe = Producto::
                            join("modelo","producto.id_modelo","modelo.id")->
                            join("marca","modelo.id_marca","marca.id")->
                            join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                            join("sucursal","producto.id_sucursal","sucursal.id")->
                            select("producto.id","producto.id_modelo","producto.id_sucursal","modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal")->
                            where("serie",$serie)->first();
                    if($existe!=null){
                        if($existe->id_sucursal==$idorigen){
                            if(!array_key_exists($existe->id_modelo, $modelos)){
                                $modelos[$existe->id_modelo][0] = [];
                                $modelos[$existe->id_modelo][1] = $existe->nombretipo.' '.$existe->nombremarca.' '.$existe->nombremodelo;
                                $modelos[$existe->id_modelo][2] = 0;
                            }
                            if(!array_key_exists($existe->id, $modelos[$existe->id_modelo][0])){
                                $modelos[$existe->id_modelo][2] = $modelos[$existe->id_modelo][2]+1;
                            }
                            $modelos[$existe->id_modelo][0][$existe->id] = $serie;
                        }else{
                            $errores[$serie] = "La serie se encuentra en la sucursal: ".$existe->nombresucursal;
                        }
                    }else{
                        $errores[$serie] = "La serie no se ha registrado en ninguna sucursal";
                    }
                }else if($tipo==3){
                    $idproducto = $request->input("id_producto");
                    $existe = Producto::
                            join("modelo","producto.id_modelo","modelo.id")->
                            join("marca","modelo.id_marca","marca.id")->
                            join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                            join("sucursal","producto.id_sucursal","sucursal.id")->
                            select("producto.id","producto.serie","producto.id_modelo","producto.id_sucursal","modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal")->
                            where("producto.id",$idproducto)->first();
                    if($existe!=null){
                        if($existe->id_sucursal==$idorigen){
                            if(!array_key_exists($existe->id_modelo, $modelos)){
                                $modelos[$existe->id_modelo][0] = [];
                                $modelos[$existe->id_modelo][1] = $existe->nombretipo.' '.$existe->nombremarca.' '.$existe->nombremodelo;
                                $modelos[$existe->id_modelo][2] = 0;
                            }
                            if(!array_key_exists($existe->id, $modelos[$existe->id_modelo][0])){
                                $modelos[$existe->id_modelo][2] = $modelos[$existe->id_modelo][2]+1;
                            }
                            $modelos[$existe->id_modelo][0][$existe->id] = $existe->serie;
                        }else{
                            $errores[$existe->serie] = "La serie se encuentra en la sucursal: ".$existe->nombresucursal;
                        }
                    }else{
                        $errores[$existe->serie] = "La serie no se ha registrado en ninguna sucursal";
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
                    $request->session()->put("seriestraslado", $modelos);
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
    
    public function TrasladoPost(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $numero = $request->input("numero");
            $idorigen = $request->input('origen');
            $iddestino = $request->input('sucursal');
            $fecha = $request->input("fecha");
            $motivo = $request->input("motivo");
            $descripcion = $request->input("descripcion");
            $modelos = $request->session()->get("seriestraslado");
            if(count($modelos)>0){
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
                    foreach ($modelos as $modelo){
                        $productos = $modelo[0];
                        foreach ($productos as $idproducto =>$serie){
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
                        }
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
            }else{
                return json_encode(["ok"=>false,"error"=>"No ha añadido productos al traslado"]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function Traslado(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 20;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input('id');
                $traslado = Traslado::find($id);
                $detalles = DetalleTraslado::
                        join("producto","detalle_traslado.id_producto","producto.id")
                        ->join('modelo','producto.id_modelo','modelo.id')
                        ->join("marca","modelo.id_marca","marca.id")
                        ->join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")
                        ->select("modelo.id","modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo",DB::raw("count(*) as cantidad"))
                        ->where('detalle_traslado.id_traslado',$id)
                        ->groupBy("modelo.id","modelo.nombre","marca.nombre","tipo_equipo.nombre")
                        ->get();
                $archivo = Archivo::where("numero",$id)->where("tipo","traslado")->where("estado","N")->first();
                return view('/traslado',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'traslado'=>$traslado,
                    'detalles'=>$detalles,
                    'archivo'=>$archivo,
                    'w'=>0
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO A LA VISTA ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
                
        }else{
            return redirect("/index");
        }
    }
    
    public function TrasladoSeries(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 26;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                $idtraslado = $request->input("t");
                $producto = DetalleTraslado::
                        join("producto","detalle_traslado.id_producto","producto.id")->
                        join("traslado","detalle_traslado.id_traslado","traslado.id")->
                        join("modelo","producto.id_modelo","modelo.id")->
                        join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                        join("marca","modelo.id_marca","marca.id")->
                        select("traslado.numero","modelo.nombre as nombremodelo","tipo_equipo.nombre as nombretipoequipo","marca.nombre as nombremarca")->
                        where("modelo.id",$id)->
                        where("detalle_traslado.id_traslado",$idtraslado)->
                        first();
                $detalles = DetalleTraslado::
                        join("producto","detalle_traslado.id_producto","producto.id")->
                        select("producto.serie")->
                        where("producto.id_modelo",$id)->where("detalle_traslado.id_traslado",$idtraslado)->orderBy("detalle_traslado.id")->get();
                $existen = count($detalles);
                return view('/traslado-series',[
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
    
    public function AreasSucursal(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 27;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $id = $request->input("id");
                $areassucursal = AreaSucursal::join("area","area_sucursal.id_area","area.id")
                        ->select("area_sucursal.*","area.nombre")
                        ->where("area_sucursal.id_sucursal",$id)
                        ->where("area_sucursal.estado","N")
                        ->orderBy("area.nombre")
                        ->get();
                $areas = Area::where('area.estado','N')
                        ->whereNotIn('area.id', function($query) use ($id){
                    $query->select('id_area')->from('area_sucursal')->where('id_sucursal',$id)->where('estado','N');
                })->orderBy("area.nombre")->get();
                
                $sucursal = Sucursal::find($id);
                return view('/areas-sucursal',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'areassucursal'=>$areassucursal,
                    'sucursal'=>$sucursal,
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
    
    public function AreaSucursal(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $modo = $request->input("accion");
            DB::beginTransaction();
            try{
                if($modo=="agregar"){
                    $areasucursal = new AreaSucursal();
                    $areasucursal->id_area = $request->input("area");
                    $areasucursal->id_sucursal = $request->input("sucursal");
                    $areasucursal->save();
                    $request->session()->put("mensaje","Guardado correctamente");
                }else if($modo=="eliminar"){
                    $areasucursal = AreaSucursal::find($request->input("id"));
                    $areasucursal->estado = "A";
                    $request->session()->put("mensaje","Eliminado correctamente");
                }
                $areasucursal->save();
                DB::commit();
                return redirect("/areas-sucursal?id=".$areasucursal->id_sucursal);
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
    
    public function AsignarArea(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            DB::beginTransaction();
            try{
                $producto = Producto::find($request->input("id"));
                if($producto->serie!=null){
                    $idarea = $request->input("a");
                    if($idarea>0){
                        $producto->id_area_sucursal = $idarea;
                    }else{
                        $producto->id_area_sucursal = null;
                    }
                    $producto->save();
                    DB::commit();
                    return json_encode(["ok"=>true]);
                }else{
                    DB::rollback();
                    return json_encode(["ok"=>false,"error"=>"El producto aún no tiene serie"]);
                }
            } 
            catch (Exception $e) {
                DB::rollback();
                $error = $e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error.'-linea:'.$e->getLine()]);
            }
        }
        else{
            return json_encode(["ok"=>false,"url"=>"index"]);
        }
    }
    
    public function Productos(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 12;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $proveedores = Proveedor::where('estado','N')->orderBy('razon')->get();
                $marcas = Marca::where("estado","N")->orderBy("nombre")->get();
                $tiposequipo = TipoEquipo::where("estado","N")->orderBy("nombre")->get();
                $sucursales = Sucursal::where("estado","N")->orderBy("nombre")->get();
                
                $idproveedor = $request->input("id_proveedor");
                $idmarca = $request->input("id_marca");
                $idmodelo = $request->input("id_modelo");
                $idtipoequipo = $request->input("id_tipo_equipo");
                $idsucursal = $request->input("id_sucursal");
                
                $listar = $request->input("listar");
                
                if(!empty($listar)){
                    $productos = Producto::
                            join("modelo","producto.id_modelo","modelo.id")
                            ->join("marca","modelo.id_marca","marca.id")
                            ->join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")
                            ->join("sucursal","producto.id_sucursal","sucursal.id")
                            ->join("detalle_contrato","producto.id_detalle_contrato","detalle_contrato.id")
                            ->join("contrato","detalle_contrato.id_contrato","contrato.id")
                            ->leftJoin("proveedor","contrato.id_proveedor","proveedor.id")
                            ->select("modelo.nombre as nombremodelo","marca.nombre as nombremarca","tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal","proveedor.razon as nombreproveedor",DB::raw("count(*) as cantidad"));

                    if($idsucursal>0){
                        $productos = $productos->where("producto.id_sucursal",$idsucursal);
                    }else{
                        $idsucursal = 0;
                        $productos = $productos->orderBy("sucursal.nombre");
                    }

                    if($idtipoequipo>0){
                        $productos = $productos->where("modelo.id_tipo_equipo",$idtipoequipo);
                    }else{
                        $idtipoequipo = 0;
                        $productos = $productos->orderBy("tipo_equipo.nombre");
                    }

                    if($idmarca>0){
                        $productos = $productos->where("modelo.id_marca",$idmarca);
                    }else{
                        $idmarca = 0;
                        $productos = $productos->orderBy("marca.nombre");
                    }

                    if($idmodelo>0){
                        $productos = $productos->where("producto.id_modelo",$idmodelo);
                    }else{
                        $idmodelo = 0;
                        $productos = $productos->orderBy("modelo.nombre");
                    }

                    if($idproveedor=="0"){
                        $productos = $productos->whereNull("contrato.id_proveedor");
                    }else if($idproveedor>0){
                        $productos = $productos->where("contrato.id_proveedor",$idproveedor);
                    }else{
                        $idproveedor = "x";
                        $productos = $productos->orderBy('proveedor.razon');
                    }

                    $productos = $productos
                            ->groupBy("sucursal.nombre")
                            ->groupBy("tipo_equipo.nombre")
                            ->groupBy("proveedor.razon")
                            ->groupBy("modelo.nombre")
                            ->groupBy("marca.nombre")
                            ->paginate(50);
                }else{
                    $productos = Producto::where("id",0)->paginate(50);
                }
                return view('/productos',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'sucursales'=>$sucursales,
                    'productos'=>$productos,
                    'marcas'=>$marcas,
                    'proveedores'=>$proveedores,
                    'tiposequipo'=>$tiposequipo,
                    'idproveedor'=>$idproveedor,
                    'idmarca'=>$idmarca,
                    'idmodelo'=>$idmodelo,
                    'idtipoequipo'=>$idtipoequipo,
                    'idsucursal'=>$idsucursal,
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
    
    public function Cliente(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 22;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $empresa = Empresa::find(1);
                return view('/cliente',[
                    'usuario'=>$usuario,
                    'mensaje'=>$mensaje,
                    'empresa'=>$empresa,
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
    
    public function ClientePost(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            DB::beginTransaction();
            try{
                $empresa = Empresa::find(1);
                if($empresa->nombre==null){
                    $empresa->nombre = $request->input("nombre");
                }
                if($empresa->ruc==null){
                    $empresa->ruc = $request->input("ruc");
                }
                $empresa->direccion = $request->input("direccion");
                $empresa->telefono = $request->input("telefono");
                $empresa->correo = $request->input("correo");
                $empresa->save();
                DB::commit();
                $request->session()->put("mensaje","Guardado correctamente");
                return redirect("/cliente");
            } 
            catch (Exception $e) {
                DB::rollback();
                $error = $e->getMessage();
                return json_encode(["ok"=>false,"error"=>$error.'-linea:'.$e->getLine()]);
            }
        }else{
            return redirect("/index");
        }
    }
}
    