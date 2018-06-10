<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    
    protected $table = 'proyecto';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function usuario(){ 
        return $this->hasOne("App\Usuario","id","id_usuario"); 
    } 
}
