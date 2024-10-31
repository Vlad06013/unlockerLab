<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lock_mech_secret_types', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->timestamps();
        });

        $this->add();
    }
    public function add()
    {
        $types = [
            'Крестовой',
            'Сувальдный',
            'Цилиндровый',
            'Двухсистемный',
            'Реечный',
            'Помповый',
        ];
        foreach ($types as $type) {
            \App\Models\LockMechSecretType::create(['name' => $type]);
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("lock_mech_secret_types");
    }
};
