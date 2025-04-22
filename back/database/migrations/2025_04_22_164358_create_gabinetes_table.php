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
        Schema::create('gabinetes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('dependencia_id')->index('gabinetes_dependencia_id_foreign');
            $table->unsignedBigInteger('perfil_id')->index('gabinetes_perfil_id_foreign');
            $table->string('cargo')->nullable()->comment('Cargo del gabinete');
            $table->date('fecha_inicio')->index();
            $table->date('fecha_fin')->nullable()->index();
            $table->boolean('actual')->default(false)->index();
            $table->timestamps();

            $table->unique(['user_id', 'dependencia_id', 'perfil_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gabinetes');
    }
};
