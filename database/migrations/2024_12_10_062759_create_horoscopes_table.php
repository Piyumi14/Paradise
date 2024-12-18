<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoroscopesTable extends Migration
{
    public function up()
    {
        Schema::create('horoscopes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->string('birth_date', 100)->nullable();
            $table->string('birth_time', 100)->nullable();
            $table->string('birth_place', 100)->nullable();
            $table->string('lagnaya', 50)->nullable();
            $table->string('1', 50)->nullable();
            $table->string('2', 50)->nullable();
            $table->string('3', 50)->nullable();
            $table->string('4', 50)->nullable();
            $table->string('5', 50)->nullable();
            $table->string('6', 50)->nullable();
            $table->string('7', 50)->nullable();
            $table->string('8', 50)->nullable();
            $table->string('9', 50)->nullable();
            $table->string('10', 50)->nullable();
            $table->string('11', 50)->nullable();
            $table->string('12', 50)->nullable();
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposals')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('horoscopes');
    }
}
