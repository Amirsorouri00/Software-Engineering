<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
  public $timestamps = false;
    public function basket(){
      return $this->hasMany(Basket::class, 'examID', 'examID');
    }

    public function randomNum(){
      return $this->hasMany(Randomnumber::class, 'examID', 'examID');
    }

    public function student(){
      return $this->hasMany(Studentinfo::class, 'examID', 'examID');
    }

    public function instructor(){
      return $this->hasOne(Classindividual::class, 'personalID', 'instructorID');
    }
}
