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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('macro_proceso_id')->index('procedimientos_macro_procesos_macro_proceso_id_foreign');
            $table->unsignedBigInteger('tipo_procedimiento_id')->nullable()->index('procedimientos_macro_procesos_tipo_procedimiento_id_foreign');
            $table->unsignedBigInteger('funcion_macro_proceso_id')->nullable()->index('procedimientos_macro_procesos_funcion_macro_proceso_id_foreign');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->integer('orden')->nullable();
            $table->boolean('estado')->default(true);
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
