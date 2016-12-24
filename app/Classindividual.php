<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classindividual extends Model
{
  public $timestamps = false;
  public function Qbasket(){
    return $this->hasOne(Basket::class,  'questionerID', 'personalID');
  }

  public function Rbasket(){
    return $this->hasOne(Basket::class, 'responderedID', 'personalID');
  }

  public function classes(){
    return $this->belongsTo(Classexam::class, 'classID', 'classID');
  }

  public function person(){
    return $this->hasOne(Studentinfo::class, 'participantID', 'personalID');
  }

  public function insexam(){
    return $this->hasOne(Exam::class, 'instructorID', 'personalID');
  }
}
