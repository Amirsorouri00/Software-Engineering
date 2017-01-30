<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Randomnumber extends Model
{
  public $timestamps = false;
  public function exam(){
    return $this->belongsTo(Exam::class, 'examID', 'examID');
  }
}
