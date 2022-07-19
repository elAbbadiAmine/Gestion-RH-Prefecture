<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Division;
use Laravel\Passport\HasApiTokens;

class Service extends Model
{
    protected $table = 'services';

    public function division() {
        return $this->belongsTo('App\Division');
    }
    public function user() {
        return $this->hasMany('App\User');
    }
}
