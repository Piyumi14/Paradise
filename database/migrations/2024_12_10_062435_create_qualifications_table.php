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
            $table->enum('industry', ['IT', 'Healthcare', 'Engineering', 'Education', 'Finance', 'Government', 'Other'])->nullable();
            $table->string('company', 200)->nullable();
            $table->string('salary_range', 50)->nullable();
            $table->enum('highest_education', ['High School', 'Bachelor’s Degree', 'Master’s Degree', 'Doctorate', 'Other'])->nullable();
            $table->string('field_of_study', 200)->nullable();
            $table->string('institution', 200)->nullable();
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposals')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qualifications');
    }
}

