<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Archivo;
use App\Area;
use App\AreaSucursal;
use App\Bitacora;
use App\Caso;
use App\Contrato;
use App\Departamento;
use App\DetalleCaso;
use App\DetalleContrato;
use App\DetalleGuiaBaja;
use App\DetalleTraslado;
use App\Distrito;
use App\Documento;
use App\Empresa;
use App\Grupo;
use App\Guia;
use App\GuiaBaja;
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

    //SISTEMA
    
    public function Index(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        $mensaje = $request->session()->get('mensaje');
        $request->session()->forget('mensaje');
        if(!empty($usuario)){
            return redirect("/inicio");
        }else{
            return view('index',[
                'empresa'=>null,
                'mensaje'=>$mensaje
            ]);
        }
    }
    
    public function Login(Request $request,  Response $response) {
        $correo = $request->input('correo');
        $password = $request->input('password');
        $usuario = Usuario::where('correo',$correo)->first();
        if(!empty($usuario)){
            if(\Hash::check($password,$usuario->password)){
                if($usuario->estado=="N"){
                        $idtipousuario = $usuario->id_tipo_usuario;
                        $menus = Menu::join("grupo","menu.id_grupo","grupo.id")
                        ->select("menu.*","grupo.id as idgrupo","grupo.nombre as nombregrupo")
                        ->whereIn("menu.id",function($query) use ($idtipousuario){
                            $query->select("id_menu")->from("permiso")->where("id_tipo_usuario",$idtipousuario)->where("estado","N");
                        })->orderBy("menu.orden")->get();

                        $grupos = Permiso::join("menu","permiso.id_menu","menu.id")
                                ->select("grupo.id","grupo.nombre")
                                ->join("grupo","menu.id_grupo","grupo.id")
                                ->where("permiso.id_tipo_usuario",$idtipousuario)
                                ->where("permiso.estado","N")
                                ->groupBy("grupo.id","grupo.nombre")
                                ->orderBy("grupo.orden")
                                ->get();
                        $usuario->menus =$menus;
                        $usuario->grupos = $grupos;
                        $request->session()->put('usuario', $usuario);
                        $request->session()->put('mensaje', "Bienvenido ".$usuario->nombre);
                        new Bitacora("usuario","login","",$usuario->id);
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
    
    public function Password(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $mensaje = $request->session()->get('mensaje');
            $request->session()->forget('mensaje');
            return view('/password',[
                'usuario'=>$usuario,
                'mensaje'=>$mensaje,
                'w'=>0
            ]);
        }else{
            return redirect("/index");
        }
    }
    
    public function Reportes(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $menuid = 33;
            if($this->ComprobarPermiso($usuario, $menuid)){
                $mensaje = $request->session()->get('mensaje');
                $request->session()->forget('mensaje');
                $hoy = date('Y-m-d');
                $desde = date('Y');
                $sucursales = Sucursal::where("estado","N")->orderBy("nombre")->get();
                $marcas = Marca::where("estado","N")->orderBy("nombre")->get();
                $tiposequipo = TipoEquipo::where("estado","N")->orderBy("nombre")->get();
                $modelos = Modelo::where("estado","N")->orderBy("nombre")->get();
                $tipossucursal = TipoSucursal::where("estado","N")->orderBy("nombre")->get();
                $areas = Area::where("estado","N")->orderBy("nombre")->get();
                $proveedores = Proveedor::where("estado","N")->orderBy("razon")->get();
                $motivostraslado = MotivoTraslado::all();
                $traslados = Traslado::select("id","numero")->get();
                $contratos = Contrato::select("id","numero")->where("tipo","C")->get();
                return view('/reportes',[
                    'mensaje'=>$mensaje,
                    'usuario'=>$usuario,
                    'hoy'=>$hoy,
                    'desde'=>$desde,
                    'sucursales'=>$sucursales,
                    'marcas'=>$marcas,
                    'tiposequipo'=>$tiposequipo,
                    'modelos'=>$modelos,
                    'tipossucursal'=>$tipossucursal,
                    'areas'=>$areas,
                    'proveedores'=>$proveedores,
                    'motivostraslado'=>$motivostraslado,
                    'traslados'=>$traslados,
                    'contratos'=>$contratos
                ]);
            }else{
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre);
                return redirect ("/inicio");
            }
        }else{
            return redirect("/index");
            
        }
    }
    
    public function Reporte(Request $request,  Response $response) {
        $id = $request->input("id");
        $tiposucursal = $request->input("tiposucursal");
        $area = $request->input("area");
        $sucursal = $request->input("sucursal");
        $tipoequipo = $request->input("tipoequipo");
        $marca = $request->input("marca");
        $modelo = $request->input("modelo");
        $ingreso = $request->input("ingreso");
        $proveedor = $request->input("proveedor");
        $desde = $request->input("desde");
        $hasta = $request->input("hasta");
        $reporte = $request->input("reporte");
        $idcontrato = $request->input("contrato");
        $idtraslado = $request->input("traslado");
        $idguia = $request->input("guia");
        $idbaja = $request->input("baja");
        $parametros = [];
        if($id=="1"){
            $productos = Producto::join("modelo","producto.id_modelo","modelo.id")->
                    join("marca","modelo.id_marca","marca.id")->
                    join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                    join("sucursal","producto.id_sucursal","sucursal.id")->
                    join("detalle_contrato","producto.id_detalle_contrato","detalle_contrato.id")->
                    join("contrato","detalle_contrato.id_contrato","contrato.id")->
                    join("proveedor","contrato.id_proveedor","proveedor.id")->
                    join("tipo_sucursal","sucursal.id_tipo_sucursal","tipo_sucursal.id")->
                    leftJoin("area_sucursal","producto.id_area_sucursal","area_sucursal.id")->
                    leftJoin("area","area_sucursal.id_area","area.id")->
                    select("producto.serie","modelo.nombre as nombremodelo","marca.nombre as nombremarca",
                            "tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal",
                            "contrato.numero as numerocontrato","contrato.tipo as tipocontrato","proveedor.razon","tipo_sucursal.nombre as nombretiposucursal",
                            "area.nombre as nombrearea")->
                    where("producto.estado","N");
            if($tiposucursal>0){
                $productos = $productos->where("tipo_sucursal.id",$tiposucursal);
            }
            
            if($area>0){
                $productos = $productos->where("area.id",$area);
            }
            
            if($sucursal>0){
                $productos = $productos->where("sucursal.id",$sucursal);
            }
            
            if($tipoequipo>0){
                $productos = $productos->where("tipo_equipo.id",$tipoequipo);
            }
            
            if($marca>0){
                $productos = $productos->where("marca.id",$marca);
            }
            
            if($modelo>0){
                $productos = $productos->where("modelo.id",$modelo);
            }
            
            if($ingreso!="X"){
                $productos = $productos->where("contrato.tipo",$ingreso);
            }
            
            if($proveedor>0){
                $productos = $productos->where("proveedor.id",$proveedor);
            }
            
            $productos = $productos->orderBy("tipo_sucursal.nombre")->orderBy("sucursal.nombre")->orderBy("area.nombre")
                    ->orderBy("tipo_equipo.nombre")->orderBy("marca.nombre")->orderBy("modelo.nombre")->orderBy("contrato.tipo")->orderBy("proveedor.razon")->get();
            if($reporte=="E"){
                Reportes::ReporteProductos($productos);
            }else{
                Reportes::ReporteProductosPDF($productos,$tiposucursal,$sucursal,$area,$tipoequipo,$marca,$modelo,$ingreso,$proveedor);
            }
                
        }
        else if($id=="2"){
            $contratos = Contrato::join("proveedor","contrato.id_proveedor","proveedor.id")
                    ->select("contrato.*","proveedor.razon");
            if($proveedor>0){
                $contratos = $contratos->where("proveedor.id",$proveedor);
            }
            
            if($ingreso!="X"){
                $contratos = $contratos->where("contrato.tipo",$ingreso);
            }
            $contratos = $contratos->orderBy("contrato.fecha")->get();
            Reportes::ReporteContratos($contratos);
        }
        else if($id=="3"){
            $casos = Caso::join("producto","caso.id_producto","producto.id")->
                    join("modelo","producto.id_modelo","modelo.id")->
                    join("marca","modelo.id_marca","marca.id")->
                    join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                    join("sucursal","caso.id_sucursalorigen","sucursal.id")->
                    join("detalle_contrato","producto.id_detalle_contrato","detalle_contrato.id")->
                    join("contrato","detalle_contrato.id_contrato","contrato.id")->
                    join("proveedor","contrato.id_proveedor","proveedor.id")->
                    join("tipo_sucursal","sucursal.id_tipo_sucursal","tipo_sucursal.id")->
                    leftJoin("area_sucursal","producto.id_area_sucursal","area_sucursal.id")->
                    leftJoin("area","area_sucursal.id_area","area.id")->
                    leftJoin("tipo_caso","caso.id_tipo_caso","tipo_caso.id")->
                    leftJoin("tipo_solucion","caso.id_tipo_solucion","tipo_solucion.id")->
                    leftJoin("tecnico","caso.id_tecnico","tecnico.id")->
                    select("producto.serie","modelo.nombre as nombremodelo","marca.nombre as nombremarca",
                            "tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal",
                            "contrato.numero as numerocontrato","proveedor.razon","tipo_sucursal.nombre as nombretiposucursal",
                            "area.nombre as nombrearea","caso.numero",
                            "caso.fecha","caso.fechat","caso.fechad","caso.fechae","caso.fechaf","caso.problema",
                            "caso.analisis","caso.conclusion","caso.sla","caso.estado","caso.comentario",
                            "tipo_caso.nombre as nombretipocaso","tipo_solucion.nombre as nombretiposolucion",
                            "tecnico.nombre as nombretecnico","tecnico.apellidos as apellidostecnico");
            if($tiposucursal>0){
                $casos = $casos->where("tipo_sucursal.id",$tiposucursal);
            }
            
            if($area>0){
                $productos = $productos->where("area.id",$area);
            }
            
            if($sucursal>0){
                $casos = $casos->where("sucursal.id",$sucursal);
            }
            
            if($tipoequipo>0){
                $casos = $casos->where("tipo_equipo.id",$tipoequipo);
            }
            
            if($marca>0){
                $casos = $casos->where("marca.id",$marca);
            }
            
            if($modelo>0){
                $casos = $casos->where("modelo.id",$modelo);
            }
            
            if($proveedor>0){
                $casos = $casos->where("proveedor.id",$proveedor);
            }
            
            if($desde!=null){
                $casos = $casos->where("caso.fecha",">=",$desde);
            }
            
            if($hasta!=null){
                $casos =  $casos->where("caso.fecha","<=",$hasta.' 23:59:59');
            }
            $casos = $casos->orderBy("caso.fecha")->get();
            Reportes::ReporteCasos($casos);
        }
        else if($id=="4"){
            $traslados = Traslado::
                    join("sucursal","traslado.id_origen","sucursal.id")->
                    join("tipo_sucursal","sucursal.id_tipo_sucursal","tipo_sucursal.id")->
                    join("motivo_traslado","traslado.id_motivo_traslado","motivo_traslado.id")->
                    select("traslado.numero","traslado.remision","traslado.fecha","traslado.descripcion","sucursal.nombre as nombresucursal","motivo_traslado.nombre as nombremotivotraslado","traslado.id_destino");
            if($tiposucursal>0){
                $traslados = $traslados->where("tipo_sucursal.id",$tiposucursal);
            }
            if($sucursal>0){
                $traslados = $traslados->where("sucursal.id",$sucursal);
            }
            if($desde!=null){
                $traslados = $traslados->where("traslado.fecha",">=",$desde);
            }
            if($hasta!=null){
                $traslados =  $traslados->where("traslado.fecha","<=",$hasta.' 23:59:59');
            }
            $traslados = $traslados->orderBy("traslado.fecha")->get();
            Reportes::ReporteTraslados($traslados);
        }
        else if($id=="5"){
            $contrato = Contrato::find($idcontrato);
            $productos = Producto::join("modelo","producto.id_modelo","modelo.id")->
                    join("marca","modelo.id_marca","marca.id")->
                    join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                    leftJoin("sucursal","producto.id_sucursal","sucursal.id")->
                    join("detalle_contrato","producto.id_detalle_contrato","detalle_contrato.id")->
                    leftJoin("tipo_sucursal","sucursal.id_tipo_sucursal","tipo_sucursal.id")->
                    leftJoin("area_sucursal","producto.id_area_sucursal","area_sucursal.id")->
                    leftJoin("area","area_sucursal.id_area","area.id")->
                    select("producto.serie","modelo.nombre as nombremodelo","marca.nombre as nombremarca",
                            "tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal",
                            "tipo_sucursal.nombre as nombretiposucursal",
                            "area.nombre as nombrearea")->
                    where("detalle_contrato.id_contrato",$idcontrato)
                    ->orderBy("tipo_sucursal.nombre")->orderBy("sucursal.nombre")->orderBy("area.nombre")
                    ->orderBy("tipo_equipo.nombre")->orderBy("marca.nombre")->orderBy("modelo.nombre")->get();
            if($reporte=="E"){
                Reportes::ReporteContrato($contrato,$productos);
            }else{
                Reportes::ReporteContratoPDF($contrato,$productos);
            }
        }
        else if($id=="6"){
            $guia = Guia::find($idguia);
            $productos = Producto::join("modelo","producto.id_modelo","modelo.id")->
                    join("marca","modelo.id_marca","marca.id")->
                    join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                    leftJoin("sucursal","producto.id_sucursal","sucursal.id")->
                    leftJoin("tipo_sucursal","sucursal.id_tipo_sucursal","tipo_sucursal.id")->
                    leftJoin("area_sucursal","producto.id_area_sucursal","area_sucursal.id")->
                    leftJoin("area","area_sucursal.id_area","area.id")->
                    select("producto.serie","modelo.nombre as nombremodelo","marca.nombre as nombremarca",
                            "tipo_equipo.nombre as nombretipoequipo","sucursal.nombre as nombresucursal",
                            "tipo_sucursal.nombre as nombretiposucursal",
                            "area.nombre as nombrearea")->
                    where("producto.id_guia",$idguia)
                    ->orderBy("tipo_sucursal.nombre")->orderBy("sucursal.nombre")->orderBy("area.nombre")
                    ->orderBy("tipo_equipo.nombre")->orderBy("marca.nombre")->orderBy("modelo.nombre")->get();
            if($reporte=="E"){
                Reportes::ReporteGuia($guia,$productos);
            }else{
                Reportes::ReporteGuiaPDF($guia,$productos);
            }
        }
        else if($id=="7"){
            $traslado = Traslado::find($idtraslado);
            $productos = DetalleTraslado::
                    join("producto","detalle_traslado.id_producto","producto.id")->
                    join("modelo","producto.id_modelo","modelo.id")->
                    join("marca","modelo.id_marca","marca.id")->
                    join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                    select("producto.serie","modelo.nombre as nombremodelo","marca.nombre as nombremarca",
                            "tipo_equipo.nombre as nombretipoequipo")->
                    where("detalle_traslado.id_traslado",$idtraslado)
                    ->orderBy("tipo_equipo.nombre")->orderBy("marca.nombre")->orderBy("modelo.nombre")->get();
            if($reporte=="E"){
                Reportes::ReporteTraslado($traslado,$productos);
            }else{
                Reportes::ReporteTrasladoPDF($traslado,$productos);
            }
        }
        else if($id=="8"){
            $baja = GuiaBaja::find($idbaja);
            $productos = DetalleGuiaBaja::
                    join("producto","detalle_guiabaja.id_producto","producto.id")->
                    join("modelo","producto.id_modelo","modelo.id")->
                    join("marca","modelo.id_marca","marca.id")->
                    join("tipo_equipo","modelo.id_tipo_equipo","tipo_equipo.id")->
                    select("producto.serie","modelo.nombre as nombremodelo","marca.nombre as nombremarca",
                            "tipo_equipo.nombre as nombretipoequipo")->
                    where("detalle_guiabaja.id_guiabaja",$idbaja)
                    ->orderBy("tipo_equipo.nombre")->orderBy("marca.nombre")->orderBy("modelo.nombre")->get();
            if($reporte=="E"){
                Reportes::ReporteBaja($baja,$productos);
            }else{
                Reportes::ReporteBajaPDF($baja,$productos);
            }
        }
    }
    
    public function Provincias(Request $request,  Response $response) {
        $id = $request->input("id");
        $provincias = Provincia::where("id_departamento",$id)->orderBy("nombre")->get();
        return json_encode(["obj"=>$provincias]);
    }
    
    public function Distritos(Request $request,  Response $response) {
        $id = $request->input("id");
        $distritos = Distrito::where("id_provincia",$id)->orderBy("nombre")->get();
        return json_encode(["obj"=>$distritos]);
    }
    
    public function SubirArchivo(Request $request,  Response $response) {
        $usuario = $request->session()->get('usuario');
        if($this->ComprobarUsuario($usuario)){
            $id = $request->input("id");
            $tipo = $request->input("tipo");
            if($tipo=="contrato"){
                $obj = Contrato::find($id);
                $noexiste = "El contrato no existe";
            }else if($tipo=="guia"){
                $obj = Guia::find($id);
                $noexiste = "La guia no existe";
            }else if($tipo=="traslado"){
                $obj = Traslado::find($id);
                $noexiste = "El traslado no existe";
            }else if($tipo=="baja"){
                $obj = GuiaBaja::find($id);
                $noexiste = "La guia de baja no existe";
            }
            if($obj!=null){
                DB::beginTransaction();
                try{
                    $file = Input::file("archivo");
                    if($file!=null){
                        $extension = $file->getClientOriginalExtension();
                        $existe = Archivo::where("numero",$id)->where("tipo",$tipo)->where("estado","N")->first();
                        if($existe!=null){
                            Storage::disk($tipo)->delete($id.".".$existe->extension);
                            $existe->estado = "A";
                            $existe->save();
                        }
                        $archivo = new Archivo();
                        $archivo->numero = $id;
                        $archivo->tipo = $tipo;
                        $archivo->extension = $extension;
                        $archivo->save();

                        $nombre = $archivo->numero.'.'.$archivo->extension;
                        Storage::disk($archivo->tipo)->put($nombre,\File::get($file));
                        new Bitacora("archivo","nuevo","Se subió un archivo de tipo ".$tipo." ( ".$obj->numero." )",$usuario->id);
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
            }else{
                $request->session()->put("mensaje",$noexiste);
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
            $numero = "";
            if($archivo->tipo=="contrato"){
                $contrato = Contrato::find($archivo->numero);
                $numero = $contrato->numero;
            }else if($archivo->tipo=="guia"){
                $guia = Guia::find($archivo->numero);
                $numero = $guia->numero;
            }else if($archivo->tipo=="traslado"){
                $traslado = Traslado::find($archivo->numero);
                $numero = $traslado->numero;
            }else if($archivo->tipo=="baja"){
                $baja = GuiaBaja::find($archivo->numero);
                $numero = $baja->numero;
            }
            $storage_path = storage_path();
            $url = $storage_path.'/app/'.$archivo->tipo.'/'.$archivo->numero.'.'.$archivo->extension;
            //verificamos si el archivo existe y lo retornamos
            if (Storage::disk($archivo->tipo)->exists($archivo->numero.'.'.$archivo->extension))
            {
              $nombre = $archivo->tipo.'-'.$numero.'.'.$archivo->extension;
              return response()->download($url,$nombre);
            }
            //si no se encuentra lanzamos un error 404.
            abort(404);
        }else{
            return redirect("/index");
        }
    }
    
    public function ImportarSucursales2(Request $request,  Response $response){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load("C:/xampp/htdocs/sisgiec/routes/sucursales.xlsx");
        $sheet = $objPHPExcel->getSheet(0);
        $array = array();
        for ($w = 2; $w <= $sheet->getHighestRow(); $w++) {
            $array[] = array(
                    $sheet->getCell("A".$w)->getFormattedValue(),//NOMBRE
                    $sheet->getCell("B".$w)->getFormattedValue(),//TIPO
                    $sheet->getCell("C".$w)->getFormattedValue(),//DIRECCION
                    $sheet->getCell("D".$w)->getFormattedValue(),//ZONA
                    $sheet->getCell("E".$w)->getFormattedValue(),//TERRITORIO
                    $sheet->getCell("F".$w)->getFormattedValue(),//DEPARTAMENTO
                    $sheet->getCell("G".$w)->getFormattedValue(),//PROVINCIA
                    $sheet->getCell("H".$w)->getFormattedValue(),//DISTRITO
                    );
        }
        DB::beginTransaction();
        $i = 1;
        
        $creados = "";
        try {
            foreach ($array as $fila){
                $i++;
                $sucursal = new Sucursal();
                
                $sucursal->nombre = $fila[0];
                
                if($fila[1]=="AG"){
                    $sucursal->id_tipo_sucursal = 5;
                }else if($fila[1]=="OF"){
                    $sucursal->id_tipo_sucursal = 6;
                }else if($fila[1]=="AC"){
                    $sucursal->id_tipo_sucursal = 8;
                }else{
                    return "ERROR 1 EN FILA N ".$i;
                }
                
                $sucursal->direccion = $fila[2];
                
                if($fila[3]=="ZP"){
                    $sucursal->id_zona = 1;
                }else if($fila[3]=="ZN"){
                    $sucursal->id_zona = 2;
                }else if($fila[3]=="ZL"){
                    $sucursal->id_zona = 3;
                }else if($fila[3]=="ZS"){
                    $sucursal->id_zona = 4;
                }else{
                    return "ERROR 2 EN FILA N ".$i;
                }
                
                if($fila[4]=="SEMI URBANO/ RURAL"){
                    $sucursal->id_tipo_territorio = 7;
                }else if($fila[4]=="URBANO"){
                    $sucursal->id_tipo_territorio = 6;
                }else if($fila[4]=="SULLANA"){
                    $sucursal->id_tipo_territorio = 5;
                }else{
                    return "ERROR 3 EN FILA N ".$i;
                }
                    
                $departamento = Departamento::where("nombre",$fila[5])->first();
                if($departamento!=null){
                    $provincia = Provincia::where("nombre",$fila[6])->where("id_departamento",$departamento->id)->first();
                    if($provincia!=null){
                        
                    }else{
                        $provincia = new Provincia();
                        $provincia->nombre = $fila[6];
                        $provincia->id_departamento = $departamento->id;
                        $provincia->save();
                        $creados += "<br>Creada provincia ".$fila[6]."</br>";
                    }
                    
                    $distrito = Distrito::where("nombre",$fila[7])->where("id_provincia",$provincia->id)->first();
                    if($distrito!=null){
                        
                    }else{
                        $distrito = new Distrito();
                        $distrito->nombre = $fila[7];
                        $distrito->id_provincia = $provincia->id;
                        $distrito->save();
                        $creados += "<br>Creado distrito ".$fila[7]."</br>";
                    }
                    $sucursal->id_distrito = $distrito->id;
                }else{
                    return "ERROR EN 4 FILA N ".$i;
                }
                $sucursal->save();
            }
            DB::commit();
            return $creados;
        } catch (\Exception $exc) {
            DB::rollback();;
            return $exc->getMessage();
        }
    }
    
    public function ImportarSucursales(Request $request,  Response $response){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load("C:/xampp/htdocs/sisgiec/routes/importar.xlsx");
        $sheet = $objPHPExcel->getSheet(5);
        $array = array();
        for ($w = 2; $w <= $sheet->getHighestRow(); $w++) {
            $array[] = array(
                    $sheet->getCell("A".$w)->getFormattedValue(),//NOMBRE
                    $sheet->getCell("B".$w)->getFormattedValue(),//TIPO
                    $sheet->getCell("C".$w)->getFormattedValue(),//DIRECCION
                    $sheet->getCell("D".$w)->getFormattedValue(),//ZONA
                    $sheet->getCell("E".$w)->getFormattedValue(),//TERRITORIO
                    $sheet->getCell("F".$w)->getFormattedValue(),//DEPARTAMENTO
                    $sheet->getCell("G".$w)->getFormattedValue(),//PROVINCIA
                    $sheet->getCell("H".$w)->getFormattedValue(),//DISTRITO
                    );
        }
        DB::beginTransaction();
        $i = 1;
        
        $errores = [];
        try {
            foreach ($array as $fila){
                $i++;
                $sucursal = new Sucursal();
                
                $sucursal->nombre = $fila[0];
                
                if($fila[1]=="AG"){
                    $sucursal->id_tipo_sucursal = 5;
                }else if($fila[1]=="OF"){
                    $sucursal->id_tipo_sucursal = 6;
                }else if($fila[1]=="AC"){
                    $sucursal->id_tipo_sucursal = 8;
                }else{
                    return "ERROR 1 EN FILA N ".$i;
                }
                
                $sucursal->direccion = $fila[2];
                
                if($fila[3]=="ZP"){
                    $sucursal->id_zona = 1;
                }else if($fila[3]=="ZN"){
                    $sucursal->id_zona = 2;
                }else if($fila[3]=="ZL"){
                    $sucursal->id_zona = 3;
                }else if($fila[3]=="ZS"){
                    $sucursal->id_zona = 4;
                }else{
                    return "ERROR 2 EN FILA N ".$i;
                }
                
                if($fila[4]=="SEMI URBANO/ RURAL"){
                    $sucursal->id_tipo_territorio = 7;
                }else if($fila[4]=="URBANO"){
                    $sucursal->id_tipo_territorio = 6;
                }else if($fila[4]=="SULLANA"){
                    $sucursal->id_tipo_territorio = 5;
                }else{
                    return "ERROR 3 EN FILA N ".$i;
                }
                    
                $departamento = Departamento::where("nombre",trim($fila[5]))->first();
                if($departamento!=null){
                    $provincia = Provincia::where("nombre",trim($fila[6]))->where("id_departamento",$departamento->id)->first();
                    if($provincia==null){
                        $errores[] =  "No existe provincia : ".$fila[6]." en fila ".$i;
                    }else{
                        $distrito = Distrito::where("nombre",trim($fila[7]))->where("id_provincia",$provincia->id)->first();
                        if($distrito==null){
                            $errores[] = "No existe distrito : ".$fila[7]." en fila ".$i;
                        }else{
                            $sucursal->id_distrito = $distrito->id;
                            $sucursal->save();
                        }
                    }
                }else{
                    $errores[] = "No existe departamento : ".$fila[5]." en fila ".$i;
                }
            }
            DB::commit();
            return json_encode(["errores"=>$errores]);
        } catch (\Exception $exc) {
            DB::rollback();;
            return $exc->getMessage();
        }
    }
    
    public function ImportarProductosSoloSeries(Request $request,  Response $response){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load("C:/xampp/htdocs/sisgiec/routes/importarsiec.xlsx");
        $sheet = $objPHPExcel->getSheet(0);
            
        try {
            for ($w = 2; $w <= $sheet->getHighestRow(); $w++) {
                $serie = $sheet->getCell("D".$w)->getFormattedValue();
                $producto = new Producto();

                $producto->serie= trim(strtoupper($serie));

                $producto->save();
            }
            return "FIN";
        } catch (\Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    public function ImportarProductosSucursales(Request $request,  Response $response){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load("C:/xampp/htdocs/siec/routes/importarsiec.xlsx");
        $sheet = $objPHPExcel->getSheet(0);
        $array = array();
        for ($w = 2; $w <= $sheet->getHighestRow(); $w++) {
            $array[] = array(
                    $sheet->getCell("A".$w)->getFormattedValue(),//TIPO
                    $sheet->getCell("B".$w)->getFormattedValue(),//MARCA
                    $sheet->getCell("C".$w)->getFormattedValue(),//MODELO
                    $sheet->getCell("D".$w)->getFormattedValue(),//SERIE
                    $sheet->getCell("E".$w)->getFormattedValue(),//CONTRATO
                    $sheet->getCell("G".$w)->getFormattedValue(),//SUCURSAL
                    $sheet->getCell("F".$w)->getFormattedValue(),//PROVEEDOR
                    );
        }
        $i = 1;
        $errores = [];
        try {
            foreach ($array as $fila){
                $i++;
                $producto = new Producto();
                $sucursal = Sucursal::where("nombre",$fila[5])->first();
                if($sucursal==null){
                    $errores[] = "No se encontró la sucursal: ".$fila[5]." en la fila ".$i;
                    $producto->serie = "No se encontró la sucursal: ".$fila[5]." en la fila ".$i;
                    $producto->save();
                }
            }
            return json_encode(["errores"=>$errores]);
        } catch (\Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    public function ImportarProductos(Request $request,  Response $response){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load("C:/xampp/htdocs/sisgiec/routes/importar.xlsx");
        $sheet = $objPHPExcel->getSheet(0);
        $array = array();
        for ($w = 2; $w <= $sheet->getHighestRow(); $w++) {
            $array[] = array(
                    $sheet->getCell("A".$w)->getFormattedValue(),//TIPO
                    $sheet->getCell("B".$w)->getFormattedValue(),//MARCA
                    $sheet->getCell("C".$w)->getFormattedValue(),//MODELO
                    $sheet->getCell("D".$w)->getFormattedValue(),//SERIE
                    $sheet->getCell("E".$w)->getFormattedValue(),//CONTRATO
                    $sheet->getCell("G".$w)->getFormattedValue(),//SUCURSAL
                    $sheet->getCell("F".$w)->getFormattedValue(),//PROVEEDOR
                    );
        }
        $i = 1;
        DB::beginTransaction();
        try {
            foreach ($array as $fila){
                $i++;
                $tipo = null;
                $nombre = trim(strtoupper($fila[0]));
                $tipo = TipoEquipo::where("nombre",$nombre)->first();
                if($tipo==null){
                    return "ERROR TIPO EN FILA N ".$i;
                }
                
                $marca = null;
                $nombre = trim(strtoupper($fila[1]));
                $marca = Marca::where("nombre",$nombre)->first();
                if($marca==null){
                    return "ERROR MARCA EN FILA N ".$i;
                }
                
                $modelo = null;
                $nombre = trim(strtoupper($fila[2]));
                $modelo = Modelo::where("id_marca",$marca->id)->where("id_tipo_equipo",$tipo->id)->where("nombre",$nombre)->first();
                if($modelo==null){
                    return "ERROR MODELO EN FILA N ".$i;
                }
                
                $producto = new Producto();
                $producto->id_modelo = $modelo->id;
                $producto->serie= trim(strtoupper($fila[3]));
                
                $ok = true;
                $compra = false;
                //CONTRATO
                $nombrecontrato = strtoupper(trim($fila[4]));
                if($nombrecontrato=="CONTRATO 30-2012"){
                    $idcontrato = 5;
                }else if($nombrecontrato=="CONTRATO 042-2016"){
                    $idcontrato = 1;
                }else if($nombrecontrato=="CONTRATO 28-2015"){
                    $idcontrato = 3;
                }else if($nombrecontrato=="CONTRATO 09-2014"){
                    $idcontrato = 2;
                }else if($nombrecontrato=="CONTRATO CUSCO"){
                    $idcontrato = 6;
                }else if($nombrecontrato=="CMAC SULLANA"){
                    $compra = true;
                }else{
                    $ok = false;
                }
                
                if($ok){
                    //SUCURSAL
                    $sucursal = Sucursal::where("nombre",strtoupper(trim($fila[5])))->first();
                    if($sucursal==null){
                        return "ERROR DE SUCURSAL EN FILA N ".$i;
                    }
                    $producto->id_sucursal = $sucursal->id;
                    
                    if($compra){
                        if($fila[6]=="COMPUSOFT"){
                            $idproveedor = 1;
                        }else{
                            $idproveedor = 2;
                        }
                        $contrato = Guia::join("contrato","guia.id_contrato","contrato.id")
                                ->select("contrato.*")
                                ->where("contrato.tipo","A")
                                ->where("guia.id_sucursal",$producto->id_sucursal)
                                ->where("contrato.id_proveedor",$idproveedor)
                                ->first();
                        if($contrato==null){
                            $contrato = new Contrato();
                            $contrato->numero = "COMPRA";
                            $contrato->fecha = '2017-01-01';
                            if(strtoupper(trim($fila[6]))=="COMPUSOFT"){
                                $contrato->id_proveedor = 1;
                            }else{
                                $contrato->id_proveedor = 2;
                            }
                            $contrato->tipo = "A";
                            $contrato->save();
                        }
                    }else{
                        $contrato = Contrato::find($idcontrato);
                    }
                        

                    //DETALLE CONTRATO
                    $detallecontrato = null;
                    $detallecontrato = DetalleContrato::where("id_contrato",$contrato->id)->where("id_modelo",$modelo->id)->first();
                    if($detallecontrato==null){
                        $detallecontrato = new DetalleContrato();
                        $detallecontrato->id_modelo = $modelo->id;
                        $detallecontrato->id_contrato = $contrato->id;
                        $detallecontrato->cantidad = 1;
                    }else{
                        $detallecontrato->cantidad = $detallecontrato->cantidad + 1;
                    }
                    $detallecontrato->save();

                    $producto->id_detalle_contrato = $detallecontrato->id;


                    //GUIA
                    $guia = null;
                    $guia = Guia::where("id_contrato",$contrato->id)->where("id_sucursal",$sucursal->id)->first();
                    if($guia==null){
                        $guia = new Guia();
                        $guia->numero = "0";
                        $guia->fecha = $contrato->fecha;
                        $guia->id_contrato = $contrato->id;
                        $guia->id_sucursal = $sucursal->id;
                        $guia->save();
                    }
                    $producto->id_guia = $guia->id;

                    $producto->save();

                    if($compra==false){
                        $sla = null;
                        $sla = Sla::where("id_contrato",$contrato->id)
                                ->where("id_tipo_territorio",$sucursal->id_tipo_territorio)
                                ->where("id_tipo_equipo",$tipo->id)
                                ->first();
                        if($sla==null){
                            $sla = new Sla();
                            $sla->id_contrato = $contrato->id;
                            $sla->id_tipo_equipo = $tipo->id;
                            $sla->id_tipo_territorio = $sucursal->id_tipo_territorio;
                            $sla->horas = 99;
                            $sla->save();
                        }
                    }
                }else{
                    return "ERROR DE CONTRATO EN ".$i;
                }
            }
            DB::commit();
            return "FIN";
        } catch (\Exception $exc) {
            DB::rollback();;
            return $exc->getMessage()." ".$exc->getLine()."en I ".$i;
        }
    }
    
    public function ImportarBaseProductos(Request $request,  Response $response){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load("C:/xampp/htdocs/siec/routes/importarsiec.xlsx");
        $sheet = $objPHPExcel->getSheet(0);
        $array = array();
        for ($w = 2; $w <= $sheet->getHighestRow(); $w++) {
            $array[] = array(
                    $sheet->getCell("A".$w)->getFormattedValue(),//TIPO
                    $sheet->getCell("B".$w)->getFormattedValue(),//MARCA
                    $sheet->getCell("C".$w)->getFormattedValue(),//MODELO
                    );
        }
        $i = 1;
        
        try {
            foreach ($array as $fila){
                $i++;
                $tipo = null;
                $nombre = trim(strtoupper($fila[0]));
                $tipo = TipoEquipo::where("nombre",$nombre)->first();
                if($tipo==null){
                    $tipo = new TipoEquipo();
                    $tipo->nombre = $nombre;
                    $tipo->save();
                }
                
                $marca = null;
                $nombre = trim(strtoupper($fila[1]));
                $marca = Marca::where("nombre",$nombre)->first();
                if($marca==null){
                    $marca = new Marca();
                    
                    $marca->nombre = $nombre;
                    $marca->save();
                }
                
                $modelo = null;
                $nombre = trim(strtoupper($fila[2]));
                $modelo = Modelo::where("id_marca",$marca->id)->where("id_tipo_equipo",$tipo->id)->where("nombre",$nombre)->first();
                if($modelo==null){
                    $modelo = new Modelo();
                    $modelo->id_marca = $marca->id;
                    $modelo->id_tipo_equipo = $tipo->id;
                    $modelo->nombre = $nombre;
                    $modelo->save();
                }
            }
            return "FIN";
        } catch (\Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    public function ImportarSLA(Request $request,  Response $response){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load("C:/xampp/htdocs/sisgiec/routes/importar.xlsx");
        $sheet = $objPHPExcel->getSheet(6);
        $array = array();
        for ($w = 2; $w <= $sheet->getHighestRow(); $w++) {
            $array[] = array(
                    $sheet->getCell("A".$w)->getFormattedValue(),//CONTRATO
                    $sheet->getCell("B".$w)->getFormattedValue(),//TIPO
                    $sheet->getCell("C".$w)->getFormattedValue(),//TERRITORIO
                    $sheet->getCell("D".$w)->getFormattedValue(),//SLA
                    );
        }
        $i = 1;
        
        try {
            foreach ($array as $fila){
                $i++;
                
                //CONTRATO
                $contrato = null;
                $numero = trim($fila[0]);
                $contrato = Contrato::where("numero",$numero)->first();
                if($contrato==null){
                    return "ERROR 1 EN FILA N ".$i;
                }
                
                //TIPO
                $tipo = null;
                $nombre = trim(strtoupper($fila[1]));
                $tipo = TipoEquipo::where("nombre",$nombre)->first();
                
                if($tipo!=null){
                    if($fila[2]=="SULLANA"){
                        $territorio = 5;
                    }else if($fila[2]=="URBANO"){
                        $territorio = 6;
                    }else if($fila[2]=="SEMI URBANO/RURAL"){
                        $territorio = 7;
                    }else{
                        return "ERROR e en fila ".$i;
                    }

                    $sla = new Sla();
                    $sla->id_contrato = $contrato->id;
                    $sla->id_tipo_equipo = $tipo->id;
                    $sla->id_tipo_territorio = $territorio;
                    $sla->horas = $fila[3];
                    $sla->save();
                }else{
                    return "NO EXISTE EL TIPO";
                }
            }
            return "FIN";
        } catch (\Exception $exc) {
            return $exc->getMessage();
        }
    }
}
    