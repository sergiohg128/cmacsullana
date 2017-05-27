<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleContrato extends Model
{
    
    protected $table = 'detalle_contrato';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function contrato() {
        return Contrato::find($this->id_contrato);
    }
    
    public function modelo(){
        return Modelo::find($this->id_modelo);
    }
    
    public function sla(){
        $idcontrato = $this->id_contrato;
        $idtipoequipo = Modelo::find($this->id_modelo)->select('id_tipo_equipo')->first()->id_tipo_equipo;
        $idtipoterritorio = Sucursal::find($this->id_sucursal)->select('id_tipo_territorio')->first()->id_tipo_territorio;
        $sla = Sla::where("id_contrato",$idcontrato)->where("id_tipo_equipo",$idtipoequipo)->where("id_tipo_territorio",$idtipoterritorio)->select("horas")->first()->horas;
        return $sla;
    }
}
