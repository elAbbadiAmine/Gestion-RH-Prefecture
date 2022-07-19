<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demande_Utilisateur extends Model
{
    protected $table = 'demande_utilisateur';

    public function etat(){
        return $this->hasMany('App\Etat');
    }
    public function demande(){
        return $this->hasMany('App\Demande');
    }
    public function utilisateur(){
        return $this->belongsTo('App\User');
    }
}
