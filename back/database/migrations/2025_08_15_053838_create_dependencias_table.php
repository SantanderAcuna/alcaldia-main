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
        Schema::create('dependencias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('codigo', 20)->unique()->nullable();
            $table->text('descripcion');
            $table->enum('tipo', ['SECRETARIA', 'DEPENDENCIA', 'SUB_DEPENDENCIA'])->default('DEPENDENCIA');
            $table->foreignId('dependencia_padre_id')
                ->nullable()
                ->constrained('dependencias')
                ->onDelete('cascade');
            $table->text('mision');
            $table->text('vision');
            $table->string('organigrama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependencias');
    }
};
