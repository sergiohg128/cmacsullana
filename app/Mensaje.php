<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    
    protected $table = 'mensaje';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function usuario(){
        return $this->hasOne("App\Usuario","id","id_usuario");
    }
    
    public function archivo(){
        $archivos = Archivo::where("id_mensaje",$this->id)->where("estado","N")->get();
        if(count($archivos)>0){
            return true;
        }else{
            return false;
        }
            
    }
    
}
