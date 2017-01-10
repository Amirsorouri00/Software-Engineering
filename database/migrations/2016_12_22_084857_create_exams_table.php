<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function(Blueprint $table){
            // Primary Key
            $table->increments('id');
            $table->char('examID', 7)->unique();
            $table->string('lessonGroup', 20);
            // Foreign Key
            $table->char('instructorID', 7);
            $table->foreign('instructorID')
              ->references('personalID')->on('classindividuals')
              ->onDelete('cascade');
            $table->integer('average');
            $table->integer('studentNumbers');
            //sizeof varchar has been changed
            //since it may be more than 30 character
            $table->string('location', 50);
            $table->integer('questionScore')->default(1);
            $table->dateTime('lastRound_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exams');
    }
}
