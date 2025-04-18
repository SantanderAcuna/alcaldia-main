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
            $table->foreignId('categoria_id')->constrained()->comment('Relación con navbar');
            $table->string('nombre', 150)->index();
            $table->string('cargo', 100);
            $table->string('email')->unique();
            $table->json('contactos')->comment('{telefonos:[], redes_sociales: {}}');
            $table->foreignId('tipo_entidad_id')->constrained()->comment('Relación con navbar');
           $table->foreignId('foto_id')->nullable()->constrained('galerias')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

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
