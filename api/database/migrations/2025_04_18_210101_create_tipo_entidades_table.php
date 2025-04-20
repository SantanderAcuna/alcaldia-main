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
        Schema::create('tipo_entidades', function (Blueprint $table) {
            $table->id(); // Equivale a: bigIncrements('id')->unsigned()

            $table->string('nombre', 50)->unique()->comment('Nombre oficial: SECRETARÍA, INSTITUTO, etc.');
            $table->string('slug', 60)->unique()->comment('URL-friendly: secretaria, instituto');
            $table->text('descripcion')->nullable()->comment('Propósito de este tipo de entidad');
            $table->integer('nivel_jerarquico')->default(1)->comment('Orden jerárquico para visualización');
            $table->boolean('activo')->default(true)->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_entidades');
    }
};
