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
       // Migración roles
Schema::create('roles', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('name', 50)->unique()->comment('Clave interna del rol, p.ej. admin');
    $table->string('slug', 60)->unique()->comment('URL-friendly');
    $table->string('label', 100)->comment('Nombre legible, p.ej. Administrador');
    $table->boolean('is_active')->default(true)->index()->comment('Rol habilitado');
    $table->softDeletes();
    $table->timestamps();
});

// Migración permisos
Schema::create('permisos', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('nombre')->unique()->comment('Ej: post.create');
    $table->string('grupo', 50)->index()->comment('Agrupación: users, posts');
    $table->string('slug');
    $table->boolean('is_active')->default(true)->index();
    $table->softDeletes();
    $table->timestamps();
});

// Migración permiso_rols (Tabla pivot)
Schema::create('permiso_rols', function (Blueprint $table) {
    $table->unsignedBigInteger('role_id');
    $table->unsignedBigInteger('permiso_id');
    $table->primary(['role_id', 'permiso_id']);
    $table->index(['permiso_id', 'role_id']);
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
