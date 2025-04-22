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
            $table->bigIncrements('id');
            $table->string('nombre', 150)->unique();
            $table->text('mision');
            $table->text('vision')->nullable();
            $table->unsignedBigInteger('dependencia_id')->index('macro_procesos_dependencia_id_foreign');
            $table->string('codigo', 50)->nullable()->unique();
            $table->string('organigrama_url', 500)->nullable();
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
