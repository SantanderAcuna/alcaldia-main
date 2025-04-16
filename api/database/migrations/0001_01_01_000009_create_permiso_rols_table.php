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
        Schema::create('permiso_rols', function (Blueprint $table) {
            $table->foreignId('permiso_id')
            ->constrained('permisos')
            ->onDelete('cascade');
      $table->foreignId('role_id')
            ->constrained('roles')
            ->onDelete('cascade');

      $table->primary(['permiso_id', 'role_id']);                     // PK compuesta
      $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso__rols');
    }
};
