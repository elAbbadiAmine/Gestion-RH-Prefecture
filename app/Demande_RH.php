<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Demande;

class Demande_RH extends Model
{
    protected $table = 'demanderh';

    public function rh(){
        return $this->belongsTo("App\Demande");
    }
}
