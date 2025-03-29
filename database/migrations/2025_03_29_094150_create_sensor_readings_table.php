<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sensor_readings', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp');
            $table->string('device');
            $table->float('soil1');
            $table->float('soil2');
            $table->float('soil3');
            $table->float('soil4');
            $table->float('soil5');
            $table->float('water_temperature');
            $table->float('air_temperature');
            $table->float('air_humidity');
            $table->float('light_level');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_readings');
    }
};
