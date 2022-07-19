<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demande_Conge extends Model
{
    protected $table = 'conges';

    public function conge(){
        return $this->belongsTo("App\Demande");
    }
    
}
