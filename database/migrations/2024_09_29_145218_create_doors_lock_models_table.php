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
        Schema::create('doors_lock_models', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('doors_lock_mark_id')->nullable();
            $table->foreign('doors_lock_mark_id')
                ->references('id')
                ->on('doors_lock_marks')
                ->onUpdate('cascade')
                ->nullOnDelete();
            $table->unsignedInteger('lock_type_id')->nullable();
            $table->foreign('lock_type_id')
                ->references('id')
                ->on('lock_types')
                ->onUpdate('cascade')
                ->nullOnDelete();
            $table->unsignedInteger('lock_mech_secret_type_id')->nullable();
            $table->foreign('lock_mech_secret_type_id')
                ->references('id')
                ->on('lock_mech_secret_types')
                ->onUpdate('cascade')
                ->nullOnDelete();
            $table->unsignedInteger('secret_type')->nullable();
            $table->string('resistance_class')->nullable();
            $table->boolean('tail_latch')->default(false);
            $table->boolean('latch_inside')->default(false);
            $table->boolean('rods')->default(false);
            $table->string('center_distance')->nullable();
            $table->string('backset')->nullable();
            $table->string('end_strip_length')->nullable();
            $table->string('end_strip_width')->nullable();
            $table->string('center_distance_fastenings')->nullable();
            $table->string('crossbar_diameter')->nullable();
            $table->string('deadbolt_overhang')->nullable();
            $table->unsignedInteger('overhang_count')->default(1);
            $table->string('body_height')->nullable();
            $table->string('case_depth')->nullable();
            $table->string('width_depth')->nullable();
            $table->string('locking_from_inside')->default('none');
            $table->string('key_type')->nullable();
            $table->mediumText('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doors_lock_models');
    }
};
