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
            $table->string('cargo');
            $table->enum('genero', ['M', 'F', 'Otro']);
            $table->string('foto')->nullable();
            $table->string('correo')->nullable();
            $table->string('linkendin')->nullable();
            // Datos laborales
            $table->date('fecha_ingreso');
            $table->foreignId('secretaria_id')
                ->nullable()
                ->constrained('secretarias')
                ->onDelete('cascade');
         
            $table->foreignId('perfil_id')
                ->constrained('perfiles')
                ->onDelete('cascade');
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
