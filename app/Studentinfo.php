<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studentinfo extends Model
{
    public $timestamps = false;

    public function participants()
    {
        return $this->belongsTo(Classindividual::class, 'personalID', 'participantID');
    }

    public function individuals()
    {
        return Classindividual::where('personalID', $this->participantID)->firstOrFail();
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'examID', 'examID');
    }

    public function reduceGrade($grade)
    {
        dd($grade);
        return self::all()->where('roundNumber', 2);
    }

    public static function getFree()
    {

        $cList = Classindividual::all()->where('isPresent', 1);
        $list = collect();
        foreach ($cList as $cl) {
            $student = $cl->person()->get()->first();
            if ($student)
                if ($student->individualStatus == 0) {
                    $list->push($student);
                }


        }
        return $list;
    }
}
