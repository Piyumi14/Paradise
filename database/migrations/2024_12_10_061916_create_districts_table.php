<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained('provinces');
            $table->string('name', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('districts');
    }
}
