<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    
    protected $table = 'permiso';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function tipousuario() {
        return TipoUsuario::find($this->id_tipo_usuario);
    }
    
    public function menu() {
        return Menu::find($this->id_menu);
    }
}
