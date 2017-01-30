<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRandomnumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('randomnumbers', function (Blueprint $table) {
          // primary key
          $table->increments('id');
          $table->char('numberID', 7)->unique();
          //foreign key
          $table->char('examID', 7);
          $table->foreign('examID')
            ->references('examID')->on('exams')
            ->onDelete('cascade');
          $table->string('subsystem', 50);
          // data type has changed from int to string(varchar)
          $table->string('randNumber');
          // detecting the fact whether subsystem
          // is a reciever or sender
          $table->boolean('detectionBit');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('randomnumbers');
    }
}
