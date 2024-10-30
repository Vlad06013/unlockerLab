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
        Schema::create('keyboards', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('message_id')->nullable();
            $table->foreign('message_id')
                ->references('id')
                ->on('messages')
                ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->boolean('resize_keyboard')->default(true);
            $table->boolean('one_time_keyboard')->default(true);

            $table->string('input_filter_field')->nullable();
            $table->string('table_name')->nullable();
            $table->string('key_to_button_text')->nullable();
            $table->string('key_to_button_callback_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keyboards');
    }
};
