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
        Schema::create('tg_messagables', function (Blueprint $table) {
            $table->id();
            $table->morphs("tg_messagable");
            $table->unsignedInteger('from_message_id');
            $table->foreign('from_message_id')
                ->references('id')
                ->on('messages')
                ->onDelete('cascade');
            $table->unsignedInteger('to_message_id')->nullable();
            $table->foreign('to_message_id')
                ->references('id')
                ->on('messages')
                ->onDelete('cascade');
            $table->string('callback_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tg_messagables');
    }
};
