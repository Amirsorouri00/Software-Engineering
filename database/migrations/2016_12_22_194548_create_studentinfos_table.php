<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentinfos', function (Blueprint $table) {
            $table->increments('id');
            // foreign key
            $table->char('participantID',7);
            $table->foreign('participantID')
                ->references('personalID')->on('classindividuals')
                ->onDelete('cascade');
            // foreign key
            $table->char('examID', 7);
            $table->foreign('examID')
                ->references('examID')->on('exams')
                ->onDelete('cascade');
            $table->integer('roundNumber');
            $table->boolean('QorR');
            $table->integer('gradeH');
            $table->integer('gradeL');
            // data type has changed from bit to boolean
            $table->boolean('individualStatus');
            // data type has changed from bit to boolean
            $table->double('finalScore', 4, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('studentinfos');
    }
}
