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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('lugar_nacimiento')->nullable();
            $table->string('direccion')->nullable();
            $table->string('ciudad')->nullable();
            // Puedes definir un enum si conoces los posibles valores para estado civil, por ejemplo: ['soltero', 'casado', 'divorciado', 'viudo']
            $table->string('estado_civil')->nullable();

            // Considera usar enum si solo manejas "Masculino" y "Femenino", o bien deja el campo abierto
            $table->string('sexo')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('tipo_sangre')->nullable();
            $table->string('foto')->nullable()->comment('Ruta o URL de la foto de perfil');

            // El campo cargo puede representar la posición o responsabilidad, revisa si conviene pasar a una relación en caso de tener muchos cargos predefinidos
            $table->string('cargo')->nullable();
            // Para usuarios, si hay roles predefinidos, podrías usar enum o relacionar con otra tabla (ej. roles o perfiles)
            $table->string('tipo_usuario')->nullable();

            // Si los tipos de documento están limitados, considera también un enum (ej: ['CC', 'TI', 'CE'])
            $table->string('tipo_documento')->nullable();
            $table->string('numero_documento')->nullable();

            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();

            // Se asume que la tabla "positions" ya existe; asegúrate que se relaciona correctamente
            $table->foreignId('position_id')->constrained('positions');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
