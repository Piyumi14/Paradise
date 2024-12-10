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
            $table->bigInteger('phone_number');
            $table->string('email', 100);
            $table->string('height', 10)->nullable();
            $table->enum('civil_status', ['Single', 'Divorced', 'Widowed', 'Engaged', 'Separated']);
            $table->foreignId('country_id')->constrained('countries')->default(1);
            $table->foreignId('province_id')->constrained('provinces');
            $table->foreignId('district_id')->constrained('districts');
            $table->string('area', 100);
            $table->enum('nationality', ['Sri Lankan', 'Other']);
            $table->enum('religion', ['Buddhism', 'Christianity', 'Hinduism', 'Islam', 'Other']);
            $table->enum('cast', ['Govigama', 'Radala', 'Salagama', 'Durawe', 'Karava', 'Wahumpura', 'Batgama', 'Berava']);
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
