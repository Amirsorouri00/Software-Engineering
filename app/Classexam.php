<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classexam extends Model
{
  public $timestamps = false;
  public function classindividual(){
    return $this->hasMany(Classindividual::class, 'classID', 'classID');
  }

}
