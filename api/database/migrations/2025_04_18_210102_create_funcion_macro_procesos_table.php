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
        Schema::create('funcion_macro_procesos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('macro_proceso_id')->index('funcion_macro_procesos_macro_proceso_id_foreign');
            $table->unsignedBigInteger('tipo_procedimiento_id')->nullable()->index('funcion_macro_procesos_tipo_procedimiento_id_foreign');
            $table->text('descripcion');
            $table->integer('orden')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcion_macro_procesos');
    }
};
