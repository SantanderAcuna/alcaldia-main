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
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->unique()->comment('Clave interna del rol, p.ej. admin');
            $table->string('slug', 60)->unique()->comment('URL-friendly');
            $table->string('label', 100)->comment('Nombre legible, p.ej. Administrador');
            $table->boolean('is_active')->default(true)->index()->comment('Rol habilitado');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
