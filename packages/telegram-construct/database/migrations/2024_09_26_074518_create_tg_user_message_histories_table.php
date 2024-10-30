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
        Schema::create('tg_user_message_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tg_user_id');
            $table->foreign('tg_user_id')
                ->references('id')
                ->on('tg_users')
                ->onDelete('cascade');
            $table->unsignedInteger('bot_id');
            $table->foreign('bot_id')
                ->references('id')
                ->on('bots')
                ->onDelete('cascade');
            $table->unsignedBigInteger('last_message_id')->nullable();
            $table->unsignedBigInteger('last_tg_message_id')->nullable();
            $table->string('last_query_filter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tg_user_message_histories');
    }
};
