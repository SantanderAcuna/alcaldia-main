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
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->text('titulo');
            $table->text('descripcion')->nullable();
            $table->longText('cuerpo')->nullable();
            $table->longText('body')->nullable();
           
            $table->enum('estado', ['borrador', 'publicado'])
                ->default('borrador')
                ->comment('Estado de la publicación');
            $table->foreignId('tag_id')
                ->nullable()
                ->constrained('tags')
                ->onDelete('cascade');
            $table->foreignId('tipo_id')
                ->nullable()
                ->constrained('tipos')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
