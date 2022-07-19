<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $table = 'demande';

    public function damande_utilisateur(){
        return $this->hasOne('App\Demande_Utilisateur');
    }

}
