<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->integer('amount');
            $table->integer('gender');
            $table->integer('age')->unsigned();
            $table->foreign('age')->references('id')->on('fields')->onDelete('cascade');
            $table->integer('section')->unsigned();
            $table->foreign('section')->references('id')->on('fields')->onDelete('cascade');
            $table->integer('state')->unsigned();
            $table->foreign('state')->references('id')->on('fields')->onDelete('cascade');
            $table->integer('center')->unsigned();
            $table->foreign('center')->references('id')->on('centers')->onDelete('cascade');
            $table->string('date');
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
        Schema::dropIfExists('clients');
    }
}
