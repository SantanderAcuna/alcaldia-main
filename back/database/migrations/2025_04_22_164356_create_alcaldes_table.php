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
        Schema::create('alcaldes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo', 150);
            $table->enum('sexo', ['masculino', 'femenino', 'Otro'])->default('Otro');


            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();

            $table->longText('presentacion')->nullable(); // Cambiado a longText
            $table->string('foto_path')->nullable();
            $table->boolean('actual')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Índices optimizados
            $table->index('actual');
            $table->index(['fecha_inicio', 'fecha_fin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alcaldes');
    }
};
