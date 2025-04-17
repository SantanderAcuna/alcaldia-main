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
        Schema::create('directorio_distritals', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('funcionario');
            $table->string('correo');
            $table->string('red_social')->nullable();
            $table->enum('tipo_entidad', [
                'SECRETARÍA',
                'INSTITUTO',
                'DESCENTRALIZADO',
                'JEFATURA',
                'ASESORÍA',
                'SUBDIRECCIÓN'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directorio_distritals');
    }
};
