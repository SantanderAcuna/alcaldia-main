<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
 Schema::create('auditoria', function (Blueprint $table) {
    $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY

    $table->string('tabla', 100)
        ->comment('Tabla auditada');

    $table->enum('operacion', ['INSERT', 'UPDATE', 'DELETE'])
        ->comment('Tipo de operación');

    $table->string('usuario_bd', 100)
        ->comment('Usuario de BD que ejecutó la acción');

    $table->json('datos_anteriores')
        ->nullable()
        ->comment('Estado anterior del registro');

    $table->json('datos_nuevos')
        ->nullable()
        ->comment('Estado posterior del registro');

    $table->timestamp('fecha_evento')
        ->useCurrent()
        ->comment('Fecha y hora del cambio');
});

// Esto va **fuera** del Schema::create
DB::statement("ALTER TABLE auditoria CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria');
    }
};


