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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->enum('genero', ['M', 'F']);
            $table->string('foto')->nullable();
            $table->string('correo')->nullable()->unique();
            $table->string('linkedin')->nullable();
            $table->string('departamento');
            $table->string('municipio');
            $table->date('fecha_nacimiento');
            $table->foreignId('dependencia_id')->constrained('dependencias')->onDelete('cascade');
            $table->foreignId('cargo_id')->constrained('cargos')->onDelete('cascade');
            $table->foreignId('perfil_id')->constrained('perfiles')->onDelete('cascade');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Inactivo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
