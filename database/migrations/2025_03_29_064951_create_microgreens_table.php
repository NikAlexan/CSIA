<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('microgreens', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название сорта (например, базилик)
            $table->string('germination_time')->nullable(); // Срок проращивания (например, "5-7 дней")
            $table->string('temperature')->nullable(); // Рекомендованная температура (например, "20-24°C")
            $table->string('light')->nullable(); // Освещение (например, "яркий рассеянный свет")
            $table->timestamps(); // created_at и updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('microgreens');
    }
};
