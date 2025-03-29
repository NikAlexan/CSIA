<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notification_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Тип уведомления: watering, daily_check, tip, etc.
            $table->string('type');

            // Время в формате HH:MM:SS
            $table->time('notify_at')->nullable();

            // Включено ли уведомление
            $table->boolean('enabled')->default(true);

            // Пользовательский текст или подсказка
            $table->text('message')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_schedules');
    }
};
