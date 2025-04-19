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
            $table->bigIncrements('id');
            $table->string('disco', 20)
                ->default('public')
                ->index();
            $table->string('ruta_archivo')
                ->comment('Ruta relativa en el disco');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('tamano_bytes');
            $table->json('metadatos')
                ->nullable()
                ->comment('EXIF, dimensiones, etc.');
            $table->fullText('metadatos');

            // Estas columnas serán NULL por defecto y evitan el error de constraint
            $table->nullableMorphs('galeriaable');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['created_at', 'disco']);
            // El índice para morphs ya lo crea nullableMorphs automáticamente
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
