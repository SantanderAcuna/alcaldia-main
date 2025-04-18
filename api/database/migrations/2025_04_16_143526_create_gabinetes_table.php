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
        Schema::create('gabinetes', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('dependencia_id')->constrained()->cascadeOnDelete();
            $table->foreignId('perfil_id')->constrained('perfiles')->cascadeOnDelete();
            $table->date('fecha_inicio')->index();
            $table->date('fecha_fin')->nullable()->index();
            $table->boolean('actual')->default(false)->index();
            $table->timestamps();

            // Restricción única compuesta
            $table->unique(['user_id', 'dependencia_id', 'perfil_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gabinetes');
    }
};
