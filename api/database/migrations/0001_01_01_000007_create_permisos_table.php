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
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();                                                      // BigInt unsigned PK
            $table->string('name', 60)->unique()->comment('Clave interna, p.ej. post.create');
            $table->string('slug', 100)->unique()->comment('URL-friendly o agrupación');
            $table->string('label', 120)->comment('Nombre legible, p.ej. Crear publicaciones');
            $table->boolean('is_active')->default(true)->comment('Permiso habilitado');
            $table->softDeletes();                                              // Soft deletes
            $table->timestamps();                                               // created_at y updated_at
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};
