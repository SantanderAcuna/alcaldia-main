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
        Schema::create('alcaldes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('galeria_id')->nullable()->constrained('galerias')->cascadeOnDelete();

            $table->string('nombre_completo');
            $table->string('cargo')->comment('alcalde distrital y periodo');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->longText('objetivo')->nullable();
            $table->boolean('actual')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alcaldes');
    }
};
