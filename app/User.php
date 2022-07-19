<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom','prenom','CNE','Division','Matricule','Sex','Date-naissance','Adresse','Telephone','Date_recrutement','Intitule', 'email', 'password', 'bio', 'photo','type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function division() {
        return $this->belongsTo('App\Division');
    }
    public function service() {
        return $this->belongsTo('App\Service');
    }
    public function demande_user(){
        return $this->hasMany('App\Demande_Utilisateur');
    }
}
