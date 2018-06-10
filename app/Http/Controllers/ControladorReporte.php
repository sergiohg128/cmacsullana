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
use Datetime; 
use Exception; 
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Input; 
use App\Reportes;
use App\Cuota;
class ControladorReporte extends Controller 
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
 
    public function Reportes(Request $request,  Response $response) { 
        $usuario = $request->session()->get('usuario'); 
        if($this->ComprobarUsuario($usuario)){ 
            $menuid = 18; 
            if($this->ComprobarPermiso($usuario, $menuid)){ 
                $mensaje = $request->session()->get('mensaje'); 
                $request->session()->forget('mensaje'); 
                return view('/reportes',[ 
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
 
    public function Reporte(Request $request,  Response $response) { 
        $usuario = $request->session()->get('usuario'); 
        if($this->ComprobarUsuario($usuario)){ 
            $menuid = 18; 
            if($this->ComprobarPermiso($usuario, $menuid)){ 
                $mensaje = $request->session()->get('mensaje'); 
                $request->session()->forget('mensaje'); 
                $reporte = request()->input("modo"); 
                $url = ""; 
                if($reporte=="cuotapendiente"){ 
                    $url = "listarcuotas"; 
                }elseif($reporte=="pagorealizado"){ 
                    $url = "listarpagos"; 
                } 
                return view('/reporte',[ 
                    'usuario'=>$usuario, 
                    'mensaje'=>$mensaje, 
                    'modo'=>$reporte, 
                    'url'=>$url, 
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

    public function Exportar(Request $request,  Response $response) { 
        $usuario = $request->session()->get('usuario'); 
        if($this->ComprobarUsuario($usuario)){ 
            $menuid = 18; 
            if($this->ComprobarPermiso($usuario, $menuid)){ 
                $modo = $request->input("modo");
                $fecini = $request->input("fecini");
                $fecfin = $request->input("fecfin");

                if($modo == "cuotapendiente"){
                    $cuotas = Cuota::where("estado","<>","A"); 
                    $cuotas = $cuotas->orderBy("fecha","DESC");
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
                    Reportes::CuotasPendientes($cuotas,$fecini,$fecfin);
                }else if($modo=="pagorealizado"){
                    $pagos = Pago::query();
                    $pagos = $pagos->where("pago.estado","<>","A"); 
                    $pagos = $pagos->orderBy("fecha");
                    if(strlen($fecini)>0){ 
                        $pagos = $pagos->where("fecha",">=",$fecini); 
                    } 
                    if(strlen($fecfin)>0){ 
                        $pagos = $pagos->where("fecha","<=",$fecfin); 
                    }
                    $pagos = $pagos->get(); 
                    Reportes::PagosRealizados($pagos,$fecini,$fecfin);
                }
            }else{ 
                $request->session()->put("mensaje","NO TIENE ACCESO AL MENÚ ".Menu::find($menuid)->nombre); 
                return redirect ("/inicio"); 
            } 
        }else{ 
            return redirect("/index"); 
        } 
    } 
 
} 