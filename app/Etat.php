<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    protected $table = 'etat';

    public function deamnde_utilisateur(){
        return $this->hasMany('App\Demande_Utilisateur');
    }

}
