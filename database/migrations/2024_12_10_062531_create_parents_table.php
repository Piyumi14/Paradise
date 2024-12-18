<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentsTable extends Migration
{
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->string('father_nationality', 100);
            $table->string('father_religion', 100);
            $table->string('father_cast', 100);
            $table->string('father_profession', 100)->nullable();
            $table->boolean('father_is_live')->default(true);
            $table->string('mother_nationality', 100);
            $table->string('mother_religion', 100);
            $table->string('mother_cast', 100);
            $table->string('mother_profession', 100)->nullable();
            $table->boolean('mother_is_live')->default(true);
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposals')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parents');
    }
}
