<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('reference_number', 10)->unique();
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);
            $table->string('preferred_name', 100);
            $table->integer('age')->nullable();
            $table->enum('gender', ['Male', 'Female']);
            $table->string('phone_number', 100);
            $table->string('email', 100);
            $table->string('height_f', 10)->nullable();
            $table->string('height_i', 10)->nullable();
            $table->string('civil_status', 100);
            $table->string('country', 100);
            $table->string('province', 100);
            $table->string('district', 100);
            $table->string('area', 100);
            $table->string('nationality', 100);
            $table->string('religion', 100);
            $table->string('cast', 100);
            $table->text('profile_description')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}
