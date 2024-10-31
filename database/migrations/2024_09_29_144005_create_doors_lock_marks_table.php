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
        Schema::create('doors_lock_marks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('link_on_forum_topic')->nullable();
            $table->timestamps();
        });

        $this->add();
    }
    public function add()
    {
        $types = [
            'Гардиан',
            'Бордер',
            'Эльбор',
            'Просам',
            'Kale Kilit',
            'Cisa',
            'Mottura',
            'Mul-T-Lock',
        ];
        foreach ($types as $type) {
            \App\Models\DoorsLockMark::create(['name' => $type]);
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doors_lock_marks');
    }
};
