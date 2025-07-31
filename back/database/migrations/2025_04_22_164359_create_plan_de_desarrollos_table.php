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
            $table->id();
            $table->foreignId('alcalde_id')
                ->constrained('alcaldes')
                ->cascadeOnDelete();
            $table->string('titulo');
            $table->longText('descripcion');
            $table->timestamps();
            $table->softDeletes();
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
