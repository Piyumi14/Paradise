<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationsTable extends Migration
{
    public function up()
    {
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->string('occupation', 200)->nullable();
            $table->string('industry', 100)->nullable();
            $table->string('company', 200)->nullable();
            $table->string('salary_range', 50)->nullable();
            $table->string('highest_education', 100)->nullable();
            $table->string('field_of_study', 200)->nullable();
            $table->string('institution', 200)->nullable();
            $table->text('other_details')->nullable();
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposals')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qualifications');
    }
}
