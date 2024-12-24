<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('proposal_id');
            $table->enum('status', ['Pending', 'Accepted', 'Cancelled'])->default('Pending');
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('receiver_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('proposal_id')->references('id')->on('proposals')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}
