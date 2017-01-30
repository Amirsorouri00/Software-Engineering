<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{

  public $timestamps = false;
    public function exam(){
      return $this->belongsTo(Exam::class, 'examID', 'examID');
    }

    public function questioner(){
      return $this->hasOne(Classindividual::class, 'personalID', 'questionerID');
    }

    public function responder(){
      return $this->hasOne(Classindividual::class,  'personalID', 'responderedID');
    }

}
