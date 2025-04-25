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
            $table->bigIncrements('id');

            // Datos básicos del alcalde
            $table->string('nombre_completo');
            $table->string('cargo')->comment('alcalde distrital y periodo');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->longText('objetivo')->nullable();
            $table->boolean('actual')->default(true);

            // Relación para la foto de perfil (IMAGEN)
            $table->foreignId('foto_id')
                ->nullable()
                ->constrained('galerias')
                ->onDelete('set null')
                ->comment('Referencia a la foto de perfil en galerías');

            // Relación para el plan de desarrollo (DOCUMENTO)
            $table->foreignId('plan_desarrollo_id')
                ->nullable()
                ->constrained('galerias')
                ->onDelete('set null')
                ->comment('Referencia al documento del plan de desarrollo en galerías');

            $table->timestamps();

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
