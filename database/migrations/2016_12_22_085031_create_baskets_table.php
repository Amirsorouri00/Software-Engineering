<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baskets', function (Blueprint $table) {
            // primary key
            $table->increments('id');
            $table->char('basketID', 7)->unique();
            // foreign key
            $table->char('examID', 7);
            $table->foreign('examID')
                ->references('examID')->on('exams')
                ->onDelete('cascade');
            // foreign key
            $table->char('questionerID', 7);
            $table->foreign('questionerID')
                ->references('personalID')->on('classindividuals')
                ->onDelete('cascade');
            // foreign key
            $table->char('responderedID', 7);
            $table->foreign('responderedID')
                ->references('personalID')->on('classIndividuals')
                ->onDelete('cascade');
            // bit changed to boolean
            $table->boolean('correctness');
            // given from the questionBank service
            $table->char('questionID', 7);
            $table->string('basketStatus', 20);
            $table->integer('basketScore');
            $table->integer('flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('baskets');
    }
}
