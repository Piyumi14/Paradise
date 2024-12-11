<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCredentialsTable extends Migration
{
    public function up()
    {
        Schema::create('user_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('user_name', 100);
            $table->string('password', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_credentials');
    }
}
