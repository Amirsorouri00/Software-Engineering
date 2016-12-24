<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studentinfo extends Model
{
  public $timestamps = false;
    public function participants(){
      return $this->belongsTo(Classindividual::class, 'personalID', 'participantID');
    }

    public function exam(){
      return $this->belongsTo(Exam::class, 'examID', 'examID');
    }
}
