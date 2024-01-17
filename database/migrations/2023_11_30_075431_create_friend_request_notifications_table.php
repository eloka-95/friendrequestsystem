<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('friend_request_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id'); // ID of the user who sent the friend request
            $table->unsignedBigInteger('receiver_id'); // ID of the user who received the friend request
            $table->boolean('read')->default(false); // Whether the notification has been read
            $table->timestamps();

            // Relationships
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend_request_notifications');
    }
};
