<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    
    protected $table = 'cuota';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function proyecto(){
        return $this->hasOne("App\Proyecto","id","id_proyecto");
    }
    
}
