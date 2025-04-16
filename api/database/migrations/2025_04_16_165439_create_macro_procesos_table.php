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
        Schema::create('macro_procesos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique();
            $table->text('mision');
            $table->text('vision')->nullable();
            $table->foreignId('dependencia_id')->constrained('dependencias')->onDelete('cascade');
            $table->string('codigo', 50)->nullable()->unique();
            $table->string('organigrama_url', 500)->nullable(); // Nueva columna para imagen
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('macro_procesos');
    }
};
