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
        Schema::create('galerias', function (Blueprint $table) {
            $table->id();

            // Información del archivo
            $table->string('disco', 20)->default('public')->index();
            $table->string('ruta_archivo')->comment('Ruta física del archivo en el disco');
            $table->string('nombre_original')->comment('Nombre original del archivo');
            $table->string('mime_type', 100)->comment('Tipo MIME del archivo');
            $table->unsignedBigInteger('tamano_bytes')->comment('Tamaño en bytes');

            // Relación polimórfica
            $table->unsignedBigInteger('galeriaable_id')->nullable();
            $table->string('galeriaable_type')->nullable();

            // Metadatos y categorización
            $table->string('tipo_archivo', 50)->index()->comment('imagen/documento/archivo');
            $table->json('metadatos')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['galeriaable_id', 'galeriaable_type']);
            $table->index(['disco', 'tipo_archivo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galerias');
    }
};
