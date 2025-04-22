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
        Schema::create('plan_de_desarrollos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('titulo')->comment('Plan de desarrollo perioodo en curso');
            $table->text('contenido')->nullable();
            $table->unsignedBigInteger('galeria_id')->index('plan_de_desarrollos_galeria_id_foreign');
            $table->unsignedBigInteger('alcalde_id')->index('plan_de_desarrollos_alcalde_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_de_desarrollos');
    }
};
