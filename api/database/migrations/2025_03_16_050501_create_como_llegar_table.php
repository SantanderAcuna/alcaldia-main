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
        Schema::create('como_llegar', function (Blueprint $table) {
            $table->id();
            $table->enum('metodo_transporte', [
                'Vía terrestre',
                'Vía marítima',
                'Vía aérea'
            ]);
            $table->string('nombre_lugar', 255);
            $table->text('Descripcion')->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->json('imagenes');
            $table->text('google_maps_iframe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('como_llegars');
    }
};
