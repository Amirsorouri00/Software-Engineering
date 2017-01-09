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
  public  function  reduceGrade($grade)
  {
    dd($grade);
    return self::all()->where('roundNumber',2);
  }
}
