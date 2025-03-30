<?php

use App\Models\Batch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('observations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Batch::class, 'batch_id')->constrained('batches');
            $table->dateTime('date');
            $table->text('visualChanges');
            $table->string('image');
            $table->string('height');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observations');
    }
};
