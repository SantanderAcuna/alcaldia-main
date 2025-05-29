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
        Schema::create('perfiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('alcalde_id')->index();
            $table->string('titulo_profesional')->nullable();
            $table->string('especializacion')->nullable();
            $table->text('resumen_biografico')->nullable();
            $table->text('experiencia_publica')->nullable();
            $table->foreign('alcalde_id')->references('id')->on('alcaldes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfils');
    }
};
