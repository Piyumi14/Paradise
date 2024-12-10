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
            $table->date('birth_date')->nullable();
            $table->time('birth_time')->nullable();
            $table->string('birth_place', 100)->nullable();
            $table->enum('lagnaya', ['Mesha', 'Wrushamba', 'Mithuna', 'Kataka', 'Sinha', 'Kanya', 'Thula', 'Wrushika', 'Dhanu', 'Makara', 'Kumba', 'Meena']);
            $table->text('horoscope_details')->nullable();
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposals')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('horoscopes');
    }
}
