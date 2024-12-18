<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiblingsTable extends Migration
{
    public function up()
    {
        Schema::create('siblings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->string('sibling_type', 100);
            $table->string('civil_status', 100);
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposals')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('siblings');
    }
}
