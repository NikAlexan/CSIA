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
    $table->string('name');
    $table->integer('germination_min_days')->nullable();
    $table->integer('germination_max_days')->nullable();
    $table->float('temperature_min')->nullable();
    $table->float('temperature_max')->nullable();
    $table->string('light')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('microgreens');
    }
};
