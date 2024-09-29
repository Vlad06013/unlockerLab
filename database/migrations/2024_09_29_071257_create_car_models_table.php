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
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('car_mark_id')->nullable();
            $table->foreign('car_mark_id')
                ->references('id')
                ->on('car_marks')
                ->onUpdate('cascade')
                ->nullOnDelete();
            $table->unsignedInteger('detail_id')->nullable();
            $table->foreign('detail_id')
                ->references('id')
                ->on('details')
                ->onUpdate('cascade')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
};
