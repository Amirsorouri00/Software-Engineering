<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classexam extends Model
{
    public $timestamps = false;
    public function member(){
        return $this->hasMany(Classindividual::class, 'classID', 'classID');
    }

    public function instructor(){
        return $this->belongsTo(Classindividual::class, 'personalID', 'instructorID');
    }

    public function exam(){
        return $this->hasOne(Exam::class, 'classID', 'classID');
    }
}
