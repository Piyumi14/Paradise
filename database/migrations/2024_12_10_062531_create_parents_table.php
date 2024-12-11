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
            $table->enum('father_nationality', ['Sri Lankan', 'Other']);
            $table->enum('father_religion', ['Buddhism', 'Christianity', 'Hinduism', 'Islam', 'Other']);
            $table->enum('father_cast', ['Govigama', 'Radala', 'Salagama', 'Durawe', 'Karava', 'Wahumpura', 'Batgama', 'Berava']);
            $table->string('father_profession', 100)->nullable();
            $table->boolean('father_is_live')->default(true);
            $table->enum('mother_nationality', ['Sri Lankan', 'Other']);
            $table->enum('mother_religion', ['Buddhism', 'Christianity', 'Hinduism', 'Islam', 'Other']);
            $table->enum('mother_cast', ['Govigama', 'Radala', 'Salagama', 'Durawe', 'Karava', 'Wahumpura', 'Batgama', 'Berava']);
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
