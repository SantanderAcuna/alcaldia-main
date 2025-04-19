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
            $table->unsignedBigInteger('user_id')->index('perfiles_user_id_foreign');
            $table->unsignedBigInteger('dependencia_id')->nullable()->index('perfiles_dependencia_id_foreign');
            $table->string('titulo_profesional')->nullable();
            $table->string('especializacion')->nullable();
            $table->string('doctorado')->nullable();
            $table->string('foto_url', 500)->nullable();
            $table->text('resumen_biografico')->nullable();
            $table->json('experiencia_publica')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfiles');
    }
};
