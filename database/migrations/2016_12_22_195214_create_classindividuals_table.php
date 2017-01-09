<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassindividualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classindividuals', function (Blueprint $table) {
            $table->increments('id');
            $table->char('personalID', 7)->unique();
            /* Foreign key */
            $table->char('classID', 7);
            $table->foreign('classID')
                ->references('classID')->on('classexams')
                ->onDelete('cascade');
            $table->integer('accessibility');
            //next 2 attributes data type has changed since there maybe
            //exists more than 2 state
            $table->integer('isPresent');
            $table->integer('isActive');
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('classindividuals');
    }
}
