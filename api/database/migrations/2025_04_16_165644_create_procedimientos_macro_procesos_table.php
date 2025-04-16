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
        Schema::create('procedimientos_macro_procesos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('macro_proceso_id')->constrained('macro_procesos')->onDelete('cascade');
            $table->foreignId('tipo_procedimiento_id')->constrained('tipo_procedimientos')->onDelete('restrict');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->integer('orden')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedimientos_macro_procesos');
    }
};
