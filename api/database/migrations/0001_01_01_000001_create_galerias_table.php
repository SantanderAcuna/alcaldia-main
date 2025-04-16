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
            // Nombre amigable o título para el archivo (opcional)
            $table->string('nombre')->nullable();
            // La ruta donde se almacena el archivo (puede ser un path relativo o URL)
            $table->string('ruta');
            // Tipo de archivo: imagen, documento, video, audio, etc.
            $table->string('tipo')->nullable();
            // Extensión del archivo, ej. jpg, png, pdf, mp4...
            $table->string('extension')->nullable();
            // Tamaño del archivo en bytes
            $table->unsignedBigInteger('tamano')->nullable();
            // Descripción adicional o metadatos
            $table->text('descripcion')->nullable();
            $table->timestamps();
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
