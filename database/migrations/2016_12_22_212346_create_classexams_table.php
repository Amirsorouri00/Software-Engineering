<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassexamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classexams', function (Blueprint $table) {
          // Primary Key
          $table->increments('id');
          $table->char('classID',7)->unique();
          // Foreign Key
          $table->char('instructorID', 7);
          $table->foreign('instructorID')
            ->references('personalID')->on('classindividuals')
            ->onDelete('cascade');
          $table->string('department',20);
          $table->string('location', 20);
          /*
          * this is not useable this way...
          * should be changed
          $table->date('classTime');*/
          $table->rememberToken();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('classexams');
    }
}
