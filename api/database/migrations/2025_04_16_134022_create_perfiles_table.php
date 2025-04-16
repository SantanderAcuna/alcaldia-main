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
        Schema::create('perfiles', function (Blueprint $table) {

            $table->id(); // Crea un unsignedBigInteger como primary key.
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('dependencia_id')
                ->nullable()
                ->constrained('dependencias')
                ->nullOnDelete();

            // Información académica
            $table->string('titulo_profesional')->nullable();
            $table->string('especializacion')->nullable();
            $table->string('doctorado')->nullable();

            // Otros campos
            $table->string('foto_url', 500)->nullable();
            $table->text('resumen_biografico')->nullable();
            $table->json('experiencia_publica')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfiles');
    }
};
