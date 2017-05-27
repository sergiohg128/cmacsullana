<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    
    protected $table = 'producto';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function detallecontrato(){
        return DetalleContrato::find($this->id_detalle_contrato);
    }
    
    public function contrato(){
        return Contrato::find(DetalleContrato::find($this->id_detalle_contrato)->select('id_contrato'));
    }
    
    public function modelo(){
        return Modelo::find($this->id_modelo);
    }
    
    public function sucursal(){
        return Sucursal::find($this->id_sucursal);
    }
    
    public function guia(){
        return Guia::find($this->id_guia);
    }
    
    public function areasucursal(){
        return AreaSucursal::find($this->id_area_sucursal);
    }
    
    public function sla(){
        $detallecontrato = DetalleContrato::find($this->id_detalle_contrato);
        if($detallecontrato!=null){
            $idcontrato = $detallecontrato->id_contrato;
            $modelo = Modelo::find($this->id_modelo);
            $idtipoequipo = $modelo->id_tipo_equipo;
            $sucursal = Sucursal::find($this->id_sucursal);
            $idtipoterritorio = $sucursal->id_tipo_territorio;
            $sla = Sla::where("id_contrato",$idcontrato)->where("id_tipo_equipo",$idtipoequipo)->where("id_tipo_territorio",$idtipoterritorio)->select("horas")->first()->horas;
        }else{
            $sla = null;
        }
            
        return $sla;
    }
}
