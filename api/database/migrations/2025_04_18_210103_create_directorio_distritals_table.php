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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('categoria_id')->index('directorio_distritals_categoria_id_foreign');
            $table->string('nombre', 150)->index();
            $table->string('cargo', 100);
            $table->string('email')->unique();
            $table->json('contactos')->comment('{telefonos:[], redes_sociales: {}}');
            $table->unsignedBigInteger('tipo_entidad_id')->index('directorio_distritals_tipo_entidad_id_foreign');
            $table->unsignedBigInteger('foto_id')->nullable()->index('directorio_distritals_foto_id_foreign');
            $table->timestamps();
            $table->softDeletes();

            // Relaciones (FKs explícitas)
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('tipo_entidad_id')->references('id')->on('tipo_entidades');
            $table->foreign('foto_id')->references('id')->on('galerias');
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
