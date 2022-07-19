<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDisplay extends Model
{
    //
    protected $fillable = [
        'nom','prenom','CNE','Division','Matricule','Sex','Date-naissance','Adresse','Telephone','Date_recrutement','Intitule', 'email', 'password', 'bio', 'photo','type'
    ];
}
